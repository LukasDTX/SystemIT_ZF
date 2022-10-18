<?php

namespace Telefon\Model;

class Telefon {//implements InputFilterAwareInterface {

    public $id;
    public $marka;
    public $model;
    public $sn;
    public $imei;
    public $nr_gsm;
    public $nr_ewid;
    public $data_zakupu;
    public $uzytkownik_id;
    public $nazwisko;
    public $imie;
    public $dzial_id;
    public $dzial;

    //protected $inputFilter;

    /**
     * Used by ResultSet to pass each database row to the entity
     */
    public function exchangeArray($data) {
        $this->id = (isset($data['id'])) ? $data['id'] : null;
        $this->marka = (isset($data['marka'])) ? $data['marka'] : null;
        $this->model = (isset($data['model'])) ? $data['model'] : null;
        $this->sn = (isset($data['sn'])) ? $data['sn'] : null;
        $this->imei = (isset($data['imei'])) ? $data['imei'] : null;
        $this->nr_gsm = (isset($data['nr_gsm'])) ? $data['nr_gsm'] : null;
        $this->nr_ewid = (isset($data['nr_ewid'])) ? $data['nr_ewid'] : null;
        $this->data_zakupu = (isset($data['data_zakupu'])) ? $data['data_zakupu'] : null;
        $this->uzytkownik_id = (isset($data['uzytkownik_id'])) ? $data['uzytkownik_id'] : null;
        $this->nazwisko = (isset($data['nazwisko'])) ? $data['nazwisko'] : null;
        $this->imie = (isset($data['imie'])) ? $data['imie'] : null;
        $this->dzial_id = (isset($data['dzial_id'])) ? $data['dzial_id'] : null;
        $this->dzial = (isset($data['dzial'])) ? $data['dzial'] : null;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
