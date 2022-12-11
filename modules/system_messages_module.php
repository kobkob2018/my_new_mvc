<?php
	class System_messagesModule extends Module{


		
        public function show(){
            $system_messages = SystemMessages::get_all();
            
			//var_dump($system_messages);
			$this->add_data('success_messages',$system_messages['seccess']);
			$this->add_data('err_messages',$system_messages['err']);
            $this->include_view('views/messages/all.php');

            
        }

	}
?>