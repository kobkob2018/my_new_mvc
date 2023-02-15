<?php
  class User_lead_settings extends TableModel{

    protected static $main_table = 'user_lead_settings';

    public static $fields_collection = array(
        'active'=>array(
            'label'=>'פעיל',
            'type'=>'select',
            'default'=>'1',
            'options'=>array(
                array('value'=>'0', 'title'=>'לא'),
                array('value'=>'1', 'title'=>'כן')
            ),
            'validation'=>'required'
        ),

        'end_date'=>array(
            'label'=>'תאריך תפוגת פעילות',
            'type'=>'text',
            'validation'=>'date_time'
        ),

        'free_send'=>array(
            'label'=>'שליחה חופשית',
            'type'=>'select',
            'default'=>'0',
            'options'=>array(
                array('value'=>'0', 'title'=>'לא'),
                array('value'=>'1', 'title'=>'כן')
            ),
            'validation'=>'required'
        ),

        'lead_credit'=>array(
            'label'=>'קרדיט לידים',
            'type'=>'text',
            'default'=>'10',
            'validation'=>'int'
        ),

        'rotation_state'=>array(
            'label'=>'מצב רוטציה',
            'type'=>'text',
            'default'=>'0',
            'validation'=>'int'
        ),
        'rotation_priority'=>array(
            'label'=>'עדיפות ברוטציה',
            'type'=>'text',
            'default'=>'0',
            'validation'=>'int'
        ),
    );
}
?>