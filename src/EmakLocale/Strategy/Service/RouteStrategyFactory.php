<?php
/**
 * RouteStrategyFactory.php File
 *
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */

namespace EmakLocale\Strategy\Service;

use EmakLocale\Strategy\RouteStrategy;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * RouteStrategyFactory Class
 *
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */
class RouteStrategyFactory implements FactoryInterface {

    /**
     * Create service
     *
     * @param \Zend\ServiceManager\ServiceLocatorInterface $strategyPluginManager
     * @internal param \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $strategyPluginManager)
    {
        $serviceLocator = $strategyPluginManager->getServiceLocator();
        $translator = $serviceLocator->get('translator');
        $router = $serviceLocator->get('router');

        $strategyPlugin = new RouteStrategy($router, $translator);

        return $strategyPlugin;

    }
}