<?php
  class AdminPages extends TableModel{

    protected static $main_table = 'content_pages';


    public static $fields_collection = array(
        'title'=>array(
            'label'=>'כותרת',
            'type'=>'text',
            'validation'=>'required'
        ),
        'meta_title'=>array(
            'label'=>'כותרת מטא',
            'type'=>'text',
            'validation'=>'required'
        ),
        'link'=>array(
            'label'=>'כתובת URL',
            'type'=>'text',
            'validation'=>'required, url'
        ),       
        'description'=>array(
            'label'=>'תיאור',
            'type'=>'textbox',
        ),

        'content'=>array(
            'label'=>'תוכן ראשי',
            'type'=>'textbox',
        ),

        'right_banner'=>array(
            'label'=>'באנר',
            'type'=>'file',
            'file_type'=>'img',
            'validation'=>'img',
            'img_max'=>'100000',
            'upload_to'=>'pages/banners',
            'name_file'=>'r_banner_{{row_id}}.{{ext}}'
        ),      

    );
}
?>