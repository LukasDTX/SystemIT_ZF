<?php

namespace Telefon\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;

class UzytkownikTable extends AbstractTableGateway {

    protected $table = 'uzytkownik';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Uzytkownik());
        $this->initialize();
    }

    public function fetchAll() {

        $resultSet = $this->select()->toArray();
        
        return $resultSet;
        // if (null === $select)
        // $select = new Select();
        // $select->from($this->table);
        // $resultSet = $this->selectWith($select);
        // $resultSet->buffer();
        // return $resultSet;
    }

    // public function fetchAll(Select $select = null) {
        // if (null === $select)
            // $select = new Select();
        // $select->from($this->table);
		// $select->join('stanowisko', 'stanowisko.id = stanowisko.stanowisko_id', array('stanowisko'), 'left');
		////$select->where();	
        ////$select->order('imie ASC');
		// $resultSet = $this->selectWith($select);
        // $resultSet->buffer();
        // return $resultSet;
    // }

    // public function getStanowisko($id) {
        // $id = (int) $id;
        // $rowset = $this->select(array('id' => $id));
        // $row = $rowset->current();
        // if (!$row) {
            // throw new \Exception("Nie odnaleziono wiersza o $id");
        // }
        // return $row;
    // }

    // public function saveStanowisko(Stanowisko $stanowisko) {
        // $data = array(
            // 'imie' => $stanowisko->imie,
            // 'nazwisko' => $stanowisko->nazwisko,
			// 'stanowisko_id' => $stanowisko->stanowisko,
        // );

        // $id = (int) $stanowisko->id;
        // if ($id == 0) {
            // $this->insert($data);
        // } else {
            // if ($this->getStanowisko($id)) {
                // $this->update($data, array('id' => $id));
            // } else {
                // throw new \Exception('Formularz nie istnieje');
            // }
        // }
    // }

    // public function deleteStanowisko($id) {
        // $this->delete(array('id' => $id));
    // }

}
