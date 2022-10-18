<?php

namespace Zf2AuthAcl\Factory;

use ZF2AuthAcl\Service\UserService;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserServiceFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new UserService(
                $serviceLocator->get('ZF2AuthAcl\Mapper\UserMapperInterface')
        );
    }

}
