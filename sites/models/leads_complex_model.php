<?php
  class Leads_complex extends TableModel{

    /*
    public function example_from_old_code(){

        //this is how you deside if to send in open mode and also charge, 
        // or just send in open mode without charge
        // or not send in open mode
        $open_mode_final = false;
        if($user['open_mode']>0){ 
            if($user['leadQry']>0){
                $open_mode_final = true;
            }
            else{
                if($user['freeSend']>0){
                    $open_mode_final = true;
                }								
            }							
        }		
    }
*/
    public static function find_users_for_lead($lead_info){
        $lead_info = self::get_category_defaults($lead_info);
        $lead_info['cat_id_arr'] = self::get_tree_id_arr($lead_info['cat_tree']);
        $lead_info['city_id_arr'] = self::get_tree_id_arr($lead_info['city_tree']);

        
        $optional_user_ids = self::get_cat_user_ids($lead_info);

        print_r_help($optional_user_ids,"get_cat_user_ids");

        $optional_user_ids = self::filter_inactive_users($optional_user_ids);

        print_r_help($optional_user_ids,"filter_inactive_users");
        $optional_user_ids = self::filter_city_users($optional_user_ids, $lead_info);
        print_r_help($optional_user_ids,"filter_city_users");
        print_r_help($lead_info['city_tree']);
        return array('stam'=>'po');
    }

    public static function get_category_defaults($lead_info){
        $cat_tree = $lead_info['cat_tree'];
        $defaults = array(
            'max_lead_send'=>'0'
        );
        foreach($defaults as $key=>$value){
            foreach($cat_tree as $cat){
                if(isset($cat[$key]) && $cat[$key] != '0' && $cat[$key] != ""){
                    $defaults[$key] = $cat[$key];
                } 
            }
        }
        foreach($defaults as $key=>$value){
            $lead_info[$key] = $value;
        }
        return $lead_info;
    }

    public static function filter_inactive_users($optional_user_ids){
        if(empty($optional_user_ids)){
            return $optional_user_ids;
        }
        $user_id_in = implode(",",$optional_user_ids);
        $sql = "SELECT id FROM user_lead_settings WHERE id IN($user_id_in)  
        AND active = '1' 
        AND (end_date > now() OR end_date = '0000-00-00')";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $user_ids = array();
        foreach($result as $user){
            $user_ids[] = $user['id'];
        }
        return $user_ids;
    }

    public static function filter_city_users($optional_user_ids, $lead_info){
        if(empty($optional_user_ids)){
            return $optional_user_ids;
        }
        $user_id_in = implode(",",$optional_user_ids);
        $cat_id_in =  implode(",",$lead_info['cat_id_arr']);
        $city_id_in =  implode(",",$lead_info['city_id_arr']);

        $sql = "SELECT distinct user_id FROM user_city 
                WHERE user_id IN($user_id_in)
                AND city_id IN($city_id_in)";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $user_ids = array();
        foreach($result as $user){
            $user_ids[] = $user['user_id'];
        }

        $sql = "SELECT distinct user_id FROM user_cat_city 
                WHERE user_id IN($user_id_in)
                AND city_id IN($city_id_in) 
                AND cat_id IN($cat_id_in)";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        foreach($result as $user){
            if(!in_array($user['user_id'], $user_ids)){
                $user_ids[] = $user['user_id'];
            }
        }       
        return $user_ids;
    }


    public static function get_tree_id_arr($tree){
        $tree_id_arr = array();
        foreach($tree as $item){
            $tree_id_arr[] = $item['id'];
        }
        return $tree_id_arr;
    }

    public static function get_cat_user_ids($lead_info){
        $cat_id_in = implode(",",$lead_info['cat_id_arr']);
        $sql = "SELECT distinct user_id FROM user_cat WHERE cat_id IN ($cat_id_in)";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute();
        $result = $req->fetchAll();
        $user_ids = array();
        foreach($result as $user){
            $user_ids[] = $user['user_id'];
        }
        return $user_ids;
    }
}
?>