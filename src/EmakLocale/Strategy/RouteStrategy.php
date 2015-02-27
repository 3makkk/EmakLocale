<?php
/**
 * RouteStrategy.php File
 *
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */

namespace EmakLocale\Strategy;

use SlmLocale\LocaleEvent;
use SlmLocale\Strategy\AbstractStrategy;
use Zend\I18n\Translator\Translator;
use Zend\I18n\Translator\TranslatorAwareInterface;
use Zend\Mvc\Router\RouteInterface;

/**
 * RouteStrategy Class
 *
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */
class RouteStrategy extends AbstractStrategy
{

    /**
     * Default Segment Name of the locale param
     */
    const LANG_SEGMENT_NAME = 'lang';

    /**
     * Segment name of the locale param
     * @var string
     */
    protected $segmentName;

    /**
     * @var Translator
     */
    protected $translator;

    /**
     * @var RouteInterface
     */
    protected $router;

    function __construct($router, $translator)
    {
        $this->router = $router;
        $this->translator = $translator;
    }


    /**
     * Set Options
     *
     * @param array $options
     */
    public function setOptions(array $options)
    {
        if (array_key_exists('segment_name', $options)) {
            $this->segmentName = $options['segment_name'];
        }
    }

    /**
     * {@inheritdoc}
     *
     * @param LocaleEvent $event
     * @return string|null
     */
    public function detect(LocaleEvent $event)
    {
        $request = $event->getRequest();
        if (!$this->isHttpRequest($request)) {
            return null;
        }



        $router = $this->getRouter();
        if ($router instanceof TranslatorAwareInterface) {
            $translator = $this->getTranslator();
            $router->setTranslator($translator);

            if (!$matchedRoute = $router->match($request)) {

                /**
                 * Find route match when a TranslatorAwareTreeRouteStack is used
                 *
                 * The route doesn't match to a request when the wrong locale used in translator.
                 * To find a match, each supported locale is tested.
                 */
                foreach ($event->getSupported() as $supportedLocale) {
                    $router->getTranslator()->setLocale($supportedLocale);

                    return $this->getLocaleFromRoute($event);
                }

            }
        }

        return $this->getLocaleFromRoute($event);

    }


    protected function getLocaleFromRoute(LocaleEvent $event)
    {
        $supported = array();
        if ($lookup = $event->hasSupported()) {
            $supported = $event->getSupported();
        }

        if ($matchedRoute = $this->getRouter()->match($event->getRequest())) {
            if ($locale = $matchedRoute->getParam($this->getSegmentName())) {

                if (!$lookup) {
                    return $locale;
                }

                if (\Locale::lookup($supported, $locale)) {
                    return \Locale::lookup($supported, $locale);
                }
            }
        }

        return null;
    }

    /**
     * @return RouteInterface
     */
    protected function getRouter()
    {
        return $this->router;
    }

    /**
     * @param \Zend\Mvc\Router\RouteInterface $router
     */
    public function setRouter($router)
    {
        $this->router = $router;
    }

    /**
     * @return Translator
     */
    protected function getTranslator()
    {
        return $this->translator;
    }

    /**
     * @param \Zend\I18n\Translator\Translator $translator
     */
    public function setTranslator($translator)
    {
        $this->translator = $translator;
    }

    /**
     * Get segment name
     *
     * Return default segment name of no segment name configured.
     * @return string
     */
    protected function getSegmentName()
    {
        if (null === $this->segmentName) {
            $this->segmentName = self::LANG_SEGMENT_NAME;
        }

        return $this->segmentName;
    }

    /**
     * Set segment name
     *
     * @param $segmentName
     * @throws \InvalidArgumentException
     */
    public function setSegmentName($segmentName)
    {
        if (!is_string($segmentName)) {
            throw new \InvalidArgumentException('Segment name must be an string');
        }
        $this->segmentName = $segmentName;
    }


}