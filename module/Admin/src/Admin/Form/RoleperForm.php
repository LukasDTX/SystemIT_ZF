<?php

namespace Admin\Form;

use Zend\Form\Form;

class RoleperForm extends Form {

    public function __construct($role, $resource, $permission, $name = null) {
        parent::__construct('roleper');

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
            'name' => 'role_id',
            'options' => array(
                'label' => 'Role',
                'value_options' => $this->getOptionsForRole($role),
            ),
            'attributes' => array(
                'value' => '0', //set selected to '1'
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'permission_id',
            'options' => array(
                'label' => 'Permission',
                'value_options' => $this->getOptionsForPermission($permission),
            ),
            'attributes' => array(
                'value' => '0', //set selected to '1'
                'class' => 'form-control',
            )
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'resource_id',
            'options' => array(
                'label' => 'Resource',
                'value_options' => $this->getOptionsForResource($resource),
            ),
            'attributes' => array(
                'value' => '0', //set selected to '1'
                'class' => 'form-control',
            )
        ));

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

    public function getOptionsForRole($result) {
        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['rid']] = $res['role_name'];
        }
        return $selectData;
    }

    public function getOptionsForPermission($result) {
        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['permission_name'];
        }
        return $selectData;
    }

    public function getOptionsForResource($result) {
        $selectData = array();

        foreach ($result as $res) {
            $selectData[$res['id']] = $res['resource_name'];
        }
        return $selectData;
    }

}
