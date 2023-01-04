<?php
  class MenusController extends Controller{
    public $add_models = array("menuItems");
    protected $list_forms = array();

    protected function init_setup($action){
      $this->data['site'] = Sites::get_user_workon_site();
    }

    public function right_menu(){
        if(isset($_GET['delete'])){
            $this->delete_item($_REQUEST['delete']);
            $row_url = '';
            if(isset($_GET['row_id'])){
                $row_url = "?row_id=".$_GET['row_id'];
            }
            $this->redirect_to(inner_url("menus/right_menu/$row_url"));
        }
        $this->data['page_title'] = "רשימת קישורים לתפריט ימני";
        $this->data['menu_identifier'] = 'right';
        $this->data['menu_id'] = MenuItems::$menu_type_list[$this->data['menu_identifier']];
        
        $item_id = '0';
        if(isset($_GET['item_id'])){
            $item_id = $_GET['item_id'];
            $main_menu_item = MenuItems::get_by_id($item_id);
            $menu_item_list = MenuItems::get_children_list_of($item_id);
        }
        else{
            $main_menu_item = false;
            $menu_item_list = MenuItems::get_parent_list_of($this->data['site']['id'],$this->data['menu_id']);
        }

        if($main_menu_item){
            $main_menu_item = $this->setup_item_form_handler('main',$main_menu_item);
        }

        foreach($menu_item_list as $item_key=>$item){
            $item_identifier = "item_".$item['id'];
            $item = $this->setup_item_form_handler($item_identifier,$item);
            $menu_item_list[$item_key] = $item;
        }


        $this->data['main_menu_item'] = $main_menu_item;
        $this->data['menu_item_list'] = $menu_item_list;
        $this->data['item_id'] = $item_id;

        $this->send_action_proceed();

        $this->include_view('menus/list_items.php');
    }


    public function updateSend(){

        if(!isset($_REQUEST['row_id'])){
            return;
        }
        $row_id = $_REQUEST['row_id'];
        $item_identifier = "item_".$row_id;
        
        if(!isset($this->form_handlers[$item_identifier])){
            return;
        }
        $form_handler = $this->form_handlers[$item_identifier];

        $validate_result = $form_handler->validate();
        $fixed_values = $validate_result['fixed_values'];
        if($validate_result['success']){
            MenuItems::update($row_id,$fixed_values);
            SystemMessages::add_success_message("הקישור נשמר בהצלחה");
            $this->redirect_to(current_url());
        }
        else{
            if(!empty($validate_result['err_messages'])){
                $this->data['form_err_messages'] = $validate_result['err_messages'];
            }
        }
    }

    public function delete_item($row_id){
        MenuItems::delete($row_id);
        SystemMessages::add_success_message("הקישור נמחק בהצלחה");           
    }  

    private function setup_item_form_handler($item_key,$item){
        if(!$item || $item == null){
            return $item;
        }
        $item_fields_colection = MenuItems::$item_fields_colection;
        $form_handler = $this->init_form_handler($item_key);
        $form_handler->setup_fields_collection($item_fields_colection);
        $form_handler->setup_db_values($item);
        $item['form_identifier'] = $item_key;
        return $item;
    }
  }
?>