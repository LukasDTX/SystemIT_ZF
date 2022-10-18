<?php

namespace ZF2AuthAcl\Factory;

use ZF2AuthAcl\Controller\IndexController;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class IndexControllerFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        
       return new IndexController($serviceLocator->getServiceLocator()->get('ZF2AuthAcl\Service\UserServiceInterface'));
    
    //return new IndexController($serviceLocator->getServiceLocator()->get('ZF2AuthAcl\Baza\UserBazaInterface'));
    }

}
