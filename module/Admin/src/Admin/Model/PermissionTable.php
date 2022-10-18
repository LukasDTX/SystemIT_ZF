<?php

namespace Admin\Model;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;

class PermissionTable extends AbstractTableGateway {

    protected $table = 'permission';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Permission());
        $this->initialize();
    }

    public function fetchAll() {
        
        $resultSet = $this->select()->toArray();
        
        return $resultSet;
}
}