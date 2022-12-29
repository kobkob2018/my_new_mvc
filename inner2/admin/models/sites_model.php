<?php
  class Sites extends Model{

    protected static $current_site = false;
    protected static $sites_by_domain = array();
    protected static $sites_by_id = array();


    public static function get_current_site(){
        if(!self::$current_site){
            if(session__isset("site_id")){
                self::$current_site = self::get_by_id(session__get("site_id"));
            }
            else{
                self::$current_site = self::get_by_domain($_SERVER["HTTP_HOST"]);
                if(self::$current_site){
                    session__set("site_id",self::$current_site['id']);
                }
            }
        }
        return self::$current_site;
    }

    public static function get_by_id($site_id){
        if(!isset(self::$sites_by_id[$site_id])){
            self::$sites_by_id[$site_id] = self::simple_find_by_table_name(array('id'=>$site_id),'sites');
        }
        return self::$sites_by_id[$site_id];
    }

    public static function get_by_domain($domain_name){
        if(!isset(self::$sites_by_domain[$domain_name])){
            self::$sites_by_domain[$domain_name] = self::simple_find_by_table_name(array('domain'=>$domain_name),'sites');
        }
        return self::$sites_by_domain[$domain_name];
    }

  }
?>