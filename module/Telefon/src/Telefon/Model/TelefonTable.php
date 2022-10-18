<?php
namespace Telefon\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\HydratingResultSet;

class TelefonTable extends AbstractTableGateway {

    protected $table = 'telefon';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Telefon());
        $this->initialize();
    }

    public function fetchAll(Select $select = null, $markaFiltr, $modelFiltr, $dzialFiltr,
            $uzytkownikFiltr, $inwentFiltr, $imeiFiltr) {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        
        $select->join('uzytkownik', 'uzytkownik.id = telefon.uzytkownik_id', array('imie', 'nazwisko','dzial_id'), 'left');
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
            $select->where(array('telefon.uzytkownik_id' => $uzytkownikFiltr));
        }
                if (count($inwentFiltr) > 0) {
            $select->where->like('nr_inwent', "%".$inwentFiltr."%");
        }
        if (count($imeiFiltr) > 0) {
            $select->where->like('imei', "%".$imeiFiltr."%");
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
            //'dzial_id' => $telefon->dzial_id,
            'uzytkownik_id' => $telefon->uzytkownik_id,
            'gw' => $telefon->gw["name"],
            'fv' => $telefon->fv["name"],
            'sn' => $telefon->sn,
            'nr_inwent' => $telefon->nr_inwent,
            'imei' => $telefon->imei,
            'data_zakupu' => date("Y-m-d")
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
