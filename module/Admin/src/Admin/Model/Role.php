<?php

namespace Admin\Model;

class Role {

    public $rid;
    public $role_name;

    public function exchangeArray($data) {
        $this->rid = (isset($data['rid'])) ? $data['rid'] : null;
        $this->role_name = (isset($data['role_name'])) ? $data['role_name'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
