<?php

namespace Application\Controller;

use Application\Orm\EntityManagerAwareInterface;
use Application\Orm\EntityManagerAwareTrait;
use Application\Factory\ServiceLocatorFactory;

use Doctrine\ORM\EntityManager;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class BaseController extends AbstractActionController
{
    use EntityManagerAwareTrait;

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if ($this->entityManager === null) {
            $this->entityManager = ServiceLocatorFactory::getInstance()->get('doctrine.entitymanager.orm_default');
        }
        return $this->entityManager;
    }
    
    protected function getEntityFromRouteId($className, $paramName = 'id')
    {
        $em = $this->getEntityManager();
        
        $id = (int) $this->params()->fromRoute($paramName, 0);
        if (!$id) {
            return false;
        }
        
        $entity = $em->find($className, $id);
        
        return $entity;
    }
}
