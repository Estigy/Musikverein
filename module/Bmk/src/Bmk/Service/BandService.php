<?php

namespace Bmk\Service;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorAwareTrait;

class BandService implements ServiceLocatorAwareInterface
{
	use ServiceLocatorAwareTrait;
	
	protected $bands;
	
	public function getBands()
	{
		if ($this->bands === null) {
			$this->bands = $this->getServiceLocator()->get('Config')['band_service']['bands'];
		}
		return $this->bands;
	}
}