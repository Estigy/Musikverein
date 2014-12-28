<?php

namespace Application\Helper;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;
use Zend\View\Helper\AbstractHelper;

class Customization extends AbstractHelper implements ServiceLocatorAwareInterface
{
    use ServiceLocatorAwareTrait;

    protected $config;

    /**
     * Get Customization option
     */
    public function __invoke($option)
    {
        if ($this->config === null) {
            $config = $this->getServiceLocator()->getServiceLocator()->get('Config');

            $this->config = $config['customization'];
        }

        return isset($this->config[$option]) ? $this->config[$option] : null;
    }
}
