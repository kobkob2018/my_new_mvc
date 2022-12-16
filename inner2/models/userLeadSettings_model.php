<?php
  class userLeadSettings_model extends Model{
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly

    public static function get(){
        $user = User::get_loged_in_user();
        if(!$user){
            return null;
        }

		$db = Db::getInstance();
		$sql = "select user_id, free_send, lead_credit from user_lead_settings where user_id = :user_id";
		$req = $db->prepare($sql);
		$req->execute(array('user_id'=>$user_data['id']));
		$user_lead_settings = $req->fetch();
        return $user_lead_settings;
    }
	
  }
?>