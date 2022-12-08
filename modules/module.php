<?php
  class Module {
	private $controller;
    private $action_data;
    public function __construct($controllerInterface,$action_data = null) {
		$this->controller = $controllerInterface;
        $this->action_data = $action_data;
    }

    protected function add_data($dataName,$dataVal){
        $this->controller->add_module_data($dataName,$dataVal);
    }

    protected function include_view($view_path){
        $this->controller->include_view($view_path);
    }
  }
?>
