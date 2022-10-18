<?php

namespace Telefon\Model;

class Dzial {

    public $id;
    public $dzial;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->dzial = (isset($data['dzial'])) ? $data['dzial'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
