<?php

namespace Uzytkownik;

use Uzytkownik\Model\UzytkownikTable;
//use Uzytkownik\Form\UzytkownikForm;
use Uzytkownik\Model\DzialTable;
use Uzytkownik\Model\KomputerTable;
use Uzytkownik\Model\TelefonTable;


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
                'Uzytkownik\Model\UzytkownikTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UzytkownikTable($dbAdapter);
                    return $table;
                },
                'Uzytkownik\Model\KomputerTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new KomputerTable($dbAdapter);
                    return $table;
                },
                'Uzytkownik\Model\TelefonTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new TelefonTable($dbAdapter);
                    return $table;
                },                        
                'Uzytkownik\Model\DzialTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new DzialTable($dbAdapter);
                    return $table;
                },
//			
//					'Uzytkownik\Form\UzytkownikForm' => function($sm) {
//					$dbA  = $sm->get('Zend\Db\Adapter\Adapter');
//					$form = new UzytkownikForm($dbA);
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
