<?php
  class Form_handler {
    protected $db_values = array();
    protected $user_values = array();
    protected $messages = array('success'=>array(),'err'=>array());
    protected $fields_collection = array();
    protected $validation_handler;
    private $controller_interface;

    public function __construct($controller_interface){
      $this->controller_interface = $controller_interface;
    }

    public function setup_db_values($db_data){
      $this->db_values = $db_data;
    }


    public function validate($input_group = 'row'){
      //generate a validation handler
      system_require_once('core/helpers/validation_handler.php');
      $this->validation_handler = new Validation_handler();

      $validate_result = array(
        'success'=>true,
        'fixed_values'=>array(),
        'err_messages'=>array(),
      );

      
      //initiate all user sent values
      if(isset($_REQUEST[$input_group])){
        $this->user_values = $_REQUEST[$input_group];
      }
      
      //loop all fields array
      foreach($this->fields_collection as $field_key=>$field){
        //$fixed_values = array();
        
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
        //$fixed_values[$field_key] = $user_value;
        if(isset($field['validation'])){

          //get all validate methods from the field setup
          $validate_methods = explode(",", $field['validation']);
          foreach($validate_methods as $method){
            //sent each validation to the validation_handler proper method
            $field_validate_result = $this->validation_handler->validate_by($method, $user_value);

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
        if(isset($field['custom_validation']) && $field_is_valid){

          $field_validate_result = $this->validation_handler->validate_by_custom($this->controller_interface, $field['custom_validation'], $user_value);
        }

        if(isset($field_validate_result['fixed_value'])){
          $user_fixed_value = $field_validate_result['fixed_value'];
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

  }


?>