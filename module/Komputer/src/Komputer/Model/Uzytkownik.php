<?php

namespace Komputer\Model;

class Uzytkownik {

    public $id;
    public $imie;
    public $nazwisko;
    public $dzial_id;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->imie = (isset($data['imie'])) ? $data['imie'] : null;
        $this->nazwisko = (isset($data['nazwisko'])) ? $data['nazwisko'] : null;
        $this->dzial_id = (isset($data['dzial_id'])) ? $data['dzial_id'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
