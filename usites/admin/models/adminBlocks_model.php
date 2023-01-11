<?php
  class AdminBlocks extends TableModel{

    protected static $main_table = 'content_blocks';


    public static $fields_collection = array(
        
        'priority'=>array(
            'label'=>'מיקום',
            'type'=>'text',
            'validation'=>'required',
            'default'=>'0'
        ),

        'label'=>array(
            'label'=>'שם לצורך זיהוי',
            'type'=>'text',
            'validation'=>'required'
        ),

        'content'=>array(
            'label'=>'תוכן',
            'type'=>'textbox',
            'reachtext'=>true,
            'css_class'=>'big-text'
        ),    

    );
}
?>