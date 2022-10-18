<?php

namespace Admin\Model;

class Permission {

    public $id;
    public $permission_name;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->permission_name = (isset($data['permission_name'])) ? $data['permission_name'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
