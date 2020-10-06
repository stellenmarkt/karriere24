<?php

namespace Karriere24;

use Laminas\Console\Console;
use Laminas\Mvc\MvcEvent;

/**
 * Bootstrap class of the YAWIK Karriere24
 */
class Module
{
    const TEXT_DOMAIN = __NAMESPACE__;

    /**
     * indicates, that the autoload configuration for this module should be loaded.
     * @see
     *
     * @var bool
     */
    public static $isLoaded=false;

    function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Loads module specific autoloader configuration.
     *
     * @return array
     */
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

    public function onBootstrap(MvcEvent $e)
    {
        self::$isLoaded=true;

        if (!Console::isConsole()) {
            $eventManager = $e->getApplication()->getEventManager();
            $eventManager->attach(MvcEvent::EVENT_ROUTE, function (MvcEvent $event) {
                $routeMatch = $event->getRouteMatch();

                if (!$routeMatch) { return; }

                $matchedRouteName = $routeMatch->getMatchedRouteName();

                if ('lang/jobboard' == $matchedRouteName || 'lang' == $matchedRouteName) {
                    $query = $event->getRequest()->getQuery();

                    foreach ([
                        'r' => 'region_MultiString',
                        'loc' => 'city_MultiString',
                        'c' => 'organizationTag',
                        'p' => 'profession_MultiString',
                        'i' => 'industry_MultiString',
                        't' => 'employmentType_MultiString',
                        's' => 'country_MultiString',
                        ] as $shortName => $longName) {

                        if ($v = $query->get($shortName)) {
                            $values = explode('_', $v);
                            $vals = [];
                            foreach ($values as $val) {
                                $vals[$val] = '';
                            }
                            $query->set($longName, $vals);
                            $query->offsetUnset($shortName);
                        }
                    }
                }
            }, -9999);
        }
    }
}
