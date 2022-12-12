<?php
  class Test extends Model{
    // we define 3 attributes
    // they are public so that we can access them using $post->author directly
	
    public static function get_test_data(){

		$test_list = array(
			"0"=>"ללא תיוג",
			"1"=>"check",
			"2"=>"checג",
			"3"=>"test",

		);
		return $test_list;
    }
	
	public static function get_test_model_data(){


		$db = Db::getInstance();
		$sql = "SELECT * FROM posts WHERE author = :uid";
		$req = $db->prepare($sql);
		//$user = User::getLogedInUser();
		$sql_arr = array(
			"uid"=>'1'
		);
		$req->execute($sql_arr);
		$tag_list = array("0"=>"ללא תיוג");
		foreach($req->fetchAll() as $tag) {
			$tag_list[$tag['id']] = $tag['content'];
		}
		return $tag_list;




		$test_list = array(
			"0"=>"model",
			"1"=>"model",
			"2"=>"model",
			"3"=>"model",

		);
		return $test_list;
    }

  }
?>