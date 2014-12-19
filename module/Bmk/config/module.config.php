<?php

return array(
	'controllers' => array(
		'invokables' => array(
            'Calendar\Controller\Calendar'      => 'Calendar\Controller\CalendarController',
            'Documents\Controller\Category'     => 'Documents\Controller\CategoryController',
            'Documents\Controller\Document'     => 'Documents\Controller\DocumentController',
            'Instruments\Controller\Category'   => 'Instruments\Controller\CategoryController',
            'Instruments\Controller\Instrument' => 'Instruments\Controller\InstrumentController',
            'Members\Controller\Medal'          => 'Members\Controller\MedalController',
            'Members\Controller\Member'         => 'Members\Controller\MemberController',
            'Members\Controller\Workshop'       => 'Members\Controller\WorkshopController',
            'Sheetmusic\Controller\Sheetmusic'  => 'Sheetmusic\Controller\SheetmusicController',
		),
	),
    'doctrine' => array(
        'driver' => array(
            'ApplicationDriver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__  . '/../src/Calendar/Entity',
                    __DIR__  . '/../src/Documents/Entity',
                    __DIR__  . '/../src/Instruments/Entity',
                    __DIR__  . '/../src/Members/Entity',
                    __DIR__  . '/../src/Sheetmusic/Entity',
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Calendar\Entity'    => 'ApplicationDriver',
                    'Documents\Entity'   => 'ApplicationDriver',
                    'Instruments\Entity' => 'ApplicationDriver',
                    'Members\Entity'     => 'ApplicationDriver',
                    'Sheetmusic\Entity'  => 'ApplicationDriver',
                )
            )
        ),
    ),
	'router' => array(
		'routes' => array(
            'calendar' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/calendar',
                    'defaults' => array(
                        'controller' => 'Calendar\Controller\Calendar',
                        'action'     => 'index',
                    ),
                ),
            ),
            'calendarEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/calendar/edit/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Calendar\Controller\Calendar',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'documents' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/documents[/][:page]',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Documents\Controller\Document',
                        'action'     => 'index',
                    ),
                ),
            ),
            'documentEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/documents/edit/:id',
                    'constraints' => array(
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Documents\Controller\Document',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'documentCategories' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/documents/categories',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Documents\Controller\Category',
                        'action'     => 'index',
                    ),
                ),
            ),
            'instruments' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/instruments[/][:page]',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Instruments\Controller\Instrument',
                        'action'     => 'index',
                    ),
                ),
            ),
            'instrumentEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/instruments/edit/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Instruments\Controller\Instrument',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'instrumentLend' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/instruments/edit/:id/lend',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Instruments\Controller\Instrument',
                        'action'     => 'lend',
                    ),
                ),
            ),
            'instrumentRepair' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/instruments/edit/:id/repair',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Instruments\Controller\Instrument',
                        'action'     => 'repair',
                    ),
                ),
            ),
            'instrumentCategories' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/instruments/categories',
                    'defaults' => array(
                        'controller' => 'Instruments\Controller\Category',
                        'action'     => 'index',
                    ),
                ),
            ),
            'members' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members[/][:page]',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'index',
                    ),
                ),
            ),
            'memberEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/edit/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'memberMedals' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/edit/:id/medals[/:connId]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'connId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'medals',
                    ),
                ),
            ),
            'memberWorkshops' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/edit/:id/workshops[/:connId]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'connId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'workshops',
                    ),
                ),
            ),
            'memberBands' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/edit/:id/bands[/:connId]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'connId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'bands',
                    ),
                ),
            ),
            'memberRoles' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/edit/:id/roles[/:connId]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'connId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'roles',
                    ),
                ),
            ),
            'medals' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/medals[/][:page]',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Medal',
                        'action'     => 'index',
                    ),
                ),
            ),
            'medalEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/medals/edit/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Medal',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'workshops' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/workshops[/][:page]',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Workshop',
                        'action'     => 'index',
                    ),
                ),
            ),
            'workshopEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/workshops/edit/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Workshop',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'sheetmusic' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/sheetmusic[/][:page]',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Sheetmusic\Controller\Sheetmusic',
                        'action'     => 'index',
                    ),
                ),
            ),
            'sheetmusicEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/sheetmusic/edit/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Sheetmusic\Controller\Sheetmusic',
                        'action'     => 'edit',
                    ),
                ),
            ),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'album' => __DIR__ . '/../view',
		),
	),
);