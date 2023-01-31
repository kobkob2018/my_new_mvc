<?php
  class Biz_categoriesController extends CrudController{
    public $add_models = array("biz_categories");


    protected function init_setup($action){
        $current_item_id = false;
        if(isset($_GET['item_id'])){
            $current_item_id = $_GET['item_id'];
        }
        elseif(isset($_GET['row_id'])){
            $current_item_id = $_GET['row_id'];
        }
        if($current_item_id){
            $item_parent_tree = Biz_categories::get_item_parents_tree($current_item_id,'id, label');
            $this->data['item_parent_tree'] = $item_parent_tree;
        }
        else{
            $current_item_id = '0';
        }
        $this->data['current_item_id'] = $current_item_id;


        if(isset($_REQUEST['move_item'])){
            return $this->move_item_prepare($_REQUEST['move_item']);
        }

        $this->get_move_item_session();

        return parent::init_setup($action);
    }

    protected function get_item_parents_tree($parent_id,$select_params){        
        return Biz_categories::get_item_parents_tree($parent_id,$select_params);
    }



    public function list(){
      
        //if(session__isset())
        $filter_arr = $this->get_base_filter();
        $filter_arr['parent'] = $this->data['current_item_id'];

        $payload = array(
            'order_by'=>'label'
        );
        $cat_list = Biz_categories::get_list($filter_arr,"*", $payload);  
        $this->data['cat_list'] = $cat_list;
        $this->include_view('biz_categories/list.php');
    }

    protected function get_base_filter(){
        $filter_arr = array();  
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

    public function include_edit_view(){
      if(isset($this->data['item_info'])){
        $this->data['cat_info'] = $this->data['item_info'];
      }
      $this->include_view('biz_categories/edit.php');
    }

    public function include_add_view(){
      $this->include_view('biz_categories/add.php');
    }   

    protected function update_success_message(){
      SystemMessages::add_success_message("הקטגוריה עודכנה בהצלחה");

    }

    protected function create_success_message(){
      SystemMessages::add_success_message("הקטגוריה נוצרה בהצלחה");

    }

    protected function delete_success_message(){
      SystemMessages::add_success_message("הקטגוריה נמחקה");
    }

    protected function row_error_message(){
      SystemMessages::add_err_message("לא נבחרה קטגוריה");
    }   

    protected function delete_item($row_id){
      return Biz_categories::delete($row_id);
    }

    protected function get_item_info($row_id){
      return Biz_categories::get_by_id($row_id);
    }

    public function eject_url(){
      return inner_url('biz_categories/list/');
    }

    public function url_back_to_item($item_info){
      return inner_url("biz_categories/list/?item_id=".$item_info['id']);
    }

    public function delete_url($item_info){
      return inner_url("biz_categories/delete/?row_id=".$item_info['id']);
    }

    protected function get_fields_collection(){
      return Biz_categories::setup_field_collection();
    }

    protected function update_item($item_id,$update_values){
      return Biz_categories::update($item_id,$update_values);
    }

    protected function create_item($fixed_values){
        $parent = '0';
        if(isset($_REQUEST['item_id'])){
            $parent = $_REQUEST['item_id'];
        }
        if(isset($_REQUEST['parent'])){
            $parent = $_REQUEST['parent'];
        }
        $fixed_values['parent'] = $parent;
        return Biz_categories::create($fixed_values);
    }
  }
?>