<?php

namespace Telefon\Model;

class Uzytkownik {

    public $id;
    public $imie;
    public $nazwisko;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->imie = (isset($data['imie'])) ? $data['imie'] : null;
        $this->nazwisko = (isset($data['nazwisko'])) ? $data['nazwisko'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
