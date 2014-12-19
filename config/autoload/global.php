<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
*/

return array(
	'db' => array(
		'driver'         => 'Pdo',
		'driver_options' => array(
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
		),
	),
    'doctrine' => array(
        'configuration' => array(
            'orm_default' => array(
                // Development = array, Else: memcache
                'metadata_cache'    => 'array',
                'query_cache'       => 'array',
                'result_cache'      => 'array',
                'hydration_cache'   => 'array',
                // Development = false, Else: true
                'generate_proxies'  => true,
                'proxy_dir'         => 'data/cache/DoctrineModule/Proxy',
                'proxy_namespace'   => 'DoctrineModule\Proxy',
            )
        ),
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'driverOptions' => array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
                    )
                )
            )
        ),
        /*'migrations_configuration' => array(
            'orm_default' => array(
                'directory'    => 'data/DoctrineModule/Migrations',
                'name'         => 'Bmk Migrations',
                'namespace'    => 'Bmk\Migrations',
                'table'        => 'doctrine_migrations',
            )
        )*/
    ),
	'service_manager' => array(
		'factories' => array(
			'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory',
		),
	),
);


/*
Demo-Content von local.php:

return array(
    'doctrine' => array(
       'connection' => array(
            'orm_default' => array(
                'params' => array(
                    'dbname'    => '*****',
                    'host'      => '*****',
                    'port'      => '3306',
                    'user'      => '*****',
                    'password'  => '*****',
                )
            )
        )
    )
);* 
*/