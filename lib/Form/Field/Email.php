<?php
namespace xavoc\mlm;
class Form_Field_Email extends \Form_Field_Line {
    public $min = null;
    public $max = null;

    function validate(){
        // empty value is allowed
        if($this->value!=''){
            // if( ! filter_var($this->value, FILTER_VALIDATE_EMAIL)) {
            //     $this->displayFieldError('Must Be Valid Email');
            // }
            $validate = preg_match('/^[0-9a-z]+[_\.\'0-9a-z-]*[0-9a-z]*[\@]{1}[0-9a-z]*[\.0-9a-z-]*[0-9a-z]+[\.]{1}[a-z]{2,4}$/i',$this->value);
            if(!$validate)
                $this->displayFieldError('Please input a valid email address');

        }
        return parent::validate('required');
    }
}
