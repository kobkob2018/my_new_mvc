<?php
	class TasksController extends Controller{
protected $stage_check = 1;
		public $add_models = array("tasks");
        protected function handle_access($action){
            switch ($action){
                default:
                return true;
                break;
                
            }
        }

		public function all(){
            $this->data['task_list'] = Tasks::get_list();
            include('views/tasks/all.php');
		}

        public function view(){
            if(!isset($_GET['row_id'])){
                return $this->redirect_to(inner_url('tasks/all/'));
            }

            $this->data['task_info'] = Tasks::get_by_id($_GET['row_id']);
            if(!$this->data['task_info']){
                return $this->redirect_to(inner_url('tasks/all/'));
            }
            
            $form_handler = $this->init_form_handler();
            $form_handler->setup_fields_collection(Tasks::$fields_colection);
            $form_handler->setup_db_values($this->data['task_info']);

            $this->send_action_proceed();


            include('views/tasks/view.php');
            
		}

        public function updateSend(){
            if(!isset($_REQUEST['row_id'])){
                return;
            }
            $row_id = $_REQUEST['row_id'];
            $form_handler = $this->init_form_handler();
            $validate_result = $form_handler->validate();
            if($validate_result['success']){
                Tasks::update($row_id,$validate_result['fixed_values']);
                SystemMessages::add_success_message("המשימה נשמרה בהצלחה");
                $this->redirect_to(current_url());
            }
            else{
                if(!empty($validate_result['err_messages'])){
                    $this->data['form_err_messages'] = $validate_result['err_messages'];
                }
            }
        }

        public function add(){
            $form_handler = $this->init_form_handler();
            $form_handler->setup_fields_collection(Tasks::$fields_colection);
            $this->send_action_proceed();
            include('views/tasks/add.php');           
		}       

        public function createSend(){
            $form_handler = $this->init_form_handler();
            $validate_result = $form_handler->validate();
            if($validate_result['success']){
                $row_id = Tasks::create($validate_result['fixed_values']);
                SystemMessages::add_success_message("המשימה נוספה בהצלחה");
                $this->redirect_to(inner_url("tasks/view/?row_id=$row_id"));
            }
            else{
                if(!empty($validate_result['err_messages'])){
                    $this->data['form_err_messages'] = $validate_result['err_messages'];
                }
            }
        }

        public function task_email_validate_by($value){
            $return_array =  array(
                'success'=>true
            );
            if($value == 'notgood@gmail.com'){
                $return_array['success'] = false;
                $return_array['message'] = "האימייל שבחרת לא מותר";
            }
            return $return_array;
        }
	}
?>