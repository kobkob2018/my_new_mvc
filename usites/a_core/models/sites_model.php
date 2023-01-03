<?php
  class Sites extends Model{

    protected static $sites_by_domain = array();
    protected static $sites_by_id = array();
    protected static $sites_arr = array();

    public static function get_current_site(){
        if(!isset(self::$sites_arr['current'])){
            if(session__isset("site_id")){
                self::$sites_arr['current'] = self::get_by_id(session__get("site_id"));
            }
            else{              
                $current_site = self::get_by_domain($_SERVER["HTTP_HOST"]);
                if($current_site){
                    self::$sites_arr['current'] = $current_site;
                    session__set("site_id",self::$sites_arr['current']['id']);
                }
            }
        }
        return self::$sites_arr['current'];
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

    public static function get_user_site_list(){
        $user = UserLogin::get_user();
        if(!$user){
            return false;
        }
        $execute_arr = array('user_id'=>$user['id']);
        $sql = "SELECT st.* FROM sites st LEFT JOIN user_sites us ON us.site_id = st.id WHERE us.user_id = :user_id";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute($execute_arr);
        return $req->fetchAll();
    }   

    public static function get_user_workon_site(){
        $user = UserLogin::get_user();
        if(!$user){
            return false;
        }
        if(!session__isset('workon_site')){
            return false;
        }
        if(isset(self::$sites_arr['workon'])){
            return self::$sites_arr['workon'];
        }

        $site_id = session__get('workon_site');
        $execute_arr = array('user_id'=>$user['id'],'site_id'=>$site_id,'all'=>'*');
        $sql = "SELECT st.*, us.roll as 'admin_roll' 
                FROM sites st 
                LEFT JOIN user_sites us 
                ON us.site_id = st.id 
                WHERE (us.user_id = :user_id AND us.site_id = :site_id)
                OR (us.user_id = :user_id AND us.site_id = :all)";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute($execute_arr);
        self::$sites_arr['workon'] = $req->fetch();
        return self::$sites_arr['workon'];
    }

    public static function check_user_workon_site($site_id){
        $user = UserLogin::get_user();
        if(!$user){
            return false;
        }

        $execute_arr = array('user_id'=>$user['id'],'site_id'=>$site_id,'all'=>'*');
        $sql = "SELECT * FROM user_sites 
            WHERE (user_id = :user_id AND site_id = :site_id)
            OR (user_id = :user_id AND site_id = :all)";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute($execute_arr);
        $result = $req->fetch();
        if($result){
            session__set('workon_site',$site_id);
            return $site_id;
        }
        return false;
    }   

    public static function get_user_workon_site_asset_dir(){
        $workon_site = self::get_user_workon_site();
        return self::get_site_asset_dir($workon_site);
    }

    public static function get_current_site_asset_dir(){
        $workon_site = self::get_current_site();
        return self::get_site_asset_dir($workon_site);
    }

    public static function get_site_asset_dir($site){
        $return_array = array(
            'url'=>'',
            'path'=>'',
        );
        
        $sites_build_format = get_config('sites_build_format');
        $site_url_http_s = 'http://';
        if($site['is_secure']){
            $site_url_http_s = 'https://';
        }
        $site_url = $site_url_http_s.$site['domain'];
        if(get_config('base_url_dir') != ''){
            $site_url.='/'.get_config('base_url_dir');
        }
        if($sites_build_format == 'symlinks'){
            $return_array['path'] = get_config('domains_path').'/'.$site['domain'].'/public_html/'.'assets/';
            $return_array['url'] = $site_url.'/assets/';
            if(get_config('mode') == 'dev'){
                $return_array['url'] = $site_url.'/'.get_config('domains_path').'/'.$site['domain'].'/public_html/'.'assets/';
            }
        }
        elseif($sites_build_format == 'pointer_to_main'){
            $return_array['path'] = '/sites_assets/'.$site['id'].'/';
            $return_array['url'] = $site_url.'/sites_assets/'.$site['id'].'/';
        }
        return $return_array;
    }
  }
?>