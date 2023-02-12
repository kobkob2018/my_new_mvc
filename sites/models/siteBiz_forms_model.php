<?php
  class SiteBiz_forms extends TableModel{

    protected static $main_table = 'biz_forms';

    protected static $current_biz_form = false;

    protected static $current_biz_form_set = false;

    public static function get_current_biz_form(){
        if(self::$current_biz_form_set){
            return self::$current_biz_form;
        }
        $current_page = SitePages::get_current_page();
        $site = Sites::get_current_site();
        if(!$current_page){
            return false;
        }
        $filter_arr = array(
            'page_id'=>$current_page['id'],
            'site_id'=>$site['id']
        );

        $current_biz_form_arr = self::get_list($filter_arr);
        if(is_array($current_biz_form_arr) && isset($current_biz_form_arr[0])){
            self::$current_biz_form = $current_biz_form_arr[0];
        }
        else{
            self::$current_biz_form = false;
        }
        self::$current_biz_form_set = true;   
        return self::$current_biz_form;
    }
}
?>