<?php
	class admin_accessModule extends Module{

        public function handle_access_default(){
            return $this->handle_access_workon_site_only();
        }

        public function handle_access_login_only(){
            $action_name = $this->action_data;
             if(!$this->user){
                if(strpos($action_name, 'ajax_') === 0){
                    $this->controller->print_json_page(array()); 
                }
                else{
                    session__set('last_requested_url',current_url());
                    $this->redirect_to(inner_url('userLogin/login/'));
                }
                return false;
            }
            session__unset('last_requested_url');
            return true;
        }

        public function handle_access_loggedout_only(){
            if($this->user){
                $this->redirect_to(outer_url(''));
                return false;
            }
            return true;
        }

        public function handle_access_workon_site_only(){
            if(!$this->handle_access_login_only()){
                return false;
            }
            if(!$this->user){ //this one should never happen, but just in case..
                $this->redirect_to(inner_url('userLogin/login/'));
                return false;
            }
            $this->controller->add_model('sites');
            $work_on_site = Sites::get_user_workon_site();
            if(!$work_on_site){
                $this->redirect_to(inner_url('userSites/list/'));
                return false;
            }
            return true;
        }

	}
?>