<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Roleper' => 'Admin\Controller\RoleperController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Roleper',
                        'action' => 'index',
                    ),
                ),
            ),
            'detail' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin/:id',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Roleper',
                        'action' => 'detail'),
                    'constraints' => array(
                        'id' => '\d+'
                    )
                )
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-roleper' => __DIR__ . '/../view/layout/slidePaginatorroleper.phtml',
            
        ),
    ),
);
