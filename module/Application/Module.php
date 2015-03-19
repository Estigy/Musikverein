<?php

namespace Application;

use Application\Factory\ServiceLocatorFactory;

use Zend\I18n\Translator\Translator;
use Zend\Mvc\I18n\Translator as MvcTranslator;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Navigation\Page\Mvc as MvcPage;
use Zend\Session\Config\SessionConfig;
use Zend\Session\Container;
use Zend\Session\SessionManager;
use Zend\Validator\AbstractValidator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        ServiceLocatorFactory::setInstance($e->getApplication()->getServiceManager());

        $this->initSession(array(
            'remember_me_seconds' => 180,
            'use_cookies' => true,
            'cookie_httponly' => true,
        ));
        
        $translator = new Translator();
        $translator->addTranslationFile(
            'phpArray',
            'vendor/zendframework/zendframework/resources/languages/de/Zend_Validate.php',
            'default',
            'de_DE'
        );
        $translator->setLocale('de_DE');
        $mvcTranslator = new MvcTranslator($translator);
        AbstractValidator::setDefaultTranslator($mvcTranslator);        
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    protected function initSession($config)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->start();
        Container::setDefaultManager($sessionManager);
    }
}
