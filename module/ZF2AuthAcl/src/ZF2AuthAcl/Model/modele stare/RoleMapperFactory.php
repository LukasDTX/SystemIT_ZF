<?php

namespace ZF2AuthAcl\Factory;

use ZF2AuthAcl\Mapper\RoleMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class RoleMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new RoleMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
