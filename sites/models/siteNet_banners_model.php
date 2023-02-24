<?php
  class SiteNet_banners extends TableModel{

    protected static $main_table = 'net_banners';

    public static $assets_mapping = array(
        'net_banners'=>'net/banners'
    );

    public static function add_count_to_banner($banner_id, $column_name){
        $execute_arr = array('banner_id'=>$banner_id);
        $sql = "UPDATE net_banners SET $column_name = $column_name + 1 WHERE id = :banner_id";
        $db = Db::getInstance();		
        $req = $db->prepare($sql);
        $req->execute($execute_arr);
        return;
    }

}
?>