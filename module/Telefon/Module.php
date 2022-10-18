<?php

namespace Telefon;

use Telefon\Model\TelefonTable;
use Telefon\Model\DzialTable;
use Telefon\Model\UzytkownikTable;

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
                'Telefon\Model\TelefonTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new TelefonTable($dbAdapter);
                    return $table;
                },
                'Telefon\Model\UzytkownikTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UzytkownikTable($dbAdapter);
                    return $table;
                },
                'Telefon\Model\DzialTable' => function($sm) {
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
