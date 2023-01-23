<?php
  class Helper {
    public static function eazy_index_arr_by($param_name,$arr_to_index,$param_of_value = '*'){
      $index_arr = array();
      foreach($arr_to_index as $key=>$value_arr){
        if($param_of_value == '*'){
          $value = $value_arr;
          if(is_array($value)){
            $value['key_index'] = $key;
          }
        }
        else{
          $value = $value_arr[$param_of_value];
        }
        $index_arr[$value_arr[$param_name]] = $value;
      }
      return $index_arr;
    }

    public static function eazy_index_switch_arr($arr_to_index){
      $index_arr = array();
      foreach($arr_to_index as $key=>$val){
        $index_arr[$val] = $key;
      }
      return $index_arr;
    }

    public static function user_is($needed_roll,$user,$work_on_site = false){
      $user_is = 'logout';
      $login_user_roll_hirachy = array(
        //can go in between these numbers
        5=>'master_admin',
        10=>'admin',
        15=>'author',
        20=>'login'
      );
      if($user){
        $user_is = $login_user_roll_hirachy[$user['roll']];
        if($needed_roll == 'logout'){
          return false;
        }
      }
      else{
        //return if is user loged out or not
        return ($user_is == $needed_roll);
      }

      //now start check hirarchy
      if($work_on_site){
        $user_is = $work_on_site['admin_roll'];
      }

      $exepted_rolls = array();
      foreach($login_user_roll_hirachy as $roll){
        $exepted_rolls[] = $roll;
        if($roll == $needed_roll ){
          break;
        }
      }

      foreach($exepted_rolls as $roll){
        if($roll == $user_is){
          return true;
        }
      }
      return false;
      
    } 
  
  }
?>
