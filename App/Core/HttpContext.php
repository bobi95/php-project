<?php namespace App\Core;

class HttpContext {
    private static $_instance  = null;

    /**
     * Get the current http context
     * 
     * @return HttpContext The current context
     */
    public static function instance() {
        if(self::$_instance == null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private $_controller,
            $_action,
            $_url,
            $_route,
            $_tempData;

    /**
     * Get executing controller's name
     * 
     * @return string
     */
    public function getController() {
        return $this->_controller;
    }

    /**
     * Get executing action's name
     * 
     * @return string
     */
    public function getAction() {
        return $this->_action;
    }

    /**
     * Get temp data
     * 
     * @return Array
     */
    public function getTempData() {
        return $this->_tempData;
    }

    /**
     * @return \App\Core\Router\Route
     */
    public function getRoute() {
        return $this->_route;
    }
    
    public function requestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function construct($httpData, $route) {
        $this->_controller = $httpData['controller'];
        $this->_action = $httpData['action'];
        $this->_url = $httpData['url'];
        $this->_route = $route;
        $this->_tempData = \App\Helpers\TempData::create($httpData);
    }
}