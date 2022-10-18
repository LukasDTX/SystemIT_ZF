<?php

namespace Komputer\Model;

class Dzial {

    public $id;
    public $dzial;
    public $data;


    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->dzial = (isset($data['dzial'])) ? $data['dzial'] : null;
        $this->data = (isset($data['data'])) ? $data['data'] : null;      
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
