<?php

namespace Komputer\Form;

use Zend\Form\Form;

class KomputerForm extends Form {

    //protected $dbAdapter;
// 
    public function __construct($uzytkownicy, $name = null) {
        //$this->$dbAdapter = $adapter;
        // we want to ignore the name passed
        parent::__construct('komputer');

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
            'name' => 'marka',
            'attributes' => array(
                'type' => 'text',
                'id' => 'marka',
                'class' => 'form-control',
                'placeholder' => "Podaj markę komputera"
            ),
            'options' => array(
                'label' => 'Marka',
            ),
        ));
        $this->add(array(
            'name' => 'model',
            'attributes' => array(
                'type' => 'text',
                'id' => 'model',
                'class' => 'form-control',
                'placeholder' => "Podaj model komputera"
            ),
            'options' => array(
                'label' => 'Model',
            ),
        ));
        $this->add(array(
            'name' => 'nr_ewid',
            'attributes' => array(
                'type' => 'text',
                'id' => 'nr_ewid',
                'class' => 'form-control',
                'placeholder' => "Podaj nr ewidencyjny komputera"
            ),
            'options' => array(
                'label' => 'Nr ewidencyjny',
            ),
        ));
        $this->add(array(
            'name' => 'nr_inwent',
            'attributes' => array(
                'type' => 'text',
                'id' => 'nr_inwent',
                'class' => 'form-control',
                'placeholder' => "Podaj nr inwentarzowy komputera"
            ),
            'options' => array(
                'label' => 'Nr inwentarzowy',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'gw',
            'options' => array(
                'label' => 'Gwarancja',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\File',
            'name' => 'fv',
            'options' => array(
                'label' => 'Faktura',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Select',
//            'name' => 'dzial_id',
//            'options' => array(
//                'label' => 'Dzial',
//                'value_options' => $this->getOptionsForSelect($dzialy),
//            // 'value_options' => array(
//            // '1' => 'Informatyk',
//            // '2' => 'Projektant',
//            // ),
//            ),
//            'attributes' => array(
//                'value' => '0', //set selected to '1'
//                'class' => 'form-control',
//            )
//        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'uzytkownik_id',
            'options' => array(
                'label' => 'Uzytkownik',
                'value_options' => $this->getOptionsForSelectU($uzytkownicy),
            ),
            'attributes' => array(
                'value' => '1', //set selected to '1'
                'class' => 'form-control',
            )
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Zapisz',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary',
            ),
        ));
    }

//    public function getOptionsForSelect($result) {
//        $selectData = array();
//
//        foreach ($result as $res) {
//            $selectData[$res['id']] = $res['dzial'];
//        }
//        return $selectData;
//    }

    public function getOptionsForSelectU($result) {
        $selectData = array();

        foreach ($result as $res) {

            $selectData[$res['id']] = $res['imie'] . ' ' . $res['nazwisko'];
        }
        return $selectData;
    }

}
