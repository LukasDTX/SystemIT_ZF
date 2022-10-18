<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Komputer\Controller\Komputer' => 'Komputer\Controller\KomputerController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'komputer' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/komputer[/:action][/:id]'
                    . '[/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)'
                        . '(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Komputer\Controller\Komputer',
                        'action' => 'index',
                    ),
                ),
            ),
            'detail' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/komputer/:id',
                    'defaults' => array(
                        'controller' => 'Komputer\Controller\Komputer',
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
            'komputer' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
            'paginator-slidex' => __DIR__ . '/../view/layout/slidePaginatorx.phtml',
        ),
    ),
);
