<?php

namespace Bmk;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements AutoloaderProviderInterface, ConfigProviderInterface
{
	public function getAutoloaderConfig()
	{
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php',
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    'Calendar'    => __DIR__ . '/src/Calendar',
                    'Documents'   => __DIR__ . '/src/Documents',
                    'Instruments' => __DIR__ . '/src/Instruments',
                    'Members'     => __DIR__ . '/src/Members',
                    'Sheetmusic'  => __DIR__ . '/src/Sheetmusic',
				),
			),
		);
	}

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}

	public function getServiceConfig()
	{
		return array(
			'factories' => array(
			),
		);
	}

}