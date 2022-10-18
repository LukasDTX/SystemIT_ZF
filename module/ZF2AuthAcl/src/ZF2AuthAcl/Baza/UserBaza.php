<?php

namespace ZF2AuthAcl\Baza;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

class UserBaza implements UserBazaInterface {

    protected $dbAdapter;

    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }

    public function findAll($where, $columns) {
        try {
            $sql = new Sql($this->dbAdapter);

            $select = $sql->select()->from(array(user => 'users'));

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
    public function getRolePermissions()
    {
        $sql = new Sql($this->dbAdapter);
        
        $select = $sql->select()
            ->from(array(
            't1' => 'role'
        ))
            ->columns(array(
            'role_name'
        ))
            ->join(array(
            't2' => 'role_permission'
        ), 't1.rid = t2.role_id', array(), 'left')
            ->join(array(
            't3' => 'permission'
        ), 't3.id = t2.permission_id', array(
            'permission_name'
        ), 'left')
            ->join(array(
            't4' => 'resource'
        ), 't4.id = t3.resource_id', array(
            'resource_name'
        ), 'left')
            ->where('t3.permission_name is not null and t4.resource_name is not null')
            ->order('t1.rid');
            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = new ResultSet();
            $result = $resultSet->initialize($statement->execute())
                    ->toArray();
        return $result;
    }
    public function getUserRoles($where = array(), $columns = array())
    {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select()->from(array(
                'role' => 'role'
            ));
            $select->columns(array(
                'rid',
                'role_name',
                'status',
            ));
            $select->where('rid != "Active"');
            if (count($where) > 0) {
                $select->where($where);
            }
            
            if (count($columns) > 0) {
                $select->columns($columns);
            }
            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = new ResultSet();
            $roles = $resultSet->initialize($statement->execute())
                    ->toArray();
            return $roles;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }
    public function getAllResources()
    {
        try {
            $sql = new Sql($this->dbAdapter);
            $select = $sql->select()->from(array(
                'rs' => 'resource'
            ));
            $select->columns(array(
                'id',
                'resource_name'
            ));
            $statement = $sql->prepareStatementForSqlObject($select);
            $resultSet = new ResultSet();
            $resources = $resultSet->initialize($statement->execute())
                    ->toArray();
            return $resources;
        } catch (\Exception $e) {
            throw new \Exception($e->getPrevious()->getMessage());
        }
    }
}