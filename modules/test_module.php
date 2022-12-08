<?php
	class testModule extends Module{


		
        public function test(){
            $this->add_data('testparams',array("one"=>"jon","two"=>"do do do"));
            $this->include_view('views/test/moduletest.php');
        }

        public function nesting_module(){
            $this->add_data('nesting_message',"this is a nesting module");
            $this->include_view('views/test/nestingmoduletest.php');
        }

	}
?>