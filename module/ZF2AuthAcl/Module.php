<?php
namespace ZF2AuthAcl;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\Adapter\DbTable as DbAuthAdapter;
use Zend\Session\Container;
use ZF2AuthAcl\Model\ResourceTable;
use ZF2AuthAcl\Model\RolePermissionTable;
use Zend\Authentication\AuthenticationService;
use ZF2AuthAcl\Model\Role;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array(
            $this,
            'boforeDispatch'
        ), 100);
    }

    function boforeDispatch(MvcEvent $event)
    {
        $response = $event->getResponse();
        
        $whiteList = array(
            'ZF2AuthAcl\Controller\Index-index',
            'ZF2AuthAcl\Controller\Index-logout'
        );

        $controller = $event->getRouteMatch()->getParam('controller');
        
        $action = $event->getRouteMatch()->getParam('action');
        
        $requestedResourse = $controller . "-" . $action;
        
        $session = new Container('User');

        if ($session->offsetExists('email')) {
            if ($requestedResourse == 'ZF2AuthAcl\Controller\Index-index' || in_array($requestedResourse, $whiteList)) {
                if ($session->offsetGet('roleName') == 'Pracownik') {
                    $url = '/komputer/indexx';
                } else {
                    $url = '/komputer/index';
                }
                $response->setHeaders($response->getHeaders()
                                ->addHeaderLine('Location', $url));
                $response->setStatusCode(302);
            } else {
                
                $serviceManager = $event->getApplication()->getServiceManager();
                $userRole = $session->offsetGet('roleName');
                
                $acl = $serviceManager->get('Acl');
                $acl->initAcl();
                
                $status = $acl->isAccessAllowed($userRole, $controller, $action);
                if (! $status) {
                    die('Permission denied');
                }
            }
        } else {
            
            if ($requestedResourse != 'ZF2AuthAcl\Controller\Index-index' && ! in_array($requestedResourse, $whiteList)) {
                $url = '/login';
                $response->setHeaders($response->getHeaders()
                    ->addHeaderLine('Location', $url));
                $response->setStatusCode(302);
            }
            $response->sendHeaders();
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                )
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AuthService' => function ($serviceManager)
                {
                    $adapter = $serviceManager->get('Zend\Db\Adapter\Adapter');
                    $dbAuthAdapter = new DbAuthAdapter($adapter, 'users', 'email', 'password');
                    $auth = new AuthenticationService();
                    $auth->setAdapter($dbAuthAdapter);
                    return $auth;
                },
                'RoleTable' => function ($serviceManager)
                {
                    return new Role($serviceManager->get('Zend\Db\Adapter\Adapter'));
                },
                'ResourceTable' => function ($serviceManager)
                {
                    return new ResourceTable($serviceManager->get('Zend\Db\Adapter\Adapter'));
                },
                'RolePermissionTable' => function ($serviceManager)
                {
                    return new RolePermissionTable($serviceManager->get('Zend\Db\Adapter\Adapter'));
                }
            )
        );
    }
}