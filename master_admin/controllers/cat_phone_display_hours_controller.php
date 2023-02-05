<?php

  class Cat_phone_display_hoursController extends CrudController{
    public $add_models = array("cat_phone_display_hours", "biz_categories");

    protected function init_setup($action){
        $cat_id = $this->add_cat_info_data();
        if(!$cat_id){
            return $this->redirect_to(inner_url("biz_categories/list/"));
            return false;
        }

        $item_parent_tree = Biz_categories::get_item_parents_tree($cat_id,'id, label');
        $this->data['item_parent_tree'] = $item_parent_tree;
        $this->data['current_item_id'] = $cat_id;

        return parent::init_setup($action);
    }

    public function list(){
        //if(session__isset())
        $filter_arr = $this->get_base_filter();
        $hours_info = Cat_phone_display_hours::get_list($filter_arr,"id");      
        $this->data['hours_info'] = $hours_info;
        $cat_id = $_GET['cat_id'];
        if(empty($hours_info)){
            return $this->redirect_to(inner_url("cat_phone_display_hours/add/?cat_id=$cat_id"));
        }
        else{
            $row_id = $hours_info[0]['id'];
            return $this->redirect_to(inner_url("cat_phone_display_hours/edit/?cat_id=$cat_id&row_id=$row_id"));
        }
    }

    protected function add_cat_info_data(){

        if(!isset($_GET['cat_id'])){
            return false;
        }
        $cat_id = $_GET['cat_id'];
        $cat_info = Biz_categories::get_by_id($cat_id, 'id, label');
        $this->data['cat_info'] = $cat_info;
        if($cat_info && isset($cat_info['id'])){
            return $cat_info['id'];
        }
    }

    protected function get_base_filter(){
        $cat_id = $this->add_cat_info_data();
        if(!$cat_id){
            return;
        }

        $filter_arr = array(
            'cat_id'=>$cat_id,
    
        );  
        return $filter_arr;     
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

    public function build_time_groups($field_key, $build_field){
        echo "hours here!!!";
        //this will be the hours field
    } 

    public function include_edit_view(){
        $this->include_view('cat_phone_display_hours/edit.php');
    }

    public function include_add_view(){
        $this->include_view('cat_phone_display_hours/add.php');
    }   

    protected function update_success_message(){
        SystemMessages::add_success_message("הזמנים עודכנו בהצלחה");

    }

    protected function create_success_message(){
        SystemMessages::add_success_message("הזמנים עודכנו בהצלחה");

    }

    protected function delete_success_message(){
        SystemMessages::add_success_message("הזמנים נמחקו");
    }

    protected function row_error_message(){
      SystemMessages::add_err_message("לא נבחרה קטגוריה");
    }   

    protected function delete_item($row_id){
      return Cat_phone_display_hours::delete($row_id);
    }

    protected function get_item_info($row_id){
      return Cat_phone_display_hours::get_by_id($row_id);
    }

    public function eject_url(){
      return inner_url('cat_phone_display_hours/list/?cat_id='.$this->data['cat_info']['id']);
    }

    public function url_back_to_item($item_info){
      return inner_url("cat_phone_display_hours/list/?cat_id=".$this->data['cat_info']['id']);
    }

    protected function get_fields_collection(){
      return Cat_phone_display_hours::setup_field_collection();
    }

    protected function update_item($item_id,$update_values){
      return Cat_phone_display_hours::update($item_id,$update_values);
    }

    protected function create_item($fixed_values){
        $fixed_values['cat_id'] = $this->data['cat_info']['id'];
        return Cat_phone_display_hours::create($fixed_values);
    }
    
  }
?>