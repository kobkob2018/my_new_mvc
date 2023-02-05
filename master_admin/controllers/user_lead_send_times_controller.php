<?php

  class user_lead_send_timesController extends CrudController{
    public $add_models = array("user_lead_send_times", "users");

    protected function init_setup($action){
        $user_id = $this->add_user_info_data();
        return parent::init_setup($action);
    }

    public function list(){
        //if(session__isset())
        $filter_arr = $this->get_base_filter();
        $hours_info = User_lead_send_times::get_list($filter_arr,"id");      
        $this->data['hours_info'] = $hours_info;
        $user_id = $_GET['user_id'];
        if(empty($hours_info)){
            return $this->redirect_to(inner_url("user_lead_send_times/add/?user_id=$user_id"));
        }
        else{
            $row_id = $hours_info[0]['id'];
            return $this->redirect_to(inner_url("user_lead_send_times/edit/?user_id=$user_id&row_id=$row_id"));
        }
    }

    protected function add_user_info_data(){

        if(!isset($_GET['user_id'])){
            return false;
        }
        $user_id = $_GET['user_id'];
        $user_info = Users::get_by_id($user_id, 'id, full_name');
        $this->data['user_info'] = $user_info;
        if($user_info && isset($user_info['id'])){
            return $user_info['id'];
        }
    }

    protected function get_base_filter(){
        $user_id = $this->add_user_info_data();
        if(!$user_id){
            return;
        }

        $filter_arr = array(
            'user_id'=>$user_id,
    
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
        $this->include_view('user_lead_send_times/edit.php');
    }

    public function include_add_view(){
        $this->include_view('user_lead_send_times/add.php');
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
      SystemMessages::add_err_message("לא נבחר לקוח");
    }   

    protected function delete_item($row_id){
      return User_lead_send_times::delete($row_id);
    }

    protected function get_item_info($row_id){
      return User_lead_send_times::get_by_id($row_id);
    }

    public function eject_url(){
      return inner_url('user_lead_send_times/list/?user_id='.$this->data['user_info']['id']);
    }

    public function url_back_to_item($item_info){
      return inner_url("user_lead_send_times/list/?user_id=".$this->data['user_info']['id']);
    }

    protected function get_fields_collection(){
      return User_lead_send_times::setup_field_collection();
    }

    protected function update_item($item_id,$update_values){
      return User_lead_send_times::update($item_id,$update_values);
    }

    protected function create_item($fixed_values){
        $fixed_values['user_id'] = $this->data['user_info']['id'];
        return User_lead_send_times::create($fixed_values);
    }
    
  }
?>