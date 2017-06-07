<?php
namespace xavoc\mlm;
class Form_Field_Alpha extends \Form_Field_Line {
    public $min = null;
    public $max = null;

    function setRange($min,$max){
        $this->min = $min;
        $this->max = $max;
        return $this;
    }
    
    function validate(){
        // empty value is allowed
        if($this->value!=''){
            if(!preg_match ("/^[a-zA-Z\s]+$/",$this->value)) {
                $this->displayFieldError('Must Be Alphabets only');
            }
        }
        return parent::validate();
    }
}
