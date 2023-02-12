<?php
  class Biz_formsController extends CrudController{
    public $add_models = array("sitePages","biz_categories","siteBiz_forms","cities");


    protected function init_setup($action){
      return parent::init_setup($action);
    }

    public function fetch(){
        
        $return_array = $this->init_form_data();
        if(!$this->check_continue($return_array)){
            
            return $this->print_json_page($return_array);
        }

        if(isset($_REQUEST['submit_form'])){
            return $this->submit_form($return_array);
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
        $input_remove = array();
        if($form_info['input_remove'] != ''){
            $input_remove_arr = explode(',',$form_info['input_remove']);
            foreach($input_remove_arr as $input_name){
                $input_remove = trim($input_name);
            }
        }
        $form_info['input_remove'] = $input_remove;
        $this->data['form_info'] = $form_info;

        
        return $return_array;
    }

    public function check_continue($return_array){
        if($return_array['success'] != true){
            return false;
        }
        return true;
    }

    public function submit_form(){

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

  }
?>