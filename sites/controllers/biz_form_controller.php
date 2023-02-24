<?php
//http://love.com/biz_form/submit_request/?form_id=4&submit_request=1&biz[cat_id]=52&biz[full_name]=demo_post2&biz[phone]=098765432&biz[email]=no-mail&biz[city]=6&cat_tree[0]=47&cat_tree[1]=52
  class Biz_formController extends CrudController{
    public $add_models = array("sitePages","biz_categories","siteBiz_forms","cities");


    protected function init_setup($action){
      return parent::init_setup($action);
    }

    public function fetch(){

        $return_array = $this->init_form_data();
        if(!$this->check_continue($return_array)){
            
            return $this->print_json_page($return_array);
        }

        if(isset($_REQUEST['test_form'])){
            return $this->test_form_mokup($return_array);
        } 

        $return_array = $this->get_cat_children_select($return_array);
        if(!$this->check_continue($return_array)){
            return $this->print_json_page($return_array);
        }
        if(!$return_array['have_children']){
            $return_array = $this->get_cat_final_fields($return_array);
        }
        return $this->print_json_page($return_array);
    }

    public function init_form_data(){
        
        $return_array = array(
            'state'=>'waiting',
            'success'=>true
        );  
        if(!isset($_REQUEST['form_id'])){
            $return_array['success'] = false;
            $return_array['error'] = array('msg'=>'missing form id');
            return $return_array;
        }
        $form_info = siteBiz_forms::get_by_id($_REQUEST['form_id']);


        $input_remove = $form_info['input_remove'];
        $input_remove_arr = explode(",",$input_remove);
        
        foreach($input_remove_arr as $remove_input){
            $input_remove_arr[] = trim($remove_input);
        }
        $form_info['input_remove_arr'] = $input_remove_arr;
        $this->data['form_info'] = $form_info;

        return $return_array;
    }

    public function check_continue($return_array){
        if($return_array['success'] != true){
            return false;
        }
        return true;
    }

    public function submit_request(){
        
        $return_array = $this->init_form_data();
        
        if(!$this->check_continue($return_array)){  
            return $this->print_json_page($return_array);
        }

        if(!isset($_REQUEST['biz'])){
            $return_array['success'] = false;
            $return_array['error'] = array('msg'=>'empty form');
            return $this->print_json_page($return_array);
        }

        if($_REQUEST['biz']['full_name'] == 'demo_post'){
            return $this->init_post_demo_url($return_array);
        } 
        $return_array = $this->call_module("biz_request","enter_lead",array('return_array'=>$return_array));
        return $this->print_json_page($return_array);
    }

    public function init_post_demo_url($return_array){
        $str = "";
        foreach($_REQUEST as $key=>$val){
            if(is_array($val)){
                foreach($val as $k=>$v){
                    $str .= "&$key"."[".$k."]=$v";
                }
            }
            else{
                $str .= "&$key=$val";
            }
        }
        $str = outer_url("biz_form/submit_request/?v=1$str");
        $return_array['success'] = false;
        $return_array['error'] = array('msg'=>"take this:  $str");
        return $this->print_json_page($return_array);
    }

    public function get_cat_final_fields($return_array){
        $parent_tree = Biz_categories::get_item_parents_tree($return_array['cat_id'],'*');
        $extra_fields = array();
        foreach($parent_tree as $cat){
            if($cat['extra_fields'] != ''){
                $extra_fields[] = $cat['extra_fields'];
            }
        }
        $info = array(
            'parent_tree'=>$parent_tree,
            'extra_fields'=>$extra_fields
        );
        $return_array['html'] = $this->include_ob_view('biz_form/fetch_cat_extra_fields.php',$info);
        $return_array['state'] = 'ready';
        $return_array['submit_url'] = inner_url('biz_form/submit_request/?form_id='.$this->data['form_info']['id']);
        return $return_array;
    }

    public function get_cat_children_select($return_array){
        
        if(!isset($_REQUEST['cat_id'])){
            $return_array['success'] = false;
            $return_array['error'] = array('msg'=>'לא נבחרה קטגוריה');
            return $return_array;
        }

        $cat_id = $_REQUEST['cat_id'];
        $return_array['cat_id'] = $cat_id;
        $return_array['have_children'] = false;
        $filter_arr = array('active'=>'1', 'visible'=>'1');
        $cat_children = Biz_categories::get_children_list_of($cat_id,'id,label,parent',$filter_arr);
        if(!$cat_children){
            return $return_array;
        }

        $info = array(
            'cat_id'=>$cat_id,
            'children'=>$cat_children,
            'form_info'=>$this->data['form_info']
        );

        $return_array['have_children'] = true;
        $return_array['html'] = $this->include_ob_view('biz_form/fetch_cat_select.php',$info);
        return $return_array;
    }


    public function test_form_mokup(){
        $return_array['html'] = $this->include_ob_view('biz_form/request_testing_html.php');
        return $this->print_json_page($return_array);
    }

  }
?>