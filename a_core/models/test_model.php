<?php
  class Test extends TableModel{

    protected static $main_table = 'test';

	public static function get_by_id($row_id){
		$db = Db::getInstance();
		$sql = "SELECT * FROM test WHERE id = :row_id";
		$req = $db->prepare($sql);
		$req->execute(array('row_id'=>$row_id));
		$row_data = $req->fetch();
		return $row_data;
    }

    public static function authenticate_token($row_id,$token){
		$db = Db::getInstance();
		$sql = "SELECT id,user_id FROM test WHERE id = :row_id AND token = :token";
		$req = $db->prepare($sql);
		$req->execute(array('row_id'=>$row_id,'token'=>$token));
		$row_data = $req->fetch();
		if(isset($row_data['id']) && isset($row_data['user_id'])){			
			$sql = "UPDATE test SET token = '' WHERE id = :row_id";
			$req = $db->prepare($sql);
			$req->execute(array('row_id'=>$row_id));			
			return $row_data['user_id'];			
		}
		return false;
    }

  }
?>