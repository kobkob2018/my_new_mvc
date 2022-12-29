<?php
	class MessagesModule extends Module{


		
        public function errorMessages(){
            $val1 = "first value";
            $val2 = "second value";
            $this->add_data('errorMessages',array("one"=>"jon","two"=>"do do do"));


            echo "works untill now";
            $this->include_view('messages/testMessage.php');
        }

	}
?>