<?php namespace App\Core\Router;

abstract class Route {
    public function __construct($router) {
        $this->_router = $router;
    }
    
    /**
     * Controller name
     * @var string
     */
    protected $_controllerName;
    
    /**
     * Action name
     * @var string
     */
    protected $_actionName;
    
    /**
     * Action parameters
     * @var array
     */
    protected $_params;
    
    /**
     * Default values
     * @var array
     */
    protected $_defaults;
    
    /**
     * Router
     * @var App/Core/Router/Router
     */
    protected $_router;
    
    /**
     * Get controller name
     * @return string
     */
    public function getController() {
        return $this->_controllerName;
    }
    
    /**
     * Get action name
     * @return string
     */
    public function getAction() {
        return $this->_actionName;
    }
    
    /**
     * Get default values
     * @return array
     */
    public function getDefaults() {
        return $this->_defaults;
    }
    
    /**
     * Get action parameters
     * @return array
     */
    public function getParams() {
        return $this->_params;
    }

    /**
     * Is uri match for route
     * @return bool
     */
    public abstract function isMatch($uri);
    
    /**
     * Reads the uri
     */
    public abstract function readRoute($uri);
    
    /**
     * Generates uri for given controller and action
     * @return string
     */
    public abstract function getUrlForAction($action = null, $controller = null, $params = []);
}