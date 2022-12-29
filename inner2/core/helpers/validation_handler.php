<?php
  class Validation_handler {

    protected $error_messages = array(
        'required'=>'{{label}} הוא שדה חובה',
        'phone'=>'שדה {{label}} לא תקין',
        'email'=>'שדה {{label}} לא תקין',
        'default'=>'שדה {{label}} לא תקין',
    );

    public function validate_by($method_name, $value){
        $method_name = "validate_by_".trim($method_name);
        if(!method_exists($this,$method_name)){
            $method_name = "validate_by_success";
        }
        $validation_result = $this->$method_name($value);
        return $validation_result;
    }

    public function validate_by_custom($controller_interface, $method_name, $value){
        $method_name = trim($method_name);
        if(!method_exists($controller_interface,$method_name)){
            return $this->validate_by('success',$value);
        }
        $validation_result = $controller_interface->$method_name($value);
        return $validation_result;
    }

    protected function validate_by_success($value){
        return array(
            'success'=>true,
            'fixed_value'=>$value
        );
    }

    protected function validate_by_required($value){
        $return_array =  array(
            'success'=>true,
            'fixed_value'=>$value
        );
        if($value == ''){
            $return_array['success'] = false;
            $return_array['message'] = $this->error_messages['required'];
        }
        return $return_array;
    }

    protected function validate_by_email($value){
        $return_array =  array(
            'success'=>true,
            'fixed_value'=>$value
        );

        $is_valid = filter_var($value, FILTER_VALIDATE_EMAIL);

        if(!$is_valid){
            $return_array['success'] = false;
            $return_array['message'] = $this->error_messages['email'];
        }
        return $return_array;
    }   


    protected function validate_by_phone($value){

        $return_array =  array(
            'success'=>true,
            'fixed_value'=>$value
        );

        $is_valid = preg_match('/^[0-9]{10}+$/', $value);

        if(!$is_valid){
            $return_array['success'] = false;
            $return_array['message'] = $this->error_messages['phone'];
        }
        return $return_array;
        

    }

  }
?>
