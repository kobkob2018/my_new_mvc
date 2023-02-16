<?php
//http://love.com/biz_form/submit_form/?form_id=4&submit_form=1&biz[cat_id]=52&biz[full_name]=demo_post2&biz[phone]=098765432&biz[email]=no-mail&biz[city]=6&cat_tree[0]=47&cat_tree[1]=52

	class Biz_formModule extends Module{
        public $add_models = array("biz_categories","siteBiz_forms","cities");
        public function fetch_form(){
            $biz_form_data = siteBiz_forms::get_current_biz_form();
            if(!$biz_form_data){
                return;
            }
            $this->add_data('biz_form',$biz_form_data);
            $city_select = array(
                'options'=>Cities::get_flat_select_city_options()
            );
            $this->add_data('city_select',$city_select);



            $input_remove = array();
            if($biz_form_data['input_remove'] != ''){
                $input_remove_arr = explode(',',$biz_form_data['input_remove']);
                foreach($input_remove_arr as $input_name){
                    $input_name = trim($input_name);
                    $input_remove[$input_name] = '1';
                }
            }
            $info = array(
                'biz_form'=>$biz_form_data,
                'input_remove'=>$input_remove
            );

            $this->include_view('biz_form/init_form.php',$info);
        }

	}
?>