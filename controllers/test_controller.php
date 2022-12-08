<?php
  class TestController extends Controller{

    public function test(){
      $this->data['blankMessage'] = "This will be a blank view";
      //$this->set_layout('blank');
      $this->set_layout('testLayout');
      include('views/test/controllertest.php');
    }


    public function redirectwithmessage_test(){
      //echo "Here start the test";
      $go_to_page = outer_url("test/redirectwithmessage_after_test/");
      $this->redirect_to($go_to_page);
    }

    public function redirectwithmessage_after_test(){

      
      echo "Here start the  test - AFTER!!!";
      
    }

  }
?>