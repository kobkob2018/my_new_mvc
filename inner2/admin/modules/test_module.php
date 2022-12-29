<?php
	class testModule extends Module{

        public $add_models = array("test");
		
        public function test(){
            $this->add_data('nesting_test_list',Test::get_test_model_data());
            $this->add_data('testparams',array("one"=>"jon","two"=>"do do do"));
            $this->include_view('test/moduletest.php');
        }

        public function nesting_module(){
            $this->add_data('nesting_message',"this is a nesting module");
            $this->include_view('test/nestingmoduletest.php');
        }

        public function help(){
            echo "<hr/>";
            echo "hi this is help function in test module";
            $current_url = get_config('base_url') . $_SERVER["REQUEST_URI"];
            echo "<p> here is the session:</p>";
           
           // session__clear();
            var_dump($_SESSION);
            echo "<hr/>";
            print_r($_REQUEST);
            echo "<hr/>";
        }

	}
?>