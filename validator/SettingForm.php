<?php

class SettingForm {

    private $rulesForm = array(
        'nazevprojektu' => array(
            'required' => true
        ),
        'datumodevzdaniprojektu' => array(
            'required' => true,
            'regex' => "/(0?[1-9]|[12][0-9]|3[01]).(0?[1-9]|1[012]).((19|20)\\d\\d)/"
        ),
        'typprojektu' => array(
            'required' => true
        )
    );

    public function gerRulesForm() {
        return $this->rulesForm;
    }

}
