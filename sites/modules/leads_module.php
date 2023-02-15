<?php
	class LeadsModule extends Module{
        public $add_models = array(
            "biz_categories"
            ,"siteBiz_forms"
            ,"cities"
            ,"leads_complex");
        public function send_lead(){
            $action_data = $this->action_data;
            $form_info = $this->controller->data['form_info'];
            $return_array = $action_data['return_array'];
           
            if(!$form_info){
                return;
            }

            $lead_info = $_REQUEST['biz'];
            $cat_tree = Biz_categories::simple_get_item_parents_tree($lead_info['cat_id'],"*");
            $city_tree = Cities::simple_get_item_parents_tree($lead_info['city'],"*");
            $lead_info['cat_tree'] = $cat_tree;
            $lead_info['city_tree'] = $city_tree;
            if(isset($_REQUEST['extra'])){
                $lead_info['extra'] = $_REQUEST['extra'];
            }

            $users_to_send = Leads_complex::find_users_for_lead($lead_info);

            $return_array['users_to_send'] = $users_to_send;
            $return_array['success'] = false;
            $return_array['error'] = array('msg'=>"נסיון מסר נסיון");
            return $return_array;

        }

	}
?>