<?php

namespace Uzytkownik\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class KomputerTable extends AbstractTableGateway {

    protected $table = 'komputer';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Komputer());

        $this->initialize();
    }

//    public function fetchAll() {
//        
//        $resultSet = $this->select(); 
//        $resultSet->buffer();
//        return $resultSet;
//    }

    public function fetchAll($dzialFiltr) {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        $select->join('uzytkownik', 'uzytkownik.id = komputer.uzytkownik_id', array('dzial_id', 'nazwisko', 'imie'), 'left');
        $select->join('dzialy', 'dzialy.id = dzial_id', array('dzial'), 'left');
        if ((count($dzialFiltr) > 0) && (!$dzialFiltr == '0')) {
            $select->where(array('dzial_id' => $dzialFiltr));
        }
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function downAll($uzytkownikFiltr) {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        $select->join('uzytkownik', 'uzytkownik.id = komputer.uzytkownik_id', array('dzial_id', 'imie', 'nazwisko'), 'left');
        if ((count($uzytkownikFiltr) > 0) && (!$uzytkownikFiltr == '0')) {
            $select->where(array('uzytkownik_id' => $uzytkownikFiltr));
        }
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

}
