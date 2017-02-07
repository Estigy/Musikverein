<?php

namespace Application\Controller;

use Application\Controller\BaseController;
use Application\Form\LoginForm;

use DoctrineModule\Authentication\Adapter\ObjectRepository;

use Zend\Authentication\AuthenticationService;
use Zend\View\Model\ViewModel;

class AuthController extends BaseController
{
    public function loginAction()
    {
        $auth = new AuthenticationService();
        
        if ($auth->hasIdentity()) {
            return $this->redirect()->toRoute('home');
        }
        
        $form = new LoginForm();
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $data = $form->getData();
            
                $adapter = new ObjectRepository(array(
                    'objectManager'      => $this->getEntityManager(),
                    'identityClass'      => 'Application\Entity\User',
                    'identityProperty'   => 'username',
                    'credentialProperty' => 'password',
                    'credentialCallable' => 'Application\Entity\User::checkHashedPassword',
                ));
                $adapter->setIdentity($data['username']);
                $adapter->setCredential($data['password']);
                
                $result = $auth->authenticate($adapter);
                
                if (!$result->isValid()) {
                    foreach ($result->getMessages() as $message) {
                        $this->flashmessenger()->addErrorMessage($message);
                    }
                }
                
                return $this->redirect()->toRoute('home');
            }
        }
        
        return new ViewModel(array(
            'form' => $form,
        ));
    }
    
    public function logoutAction()
    {
        $auth = new AuthenticationService();
        
        $auth->clearIdentity();
        
        return $this->redirect()->toRoute('home');
    }
}
