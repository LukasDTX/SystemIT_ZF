<?php

namespace Telefon\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class TelefonTable extends AbstractTableGateway 
{

    protected $table = 'telefon';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;	
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Telefon());
		
        $this->initialize();
    }

    public function fetchAll(Select $select = null, $markaFiltr, $modelFiltr, $dzialFiltr) {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        $select->join('dzialy', 'dzialy.id = telefon.dzial_id', array('dzial'), 'left');
        $select->join('uzytkownik', 'uzytkownik.id = telefon.uzytkownik_id', array('imie', 'nazwisko'), 'left');
        if (count($markaFiltr) > 0) {
            $select->where->like('marka', "$markaFiltr" . "%");
        }
        if (count($modelFiltr) > 0) {
            $select->where->like('model', "$modelFiltr" . "%");
        }
        if ((count($dzialFiltr) > 0) && (!$dzialFiltr == '0')) {
            $select->where->like('telefon.dzial_id', "$dzialFiltr" . "%");
        }
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getTelefon($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Nie odnaleziono wiersza o $id");
        }
        return $row;
    }

    public function saveTelefon(Telefon $telefon) {
        $data = array(
            'marka' => $telefon->marka,
            'model' => $telefon->model,
            'dzial_id' => $telefon->dzial_id,
        );

        $id = (int) $telefon->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getTelefon($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Formularz nie istnieje');
            }
        }
    }

    public function deleteTelefon($id) {
        $this->delete(array('id' => $id));
    }

}
