<?php
  class Tasks extends Model{
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly

    public static function create($field_values){
		return self::simple_create_by_table_name($field_values,'tasks');
    }

    public static function delete($row_id){
		return self::simple_delete_by_table_name($row_id,'tasks');
    }

    public static function update($row_id, $field_values){
        return self::simple_update_by_table_name($row_id, $field_values,'tasks');
    }

    public static function get_list(){
        $filter_arr = array();
        return self::simple_get_list_by_table_name($filter_arr, 'tasks');
    }

    public static function get_by_id($row_id){
        $filter_arr = array('id'=>$row_id);
        return self::simple_find_by_table_name($filter_arr,'tasks');
    }

    public static $fields_colection = array(
        'user_id'=>array(
            'label'=>'שיוך למשתמש',
            'type'=>'select',
            'options_method'=>array('model'=>'Tasks','method'=>'get_select_user_options'),
            'validation'=>'required'
        ),
        'title'=>array(
            'label'=>'כותרת',
            'type'=>'text',
            'validation'=>'required'
        ),
        'description'=>array(
            'label'=>'תיאור',
            'type'=>'textbox',
        ),
        'status'=>array(
            'label'=>'סטטוס',
            'type'=>'select',
            'default'=>'1',
            'options'=>array(
                array('value'=>'0', 'title'=>'לא'),
                array('value'=>'1', 'title'=>'כן')
            ),
            'validation'=>'required'
        ),
        'phone'=>array(
            'label'=>'טלפון',
            'type'=>'text',
            'validation'=>'required, phone'
        ),
        'email'=>array(
            'label'=>'אימייל',
            'validation'=>'required, email',
            'custom_validation'=>'task_email_validate_by',
            'readonly'=> true
        ),

        'visible'=>array(
            'label'=>'נראה באתר',
            'type'=>'select',
            'default'=>'1',
            'options_method'=>array('model'=>'Tasks','method'=>'get_select_yes_no_options'),
            'validation'=>'required'
        ),       

    );
}
?>