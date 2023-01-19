<?php
class TableModel extends Model{
    //a TableMode class manages it's own table, and have functions outomatic sqling this table

    protected static $main_table = false;


    public static function find($filter_arr, $select_params = "*", $payload = array()){
        return self::simple_find($filter_arr , $select_params, $payload);
    }

    public static function get_by_id($row_id, $select_params = "*"){
        $filter_arr = array('id'=>$row_id);
        return self::find($filter_arr, $select_params);
    }

    public static function get_list($filter_arr = array(),$select_params = "*", $payload = array()){
        return self::simple_get_list($filter_arr, $select_params, $payload);
    }

    public static function get_item_parents_tree($item_id, $select_params = "*"){
        return self::simple_get_item_parents_tree($item_id, $select_params);
    }

    public static function get_children_list_of($parent_id, $select_params = "*"){
        return self::simple_get_children_list_of($parent_id, $select_params);
    }

    public static function create($field_values){
		return self::simple_create($field_values);
    }

    public static function update($row_id, $field_values){
        return self::simple_update($row_id, $field_values);
    }

    public static function delete($row_id){
		return self::simple_delete($row_id);
    }

    public static function delete_with_offsprings($row_id){
        return self::simple_delete_with_offsprings($row_id);
    }

    public static function rearange_priority($filter_arr){
        return self::simple_rearange_priority($filter_arr);
    }

    public static function get_priority_space($filter_arr, $item_id){
        return self::simple_get_priority_space($filter_arr,$item_id);
    }

    public static function simple_rearange_priority($filter_arr){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_rearange_priority_by_table_name($filter_arr, $table_name);
    }

    public static function simple_get_priority_space($filter_arr, $item_id){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_get_priority_space_by_table_name($filter_arr,$item_id, $table_name);
    }

    public static function simple_update($row_id, $field_values){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_update_by_table_name($row_id, $field_values, $table_name);
    }
  
    public static function simple_delete($row_id){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_delete_by_table_name($row_id, $table_name);
    } 

    public static function simple_delete_list($item_list_in_str){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_delete_list_by_table_name($item_list_in_str, $table_name);
    }

    public static function simple_create($field_values){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_create_by_table_name($field_values, $table_name);
    }

    public static function simple_find($filter_arr, $select_params = "*", $payload = array()){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_find_by_table_name($filter_arr,$table_name , $select_params, $payload);
    }

    public static function simple_get_list($filter_arr, $select_params = "*", $payload = array()){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_get_list_by_table_name($filter_arr,$table_name, $select_params, $payload);
    }
    
    protected static function simple_find_with_filter_req($filter_arr, $select_params = "*"){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_find_with_filter_req_by_table_name($filter_arr,$table_name, $select_params);
    }

    public static function simple_delete_arr($item_arr){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_delete_arr_by_table_name($item_arr, $table_name);
    }   

    public static function simple_get_children_list_of($parent_id, $select_params = "*"){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_get_children_list_of_by_table_name($parent_id, $table_name, $select_params);
    }

    public static function simple_delete_with_offsprings($row_id){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_delete_with_offsprings_by_table_name($row_id, $table_name);
    }

    public static function simple_get_item_offsprings($item_id, $select_params = "*", $recursive_arr = array(), $generation = 0, $item = false){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_get_item_offsprings_by_table_name($item_id, $table_name, $select_params, $recursive_arr, $generation, $item);
    }


    public static function simple_get_item_parents_tree($item_id, $select_params = "*", $recursive_arr = array(), $deep = 0){
        if(!static::$main_table){
            return false;
        }
        $table_name = static::$main_table;
        return self::simple_get_item_parents_tree_by_table_name($item_id, $table_name, $select_params, $recursive_arr, $deep);
    }

    public static function prepare_form_builder_fields($fields_collection){
        foreach($fields_collection as $field_key=>$build_field){
            if(!isset($build_field['type'])){
                $build_field['type'] = 'text';
            }
            if(!isset($build_field['validate_frontend'])){
                $build_field['validate_frontend'] = '';
            }
            
            if($build_field['type'] == 'file' && !isset($build_field['file_type'])){
                $build_field['file_type'] = 'txt';
            }
            $fields_collection[$field_key] = $build_field;
        }
        return $fields_collection;
    }
}

?>