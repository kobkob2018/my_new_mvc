<?php
	class cron_emailsModule extends Module{
        public $add_models = array("user_pending_emails");
        public function send_pending_emails(){
            $pending_emails = User_pending_emails::get_list();
            foreach($pending_emails as $pending_email){
                
            }
        }

	}
?>