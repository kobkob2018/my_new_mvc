<?php
  class PagesController extends Controller{

    public function error() {
      SystemMessages::add_err_message("Oops! seems like you are in the wrong place");
      include('views/pages/error.php');
    }

    protected function handle_access($action){
      switch ($action){
        case 'error':
        default:
          return true;
          break;
        
      }
    }


    protected function home(){
      include('views/pages/home.php');
    }

  }
?>