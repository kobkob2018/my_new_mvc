<?php
  class Net_banner_cat extends TableModel{

    protected static $main_table = 'net_banner_cat';


    public static $fields_collection = array(

        'cat_add'=>array(
            'label'=>'שיוך קטגוריות לבאנר',
            'type'=>'checklist',
        ),
    );
}
?>