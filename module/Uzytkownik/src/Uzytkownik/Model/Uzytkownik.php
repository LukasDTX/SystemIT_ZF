<?php
namespace Uzytkownik\Model;

class Uzytkownik
{
    public $id;
    public $imie;
    public $nazwisko;
    public $dzial_id;
    public $dzial;
    public $mail;
    public $kom;

    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->imie = (isset($data['imie'])) ? $data['imie'] : null;
        $this->nazwisko = (isset($data['nazwisko'])) ? $data['nazwisko'] : null;
        $this->dzial_id = (isset($data['dzial_id'])) ? $data['dzial_id'] : null;
        $this->dzial = (isset($data['dzial'])) ? $data['dzial'] : null;
        $this->mail = (isset($data['mail'])) ? $data['mail'] : null;
        $this->kom = (isset($data['kom'])) ? $data['kom'] : null;
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}
