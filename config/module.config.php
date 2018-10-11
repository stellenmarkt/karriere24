<?php

/**
 * create a config/autoload/Karriere24.local.php and put modifications there.
 */

\Karriere24\Module::$isLoaded = true;

return array(
    'service_manager' => array(
        'factories' => array(
            'Karriere24/Listener/DelayedUserRegistrationMailSender' => 'Karriere24\Factory\Listener\DelayedUserRegistrationMailSenderFactory',
            \Karriere24\Listener\JobImportListener::class => \Karriere24\Factory\Listener\JobImportListenerFactory::class,
			\Karriere24\Model\ApiJobDehydrator::class => \Karriere24\Factory\Model\ApiJobDehydratorFactory::class,
        ),
		'aliases' => [
			'Jobs\Model\ApiJobDehydrator' => \Karriere24\Model\ApiJobDehydrator::class,
		],
    ),

    'event_manager' => [
        'Jobs/Events' => [ 'listeners' => [
            \Karriere24\Listener\JobImportListener::class => [ \Jobs\Listener\Events\JobEvent::EVENT_IMPORT_DATA, /* lazy */ true ],
        ]],
    ],

    'view_manager' => array(
        'template_map' => array(
            'layout/layout'        => __DIR__ . '/../view/layout.phtml',
            'piwik'                => __DIR__ . '/../view/piwik.phtml',
            'content/about'       => __DIR__ . '/../view/about.phtml',
            'content/applications-privacy-policy' => __DIR__ . '/../view/disclaimer.phtml',
            'main-navigation'      => __DIR__ . '/../view/main-navigation.phtml',
            'templates/default/index' => __DIR__ . '/../view/templates/default/index.phtml',
            'content/jobs-terms-and-conditions' => __DIR__ . '/../view/agb.phtml',
            'main-navigation'      => __DIR__ . '/../view/main-navigation.phtml',
            'jobs/export/feed.xml.phtml'  => __DIR__ . '/../view/jobs/feed.stellenmarkt.phtml',
            'jobs/jobboard/index.ajax.phtml' => __DIR__ . '/../view/jobs/index.ajax.phtml',
            'jobs/jobboard/index' => __DIR__ . '/../view/jobs/index.phtml',
        ),
    ),
    'translator'   => array(
        'translation_file_patterns' => array(
            array(
                'type'     => 'phparray',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.php',
                'text_domain' => \Karriere24\Module::TEXT_DOMAIN,
            ),
        ),
    ),
    'router'       => array(
        'routes' => array(
            'lang' => array(
                'options' => array(
                    'defaults' => array(
                        'controller' => 'Jobs/Jobboard', //Overwrites the route of the start Page
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'acl' => array(
        'rules' => array(
            // guests are allowed to see a list of companies.
            'guest' => array(
                'allow' => array(
                    'route/lang/organizations',
                ),
            ),
        ),
    ),
    'navigation' => array(
        'default' => array(
            'about'    => array(
                'label' => 'About',
                'order' => 200,
                'uri'   => '/de/content/about'
            ),
        ),
    ),

    'options' => [
        \Karriere24\Options\JobImportListenerOptions::class => [

        ],
    ]
);
