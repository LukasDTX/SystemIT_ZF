<?php

namespace Admin\Model;

class Roleper {

    public $id;
    public $role_id;
    public $permission_id;
    public $role_name;
    public $resource_name;
    public $permission_name;

    //protected $inputFilter;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->role_id = (isset($data['role_id'])) ? $data['role_id'] : null;
        $this->permission_id = (isset($data['permission_id'])) ? $data['permission_id'] : null;
        $this->role_name = (isset($data['role_name'])) ? $data['role_name'] : null;
        $this->permission_name = (isset($data['permission_name'])) ? $data['permission_name'] : null;
        $this->resource_name = (isset($data['resource_name'])) ? $data['resource_name'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
