<?php
  class Controller {
	public $use_models = array("user","systemMessages","globalSettings");
	public $add_models = array();
	public $controller_name;
	public $action_name;
	public $data = array();
	public $user = false;
	public $form_return_params = array();
	public $form_message = false;
	public $action_output = "";
	public $action_params = array('layout_file'=>'views/layout.php','body_layout_file'=>'views/body/main.php'); 
	public $action_result;
	public $body_class = "";
	public $cash_version = "1.0";
    public function __construct() {
		
		foreach($this->use_models as $add_model){
			require_once('models/'.$add_model.'_model.php');
		}
		foreach($this->add_models as $add_model){
			require_once('models/'.$add_model.'_model.php');
		}
		$this->user = User::get_loged_in_user();
		global $controller,$action;
		$this->controller_name = $controller;
		$this->action_name = $action;
		$this->body_class = $controller."_".$action;
    }

	protected function handle_access($action){
		return $this->handle_access_login_only($action);
	}

	//Please note override functions in extending classes
	protected function handle_access_login_only($action){
		if(!$this->user){
			if(strpos($action, 'ajax_') === 0){
				$this->print_json_page(array()); 
			}
			else{
				$current_url = get_config('base_url') . $_SERVER["REQUEST_URI"];
				session__set('last_requested_url',$current_url);
				$this->redirect_to(outer_url('userLogin/login/'));
			}
			return false;
		}
		session__unset('last_requested_url');
		return true;
   }

	public function print_layout($action){

		if(!$this->handle_access($action)){
			return;
		}

		//currently ignore user login restrictions
		if(true){
			
			ob_start();
			$this->action_result = $this->$action();
			$this->action_output = ob_get_clean();
			
			
			if(isset($_REQUEST['sendAction'])){
				$method_name = $_REQUEST['sendAction'];
				if(method_exists($this,$method_name)){
					$this->$method_name();
				}
			}
			
				
			include($this->action_params['layout_file']);
			
			return;
		}



		if(isset($_GET['row_id']) && isset($_GET['token'])){
			$log_in_user = User::logInUserWithToken($_GET['row_id'],$_GET['token']);
			if($log_in_user){
				$_SESSION[$this->session_prefix.'_login_user'] = $log_in_user['id'];
				$_SESSION[$this->session_prefix.'_show_row'] = $_GET['row_id'];
				$go_to_page = inner_url("leads/all/");
				$this->redirect_to($go_to_page);
				return;
			}
			else{
				if(isset($_SESSION[$this->session_prefix.'_login_user'])){
					$go_to_page = inner_url("leads/all/");
					$this->redirect_to($go_to_page);
					return;					
				}
				$this->redirect_to(outer_url('userLogin/login/'));
			}
		}
		elseif(isset($_GET['qty_unk']) && isset($_GET['qty_token'])){
			$log_in_user = User::logInUserWithQtyToken($_GET['qty_unk'],$_GET['qty_token']); 
			if($log_in_user){
				$_SESSION[$this->session_prefix.'_login_user'] = $log_in_user['id'];
				$_SESSION[$this->session_prefix.'_show_row'] = $_GET['row_id'];
				$go_to_page = inner_url("credits/buyLeads/");
				$this->redirect_to($go_to_page);
				return;
			}
			else{
				if(isset($_SESSION[$this->session_prefix.'_login_user'])){
					$go_to_page = inner_url("leads/all/");
					$this->redirect_to($go_to_page);
					return;					
				}
				$this->redirect_to(outer_url('userLogin/login/'));
			}
		}		
		elseif(!$this->user && get_class($this) != 'UserLoginController'){
			if(strpos($action, 'ajax_') === 0){
				$this->print_json_page(array()); 
			}
			else{
				$this->redirect_to(outer_url('userLogin/login/'));
			}
		}
		elseif($this->user && get_class($this) == 'UserLoginController'){			
			$this->redirect_to(outer_url(''));
		}
		elseif(isset($_GET['row_id']) && isset($_SESSION[$this->session_prefix.'_login_user'])){
			$_SESSION[$this->session_prefix.'_show_row'] = $_GET['row_id'];
			$go_to_page = inner_url('leads/all/');
			$this->redirect_to($go_to_page);
			return;
		}
		else{
			ob_start();
			$this->action_result = $this->$action();
			$this->action_output = ob_get_clean();
			
			if(isset($_SESSION[$this->session_prefix.'_success_message'])){
				$this->session_success_message = $_SESSION[$this->session_prefix.'_success_message'];
				unset($_SESSION[$this->session_prefix.'_success_message']);
			}
			if(isset($_SESSION[$this->session_prefix.'_err_message'])){
				$this->session_err_message = $_SESSION[$this->session_prefix.'_err_message'];
				unset($_SESSION[$this->session_prefix.'_err_message']);
			}			
			if(isset($_REQUEST['sendAction'])){
				$method_name = $_REQUEST['sendAction'];
				if(method_exists($this,$method_name)){
					$this->$method_name();
				}
			}
			
			include($this->action_params['layout_file']);
			
		}
	}

	public function add_model(){
		
	}

	protected function set_layout($layout_name){
		$this->action_params['layout_file'] = 'views/layouts/'.$layout_name.'.php';
	}

	protected function set_body($body_name){
		$this->action_params['body_layout_file'] = 'views/body/'.$body_name.'.php';
	}

	public function print_action_output(){
		print($this->action_output);
	}

	public function print_body(){
		include($this->action_params['body_layout_file']);

		/*
			on blank layout this is not called
		*/ 
	}

	public function include_view($view_path){
		include($view_path);
	}

	public function redirect_to($url){
		$this->set_layout('blank');
		header('Location: '.$url);
	}
	
	public function call_module($module_name,$action_name, $action_data = null){

		if(file_exists('modules/' . $module_name . '_module.php')){
			require_once('modules/' . $module_name . '_module.php');
			$module_class = ucfirst($module_name)."Module";
			if(method_exists(ucfirst($module_class),$action_name)){		
				$module = new $module_class($this, $action_data);
				$module->$action_name();
			}
			else{
				//this param not exist so it will invoke notice here
				echo $module_method_not_found_worning;
				//do nothing
			}			
		}
		else{
			//this param not exist so it will invoke notice here
			echo $modulenotfound_worning;
			//do nothing
		}
	}

	public function add_data($dataName,$dataVal){
		$this->data[$dataName] = $dataVal;
	}

	public function add_module_data($dataName,$dataVal){
		//currently we add module data as norrmal data. considering care for naming convension
		$this->add_data($dataName,$dataVal);
	}

	protected function send_email($email_to, $email_title,$email_content){
		$email_sender = get_config('email_sender'); 
		$email_sender_name = get_config('email_sender_name');
		// Set content-type header for sending HTML email 
		$headers = "MIME-Version: 1.0" . "\r\n"; 
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
		
		// Additional headers 
		$headers .= 'From: '.$email_sender_name.'<'.$email_sender.'>' . "\r\n"; 
		mail($email_to,$email_title,$email_content,$headers);
	}

	function form_return_val($param){
		if(isset($this->form_return_params[$param])){ 
			return $this->form_return_params[$param];
		}		
		return "";
	}
	public function print_json_page($print_result){
		


		$user_arr = array();
		$user_arr['login'] = '0';
		if($this->user){
			$user_arr['login'] = '1';
			$user_params = array(
				"id",
				"unk",
				"city",
				"city_area",
				"creditMoney",
				"deleted",
				"domain",
				"email",
				"end_date",
				"fax",
				"fb_campaign_phone",
				"full_name",
				"gender",
				"gl_campaign_phone",
				"h_refund",
				"leadPrice",
				"leads_credit",
				"name",
				"phone",
				"birthday",
				"freeSend",
				"open_mode",
				"autoSendLeadContact",
				"hasSpecialClosedLeadAlert",
			);
			foreach($user_params as $user_param){
				$user_arr[$user_param] = $this->user[$user_param];
			}
		}	
		$print_result['user'] = $user_arr;
		$this->set_layout('blank');
		echo json_encode($print_result);
	}
	
  }
?>