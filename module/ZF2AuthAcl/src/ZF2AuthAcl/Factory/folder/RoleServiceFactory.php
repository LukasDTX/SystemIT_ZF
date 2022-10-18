<?php

namespace Zf2AuthAcl\Factory;

use ZF2AuthAcl\Service\RoleService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new RoleService(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
