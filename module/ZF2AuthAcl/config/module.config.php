<?php

return array(
    'router' => array(
        'routes' => array(
            'login' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'index'
                    )
                )
            ),
            'logout' => array(
                'type' => 'Literal',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        '__NAMESPACE__' => 'ZF2AuthAcl\Controller',
                        'controller' => 'Index',
                        'action' => 'logout'
                    )
                )
            )
        )
    ),
    'service_manager' => array(
        'invokables' => array(
            'ZF2AuthAcl\Model\UserInterface' => 'ZF2AuthAcl\Model\User',
            'Acl' => 'ZF2AuthAcl\Utility\Acl'
        ),
        'factories' => array(
            'ZF2AuthAcl\Baza\UserBazaInterface' => 'ZF2AuthAcl\Factory\UserBazaFactory',
            'ZF2AuthAcl\Mapper\UserMapperInterface' => 'ZF2AuthAcl\Factory\UserMapperFactory',
            'ZF2AuthAcl\Service\UserServiceInterface' => 'ZF2AuthAcl\Factory\UserServiceFactory',
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
        )
    ),
    'controllers' => array(
        'factories' => array(
            'ZF2AuthAcl\Controller\Index' => 'ZF2AuthAcl\Factory\IndexControllerFactory'
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
            'zf2-auth-acl/index/index' => __DIR__ . '/../view/zf2-auth-acl/index/index.phtml'
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view'
        )
    )
);
