<?php
/**
 * Karriere24
 *
 * @filesource
 * @copyright 
 * @license  
 * @author   
 */

namespace Karriere24\Factory\Model;

use Interop\Container\ContainerInterface;
use Karriere24\Model\ApiJobDehydrator;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * Factory for ApiJobDehydrator
 *
 * @author Carsten Bleek <bleek@cross-solution.de>
 */
class ApiJobDehydratorFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string             $requestedName
     * @param  null|array         $options
     *
     * @return object
     *     creating a service.
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $viewManager = $container->get('ViewHelperManager');
        $urlHelper = $viewManager->get('url');
        $jobUrlHelper = $viewManager->get('jobUrl');
        $apiJobDehydrator = new ApiJobDehydrator();
        $apiJobDehydrator->setUrl($urlHelper);
        $apiJobDehydrator->setJobUrl($jobUrlHelper);
        return $apiJobDehydrator;
    }
}