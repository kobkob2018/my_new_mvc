<?php
  class Biz_categories extends TableModel{

    protected static $main_table = 'biz_categories';

    protected static $auto_delete_from_attached_tables = array(
        'cat_city'=>array(
            'table'=>'cat_city',
            'id_key'=>'cat_id'
        ),
        'user_cat'=>array(
            'table'=>'user_cat',
            'id_key'=>'cat_id'
        ),
        'user_cat_city'=>array(
            'table'=>'user_cat_city',
            'id_key'=>'cat_id'
        ),
    );    

    public static $fields_collection = array(
        'label'=>array(
            'label'=>'שם הקטגוריה',
            'type'=>'text',
            'validation'=>'required'
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

        'visible'=>array(
            'label'=>'נראה באתר',
            'type'=>'select',
            'default'=>'1',
            'options'=>array(
                array('value'=>'0', 'title'=>'כן'),
                array('value'=>'1', 'title'=>'לא')
            ),
            'validation'=>'required'
        ),

        'cat_phone'=>array(
            'label'=>'טלפון לתצוגה',
            'type'=>'text'
        ),

        'googleADSense'=>array(
            'label'=>'קמפיין גוגל(במקום טופס)',
            'type'=>'textbox',
            'css_class'=>'small-text'
        ),

        'extra_fields'=>array(
            'label'=>'הוספת שדות',
            'type'=>'textbox',
            'css_class'=>'small-text'
        ),

        'max_lead_send'=>array(
            'label'=>'מקסימום לידים לשליחה (0=ללא הגבלה)',
            'type'=>'text',
            'validation'=>'required, int',
            'default'=>'0',
        ),

        'add_email_to_form'=>array(
            'label'=>'הוסף שדה אימייל',
            'type'=>'select',
            'default'=>'0',
            'options'=>array(
                array('value'=>'0', 'title'=>'לא'),
                array('value'=>'1', 'title'=>'כן')
            ),
            'validation'=>'required'
        ),

        'show_whatsapp_button'=>array(
            'label'=>'הוסף שדה אימייל',
            'type'=>'select',
            'default'=>'1',
            'options'=>array(
                array('value'=>'0', 'title'=>'לא'),
                array('value'=>'1', 'title'=>'כן')
            ),
            'validation'=>'required'
        )
    );
}
?>