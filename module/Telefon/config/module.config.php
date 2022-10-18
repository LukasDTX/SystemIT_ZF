<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Telefon\Controller\Telefon' => 'Telefon\Controller\TelefonController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'telefon' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/telefon[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Telefon\Controller\Telefon',
                        'action' => 'index',
                    ),
                ),
            ),
            'detail' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/telefon/:id',
                    'defaults' => array(
                        'controller' => 'Telefon\Controller\Telefon',
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
            'telefon' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-telefon' => __DIR__ . '/../view/layout/slidePaginator.phtml',
            'paginator-telefonx' => __DIR__ . '/../view/layout/slidePaginatorx.phtml',
        ),
    ),
);
