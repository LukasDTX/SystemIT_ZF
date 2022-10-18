<?php

namespace ZF2AuthAcl\Factory;

use ZF2AuthAcl\Utility\Acl;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        
        return new Acl($serviceLocator->get('ZF2AuthAcl\Baza\UserBazaInterface'));
    }

}
