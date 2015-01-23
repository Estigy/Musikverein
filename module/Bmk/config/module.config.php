<?php

return array(
	'controllers' => array(
		'invokables' => array(
            'Attendance\Controller\Sheet'       => 'Attendance\Controller\SheetController',
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
                    __DIR__  . '/../src/Attendance/Entity',
                    __DIR__  . '/../src/Bmk/Entity',
                    __DIR__  . '/../src/Calendar/Entity',
                    __DIR__  . '/../src/Documents/Entity',
                    __DIR__  . '/../src/Instruments/Entity',
                    __DIR__  . '/../src/Members/Entity',
                    __DIR__  . '/../src/Sheetmusic/Entity',
                )
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Attendance\Entity'  => 'ApplicationDriver',
                    'Bmk\Entity'         => 'ApplicationDriver',
                    'Calendar\Entity'    => 'ApplicationDriver',
                    'Documents\Entity'   => 'ApplicationDriver',
                    'Instruments\Entity' => 'ApplicationDriver',
                    'Members\Entity'     => 'ApplicationDriver',
                    'Sheetmusic\Entity'  => 'ApplicationDriver',
                )
            )
        ),
    ),
    'documents' => array(
        'upload_path' => 'data/uploads',
    ),
	'router' => array(
		'routes' => array(
            'attendance' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/attendance[/][:page]',
                    'constraints' => array(
                        'page' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Attendance\Controller\Sheet',
                        'action'     => 'index',
                    ),
                ),
            ),
            'attendanceEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/attendance/edit/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Attendance\Controller\Sheet',
                        'action'     => 'edit',
                    ),
                ),
            ),
            'attendanceEventEdit' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/attendance/edit/:id/event/:eventId',
                    'constraints' => array(
                        'id'      => '[0-9]+',
                        'eventId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Attendance\Controller\Sheet',
                        'action'     => 'event',
                    ),
                ),
            ),
            'attendanceTable' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/attendance/table/:id',
                    'constraints' => array(
                        'id'      => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Attendance\Controller\Sheet',
                        'action'     => 'table',
                    ),
                ),
            ),
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
            'calendarExport' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/calendar/export',
                    'defaults' => array(
                        'controller' => 'Calendar\Controller\Calendar',
                        'action'     => 'export',
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
            'documentDownload' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/documents/:hash',
                    'constraints' => array(
                        'page' => '[0-9a-z]{32}',
                    ),
                    'defaults' => array(
                        'controller' => 'Documents\Controller\Document',
                        'action'     => 'download',
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
            'memberEducation' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/edit/:id/education[/:connId]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'connId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'education',
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
            'memberMembership' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/edit/:id/membership[/:connId]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                        'connId' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'membership',
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
            'memberPrintsheet' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/members/printsheet/:id',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Members\Controller\Member',
                        'action'     => 'printsheet',
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