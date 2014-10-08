<?php
/**
 * RouteStrategyTest.php File
 *
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */

namespace EmakLocaleTest\Strategy;

use EmakLocale\Strategy\RouteStrategy;
use SlmLocale\LocaleEvent;
use Zend\Http\Request  as HttpRequest;
use Zend\Http\Response as HttpResponse;
use Zend\I18n\Translator\Translator;
use Zend\Mvc\Router\Http\Segment;
use Zend\Mvc\Router\RouteStackInterface;
use Zend\Mvc\Router\SimpleRouteStack;

/**
 * Class RouteStrategyTest
 *
 * @package EmakLocaleTest\Strategy
 * @author   Sven Friedemann <sven@erstellbar.de>
 * @license  http://opensource.org/licenses/MIT MIT
 * @link     https://github.com/3makkk/EmakLocale
 */
class RouteStrategyTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var RouteStrategy $strategy
     */
    protected $strategy;
    /**
     * @var LocaleEvent $event
     */
    protected $event;

    /**
     * @var RouteStackInterface
     */
    protected $router;

    public function setUp()
    {
        $translator     = new Translator();
        $this->router   = new SimpleRouteStack();
        $this->strategy = new RouteStrategy($this->router , $translator);
        $this->event    = new LocaleEvent;

        $request  = new HttpRequest();
        $response = new HttpResponse();
        $this->event->setRequest($request);
        $this->event->setResponse($response);
        $this->event->setSupported(array('nl', 'de', 'en'));
    }

    public function testReturnsNull()
    {
        $strategy = $this->strategy;
        $event    = $this->event;

        $locale = $strategy->detect($event);
        $this->assertNull($locale);
    }

    public function testSetRouteSegmentReturnsLocale()
    {
        $expectedLocale = 'de';
        $router   = $this->router;
        $event    = $this->event;

        $localeRoute = Segment::factory(array(
            'route' => '/:lang',
        ));

        $router->addRoute('foo', $localeRoute);
        $this->strategy->setRouter($router);

        $request = $event->getRequest();
        $request->setUri('/'. $expectedLocale);


        $strategy = $this->strategy;
        $event    = $this->event;

        $locale = $strategy->detect($event);
        $this->assertEquals($expectedLocale, $locale);
    }


    public function testRouteSegmentNameCanBeModifiedAndHaveLocaleReturned()
    {
        $expectedLocale = 'de';
        $router   = $this->router;
        $event    = $this->event;
        $strategy = $this->strategy;

        $localeRoute = Segment::factory(array(
            'route' => '/:locale',
        ));

        $router->addRoute('foo', $localeRoute);
        $strategy->setRouter($router);
        $strategy->setSegmentName('locale');

        $request = $event->getRequest();
        $request->setUri('/'. $expectedLocale);

        $locale = $strategy->detect($event);
        $this->assertEquals($expectedLocale, $locale);
    }
}
 