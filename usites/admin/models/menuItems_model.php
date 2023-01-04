<?php
  class MenuItems extends Model{
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly

    protected static $select_page_options = false;

    public static function create($field_values){
		return self::simple_create_by_table_name($field_values,'menu_items');
    }

    public static function delete($row_id){
		return self::simple_delete_by_table_name($row_id,'menu_items');
    }

    public static function update($row_id, $field_values){
        return self::simple_update_by_table_name($row_id, $field_values,'menu_items');
    }

    public static function get_parent_list_of($site_id,$menu_id){
        $filter_arr = array('site_id'=>$site_id,'menu_id'=>$menu_id,'parent'=>'0');
        return self::simple_get_list_by_table_name($filter_arr, 'menu_items');
    }

    public static function get_children_list_of($parent_id){
        $filter_arr = array('parent'=>$parent_id);
        return self::simple_get_list_by_table_name($filter_arr, 'menu_items');
    }

    public static function get_item($filter_arr = array()){
        $filter_arr = array();
        return self::simple_get_list_by_table_name($filter_arr, 'menu_items');
    }

    public static function get_by_id($row_id){
        $filter_arr = array('id'=>$row_id);
        return self::simple_find_by_table_name($filter_arr,'menu_items');
    }

    public static function get_select_page_options(){
        if(self::$select_page_options){
            return self::$select_page_options;
        }

        $work_on_site = Sites::get_user_workon_site();
        $site_id = $work_on_site['id'];

        $db = Db::getInstance();
        $sql = "SELECT id, title FROM content_pages WHERE site_id = :site_id order by title";
        $req = $db->prepare($sql);
        $req->execute(array('site_id'=>$site_id));
        $page_list = $req->fetchAll();
        $return_options = array();
        foreach($page_list as $page){
            $return_options[] = array('value'=>$page['id'],'title'=>$page['title']);
        }
        self::$select_page_options = $return_options;
        return self::$select_page_options;
    }
    
    public static function get_select_yes_no_options(){
        return array(
            array('value'=>'0', 'title'=>'לא'),
            array('value'=>'1', 'title'=>'כן')
        );
    }    
    
    

    public static $menu_type_list = array(
        'top'=>'1',
        'right'=>'2',
        'hero'=>'3',
        'bottom'=>'4'
    );



    public static $item_fields_colection = array(
        'priority'=>array(
            'label'=>'מיקום',
            'type'=>'text',
            'default'=>'100',
        ),

        'title'=>array(
            'title'=>'תווית',
            'type'=>'text',
            'validation'=>'required'
        ),

        'link_type'=>array(
            'label'=>'סוג הקישור',
            'type'=>'select',
            'default'=>'0',
            'options'=>array(
                array('value'=>'0', 'title'=>'כתובת'),
                array('value'=>'1', 'title'=>'קישור לדף')
            ),
            'validation'=>'required'
        ),

        'url'=>array(
            'label'=>'כתובת הקישור',
            'type'=>'text',
        ),
        
        'page_id'=>array(
            'label'=>'קישור לדף',
            'type'=>'select',
            'options_method'=>array('model'=>'MenuItems','method'=>'get_select_page_options'),
        ),

        'target'=>array(
            'label'=>'ייפתח ב',
            'type'=>'select',
            'default'=>'0',
            'options'=>array(
                array('value'=>'0', 'title'=>'אותו הדף'),
                array('value'=>'1', 'title'=>'דף חדש')
            ),
            'validation'=>'required'
        ),

        'css_class'=>array(
            'label'=>'תווית עיצוב',
            'type'=>'text',
        ), 

    );
}
?>