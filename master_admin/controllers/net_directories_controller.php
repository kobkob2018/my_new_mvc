<?php
  class Net_directoriesController extends CrudController{
    public $add_models = array("net_directories");

    protected function init_setup($action){
      return parent::init_setup($action);
    }


    public function list(){
      
      $filter_arr = array();
      $net_directories = Net_directories::get_list($filter_arr, 'id, label, active');
      $fields_collection = Net_directories::$fields_collection;
      $active_strings = array();
      foreach($fields_collection['active']['options'] as $option){
        $active_strings[$option['value']] = $option['title'];
      }
      foreach($net_directories as $key=>$dir){
        $net_directories[$key]['active_str'] = $active_strings[$dir['active']];
      }
      $this->data['net_directories'] = $net_directories;

      $this->include_view('net_directories/list.php');

    }

    public function edit(){
      return parent::edit();
    }

    public function updateSend(){
      return parent::updateSend();
    }

    public function add(){
      return parent::add();
    }       

    public function createSend(){
      return parent::createSend();
    }

    public function delete(){
      return parent::delete();      
    }

    public function include_edit_view(){
      if(isset($this->data['item_info'])){
        $this->data['dir_info'] = $this->data['item_info'];
      }
      $this->include_view('net_directories/edit.php');
    }

    public function include_add_view(){
      $this->include_view('net_directories/add.php');
    }   

    protected function update_success_message(){
      SystemMessages::add_success_message("התיקייה עודכנה בהצלחה");

    }

    protected function create_success_message(){
      SystemMessages::add_success_message("התיקייה נוצרה בהצלחה");

    }

    protected function delete_success_message(){
      SystemMessages::add_success_message("התיקייה נמחקה");
    }

    protected function row_error_message(){
      SystemMessages::add_err_message("לא נבחרה תיקייה");
    }   

    protected function delete_item($row_id){
      return Net_directories::delete($row_id);
    }

    protected function get_item_info($row_id){
      return Net_directories::get_by_id($row_id);
    }

    public function eject_url(){
      return inner_url('net_directories/list/');
    }

    public function url_back_to_item($item_info){
      return inner_url("net_directories/edit/?row_id=".$item_info['id']);
    }

    protected function get_fields_collection(){
      return Net_directories::$fields_collection;
    }

    protected function update_item($item_id,$update_values){
      return Net_directories::update($item_id,$update_values);
    }

    protected function create_item($fixed_values){
      return Net_directories::create($fixed_values);
    }
  }
?>