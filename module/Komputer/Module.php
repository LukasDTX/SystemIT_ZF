<?php

namespace Komputer;

use Komputer\Model\KomputerTable;
//use Uzytkownik\Form\UzytkownikForm;
use Komputer\Model\DzialTable;
use Komputer\Model\UzytkownikTable;

//use Uzytkownik\Model\Uzytkownik;
// use Zend\Db\ResultSet\ResultSet;
// use Zend\Db\TableGateway\TableGateway;

class Module {

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Komputer\Model\KomputerTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new KomputerTable($dbAdapter);
                    return $table;
                },
                'Komputer\Model\UzytkownikTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UzytkownikTable($dbAdapter);
                    return $table;
                },
                'Komputer\Model\DzialTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new DzialTable($dbAdapter);
                    return $table;
                },
			
//					'Uzytkownik\Form\SzukajForm' => function($sm) {
//					$dbA  = $sm->get('Zend\Db\Adapter\Adapter');
//					$form = new SzukajForm($dbA);
//
//					return $form;
//    }
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
