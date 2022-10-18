<?php
namespace Komputer\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class KomputerTable extends AbstractTableGateway {

    protected $table = 'komputer';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Komputer());
        $this->initialize();
    }

    public function fetchAll(Select $select = null, $markaFiltr, $modelFiltr, $dzialFiltr,
            $uzytkownikFiltr, $ewidFiltr, $inwentFiltr) {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        
        $select->join('uzytkownik', 'uzytkownik.id = komputer.uzytkownik_id', array('imie', 'nazwisko','dzial_id'), 'left');
        $select->join('dzialy', 'dzialy.id = dzial_id', array('dzial'), 'left');
        if (count($markaFiltr) > 0) {
            $select->where->like('marka', "$markaFiltr" . "%");
        }
        if (count($modelFiltr) > 0) {
            $select->where->like('model', "$modelFiltr" . "%");
        }
        if ((count($dzialFiltr) > 0) && (!$dzialFiltr == '0')) {
            $select->where(array('dzial_id' => $dzialFiltr));
        }
        if ((count($uzytkownikFiltr) > 0) && (!$uzytkownikFiltr == '0')) {
            $select->where(array('komputer.uzytkownik_id' => $uzytkownikFiltr));
        }
        if (count($ewidFiltr) > 0) {
            $select->where->like('nr_ewid', "%".$ewidFiltr."%");
        }
        if (count($inwentFiltr) > 0) {
            $select->where->like('nr_inwent', "%".$inwentFiltr."%");
        }
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getKomputer($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Nie odnaleziono wiersza o $id");
        }
        return $row;
    }

    public function saveKomputer(Komputer $komputer) {
        $data = array(
            'marka' => $komputer->marka,
            'model' => $komputer->model,
            //'dzial_id' => $komputer->dzial_id,
            'uzytkownik_id' => $komputer->uzytkownik_id,
            'gw' => $komputer->gw["name"],
            'fv' => $komputer->fv["name"],
            'sn' => $komputer->sn,
            'nr_ewid' => $komputer->nr_ewid,
            'nr_inwent' => $komputer->nr_inwent,
            'data_zakupu' => date("Y-m-d")
        );

        $id = (int) $komputer->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getKomputer($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Formularz nie istnieje');
            }
        }
    }
    public function deleteKomputer($id) {
        $this->delete(array('id' => $id));
    }
}
