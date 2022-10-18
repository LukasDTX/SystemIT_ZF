<?php

namespace Uzytkownik\Form;

use Zend\Form\Form;

class SzukajForm extends Form {

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
            'name' => 'imie',
            'attributes' => array(
                'type' => 'text',
                'id' => 'imie',
                'class' => 'form-control',
                'placeholder' => "Podaj imię"
            ),
            'options' => array(
                'label' => 'Imię',
            ),
        ));

        $this->add(array(
            'name' => 'nazwisko',
            'attributes' => array(
                'type' => 'text',
                'id' => 'nazwisko',
                'class' => 'form-control',
                'placeholder' => "Podaj nazwisko"
            ),
            'options' => array(
                'label' => 'Nazwisko',
            ),
        ));
        $this->add(array(
            'name' => 'mail',
            'attributes' => array(
                'type' => 'text',
                'id' => 'mail',
                'class' => 'form-control',
                'placeholder' => "Podaj email"
            ),
            'options' => array(
                'label' => 'email',
            )
        ));
        $this->add(array(
            'name' => 'kom',
            'attributes' => array(
                'type' => 'text',
                'id' => 'kom',
                'class' => 'form-control',
                'placeholder' => "Podaj nr telefonu"
            ),
            'options' => array(
                'label' => 'Telefon',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'dzial_id',
            'options' => array(
                'label' => 'Dzial',
                'value_options' => $this->getOptionsForSelect($selectData),
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

    public function getOptionsForSelect($result) {
        $selectData = array(); //'id' => '0');

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['dzial'];
        }
        return $selectData;
    }

}
