<?php
  class SiteUsers extends Model{
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly

    public static function create($field_values){
		return self::simple_create_by_table_name($field_values,'user_sites');
    }

    public static function delete($row_id){
		return self::simple_delete_by_table_name($row_id,'user_sites');
    }

    public static function update($row_id, $field_values){
        return self::simple_update_by_table_name($row_id, $field_values,'user_sites');
    }

    public static function get_list($site_id){
        $filter_arr = array('site_id'=>$site_id);
        return self::simple_get_list_by_table_name($filter_arr, 'user_sites');
    }

    public static function get_by_id($row_id){
        $filter_arr = array('id'=>$row_id);
        return self::simple_find_by_table_name($filter_arr,'user_sites');  
    }

    public static $fields_colection = array(
        'user_id'=>array(
            'label'=>'שיוך למשתמש',
            'type'=>'select',
            'options_method'=>array('model'=>'siteUsers','method'=>'get_select_user_options'),
            'validation'=>'required',
            'custom_validation'=>'site_user_validate_by',
        ),
        'status'=>array(
            'label'=>'סטטוס',
            'type'=>'select',
            'default'=>'1',
            'options'=>array(
                array('value'=>'0', 'title'=>'לא פעיל'),
                array('value'=>'1', 'title'=>'פעיל')
            ),
            'validation'=>'required'
        ),
        'roll'=>array(
            'label'=>'תפקיד',
            'type'=>'select',
            'default'=>'admin',
            'options_method'=>array('model'=>'SiteUsers','method'=>'get_admin_roll_options'),
            'validation'=>'required'
        ),       

    );


    public static function get_admin_roll_options(){
        return array(
            array('value'=>'writer', 'title'=>'כותב'),
            array('value'=>'admin', 'title'=>'מנהל'),
            array('value'=>'master_admin', 'title'=>'מנהל כל'),
        );
      }  

}
?>