<?php
  class TestController extends Controller{
    public $add_models = array("test");
    public function test(){

      //$this->data['blankMessage'] = "This will be a blank view";
      //$this->set_layout('blank');
      //$this->set_layout('testLayout');
      //$this->add_data('test_list',Test::get_test_model_data());
      
      //var_dump($_SESSION);
      //var_dump($this->user);
      //var_dump($this->userModel);
      

      include('views/test/controllertest.php');
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