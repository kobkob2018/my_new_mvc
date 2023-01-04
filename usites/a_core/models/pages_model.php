<?php
  class Pages extends Model{

    protected static $current_page = false;
    protected static $pages_by_link = array();
    protected static $pages_by_id = array();

    public static function get_current_page(){
        if(self::$current_page){
            return self::$current_page;
        }
        if(!isset($_REQUEST['page'])){
            return false;
        }
        self::$current_page = self::get_by_link($_REQUEST['page']);
        return self::$current_page; 
    }

    public static function get_by_id($page_id){
        $current_site = Sites::get_current_site();
        if(!$current_site){
            return false;
        }
        if(!isset(self::$pages_by_id[$page_id])){
            self::$pages_by_id[$page_id] = self::simple_find_by_table_name(array('id'=>$page_id,'site_id'=>$current_site['id']),'content_pages');
        }
        return self::$pages_by_id[$page_id];
    }

    public static function get_by_link($link){
        $current_site = Sites::get_current_site();
        if(!$current_site){
            return false;
        }
        if(!isset(self::$pages_by_link[$link])){
            self::$pages_by_link[$link] = self::simple_find_by_table_name(array('link'=>$link,'site_id'=>$current_site['id']),'content_pages');
        }
        return self::$pages_by_link[$link];
    }


  }
?>