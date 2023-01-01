<?php
  class View {

    protected Controller $controller;
    public function __construct(Controller $controller_interface){
      $this->controller = $controller_interface;
    }

    public function a_class($relative_url){
        global $controller,$action;
        $current_relative_url = "$controller/$action/";
        if($relative_url == $current_relative_url){
            return "a-selected";
        }
        return "a-simpel";
    }

    public function user_is($needed_roll){
      $user = $this->controller->user;
      $work_on_site = false;
      $data = $this->controller->data;
      if(isset($data['work_on_site'])){
        $work_on_site = $data['work_on_site'];
      }
      return Helper::user_is($needed_roll,$user,$work_on_site);
    }
}

?>