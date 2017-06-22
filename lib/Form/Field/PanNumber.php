<?php
namespace xavoc\mlm;

class Form_Field_PanNumber extends \Form_Field_Line {
    
    function validate(){
        // empty value is allowed
        if($this->owner instanceof \View ){
          $last_name =   $this->owner->owner->get('last_name');
            $model = $this->owner->owner->model;
        }else{
            $last_name = $this->owner->get('last_name');
            $model = $this->owner->model;
        }

        if($this->value!=''){
            if(strtolower($this->value[4]) != strtolower($last_name[0]) OR (strlen($this->value) !=10)){
                $this->displayFieldError('Pan No Does not looks correct ');
            }


            $check=  $this->add('xavoc\mlm\Model_Distributor');
            $check->addCondition('pan_no',$this->value);

            if($model->loaded()){
                $check->addCondition('id','<>',$model->id);
            }

            $check->tryLoadAny();

            if($check->loaded()){
                $this->displayFieldError('Pan no is already used');
            }
        }



        return parent::validate('required');
    }
}
