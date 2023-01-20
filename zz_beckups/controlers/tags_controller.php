<?php
	class TagsController extends Controller{
		public $add_models = array("tags");
		public function settings(){
			if(isset($_REQUEST['add_tag'])){
				
				Tags::add_tag($_REQUEST['tag_data']);
				$message = "התיוג עודכן בהצלחה";
			}
			if(isset($_REQUEST['delete_tag'])){
				Tags::delete_tag($_REQUEST['tag_data']);
				$message = "התיוג נמחק";
			}
			$tag_list = Tags::get_user_tag_list();
			$this->include_view('tags/tags_settings.php');
		}		
	}
?>