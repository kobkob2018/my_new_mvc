<?php
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
            $this->include_view('biz_form/init_form.php',array('biz_form'=>$biz_form_data));
        }

	}
?>