<?php

namespace Guard\Service;

use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class AclBuilder implements ServiceLocatorAwareInterface {

    use ServiceLocatorAwareTrait;

    protected $acl;

    public function getAcl()
    {
        if ($this->acl === null) {
            $this->acl = new Acl();

            $config = $this->getServiceLocator()->get('Config');

            foreach ($config['acl'] as $role => $data) {
                $this->acl->addRole(new GenericRole($role), ($role == 'Gast' ? null : 'Gast'));
                foreach ($data as $resource => $privileges) {
                    if (!$this->acl->hasResource($resource)) {
                        $this->acl->addResource(new GenericResource($resource));
                    }
                    $this->acl->allow($role, $resource, $privileges === '*' ? null : $privileges);
                }
            }

            // Neue (virtuelle) Rolle anlegen, die von allen Rollen des Users erbt.
            // Dadurch kann später einfach auf diese Rolle zugegriffen werden.
            $auth = $this->getServiceLocator()->get('AuthenticationService');
            $roles = array('Gast');
            if ($auth->hasIdentity()) {
                $roles = array_merge($roles, $auth->getIdentity()->roles);
            };
            $this->acl->addRole(new GenericRole('CurrentUser'), $roles);
        }

        return $this->acl;
    }


}