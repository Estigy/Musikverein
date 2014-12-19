<?php

namespace Application\Initializer;

use Application\Orm\EntityManagerAwareInterface;

use Zend\Log\LoggerAwareInterface;
use Zend\ServiceManager\InitializerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Initializer implements InitializerInterface
{
    /**
    * {@inheritDoc}
    */
    public function initialize($instance, ServiceLocatorInterface $serviceLocator)
    {
        if (!is_object($instance)) {
            return;
        }
        
        // Logger
        if ($instance instanceof LoggerAwareInterface){
            $instance->setLogger($serviceLocator->get('Logger'));
        }

        // Service Locator
        if ($instance instanceof ServiceLocatorAwareInterface ) {
            $instance->setServiceLocator($serviceLocator);
        }

        // Doctrine Entity Manager
        if ($instance instanceof EntityManagerAwareInterface) {
            $instance->setEntityManager($serviceLocator->get('Doctrine\ORM\EntityManager'));
        }
    }
}
