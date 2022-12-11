<?php
  class PagesController extends Controller{

    public function error() {
      include('views/pages/error.php');
    }

    public function controllerError() {
      $this->data['error_message'] = "Missing controller";
      include('views/pages/error.php');
    }

    public function actionError() {
      $this->data['error_message'] = "Missing action";
      include('views/pages/error.php');
    }

    public function blankview(){
      $this->set_layout('blank');
      $this->data['blankMessage'] = "This will be a blank view";
      include('views/pages/error.php');
    }
  }
?>