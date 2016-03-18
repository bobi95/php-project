<?php namespace App\Core\Router;

class Router {

    private $_routes = [];
    private $_controllerNamespace;

    public function __construct($controllerNamespace) {

        $this->setControllerNamespace($controllerNamespace);

    }

    public function setControllerNamespace($namespace) {

        if(!empty($namespace)) {
            $this->_controllerNamespace = $namespace;
        }

    }

    public function add(Route $route) {

        $this->_routes[] = $route;

    }

    public function findRoute($uri) {
        $route = $this->matchRoute($uri);
        $route->readRoute($uri);
        return $route;
    }

    public function controllerExists($controller) {
        $controllerName =
                $this->_controllerNamespace
                . $controller
                . 'Controller';

        return class_exists($controllerName);
    }

    public function actionExists($controller, $action) {
        $controllerName =
                $this->_controllerNamespace .
                $controller .
                'Controller';
        
        return method_exists($controllerName, $action);
    }

    public function executeRoute(Route $route) {
        
        $controllerName =
                $this->_controllerNamespace
                . $route->getController()
                . 'Controller';
                
        $controller = new $controllerName();
        $params = $route->getParams();

        return call_user_func_array([$controller, $route->getAction()], $params);
    }

    private function matchRoute($uri) {

        $matchedRoute = null;

        foreach ($this->_routes as $route) {
            if($route->isMatch($uri)) {
                $matchedRoute = $route;
                break;
            }
        }

        return $matchedRoute;
    }
}