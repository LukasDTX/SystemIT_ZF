<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Uzytkownik\Controller\Uzytkownik' => 'Uzytkownik\Controller\UzytkownikController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'uzytkownik' => array(
                'type' => 'segment',
                // 'options' => array(
                // 'route'    => '/uzytkownik[/][:action[/:id]]',
                // 'constraints' => array(
                // 'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                // 'id'     => '[0-9]+',
                // ),
                // 'defaults' => array(
                // 'controller' => 'Uzytkownik\Controller\Uzytkownik',
                // 'action' => 'index',
                // ),
                // ),
                'options' => array(
                    'route' => '/uzytkownik[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Uzytkownik\Controller\Uzytkownik',
                        'action' => 'index',
                    ),
                ),
            ),
//            'komputer' => array(
//                'type' => 'segment',
//                'options' => array(
//                    'route' => '/komputer/detail[/:id]',
//                    'constraints' => array(
//                        'id' => '[0-9]+',
//                    ),
//                    'defaults' => array(
//                        'controller' => 'Komputer\Komputer\Controller\Komputer',
//                        'action' => 'detail',
//                    ),
//                ),
//            ),
            //koniec
            
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'uzytkownik' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'paginator-uzytkownik' => __DIR__ . '/../view/layout/slidePaginator.phtml',
            'paginator-uzytkownikx' => __DIR__ . '/../view/layout/slidePaginatorx.phtml',
        ),
    ),
);
