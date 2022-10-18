<?php

namespace Admin\Form;

use Zend\Form\Form;

class UsersForm extends Form {

    public function __construct($name = null) {

        parent::__construct('users');

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
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
                'id' => 'email',
                'class' => 'form-control',
                'placeholder' => "Email"
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'text',
                'id' => 'password',
                'class' => 'form-control',
                'placeholder' => "Password"
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));
 
//        $this->add(array(
//            'type' => 'Zend\Form\Element\Select',
//            'name' => 'dzial_id',
//            'options' => array(
//                'label' => 'Dzial',
//                'value_options' => $this->getOptionsForSelect($selectData),
//            ),
//            'attributes' => array(
//                'value' => '0',
//                'class' => 'form-control',
//            )
//        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Zapisz',
                'id' => 'submitbutton',
                'class' => 'btn btn-primary'
            ),
        ));
    }

//    public function getOptionsForSelect($result) {
//        $selectData = array(); //'id' => '0');
//
//        foreach ($result as $res) {
//            $selectData[$res['id']] = $res['dzial'];
//        }
//        return $selectData;
//    }



}
