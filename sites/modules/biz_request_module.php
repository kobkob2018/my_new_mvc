<?php
	class Biz_requestModule extends Module{
        //http://love.com/biz_form/submit_request/?form_id=4&submit_request=1&biz[cat_id]=52&biz[full_name]=demo_post2&biz[phone]=098765432&biz[email]=no-mail&biz[city]=6&cat_tree[0]=47&cat_tree[1]=52

        public $add_models = array(
            "biz_categories"
            ,"siteBiz_forms"
            ,"cities"
            ,"siteBiz_requests"
            ,"leads_complex");

        protected $lead_info;
        public function enter_lead(){
            $action_data = $this->action_data;
            $form_info = $this->controller->data['form_info'];
            $return_array = $action_data['return_array'];
           
            if(!$form_info){
                return;
            }

            $return_array = $this->validate_request($return_array);

            

            if(!$return_array['success']){
                return $return_array;
            }

            $validate_phone_duplications = $this->validate_phone_duplications($return_array);


            //create duplication mockup for spammers, with a success true result
            if(!$validate_phone_duplications){
                $return_array['html'] = $this->controller->include_ob_view('biz_form/request_success_mokup.php');
                return $return_array;
            }

            //exit("what");
            $this->lead_info['page_id'] = $form_info['page_id'];

            $cat_tree = Biz_categories::simple_get_item_parents_tree($this->lead_info['cat_id'],"*");
            $city_tree = Cities::simple_get_item_parents_tree($this->lead_info['city'],"*");
            $this->lead_info['cat_tree'] = $cat_tree;
            $this->add_cat_tree_to_db_values();
            $this->lead_info['city_tree'] = $city_tree;
            if(isset($_REQUEST['extra'])){
                $this->lead_info['extra'] = $_REQUEST['extra'];
            }

            $lead_sends_arr = Leads_complex::find_users_for_lead($this->lead_info);

            $this->lead_info['recivers'] = $lead_sends_arr['send_count'];

            $optional_fields = array(
                'ip',
                'cat_id',
                'c1',
                'c2',
                'c3',
                'c4',
                'city_id',
                'site_id',
                'page_id',
                'form_id',
                'is_mobile',
                'banner_id',
                'aff_id',
                'referrer',
                'recivers',
                'full_name',
                'phone',                
                'note',
                'extra_info',
            );

            $fixed_db_values = array();
            foreach ($optional_fields as $field){
                if(isset($this->lead_info[$field])){
                    $fixed_db_values[$field] = $this->lead_info[$field];
                }
            }

            $request_id = SiteBiz_requests::create($fixed_db_values);

            $this->send_leads_to_users($request_id,$fixed_db_values,$lead_sends_arr);

            $return_array['html'] = $this->controller->include_ob_view('biz_form/request_success.php',$this->lead_info);

            return $return_array;

        }
        protected function add_cat_tree_to_db_values(){
            $cat_tree = $this->lead_info['cat_tree'];
            $optional_values = array(
                '0'=>'c1',
                '1'=>'c2',
                '2'=>'c3',
                '3'=>'c4'
            );
            foreach($cat_tree as $cat_key=>$cat){
                $field_key = $optional_values[$cat_key];
                $this->lead_info[$field_key] = $cat['id'];
            }
        }
        protected function validate_request($return_array){
            
            if(!filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)){
                $return_array['success'] = false;
                $return_array['error'] = array('msg'=>"אירעה שגיאה. אנא טען את הדף ונסה שוב");
                return $return_array;
            }

            
            if(!isset($_REQUEST['biz']) || ! is_array($_REQUEST['biz'])){
                $return_array['success'] = false;
                $return_array['error'] = array('msg'=>"אירעה שגיאה. אנא טען את הדף ונסה שוב");
                return $return_array;
            }

            $this->lead_info = $_REQUEST['biz'];
            $this->lead_info['ip'] = $_SERVER['REMOTE_ADDR'];
            
            $fields_collection = SiteBiz_requests::setup_field_collection();
            

            $form_info = $this->controller->data['form_info'];
            $input_remove_arr = $form_info['input_remove_arr'];

            foreach($fields_collection as $field_key=>$field){
                
                if(in_array($field_key, $input_remove_arr)){
                    unset($fields_collection[$field_key]);
                    continue;
                }
                
                if(!isset($_REQUEST['biz'][$field_key])){
                    $return_array['success'] = false;
                    $return_array['error'] = array('msg'=>"אירעה שגיאה. אנא טען את הדף ונסה שוב");
                    return $return_array;
                }
            }

            $form_handler = $this->controller->init_form_handler("biz_request");
            $form_handler->update_fields_collection($fields_collection);
            $validate_result = $form_handler->validate('biz');

            if(!$validate_result['success']){
                $return_array['success'] = false;
                $return_array['error'] = array('msg'=>$validate_result['err_messages']);
                return $return_array;
            }

            if(isset($_REQUEST['extra'])){
                $this->lead_info['extra_info'] = json_encode($_REQUEST['extra']);
            }
            //now good
            return $return_array;

        }

        protected function validate_phone_duplications($return_array){
            $phone = $this->lead_info['phone'];
            if($phone == ""){
                return true;
            }
            $weekly_phone_duplications = SiteBiz_requests::count_weekly_phone_duplications($phone);
            if($weekly_phone_duplications < 3){
                return false;
            }
            return true;
        }

        protected function send_leads_to_users($request_id,$fixed_db_values,$lead_sends_arr){
            $cat_tree_name_arr = array();
            foreach($this->lead_info['cat_tree'] as $cat_name){
                $cat_tree_name_arr[] = $cat_name; 
            }
            $cat_tree_name = implode(", ",$cat_tree_name_arr);
            $this->lead_info['cat_tree_name'] = $cat_tree_name;
            foreach($lead_sends_arr['users'] as $user_id=>$user){
                $user_email = $user['info']['email'];
                $mail_title = "בקשה להצעת מחיר באתר";
                $lead_info = $this->lead_info;
                $lead_info['phone'] = substr_replace( $lead_info['phone'] , "****" , 4 , 4 );
                $lead_info['email'] = '****@****';

                
                $info = array(
                    'lead'=>$lead_info,
                    'user'=>$user,
                    'site'=>$this->controller->data['site'],
                );
                $mail_content = $this->controller->include_ob_view('emails/lead_alert.php',$this->lead_info);
              
                //  $this->controller->send_email($user['info']['email'], $mail_title ,$email_content);
            }
            print_r_help($info);
            exit();
        }
	}
?>