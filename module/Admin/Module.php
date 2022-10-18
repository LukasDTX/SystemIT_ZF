<?php

namespace Admin;

use Admin\Model\RoleperTable;
use Admin\Model\RoleTable;
use Admin\Model\ResourceTable;
use Admin\Model\PermissionTable;
use Admin\Model\UsersTable;

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
                'Admin\Model\RoleperTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RoleperTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\UsersTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new UsersTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\RoleTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new RoleTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\PermissionTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new PermissionTable($dbAdapter);
                    return $table;
                },
                'Admin\Model\ResourceTable' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new ResourceTable($dbAdapter);
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
