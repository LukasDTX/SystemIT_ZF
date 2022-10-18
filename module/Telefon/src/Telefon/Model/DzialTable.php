<?php

namespace Telefon\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;

class DzialTable extends AbstractTableGateway {

    protected $table = 'dzialy';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
//        $this->resultSetPrototype = new ResultSet();
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Dzial());
        $this->initialize();
    }

    public function fetchAll() {

        $resultSet = $this->select()->toArray();

        return $resultSet;
    }

}
