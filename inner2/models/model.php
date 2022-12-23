<?php
  class Model {
	//all model classes extand Model
    public function __construct() {
		
    }

    public static function simple_update_by_table_name($row_id, $field_values, $table_name){
      $fields_sql_arr = array();
      $execute_arr = array('row_identifier'=>$row_id);
      foreach($field_values as $key=>$value){
          $fields_sql_arr[] = "$key = :$key";
          $execute_arr[$key] = $value;
      }
      
      $fields_sql = implode(",",$fields_sql_arr);
      $sql = "UPDATE $table_name SET $fields_sql WHERE id = :row_identifier";
      $db = Db::getInstance();		
      $req = $db->prepare($sql);
      $req->execute($execute_arr);
    }

    public static function simple_create_by_table_name($field_values, $table_name){
      $fields_keys_sql_arr = array();
      $fields_values_sql_arr = array();
      $execute_arr = array();
      foreach($field_values as $key=>$value){
          $fields_keys_sql_arr[] = " $key";
          $fields_values_sql_arr[] = " :$key";
          $execute_arr[$key] = $value;
      }
      
      $fields_keys_sql = implode(",",$fields_keys_sql_arr);
      $fields_values_sql = implode(",",$fields_values_sql_arr);
      $sql = "INSERT INTO $table_name ($fields_keys_sql) VALUES($fields_values_sql)";
      $db = Db::getInstance();		
      $req = $db->prepare($sql);
      $req->execute($execute_arr);
      return $db->lastInsertId();
    }

    

    public static function simple_find_by_table_name($filter_arr,$table_name){
      $req = self::simple_find_with_filter_req_by_table_name($filter_arr,$table_name);
      return $req->fetch();

    }

    public static function simple_get_list_by_table_name($filter_arr,$table_name){
      $req = self::simple_find_with_filter_req_by_table_name($filter_arr,$table_name);
      return $req->fetchAll();	
    }
    
    protected function simple_find_with_filter_req_by_table_name($filter_arr,$table_name){
      $fields_sql_arr = array('1');
      $execute_arr = array('row_identifier'=>$row_id);
      foreach($filter_arr as $key=>$value){
          $fields_sql_arr[] = "$key = :$key";
          $execute_arr[$key] = $value;
      }
      
      $fields_sql = implode(" AND ",$fields_sql_arr);
      $sql = "SELECT * FROM $table_name WHERE $fields_sql";
      $db = Db::getInstance();		
      $req = $db->prepare($sql);
      $req->execute($execute_arr);
      return $req;
    }

    public static function get_select_user_options(){
      $db = Db::getInstance();
      $sql = "SELECT id, full_name FROM users order by full_name";
      $req = $db->prepare($sql);
      $sql_arr = array();
      $req->execute($sql_arr);
      $user_list = $req->fetchAll();
          $return_options = array();
          foreach($user_list as $user){
              $return_options[] = array('value'=>$user['id'],'title'=>$user['full_name']);
          }
          return $return_options;
      }
  
      public static function get_select_yes_no_options(){
        return array(
            array('value'=>'0', 'title'=>'לא'),
            array('value'=>'1', 'title'=>'כן')
        );
      }    

  }
?>