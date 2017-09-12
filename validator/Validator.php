<?php
require_once '../validator/SettingForm.php';
require_once '../database/Dotaz_DB.php';
class Validator {
    private $sesttingForm;
    private $databaze;
    private $errors = [];    
    public function __construct() {
        $this->sesttingForm = new SettingForm();
        $this->databaze = new Dotaz_DB();
    } 
    public function validatorFormZadaniProjektu($data,$id=null) {
        $data = array_change_key_case($data, CASE_LOWER);
        foreach ($this->sesttingForm->gerRulesForm() as $key => $rules) {           
            foreach ($rules as $pravidlo => $hodnota_pravidla) {  
                $hodnotaForm = $data[$key];            
                switch ($pravidlo) {                   
                    case 'required':                     
                        if(empty($hodnotaForm)){
                           $this->errors[$key]="Toto pole je povinné";
                        }
                        break;
                    case 'regex':
                    if(!empty($hodnotaForm)){    
                    if(!preg_match($hodnota_pravidla,$hodnotaForm)){
                       $this->errors[$key]="Formát není validní"; 
                    } 
                    }
                        break;
                    default:
                        break;
                }
            }
        }
        if(count($this->errors)>0){
        return $this->getError();
        }else{
            $this->databaze->InsertProjekt($data,$id);
        }
        
    }
    
private function getError(){
    return $this->errors;
}
    
}
