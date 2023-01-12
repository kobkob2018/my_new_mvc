<?php
  class CrudController extends Controller{

    protected function init_setup($action){
        $this->set_priority_from_session();
        return parent::init_setup($action);
    }

    public function edit(){
      
        if(!isset($_GET['row_id'])){
            $this->row_error_message();
            return $this->eject_redirect();
        }

        $this->data['item_info'] = $this->get_item_info($_GET['row_id']);



        if(!$this->data['item_info']){
            $this->row_error_message();
            return $this->eject_redirect();
        }

        $fields_collection = $this->get_fields_collection();

        $form_handler = $this->init_form_handler();
        $form_handler->setup_fields_collection($fields_collection);
        $form_handler->setup_db_values($this->data['item_info']);

        if(isset($_REQUEST['remove_file'])){
            return $this->remove_file($fields_collection, $form_handler);
        }

        $this->send_action_proceed();

        $this->add_form_builder_data($fields_collection,'updateSend',$this->data['item_info']['id']);  
        $this->include_edit_view();
  
    }
  
    public function updateSend(){
        if(!isset($_REQUEST['row_id'])){
            return;
        }
        $row_id = $_REQUEST['row_id'];
        $form_handler = $this->init_form_handler();
        $validate_result = $form_handler->validate();
        $fixed_values = $validate_result['fixed_values'];
        foreach($fixed_values as $key=>$value){
            $fixed_values[$key] = str_replace('{{row_id}}',$row_id,$value);
        }
        $validate_result['fixed_values'] = $fixed_values;
        if($validate_result['success']){
            $this->update_item($row_id,$fixed_values);
            $files_result = $form_handler->upload_files($validate_result, $row_id);
            $this->update_success_message();
            $this->redirect_back_to_item($this->data['item_info']);
        }
        else{
            if(!empty($validate_result['err_messages'])){
                $this->data['form_err_messages'] = $validate_result['err_messages'];
            }
        }
    }

    protected function remove_file($fields_collection, $form_handler){
        $item_info = $this->data['item_info'];
        $item_id = $item_info['id'];
        
        $field_key_for_file = $_REQUEST['remove_file'];
        if(isset($fields_collection[$field_key_for_file])){
            $form_handler->remove_file($field_key_for_file);
            $update_values = array($field_key_for_file=>'');
            $this->update_item($item_id,$update_values);
            SystemMessages::add_success_message("הקובץ הוסר");
            return $this->redirect_back_to_item($this->data['item_info']);
        }
    }

    public function add(){
        $fields_collection = $this->get_fields_collection();
        $form_handler = $this->init_form_handler();
        $form_handler->setup_fields_collection($fields_collection);
  
        $this->send_action_proceed();
        $this->add_form_builder_data($fields_collection,'createSend','new');
        $this->send_action_proceed();
        $this->include_add_view();           
    }       
  
    protected function add_form_builder_data($fields_collection, $sendAction, $row_id){
        $fields_collection = TableModel::prepare_form_builder_fields($fields_collection);

        $form_builder_data = array();
        $enctype_str = '';
        foreach($fields_collection as $field){
            if($field['type'] == 'file'){
                $enctype_str = 'enctype="multipart/form-data"';
            }
        }
        $form_builder_data['enctype_str'] = $enctype_str;
        $form_builder_data['sendAction'] = $sendAction;
        $form_builder_data['row_id'] = $row_id;
        $form_builder_data['fields_collection'] = $fields_collection;
        $this->data['form_builder'] = $form_builder_data;
    }

    public function createSend(){
        $form_handler = $this->init_form_handler();
        $validate_result = $form_handler->validate();
        
        if($validate_result['success']){
            $fixed_values = $validate_result['fixed_values'];
            $row_id = $this->create_item($fixed_values);
  
            $fixed_row_values = array();
            foreach($fixed_values as $key=>$value){
                $fixed_row_value = str_replace('{{row_id}}',$row_id,$value);
                if($fixed_row_value != $value){
                    $fixed_row_values[$key] = $fixed_row_value;
                }
            }
            if(!empty($fixed_row_values)){
                $this->update_item($row_id,$fixed_row_values);
            }
            $validate_result['fixed_values'] = $fixed_row_values;
            $files_result = $form_handler->upload_files($validate_result, $row_id);
            $this->create_success_message();
            $this->redirect_back_to_item(array('id'=>$row_id));
        }
        else{
            if(!empty($validate_result['err_messages'])){
                $this->data['form_err_messages'] = $validate_result['err_messages'];
            }
        }
    }

    public function delete(){

        if(!isset($_GET['row_id'])){
            $this->row_error_message();
            return $this->eject_redirect();
        }

        $this->data['item_info'] = $this->get_item_info($_GET['row_id']);
        if(!$this->data['item_info']){
            $this->row_error_message();
            return $this->eject_redirect();
        }

        $fields_collection = $this->get_fields_collection();

        $form_handler = $this->init_form_handler();
        $form_handler->setup_fields_collection($fields_collection);
        $form_handler->setup_db_values($this->data['item_info']);

        if(is_array($fields_collection)){
            foreach($fields_collection as $field_key=>$field){
                if($field['type'] == 'file'){
                    $form_handler->remove_file($field_key);
                }
            }
        }

        $this->delete_item($this->data['item_info']['id']);
        $this->delete_success_message();
        return $this->eject_redirect();
    }

    protected function set_priority(){
        global $controller;
        $session_param_name = $controller."_priority_set";
        $filter_arr = $this->get_base_filter();
        if(isset($_GET['row_id'])){
            $this->rearange_priority($filter_arr);
            session__set($session_param_name, $_GET['row_id']);
        }
        if(isset($_GET['cancel'])){
            session__unset($session_param_name);
        }
        if(isset($_GET['row_to'])){
            if(!isset($this->data['set_priority_item'])){
                return;
            }
            $priority = '0';
            $item_to_id = $_GET['row_to'];
            
            $place_priority = $this->get_priority_space($filter_arr, $item_to_id);
            if($place_priority){
                $priority = $place_priority;
            }
            
            
            $this->update_item($this->data['set_priority_item']['id'], array('priority'=>$priority));
            session__unset($session_param_name);
        }
        return $this->eject_redirect();
    }

    protected function set_priority_from_session(){
        global $controller;
        $session_param_name = $controller."_priority_set";
        if(session__isset($session_param_name)){
            $item_info = $this->get_item_info(session__get($session_param_name));
            $this->data['set_priority_item'] = $item_info;
        }
    }

    protected function eject_redirect(){
        return $this->redirect_to($this->eject_url());
    }
  
    protected function redirect_back_to_item($item_info){
        return $this->redirect_to($this->url_back_to_item($item_info));
    }

    protected function row_error_message(){
        return null;
    }

    public function eject_url(){
        return null;
    }
  
    public function url_back_to_item($item_info){
        return null;
    }

    public function include_edit_view(){
        return null;
    }

    public function include_add_view(){
        return null;
    }

    protected function update_success_message(){
        return null;
  
    }
  
    protected function create_success_message(){
        return null;
  
    }
  
    protected function delete_success_message(){
        return null;
  
    }
  
    protected function get_item_info($row_id){
        return null;
    }
  
  
    protected function get_fields_collection(){
        return null;
    }
  
    protected function update_item($item_id,$update_values){
        return null;
    }

    protected function create_item($create_values){
        return null;
    }

    protected function delete_item($row_id){
        return null;
    }

    protected function get_priority_space($filter_arr, $item_to_id){
        return null;
    }

    public function rearange_priority($filter_arr){
        return null;
    }

    protected function get_base_filter(){
        return array();
    }
}