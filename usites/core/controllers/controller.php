<?php
  class Controller {
	public $use_models = array("userLogin","users","systemMessages","globalSettings");
	public $add_models = array();
	public $data = array();
	public $user = false;
	public $action_output = "";
	public $action_params = array('layout_file'=>'layouts/layout.php','body_layout_file'=>'body/main.php'); 
	public $action_result;
	public $body_class = "";
	public $form_handler;
	public $registered_scripts = array("head"=>array(),"foot"=>array(),"all"=>array());
	protected $send_action_state = false;
	
    public function __construct() {
		
		
		foreach($this->use_models as $add_model){
			$this->add_model($add_model);
		}
		foreach($this->add_models as $add_model){
			$this->add_model($add_model);
		}
		$this->user = Users::get_loged_in_user();
		global $controller,$action;
		$this->body_class = $controller."_".$action;
    }

	protected function handle_access($action){
		switch(get_config('handle_access_default')){
			case 'all':
				return true;
				break;
			case 'login_only':
			default:
				return $this->handle_access_login_only($action);
				break;	
		}
		
	}

	protected function init_setup($action){
		//this is a function to override
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
		$this->init_setup($action);
			
		ob_start();
		$this->action_result = $this->$action();
		$this->action_output = ob_get_clean();

		//send_action_proceed can be also caled from the view function
		$this->send_action_proceed();

		$this->include_view($this->action_params['layout_file']);
		
		return;

	}

	protected function send_action_proceed(){
		if($this->send_action_state){
			return;
		}
		$this->send_action_state = true;

		if(isset($_REQUEST['sendAction'])){
			$method_name = $_REQUEST['sendAction'];
			if(method_exists($this,$method_name)){
				$this->$method_name();
			}
		}
	}

	public function add_model($model_name){
		if(in_array($model_name,get_config('core_models')) && !in_array($model_name,get_config('override_models'))){
			require_once('core/models/'.$model_name.'_model.php');
		}
		else{
			system_require_once('models/'.$model_name.'_model.php');
		}
	}

	protected function set_layout($layout_name){
		$this->action_params['layout_file'] = 'layouts/'.$layout_name.'.php';
	}

	protected function set_body($body_name){
		$this->action_params['body_layout_file'] = 'body/'.$body_name.'.php';
	}

	public function print_action_output(){
		print($this->action_output);
	}

	public function print_body(){
		$this->include_view($this->action_params['body_layout_file']);

		/*
			on blank layout this is not called
		*/ 
	}

	//this is to add view from modules
	public function include_view($view_path, $info_payload = array()){
		$info = $info_payload;
		$views_dir_path = "views/";
		include(system_path($views_dir_path.$view_path));
	}

	public function redirect_to($url){
		$this->set_layout('blank');
		header('Location: '.$url);
	}
	
	public function call_module($module_name,$action_name, $action_data = null){

		if(system_file_exists('modules/' . $module_name . '_module.php')){
			system_require_once('modules/' . $module_name . '_module.php');
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
			echo $module_name."<hr/>";
			//this param not exist so it will invoke notice here
			echo $modulenotfound_worning;

			//do nothing
		}
	}

	//this is to add data from modules (this controller is the module interface)
	public function add_data($dataName,$dataVal){
		$this->data[$dataName] = $dataVal;
	}

	//this is to add data from modules (this controller is the module interface)
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

	protected function init_form_handler(){
		require_once('core/helpers/form_handler.php');
		if($this->form_handler){
			return $this->form_handler;
		}
		$this->form_handler = new Form_handler($this);
		return $this->form_handler;
	}
	
	protected function get_form_input($param){
		return $this->init_form_handler()->get_form_input($param);
	}


	protected function get_select_options($param){
		return $this->init_form_handler()->get_select_options($param);
	}
	
	public function register_script($type,$label, $ref,$place = 'head',$order = array()){
		if(!isset($this->registered_scripts["all"][$label])){
			$this->registered_scripts["all"][$label] = true;
			$new_script = array('type'=>$type,'ref'=>$ref);
			$reg_arr = $this->registered_scripts[$place];


			if(isset($order['before'])){
				$keys = array_keys( $reg_arr );
				$index = array_search( $order['before'], $keys );
				$pos = false === $index ? count( $reg_arr ) : $index;
				//array_merge( array_slice( $reg_arr, 0, $pos ), $new_script, array_slice( $reg_arr, $pos ) );

				$reg_arr = array_slice( $reg_arr, 0, $pos ) + array($label=>$new_script) + array_slice( $reg_arr, $pos );

			}

			elseif(isset($order['after'])){
				$keys = array_keys( $reg_arr );
				$index = array_search( $order['after'], $keys );
				$pos = false === $index ? count( $reg_arr ) : $index + 1;
				//array_merge( array_slice( $reg_arr, 0, $pos ), $new_script, array_slice( $reg_arr, $pos ) );

				$reg_arr = array_slice( $reg_arr, 0, $pos ) + array($label=>$new_script) + array_slice( $reg_arr, $pos );
			}
			else{
				$pos = count( $reg_arr );
				$reg_arr = array_slice( $reg_arr, 0, $pos ) + array($label=>$new_script) + array_slice( $reg_arr, $pos );
			}
			$this->registered_scripts[$place] = $reg_arr;
		}

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