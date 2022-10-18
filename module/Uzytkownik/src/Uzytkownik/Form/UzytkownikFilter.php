<?php

namespace Uzytkownik\Form;

use Zend\InputFilter\InputFilter;

class UzytkownikFilter extends InputFilter {
    public function __construct() {
        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
        ));
        $this->add(array(
            'name' => 'imie',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' => 20,
                        'messages' => array(
                            'stringLengthTooShort' 
                            => 'Imię musi mieć wiecęj niż 4 znaki!',
                            'stringLengthTooLong' 
                            => 'Imię nie może mieć wiecęj niż 20 znaków!'
                        ),
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => 'Podaj imię.'
                        ),
                    ),
                ),
            ),
        ));
        $this->add(array(
            'name' => 'nazwisko',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' => 20,
                        'messages' => array(
                            'stringLengthTooShort' => 'Nazwisko musi mieć wiecęj niż 4 znaki!',
                            'stringLengthTooLong' => 'Nazwisko nie może mieć wiecęj niż 20 znaków!'
                        ),
                    ),
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => 'Podaj nazwisko.'
                        ),
                    ),
                ),
            ),
        ));
        ////email
        $this->add(array(
            'name' => 'mail',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress',
                    'options' => array(
                        'domain' => true,
                    ),
                ),
            ),
        ));
    }

}
