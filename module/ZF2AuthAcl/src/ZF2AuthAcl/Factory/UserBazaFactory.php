<?php

namespace ZF2AuthAcl\Factory;

use ZF2AuthAcl\Baza\UserBaza;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserBazaFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        return new UserBaza(
                $serviceLocator->get('Zend\Db\Adapter\Adapter')
        );
    }

}
