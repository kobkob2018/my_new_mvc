<?php
//only for loged out user
   class EstimateFormController extends Controller{
	   
	public function form(){
		$this->include_view('estimateForm/form.php');
	}
  }
?>