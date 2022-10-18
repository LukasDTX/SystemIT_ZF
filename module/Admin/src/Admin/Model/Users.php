<?php

namespace Admin\Model;

class Users {

    public $id;
    public $email;
    public $password;
    public $role_id;
    public $role_name;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->password = (isset($data['password'])) ? $data['password'] : null;
        $this->role_id = (isset($data['role_id'])) ? $data['role_id'] : null;
        $this->role_name = (isset($data['role_name'])) ? $data['role_name'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
