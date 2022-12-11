<?php
//only for loged out user
   class UserLoginController extends Controller{  
   
	function __construct() {
        parent::__construct();
        $this->set_body('clean');
    }
	public function loginSend(){
		$log_in_user = User::logInUser($_REQUEST['user_username'],$_REQUEST['user_pass']);
		if($log_in_user){
			session__set('login_user',$log_in_user['id']);
			$go_to_page = outer_url('');
			if(session__isset('last_requested_url')){
				$go_to_page = session__get('last_requested_url');
				session__unset('last_requested_url');
			}
			
			$this->redirect_to($go_to_page);
			return;
		}
		else{
			$this->err_messages[] = "שם המשתמש והסיסמה אינם תואמים"; 
		}		
	}

	public function forgotPasswordSend(){
		$data_user = User::checkUserEmailExists($_REQUEST['user_email']);
		if($data_user){
			$email = trim($data_user['email']);
			//html email message
			ob_start();
				include('views/emailsSend/forgotPasswordEmail.php');
			$content_send_to_Client = ob_get_clean();
			$content_send_to_Client = iconv("UTF-8" , "windows-1255", $content_send_to_Client);
			$fromEmail = "info@ilbiz.co.il"; 
			$fromTitle = iconv("UTF-8" , "windows-1255", "סיסמתך במערכת שיתוף לידים של אילביז");
			$header = iconv("UTF-8" , "windows-1255", "סיסמתך במערכת שיתוף לידים של אילביז");
			$ClientMail = $email;	
			GlobalFunctions::send_emails_with_phpmailer($fromEmail, $fromTitle, $header, $content_send_to_Client, $content_send_to_Client, $ClientMail, $fromTitle );		
			$this->success_messages[] = "סיסמתך נשלחה אל כתובת המייל"; 
		}
		else{
			$this->err_messages[] = "כתובת האימייל לא נמצאה במערכת"; 
		}		
	}
	
    public function login(){
		include('views/user/login.php');
    }

    public function forgotPassword(){
		include('views/user/forgotPassword.php');
    }
	
  }
?>