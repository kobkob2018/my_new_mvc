<?php
  class MenusController extends Controller{
    public $add_models = array("menus");


    protected function init_setup($action){
      $this->data['site'] = Sites::get_user_workon_site();
    }

    public function right_menu(){
        
    } 

  }
?>