<?php

namespace Application\ORM;

use Doctrine\ORM\EntityManager;

/**
 * Interface to ensure standard methods for entity manager handling
 */
interface EntityManagerAwareInterface
{
    /**
     * Return the set entity manager
     * @return EntityManager
     */
    public function getEntityManager();
    
    /**
     * Set a new entity manager
     * @param EntityManager $entityManager
     * @return EntityManagerAwareInterface
     */
    public function setEntityManager(EntityManager $entityManager);
}
