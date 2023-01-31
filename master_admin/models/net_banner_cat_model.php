<?php
  class Net_banner_cat extends TableModel{

    protected static $main_table = 'net_banner_cat';


    public static $fields_collection = array(

        'cat_add'=>array(
            'label'=>'שיוך קטגוריות לבאנר',
            'type'=>'checklist',
        ),
    );

    public static function assign_cats_to_banner($banner_id, $cat_id_arr){
        $sql_arr = array(
            'banner_id'=>$banner_id
        );
        $db = Db::getInstance();

        $sql = "DELETE FROM net_banner_cat WHERE banner_id = :banner_id"; 		
        $req = $db->prepare($sql);
        $req->execute($sql_arr);

        $car_insert_arr = array();
        foreach($cat_id_arr as $cat_id=>$on){
            $car_insert_arr[] = "(:banner_id, $cat_id)";
        }

        $cat_insert_str = implode(",",$car_insert_arr);

        $sql = "INSERT INTO net_banner_cat(banner_id , cat_id) VALUES $cat_insert_str "; 
        echo $sql;		
        $req = $db->prepare($sql);
        $req->execute($sql_arr);
        return;
    }

    public static function delete_banner_assignments($banner_id){
        $sql_arr = array(
            'banner_id'=>$banner_id
        );
        $db = Db::getInstance();

        $sql = "DELETE FROM net_banner_cat WHERE banner_id = :banner_id";
        $req = $db->prepare($sql);
        $req->execute($sql_arr);       
    }

}
?>