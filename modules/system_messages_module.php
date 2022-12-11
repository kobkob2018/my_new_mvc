<?php
	class System_messagesModule extends Module{


		
        public function show(){
            if(session__isset('success_messages')){
				$this->add_data('success_message', session__get('success_message'));
				session__unset('success_message');
			}
			if(session__isset('err_messages')){
				$this->add_data('err_messages', session__get('err_messages'));
				unset($_SESSION[$this->session_prefix.'err_messages']);
			}
            else{

                $this->add_data('err_messages',array('Here is a test message at','system_messages_module '));
            }
            
            $this->include_view('views/messages/all.php');

            
        }

	}
?>