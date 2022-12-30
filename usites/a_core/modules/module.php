<?php
  class Module {

	  protected $controller;
    protected $action_data;
    protected $user;
    public $add_models = array();

    public function __construct(Controller $controllerInterface,$action_data = null) {
		  $this->controller = $controllerInterface;
      $this->action_data = $action_data;
      $this->user = $controllerInterface->user;
      foreach($this->add_models as $add_model){
        $this->controller->add_model($add_model);
      }
    }

    protected function add_data($dataName,$dataVal){
        $this->controller->add_module_data($dataName,$dataVal);
    }

    protected function include_view($view_path, $info_payload = array()){
        $this->controller->include_view($view_path, $info_payload);
    }
    protected function redirect_to($url){
        $this->controller->redirect_to($url);
    }

  }
?>
