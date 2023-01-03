<?php
  class Form_handler {
    protected $db_values = array();
    protected $user_values = array();
    protected $messages = array('success'=>array(),'err'=>array());
    protected $fields_collection = array();
    protected $validation_handler;
    protected $files_to_upload;
    private $controller_interface;

    public function __construct($controller_interface){
      $this->controller_interface = $controller_interface;
    }

    public function setup_db_values($db_data){
      $this->db_values = $db_data;
    }

    public function validate($input_group = 'row'){
      //generate a validation handler
      require_once('a_core/helpers/validation_handler.php');
      $this->validation_handler = new Validation_handler();

      $validate_result = array(
        'success'=>true,
        'fixed_values'=>array(),
        'err_messages'=>array(),
        'upload_files'=>array(),
      );

      
      //initiate all user sent values
      if(isset($_REQUEST[$input_group])){
        $this->user_values = $_REQUEST[$input_group];
      }
      
      $user_files = $this->get_request_files($input_group);
      foreach($user_files as $key=>$value){
        $this->user_values[$key] = $value['name'];
      }
      
      //loop all fields array
      foreach($this->fields_collection as $field_key=>$field){

        //if the field is not in the form, do not check
        if(!isset($this->user_values[$field_key])){
          continue; 
        }

        $user_value = $this->user_values[$field_key];
        $user_fixed_value = $user_value;
        $field_validate_result = array(
          'success'=>true,
        );
        //first assume field is valid
        $field_is_valid = true;

        $validate_payload = array(
          'field'=>$field,
          'key'=>$field_key,
          'input_group'=>$input_group,
          'db_value'=>null,
          'user_value'=>$user_value,
          'last_state'=>array(),
        );

        if(isset($this->db_values[$field_key])){
          $validate_payload['db_value'] = $this->db_values[$field_key];
        }

        if(isset($user_files[$field_key])){
          $validate_payload['user_file'] = $user_files[$field_key];
          $this->user_values[$field_key] = $field['name_file'];
        }
        
        if(isset($field['validation'])){
          //get all validate methods from the field setup
          $validate_methods = explode(",", $field['validation']);
          foreach($validate_methods as $method){
            $method = trim($method);
            if(($method != 'required') && ($user_fixed_value == '' || $user_fixed_value == null)){
              continue;
            }
            //sent each validation to the validation_handler proper method
            $field_validate_result = $this->validation_handler->validate_by($method, $user_fixed_value,$validate_payload);
            $validate_payload['last_state'] = $field_validate_result;
            if(isset($field_validate_result['fixed_value'])){
              $user_fixed_value = $field_validate_result['fixed_value'];
            }
            //the method returns an array with a success boolean and an error message
            if(!$field_validate_result['success']){
              //need to continue checking only if still valid
              $field_is_valid = false;
              break;
            }
          }
        }
        
        //check for custom validation requests. the custom validation methhod will be in the controller
        //check only if stil valid
        if(isset($field['custom_validation']) && $field_is_valid && $user_fixed_value != '' && $user_fixed_value != null){
          $field_validate_result = $this->validation_handler->validate_by_custom($this->controller_interface, $field['custom_validation'], $user_fixed_value, $validate_payload);
          $validate_payload['last_state'] = $field_validate_result;
          if(isset($field_validate_result['fixed_value'])){
            $user_fixed_value = $field_validate_result['fixed_value'];
          }        
        }

        if($field['type'] == 'file'){
          if($user_fixed_value == ''){
            if(isset($this->db_values[$field_key])){
              $user_fixed_value = $this->db_values[$field_key];
            }
          }
          else{
            if($field_validate_result['success']){
              $file_field = $field;
              $file_field['file_info'] = $user_files[$field_key];
              $validate_result['upload_files'][$field_key] = $file_field;
            }
          }
        }

        $validate_result['fixed_values'][$field_key] = $user_fixed_value;

        if(!$field_validate_result['success']){
          $validate_result['success'] = false;

        }

        if(isset($field_validate_result['message'])){
          $validate_result['err_messages'][] = str_replace( '{{label}}', $field['label'], $field_validate_result['message']);
        }
        
        //todo validation stuff
        // add messages and all
      }
      return $validate_result;
    }

    public function upload_files($validate_result){
      $assets_dir = $this->controller_interface->get_assets_dir();
      foreach($validate_result['upload_files'] as $field_key=>$field){

        $old_file_name = $this->db_values[$field_key];
        $new_file_name = $validate_result['fixed_values'][$field_key];

        $dir_path = $assets_dir['path'];

        $upload_to_arr = explode("/",$field['upload_to']);
        
        foreach($upload_to_arr as $dirname){
          $dir_path.="/$dirname";
          if( !is_dir($dir_path) )
          {
            $oldumask = umask(0) ;
            mkdir( $dir_path, 0755 ) ;
            umask( $oldumask ) ;
          }
        }

        if($old_file_name != ''){
          $old_file_path = $dir_path.'/'.$old_file_name;
          if(file_exists($old_file_path)){  
            unlink($old_file_path);
          }
        }
        $new_file_path = $dir_path.'/'.$new_file_name;
        $tmp_name = $field['file_info']['tmp_name'];
        move_uploaded_file($tmp_name, $new_file_path);
      }
    }

    protected function get_request_files($input_group){
      /*
        the $_FILES array is built very annoyingly, so it's a long function...
      */

      $user_files = array();
      if(isset($_FILES[$input_group])){
        $user_files = array();
        foreach($_FILES[$input_group] as $param_name=>$values_arr){
          foreach($values_arr as $field_name=>$param_value){
            if(!isset($user_files[$field_name])){
              $user_files[$field_name] = array();
            }
            $user_files[$field_name][$param_name] = $param_value;
          }
        }
      }
      return $user_files;
    }

    public function setup_fields_collection($fields){     
      foreach($fields as $key => $field){
        if(!isset($field['type'])){
          $field['type'] = 'text';
        }
        if($field['type'] == 'select'){
          $field = $this->setup_select_options($field);
        }
        $fields[$key] = $field;
      }
      $this->fields_collection = $fields;
    }

    protected function setup_select_options($field){
      $select_index = array();
      $options = array();
      $select_options = array();
      if(isset($field['options'])){
        $options = $field['options'];

      }
      if(isset($field['options_method'])){
        $options_method = $field['options_method'];
        $method_name = $options_method['method'];
        $options = $options_method['model']::$method_name();
      }


      $i=0;

      foreach($options as $option){
        $option['selected'] = '';
        //we index the select options manually
        $select_index[$option['value']] = $i;
        $select_options[$i] = $option;
        $i++;
      }
      $field['options_index'] = $select_index;
      $field['options'] = $select_options;
      $field['selected_index'] = '-1';
      return $field;
    }


    public function get_select_options($key){
      $selected_index = $this->get_form_input($key);
      $prev_selected_index = $this->fields_collection[$key]['selected_index'];
      if($prev_selected_index != '-1'){
        $this->set_field_selected_str($key,$prev_selected_index,'');
      }
      
      $this->set_field_selected_str($key,$selected_index,'selected');
      return $this->fields_collection[$key]['options'];
    }

    protected function set_field_selected_str($key,$option_index,$str){
      $options_index = $this->fields_collection[$key]['options_index'];
      if(!isset($options_index[$option_index])){
        return;
      }
      $option_key = $options_index[$option_index];
      $this->fields_collection[$key]['options'][$option_key]['selected'] = $str;
    }

    public function get_form_input($key){
      if(isset($this->user_values[$key])){
        return $this->user_values[$key];
      }
      if(isset($this->db_values[$key])){
        return $this->db_values[$key];
      }
      if(isset($this->fields_collection[$key])){
        if(isset($this->fields_collection[$key]['default'])){
          return $this->fields_collection[$key]['default'];
        }
      }
      return "";
    }

    public function get_form_file_url($key){

      $assets_dir = $this->controller_interface->get_assets_dir();
      if(!isset($this->fields_collection[$key])){
        return false;
      }
      if(!isset($this->db_values[$key]) || $this->db_values[$key] == ''){
        return false;
      }
      $file_name = $this->db_values[$key];
      $field = $this->fields_collection[$key];
      
      $upload_to = $field['upload_to'];

      $relative_location = "$upload_to/$file_name";
      $full_url = $assets_dir['url'].$relative_location;
      return $full_url;
      
    }

    public function remove_file($field_key){

      if(!isset($this->fields_collection[$field_key])){
        return;
      }

      $field = $this->fields_collection[$field_key];
      $assets_dir = $this->controller_interface->get_assets_dir();
      $dir_path = $assets_dir['path']."/".$field['upload_to'];
      $file_name = $this->db_values[$field_key];
      $file_path = $dir_path."/".$file_name;

      if(file_exists($file_path)){
        unlink($file_path);
      }
      return; 
    }


  }


?>