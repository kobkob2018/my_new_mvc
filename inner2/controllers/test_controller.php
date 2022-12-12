<?php
  class TestController extends Controller{
    //public $add_models = array("test");
    public function test(){
      session__clear();



      $session_val =   session__get($session_param);
      session__unset($session_param);
      return $session_val;

      //$this->data['blankMessage'] = "This will be a blank view";
      //$this->set_layout('blank');
      //$this->set_layout('testLayout');
      //$this->add_data('test_list',Test::get_test_model_data());
      
      //var_dump($_SESSION);
      //var_dump($this->user);
      //var_dump($this->userModel);
      

      include('views/test/controllertest.php');
    }


    public function clear(){
      session__clear();
      echo "clear session";
      $this->set_layout('blank');
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