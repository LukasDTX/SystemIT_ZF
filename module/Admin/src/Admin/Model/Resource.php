<?php

namespace Admin\Model;

class Resource {

    public $id;
    public $resource_name;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->resource_name = (isset($data['resource_name'])) ? $data['resource_name'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
