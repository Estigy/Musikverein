<?php

namespace Guard\Service;

use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AuthCheck implements ServiceLocatorAwareInterface {

    use ServiceLocatorAwareTrait;

    public function __invoke(MvcEvent $e)
    {
        $routeMatch = $e->getRouteMatch();

        $acl = $this->getServiceLocator()->get('AclBuilder')->getAcl();

        if ($acl->isAllowed('CurrentUser', $routeMatch->getParam('controller'), $routeMatch->getParam('action'))) {
            return;
        }

        if (!$this->getServiceLocator()->get('AuthenticationService')->hasIdentity()) {
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $e->getRouter()->assemble(array(), array('name' => 'login')));
            $response->setStatusCode(403);
            $response->sendHeaders();
            exit;
        }

        die('Keine Rechte');
    }
}