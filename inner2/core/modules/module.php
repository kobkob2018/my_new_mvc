<?php
  class Module {
	  private $controller;
    private $action_data;
    public $add_models = array();
    public function __construct($controllerInterface,$action_data = null) {
		  $this->controller = $controllerInterface;
      $this->action_data = $action_data;
      foreach($this->add_models as $add_model){
        system_require_once('models/'.$add_model.'_model.php');
      }
    }

    protected function add_data($dataName,$dataVal){
        $this->controller->add_module_data($dataName,$dataVal);
    }

    protected function include_view($view_path, $info_payload = array()){
        $this->controller->include_view($view_path, $info_payload);
    }
  }
?>
