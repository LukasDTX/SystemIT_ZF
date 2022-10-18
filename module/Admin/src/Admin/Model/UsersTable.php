<?php

namespace Admin\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;

class UsersTable extends AbstractTableGateway {

    protected $table = 'users';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype->setArrayObjectPrototype(new Users());
        $this->initialize();
    }

    public function fetchAll() {
        if (null === $select)
            $select = new Select();

        $select->from($this->table);
        $select->join('user_role', 'user_role.user_id = users.id', array('role_id'), 'left');
        $select->join('role', 'role.rid = role_id', array('role_name'), 'left');
        $resultSet = $this->selectWith($select);
        $resultSet->buffer();
        return $resultSet;
    }

    public function getUsers($id) {
        $id = (int) $id;
        $rowset = $this->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Nie odnaleziono wiersza o $id");
        }
        return $row;
    }

    public function saveUsers(Users $users) {
        $data = array(
            'email' => $users->email,
            'password' => $users->password,
//            'role_id' => $users->role_id,
//            'mail' => $uzytkownik->mail,
//            'kom' => $uzytkownik->kom,
        );

        $id = (int) $users->id;
        if ($id == 0) {
            $this->insert($data);
        } else {
            if ($this->getUsers($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('Formularz nie istnieje');
            }
        }
    }

    public function deleteUsers($id) {
        $this->delete(array('id' => $id));
    }

}

//<?php //
//
//namespace Admin\Model;
//
//use Zend\Db\TableGateway\AbstractTableGateway;
//use Zend\Db\Adapter\Adapter;
//use Zend\Db\ResultSet\HydratingResultSet;
//
//class UzytkownikTable extends AbstractTableGateway {
//
//    protected $table = 'uzytkownik';
//
//    public function __construct(Adapter $adapter) {
//        $this->adapter = $adapter;
//        $this->resultSetPrototype = new HydratingResultSet();
//        $this->resultSetPrototype->setObjectPrototype(new Uzytkownik());
//        $this->initialize();
//    }
//
//    public function fetchAll() {
//
//        $resultSet = $this->select()->toArray();
//        
//        return $resultSet;
//    }
//}
