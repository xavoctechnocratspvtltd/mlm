<?php
namespace xavoc\mlm;

class Form_Field_AlphaNumeric extends \Form_Field_Line {
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
            if(!preg_match ("/^[a-zA-Z0-9\s]+$/",$this->value)) {
                $this->displayFieldError('Must Be Alphabet and Numbers only');
            }
        }
        return parent::validate();
    }
}
