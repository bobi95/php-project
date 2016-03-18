<?php

use App\Core\Router\Router;
use App\Core\HttpContext;
use App\Core\View;
use App\Core\ViewFactory;
use App\Routes;

/**
 * Starting point of the programm
 */
class App
{
    /**
     * Holds the current instance
     *
     * @var App Current running instance
     */
    private static $_instance = null;

    /**
     * Is the program running
     *
     * @var Boolean Is the program running
     */
    private static $_running = false;

    /**
     * Request url
     *
     * @var String Current Request url
     */
    private $_url;

    /**
     * Request url components
     *
     * @var Array The components of the request url
     */
    private $_urlComponents;
    
    /**
     * Current router
     * 
     * @var Router The router for the app
     */
    private $_router;

    /**
     * Current route
     *
     * @var \App\Core\Router\Route Current route
     */
    private $_route;
    
    /**
     * Result of the invoced action
     * 
     * @var ActionResult 
     */
    private $_actionResult;
    
    /**
     * View being rendered
     * 
     * @var View 
     */
    private $_view;

    /**
     * instance
     *
     * Get the current running instance of the app
     *
     * @return App
     */
    private static function instance() {

        if(self::$_instance == null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    private function __construct() {

    }

    /**
     * Starting point of the program
     */
    public static function run() {

        if(self::$_running) {
            return;
        }

        self::$_running = true;
        $instance = self::instance();
        $instance->onInit();
        $instance->onRoute();
        $instance->setupContext();
        $instance->onActionExecuting();
        $instance->onActionExecuted();
        $instance->onProgramFinished();
    }

    /**
     * Get the current route
     * 
     * @return App\Core\Router\Route
     */
    public static function getRoute() {
        return self::instance()->_route;
    }

    /**
     * Initiates the program. Anything that must run before routing must be
     * called here
     */
    private function onInit() {

        $this->_url = self::constructUrl();
        $this->_urlComponents = parse_url($this->_url);
    }

    /**
     * Constructs the current url from the server parameters
     *
     * @return String
     */
    private static function constructUrl() {

        $protocol = (isset($_SERVER['HTTPS']) && is_string($_SERVER['HTTPS']))
                ? 'https' : 'http';

        $host = (isset($_SERVER['HTTP_HOST']) && is_string($_SERVER['HTTP_HOST']))
                ? $_SERVER['HTTP_HOST'] : '';

        $uri = (isset($_SERVER['REQUEST_URI']) && is_string($_SERVER['REQUEST_URI']))
                ? $_SERVER['REQUEST_URI'] : '';

        $url = "{$protocol}://{$host}{$uri}";

        return $url;
    }

    /**
     * Creates the routes and matches the current url to a route
     */
    private function onRoute() {

        $this->_router = new Router('\\App\\Controllers\\');

        $this->_router->add(new Routes\DefaultRoute($this->_router));

        $this->_route = $this->_router->findRoute($this->_urlComponents['path']);
    }
    
    private function setupContext() {
        if(isset($this->_router)) {
            HttpContext::instance()->construct([
                'controller' => $this->_route->getController(),
                'action' => $this->_route->getAction(),
                'url' => $this->_url
            ], $this->_route);
        }
    }

    /**
     * The controller and action are executed here
     */
    private function onActionExecuting() {
        $this->_actionResult = $this->_router->executeRoute($this->_route);
    }

    /**
     * The view is rendered here
     */
    private function onActionExecuted() {
        if(isset($this->_actionResult)) {
            $this->_view = ViewFactory::createView($this->_actionResult);
            $this->_view->render();
        }
    }

    /**
     * Anything to be executed after the program has ran is here
     */
    private function onProgramFinished() {
        App\Helpers\Session::save();
    }
}