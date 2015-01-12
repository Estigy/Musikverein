<?php
return array(
    'acl' => array(
        'Gast' => array(
            'Application\Controller\Auth' => '*',
        ),
        // Alle anderen Rollen leiten von Gast ab, dürfen also alle zum Login.
        'Administrator' => array(
            'Application\Controller\Index' => '*',
            'Attendance\Controller\Attendance' => '*',
            'Calendar\Controller\Calendar' => '*',
            'Documents\Controller\Document' => '*',
            'Instruments\Controller\Category' => '*',
            'Instruments\Controller\Instrument' => '*',
            'Members\Controller\Medal' => '*',
            'Members\Controller\Member' => '*',
            'Members\Controller\Workshop' => '*',
            'Sheetmusic\Controller\Sheetmusic' => '*',
        ),
        'Vorstand' => array(
            'Application\Controller\Index' => '*',
            'Attendance\Controller\Attendance' => '*',
            'Calendar\Controller\Calendar' => '*',
            'Documents\Controller\Document' => '*',
            'Instruments\Controller\Category' => '*',
            'Instruments\Controller\Instrument' => '*',
            'Members\Controller\Medal' => '*',
            'Members\Controller\Member' => '*',
            'Members\Controller\Workshop' => '*',
            'Sheetmusic\Controller\Sheetmusic' => '*',
        ),
        'Instrumentenarchivar' => array(
            'Application\Controller\Index' => '*',
            'Instruments\Controller\Category' => '*',
            'Instruments\Controller\Instrument' => '*',
        ),
        'Notenarchivar' => array(
            'Application\Controller\Index' => '*',
            'Sheetmusic\Controller\Sheetmusic' => '*',
        ),
    ),
    'service_manager' => array(
        'invokables' => array(
            'AuthCheck'  => 'Guard\Service\AuthCheck',
            'AclBuilder' => 'Guard\Service\AclBuilder',
            'AuthenticationService' => 'Zend\Authentication\AuthenticationService',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'isAllowed' => 'Guard\Helper\IsAllowed',
        ),
    ),
);
