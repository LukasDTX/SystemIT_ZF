<?php

namespace ZF2AuthAcl\Mapper;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

class UserMapper implements UserMapperInterface {

    protected $dbAdapter;
    public $table = 'users';

    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function findAll($where, $columns) {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select()->from(array(
                'user' => $this->table
            ));

            if (count($where) > 0) {
                $select->where($where);
            }

            if (count($columns) > 0) {
                $select->columns($columns);
            }

            $select->join(array('userRole' => 'user_role'), 'userRole.user_id = user.id', array('role_id'), 'LEFT');
            $select->join(array('role' => 'role'), 'userRole.role_id = role.rid', array('role_name'), 'LEFT');

            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = new ResultSet();
            $users = $resultSet->initialize($statement->execute())
                    ->toArray();
            return $users;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }
}