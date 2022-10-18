<?php

namespace Uzytkownik\Model;

class Komputer
{
    public $id;
    public $marka;
    public $model;
    public $nr_ewid;
    public $nr_inwent;
    public $data_zakupu;
    public $sn;
    
    public $uzytkownik_id;
    public $nazwisko;
    public $imie;
    public $dzial_id;
    public $dzial;
    
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->nr_ewid = (isset($data['nr_ewid'])) ? $data['nr_ewid'] : null;
        $this->nr_inwent = (isset($data['nr_inwent'])) ? $data['nr_inwent'] : null;
        $this->marka = (isset($data['marka'])) ? $data['marka'] : null;
        $this->model = (isset($data['model'])) ? $data['model'] : null;
        $this->data_zakupu = (isset($data['data_zakupu'])) ? $data['data_zakupu'] : null;
        $this->sn = (isset($data['sn'])) ? $data['sn'] : null;
        
        $this->dzial_id = (isset($data['dzial_id'])) ? $data['dzial_id'] : null;
        $this->dzial = (isset($data['dzial'])) ? $data['dzial'] : null;
        $this->uzytkownik_id = (isset($data['uzytkownik_id'])) ? $data['uzytkownik_id'] : null;
        $this->nazwisko = (isset($data['nazwisko'])) ? $data['nazwisko'] : null;
        $this->imie = (isset($data['imie'])) ? $data['imie'] : null;
        
    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

}