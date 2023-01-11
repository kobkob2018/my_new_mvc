<?php
  class Users extends TableModel{

    protected static $main_table = 'users';

	public static function get_loged_in_user() {
		return UserLogin::get_user();
    }

	public static function get_by_id($user_id, $select_params = "*") {
		$filter_arr = array('id'=>$user_id);
		return self::simple_find($filter_arr, $select_params);
    }

  }
?>