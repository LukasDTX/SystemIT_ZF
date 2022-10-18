<?php

namespace Telefon\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\HydratingResultSet;

class UzytkownikTable extends AbstractTableGateway {

    protected $table = 'uzytkownik';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
        $this->resultSetPrototype = new HydratingResultSet();
        $this->resultSetPrototype->setObjectPrototype(new Uzytkownik());
        $this->initialize();
    }

    public function fetchAll() {

        $resultSet = $this->select()->toArray();

        return $resultSet;
    }

}
