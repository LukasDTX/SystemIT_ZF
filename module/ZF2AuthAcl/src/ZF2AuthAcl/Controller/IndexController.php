<?php

namespace ZF2AuthAcl\Controller;

use ZF2AuthAcl\Baza\UserBazaInterface;
use ZF2AuthAcl\Service\UserServiceInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use ZF2AuthAcl\Form\LoginForm;
use ZF2AuthAcl\Form\Filter\LoginFilter;
use Zend\Session\Container;

class IndexController extends AbstractActionController {

    protected $userService;

    public function __construct(UserServiceInterface $userService) {
        $this->userService = $userService;
    }
    private function _getUserDetails($where, $columns) {
        $users = $this->userService->findAllUsers($where, $columns);
        return $users;
    }
    
    public function indexAction() {

        $request = $this->getRequest();

        $view = new ViewModel();
        $loginForm = new LoginForm('loginForm');
        $loginForm->setInputFilter(new LoginFilter());

        if ($request->isPost()) {
            $data = $request->getPost();
            $loginForm->setData($data);

            if ($loginForm->isValid()) {
                $data = $loginForm->getData();

                $authService = $this->getServiceLocator()->get('AuthService');

                $authService->getAdapter()
                        ->setIdentity($data['email'])
                        ->setCredential($data['password']);

                $result = $authService->authenticate();

                if ($result->isValid()) {

                    $userDetails = $this->_getUserDetails(array(
                        'email' => $data['email']
                            ), array(
                        'id'
                    ));

                    $session = new Container('User');
                    $session->offsetSet('email', $data['email']);
                    $session->offsetSet('userId', $userDetails[0]['id']);
                    $session->offsetSet('roleId', $userDetails[0]['role_id']);
                    $session->offsetSet('roleName', $userDetails[0]['role_name']);

                    $this->flashMessenger()->addMessage(array(
                        'success' => 'Login Success.'
                    ));
                } else {
                    $this->flashMessenger()->addMessage(array(
                        'error' => 'invalid credentials.'
                    ));
                }
                return $this->redirect()->tourl('login');
            } else {
                $errors = $loginForm->getMessages();
            }
        }

        $view->setVariable('loginForm', $loginForm);
        return $view;
    }

    public function logoutAction() {
        $authService = $this->getServiceLocator()->get('AuthService');

        $session = new Container('User');
        $session->getManager()->destroy();

        $authService->clearIdentity();
        return $this->redirect()->toUrl('login');
    }



}
