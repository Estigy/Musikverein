<?php

namespace Application\Orm;

use Doctrine\ORM\EntityManager;

trait EntityManagerAwareTrait
{
    protected $entityManager;
    
    public function setEntityManager(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function getEntityManager()
    {
        return $this->entityManager;
    }
}