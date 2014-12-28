<?php

namespace Guard\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Helper\AbstractHelper;

class IsAllowed extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    public function __invoke($resource, $privilege = null)
    {
        $acl = $this->getServiceLocator()->getServiceLocator()->get('AclBuilder')->getAcl();

        return $acl->isAllowed('CurrentUser', $resource, $privilege);
    }
}
