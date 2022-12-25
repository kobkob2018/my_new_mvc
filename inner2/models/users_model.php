<?php
  class Users extends Model{

	public static function get_loged_in_user() {
		return UserLogin::get_user();
    }

	public static function get_by_id($user_id, $select_params = "*") {
		$filter_arr = array('id'=>$user_id);
		return self::simple_find_by_table_name($filter_arr,'users', $select_params);
    }

  }
?>