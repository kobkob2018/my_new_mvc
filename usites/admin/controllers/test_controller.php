<?php
  class TestController extends Controller{
    public $add_models = array("test");
    public function test(){
      
      $this->include_view('test/test-test.php');
    }

    protected function handle_access($action){
      switch ($action){
        case 'clear':
        case 'token_login':
          return true;
          break;
        default:
          return parent::handle_access($action);
          break;
        
      }
    }

    public function clear(){
      session__clear();
      echo "clear session";
      $this->set_layout('blank');
    }



    public function token_login(){
      $user_id = null;
      if(isset($_GET['row_id']) && isset($_GET['token'])){
          $user_id = Test::authenticate_token($_GET['row_id'],$_GET['token']);
      }
      $loged_in_user_id = null;
      if($this->user){
        $loged_in_user_id = $this->user['id'];
      }
      if($user_id){
        if($loged_in_user_id != $user_id){
          $login_with_sms = false;
          UserLogin::add_login_trace($user_id,$login_with_sms);
        }
        $this->redirect_to(inner_url('test/show_row/?row_id='.$_GET['row_id']));
      }
      else{
        //if row was not found or not valid
        //but if there is a loged in user allready
        if($this->user){
          $this->redirect_to(inner_url('test/test/'));

        }
        else{
          $this->redirect_to(outer_url('userLogin/login/'));
        }
      }
      
    }

    public function show_row(){
      $row_id = $_GET['row_id'];
      $this->data['test_row_id'] = $user_id = Test::get_by_id($row_id);
      $this->include_view('test/show-row.php');
    }  


    public function test_module(){

      $this->include_view('test/controllertest.php');
    }    

    public function token_login222(){
      if(isset($_GET['row_id']) && isset($_GET['token'])){
        $log_in_user = Test::authenticate_token($_GET['row_id'],$_GET['token']);
        if($log_in_user){
          $_SESSION[$this->session_prefix.'_login_user'] = $log_in_user['id'];
          $_SESSION[$this->session_prefix.'_show_row'] = $_GET['row_id'];
          $go_to_page = inner_url("leads/all/");
          $this->redirect_to($go_to_page);
          return;
        }
        else{
          if(isset($_SESSION[$this->session_prefix.'_login_user'])){
            $go_to_page = inner_url("leads/all/");
            $this->redirect_to($go_to_page);
            return;					
          }
          $this->redirect_to(outer_url('userLogin/login/'));
        }
      }
      
      echo "this is token login"; 
    }

    public function redirectwithmessage_test(){
      
      //echo "Here start the test";
      $go_to_page = outer_url("test/redirectwithmessage_after_test/");
      SystemMessages::add_err_message("this is an error message");

      //var_dump($_SESSION);  

      $this->redirect_to($go_to_page);
    }

    public function redirectwithmessage_after_test(){
      
      
    }

  }
?>