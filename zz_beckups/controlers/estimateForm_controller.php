<?php
//only for loged out user
   class EstimateFormController extends CrudController{
	   
	public function form(){
		$this->include_view('estimateForm/form.php');
	}
  }
?>