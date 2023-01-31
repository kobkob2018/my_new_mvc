<?php
  class CrudController extends Controller{

    protected $assets_map = array();
    protected function init_setup($action){
        $this->set_priority_from_session();
        return parent::init_setup($action);
    }

    public function edit(){
        $row_id = false;
        if(isset($_REQUEST['row_id'])){
            $row_id = $_REQUEST['row_id'];
        }
        elseif(isset($this->data['row_id'])){
            $row_id = $this->data['row_id'];
        }
        if(!$row_id){
            $this->row_error_message();
            return $this->eject_redirect();
        }

        $this->data['item_info'] = $this->get_item_info($row_id);



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
        $row_id = false;
        if(isset($_REQUEST['row_id'])){
            $row_id = $_REQUEST['row_id'];
        }
        elseif(isset($this->data['row_id'])){
            $row_id = $this->data['row_id'];
        }
        if(!$row_id){
            return;
        }
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
  
    public function file_url_of($field_name, $file_name){
        $fileds_arr = $this->get_assets_mapping();
        if($fileds_arr && isset($fileds_arr[$field_name])){
            $file_dir = $fileds_arr[$field_name];
            $assets_dir = $this->get_assets_dir();
            return $assets_dir['url'].$file_dir."/".$file_name;

        }
        return $file_name;

    }

    public function add_asset_mapping($mapping_arr){
        foreach($mapping_arr as $mapping_key=>$mapping){
            $this->assets_map[$mapping_key] = $mapping;
        }
    }

    protected function get_assets_mapping(){
        return $this->assets_map;
    }

    protected function add_form_builder_data($fields_collection, $sendAction, $row_id){
        global $controller;
        global $action;
        $fields_collection = TableModel::prepare_form_builder_fields($fields_collection);

        $form_builder_data = array(
            'controller'=>$controller,
            'action'=>$action
        );
        
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

        $item_info = $this->data['item_info'];

        $fields_collection = $this->get_fields_collection();

        $this->delete_item_files($item_info,$fields_collection);

        $this->delete_item($this->data['item_info']['id']);
        $this->delete_success_message();
        return $this->eject_redirect();
    }

    protected function delete_item_files($item_info, $fields_collection){
        $form_handler = $this->init_form_handler();
        $form_handler->setup_fields_collection($fields_collection);
        $form_handler->setup_db_values($item_info);

        if(is_array($fields_collection)){
            foreach($fields_collection as $field_key=>$field){
                if($field['type'] == 'file'){
                    $form_handler->remove_file($field_key);
                }
            }
        }
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


    protected function move_item_prepare($item_identifier){
        global $controller;
        if($item_identifier == 'cancel'){
            session__unset($controller.'_item_to_move');
        }
        elseif($item_identifier == 'here'){
            $item_to_move_id = session__get($controller.'_item_to_move');
            $parent_id = 0;
            if(isset($_GET['item_id'])){
                $parent_id = $_GET['item_id'];
            }
            $this->get_item_parents_tree($parent_id,'id');
            $parent_tree = $this->get_item_parents_tree($parent_id,'id');
            foreach($parent_tree as $branch){
                if($item_to_move_id == $branch['id']){
                    SystemMessages::add_err_message("לא ניתן להעביר רכיב לצאצאיו");
                    return $this->eject_redirect();
                }
            }
            $this->update_item($item_to_move_id,array('parent'=>$parent_id));
            SystemMessages::add_success_message("הרכיב הועבר בהצלחה");
            session__unset($controller.'_item_to_move');
            return $this->redirect_back_to_item(array('id'=>$parent_id));
        }
        else{
            session__set($controller.'_item_to_move',$item_identifier);
        }
        return $this->eject_redirect();
    }

    protected function get_move_item_session(){
        global $controller;
        $session_param = $controller.'_item_to_move';
        if(session__isset($session_param)){
            $move_item_id = session__get($session_param);
            $move_menu_item_tree = $this->get_item_parents_tree($move_item_id,'id, label');
            $this->data['move_item'] = array(
                'item_id'=>$move_item_id,
                'tree'=>$move_menu_item_tree
            );
        }
    }

    protected function get_item_parents_tree($parent_id,$select_params){
        //to be overriden
        return array();
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

    public function delete_url($item_info){
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