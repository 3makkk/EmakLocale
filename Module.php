<?php
/**
 * Module File
 *
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */
namespace EmakLocale;

/**
 * Class Module
 *
 * @package EmakLocale
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */
class Module
{
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
}
