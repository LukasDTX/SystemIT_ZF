<?php

namespace ZF2AuthAcl\Factory;

use ZF2AuthAcl\Mapper\UserMapper;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserMapperFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new UserMapper(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
