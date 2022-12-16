<?php
  class GlobalSettings extends Model{

    protected static $settings = false;


    public static function get(){
        if(!self::$settings){
            self::$settings = self::get_settings_from_db();
        }
        return self::$settings;
    }

    protected static function get_settings_from_db(){
        return array(
            'login_with_sms'=>'1',
        );
    }
    
	
  }
?>