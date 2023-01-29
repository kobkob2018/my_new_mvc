<?php
  class Net_bannersController extends CrudController{
    public $add_models = array("net_banners","net_directories");

    protected function init_setup($action){
        $dir_id = $this->add_dir_info_data();
        if(!$dir_id){
            return $this->redirect_to(inner_url("net_directories/list/"));
            return false;
        }
        return parent::init_setup($action);
    }

    public function list(){
        //if(session__isset())
        $filter_arr = $this->get_base_filter();
        $payload = array(
            'order_by'=>'label'
        );
        $net_banners = Net_banners::get_list($filter_arr,"*", 'id, insert_date , label, active, views, clicks, convertions ');
        $fields_collection = Net_banners::$fields_collection;
        $active_strings = array();
        foreach($fields_collection['active']['options'] as $option){
          $active_strings[$option['value']] = $option['title'];
        }
        foreach($net_banners as $key=>$dir){
          $net_banners[$key]['active_str'] = $active_strings[$dir['active']];
        }
        $this->data['net_banners'] = $net_banners;
        $this->include_view('net_banners/list.php');

    }

    protected function add_dir_info_data(){

        if(!isset($_GET['dir_id'])){
            return false;
        }
        $dir_id = $_GET['dir_id']; 
        $dir_info = Net_directories::get_by_id($dir_id, 'id, label');
        $this->data['dir_info'] = $dir_info;
        if($dir_info && isset($dir_info['id'])){
            return $dir_info['id'];
        }
    }

    public function select_cats(){
        $this->add_model("net_banner_cat");
        $this->add_model("biz_categories");
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

        $banner_cat_arr = Net_banners::get_banner_cat_list($row_id);
        $checked_cats = array();
        foreach($banner_cat_arr as $banner_cat){
            $checked_cats[$banner_cat['cat_id']] = true;
        }

        $add_is_checked_value = array(
            'controller'=>$this,
            'method'=>'add_cat_is_checked_param',
            'more_info'=>array(
                'banner_cat_arr'=>$checked_cats
            ),
        );

        $payload = array('add_custom_param'=>$add_is_checked_value);

        $category_tree = Biz_categories::simple_get_item_offsprings_tree('0','id, label, parent',array(), $payload);

        $category_tree = $this->add_has_checked_children_param($category_tree);


        print_r_help($category_tree);
        $this->include_view("net_banners/select_cats.php");
    }

    public function add_cat_is_checked_param($cat_info, $more_info){
        $cat_info['checked'] = '0';
        if(isset($more_info['banner_cat_arr']) && is_array($more_info['banner_cat_arr'])){
            if(isset($more_info['banner_cat_arr'][$cat_info['id']])){
                $cat_info['checked'] = '1';
            }
        }
        return $cat_info;
    }

    protected function add_has_checked_children_param($category_tree, $count = 0){
        $count++;
        if($count>10){
            exit("count is $count");
        }
        foreach($category_tree as $key=>$child_item){
            
            $child_item['has_checked_children'] = false;
            if($child_item['children']){
                $child_item['children'] = $this->add_has_checked_children_param($child_item['children']);
                $child_item['has_checked_children'] = $this->has_checked_children($child_item['children']);
            }
            if($child_item['checked']){
                $child_item['has_checked_children'] = true;
            }
            $category_tree[$key] = $child_item;
        }
        return $category_tree;
    }

    protected function has_checked_children($category_tree){
        foreach($category_tree as $child_item){
            print_help("checkinffffff", $child_item['id']);
            if($child_item['checked'] || $child_item['has_checked_children']){
                exit("yes yes yes");
                return true;
            }
            return false;
        }
    }

    protected function get_base_filter(){
        $dir_id = $this->add_dir_info_data();
        if(!$dir_id){
            return;
        }

        $filter_arr = array(
            'dir_id'=>$dir_id,
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

    public function set_priority(){
        return parent::set_priority();
    }

    public function include_edit_view(){
        $this->include_view('net_banners/edit.php');
    }

    public function include_add_view(){
        $this->include_view('net_banners/add.php');
    }   

    protected function update_success_message(){
        SystemMessages::add_success_message("הבאנר עודכן בהצלחה");

    }

    protected function create_success_message(){
        SystemMessages::add_success_message("הבאנר נוצר בהצלחה");

    }

    protected function delete_success_message(){
        SystemMessages::add_success_message("הבאנר נמחק");
    }

    protected function row_error_message(){
      SystemMessages::add_err_message("לא נבחר באנר");
    }   

    protected function delete_item($row_id){
      return Net_banners::delete($row_id);
    }

    protected function get_item_info($row_id){
      return Net_banners::get_by_id($row_id);
    }

    public function eject_url(){
      return inner_url('net_banners/list/?dir_id='.$this->data['dir_info']['id']);
    }

    public function url_back_to_item($item_info){
      return inner_url("net_banners/edit/?row_id=".$item_info['id']."&dir_id=".$this->data['dir_info']['id']);
    }

    protected function get_fields_collection(){
      return Net_banners::$fields_collection;
    }

    protected function update_item($item_id,$update_values){
      return Net_banners::update($item_id,$update_values);
    }

    protected function create_item($fixed_values){
        $fixed_values['dir_id'] = $this->data['dir_info']['id'];
        return Net_banners::create($fixed_values);
    }
  }
?>