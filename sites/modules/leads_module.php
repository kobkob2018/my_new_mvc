<?php
	class LeadsModule extends Module{
        //http://love.com/biz_form/submit_form/?form_id=4&submit_form=1&biz[cat_id]=52&biz[full_name]=demo_post2&biz[phone]=098765432&biz[email]=no-mail&biz[city]=6&cat_tree[0]=47&cat_tree[1]=52

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