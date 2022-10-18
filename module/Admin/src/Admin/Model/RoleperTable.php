<?php

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class RoleperTable extends AbstractTableGateway 
{

    protected $table = 'role_permission';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;	
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Roleper());	
        $this->initialize();
    }

    public function fetchAll(Select $select = null, $roleFiltr, $resourceFiltr, $permissionFiltr) {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        $select->join('role', 'role.rid = role_permission.role_id', array('role_name'), 'left');
        $select->join('permission', 'permission.id = role_permission.permission_id', array('permission_name'), 'left');
        $select->join('resource', 'permission.resource_id = resource.id', array('resource_name'), 'left');
//$select->join('uzytkownik', 'uzytkownik.id = telefon.uzytkownik_id', array('imie', 'nazwisko'), 'left');
        if (count($roleFiltr) > 0 && (!$roleFiltr == '0')) {
            $select->where(array('role_id' => $roleFiltr));

        }
        if (count($resourceFiltr) > 0 && (!$resourceFiltr == '0')){
            $select->where(array('resource_id'=>$resourceFiltr));
        }
//        if (count($permissionFiltr) > 0) {
//            $select->where->like('permission_id', $permissionFiltr);
//        }
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
