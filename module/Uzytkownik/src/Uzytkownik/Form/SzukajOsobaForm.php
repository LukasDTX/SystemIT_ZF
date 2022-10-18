<?php

namespace Uzytkownik\Form;

use Zend\Form\Form;

class SzukajOsobaForm extends Form {

    public function __construct($selectData, $name = null) {

        parent::__construct('uzytkownik');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'id',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'uzytkownik_id',
            'options' => array(
                'label' => 'Użytkownik',
                'value_options' => $this->getUzytkownik($selectData),
            ),
            'attributes' => array(
                'value' => '0',
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Szukaj',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

    public function getUzytkownik($result) {
        $selectData = array(); //'id' => '0');

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['nazwisko']." ".$res['imie'];
        }
        return $selectData;
    }

}
