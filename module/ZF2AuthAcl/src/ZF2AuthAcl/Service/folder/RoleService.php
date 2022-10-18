<?php

namespace ZF2AuthAcl\Service;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Sql;

class RoleService implements RoleServiceInterface {

    protected $dbAdapter;
    public $table = 'role';

    public function __construct(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }
public function getUserRoles($where = array(), $columns = array())
    {
        try {
            $sql = new Sql($this->dbAdapter());
            $select = $sql->select()->from(array(
                'role' => $this->table
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

}