<?php
  class Cities extends TableModel{

    protected static $main_table = 'cities';

    protected static $auto_delete_from_attached_tables = array(
        'cat_city'=>array(
            'table'=>'cat_city',
            'id_key'=>'city_id'
        ),
        'user_city'=>array(
            'table'=>'user_city',
            'id_key'=>'city_id'
        ),
        'user_cat_city'=>array(
            'table'=>'user_cat_city',
            'id_key'=>'city_id'
        ),
    );

    public static $fields_collection = array(

        'label'=>array(
            'label'=>'שם העיר\האזור',
            'type'=>'text',
            'validation'=>'required'
        ),
        'priority'=>array(
            'label'=>'מיקום',
            'type'=>'text',
            'default'=>'10',
            'validation'=>'required, int'
        ),
        'active'=>array(
            'label'=>'סטטוס פעיל',
            'type'=>'select',
            'default'=>'1',
            'options'=>array(
                array('value'=>'0', 'title'=>'לא'),
                array('value'=>'1', 'title'=>'כן')
            ),
            'validation'=>'required'
        ),

        'type'=>array(
            'label'=>'סוג',
            'type'=>'select',
            'default'=>'city',
            'options'=>array(
                array('value'=>'area', 'title'=>'אזור'),
                array('value'=>'city', 'title'=>'עיר')
            ),
            'validation'=>'required'
        )
    );
}
?>