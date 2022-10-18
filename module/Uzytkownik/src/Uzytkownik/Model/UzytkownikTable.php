<?php

namespace Uzytkownik\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class UzytkownikTable extends AbstractTableGateway {

    protected $table = 'uzytkownik';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Uzytkownik());
        $this->initialize();
    }
    public function downAll() {

        $resultSet = $this->select()->toArray();

        return $resultSet;
    }
    public function fetchAll(Select $select = null, $imieFiltr, $nazwiskoFiltr, $dzialFiltr, $mailFiltr, $komFiltr) {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        $select->join('dzialy', 'dzialy.id = uzytkownik.dzial_id', array('dzial'), 'left');

        if (count($imieFiltr) > 0) {
            $select->where->like('imie', "$imieFiltr" . "%");
        }
        if (count($nazwiskoFiltr) > 0) {
            $select->where->like('nazwisko', "$nazwiskoFiltr" . "%");
        }
        if (count($mailFiltr) > 0) {
            $select->where->like('mail', "%" . $mailFiltr . "%");
        }
        if (count($komFiltr) > 0) {
            $select->where->like('kom', "%" . $komFiltr . "%");
        }
        if ((count($dzialFiltr) > 0) && (!$dzialFiltr == '0')) {
            $select->where(array('dzial_id' => $dzialFiltr));
        }
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getUzytkownik($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Nie odnaleziono wiersza o $id");
        }
        return $row;
    }

    public function saveUzytkownik(Uzytkownik $uzytkownik) {
        $data = array(
            'imie' => $uzytkownik->imie,
            'nazwisko' => $uzytkownik->nazwisko,
            'dzial_id' => $uzytkownik->dzial_id,
            'mail' => $uzytkownik->mail,
            'kom' => $uzytkownik->kom,
        );

        $id = (int) $uzytkownik->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getUzytkownik($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Formularz nie istnieje');
            }
        }
    }

    public function deleteUzytkownik($id) {
        $this->delete(array('id' => $id));
    }

}
