<?php namespace App\Routes;

use App\Core\Router\Route;

class DefaultRoute extends Route {
    
    public function __construct($router) {
        parent::__construct($router);
        
        $this->_defaults = [
            'controller' => 'Home',
            'action' => 'Index'
        ];
    }
    
    public function isMatch($uri) {
        
        $matches = [];
        preg_match("/\/([a-zA-Z]*)(?:\/([a-zA-Z]*)(?:\/([0-9])*)?\/?)?/", $uri, $matches);
        
        return !empty($matches);
    }

    public function readRoute($uri) {
        $matches = [];
        preg_match("/\/([a-zA-Z]*)(?:\/([a-zA-Z]*)(?:\/([0-9]*))?\/?)?/", $uri, $matches);
        
        $this->_controllerName = $this->_defaults['controller'];
        $this->_actionName = $this->_defaults['action'];
        $this->_params = [];
        
        // controller
        if(!isset($matches[1]) ||
            empty($matches[1]) ||
            !$this->_router->controllerExists($matches[1])) {
            return;
        }
        
        $this->_controllerName = $matches[1];

        //action
        if(!isset($matches[2]) ||
            empty($matches[2]) ||
            !$this->_router->actionExists($this->_controllerName, $matches[2])) {
            
            if (!$this->_router->actionExists($this->_controllerName, $this->_defaults['action'])) {
                $this->_controllerName = $this->_defaults['controller'];
            }

            return;
        }
        
        $this->_actionName = $matches[2];
        if(!isset($matches[3]) ||
            empty($matches[3])) {
            return;
        }
        
        $this->_params = [
            'id' => (int)$matches[3]
        ];
    }
    
    public function getUrlForAction($action = null, $controller = null, $params = []) {

        if (isset($controller) && $controller === strtolower($this->_defaults['controller'])) {
            $controller = null;
        }

        if (isset($action) && $action === strtolower($this->_defaults['action'])) {
            $action = null;
        }

        if (!empty($params)) {

            if (!isset($controller)) {
                $controller = $this->_defaults['controller'];
            }

            if (!isset($action)) {
                $action = $this->_defaults['action'];
            }

            $url = "/{$controller}/{$action}";

            if(isset($params['id'])) {
                $url .= '/' . urlencode($params['id']);
                unset($params['id']);
            }

            if (!empty($params)) {
                $data = [];
                foreach ($params as $key => $value) {
                    if (!empty($value))
                    $data[] = urlencode($key) . '=' . urlencode($value);
                }
                if (!empty($data)) {
                    $url .= '?' . implode('&', $data);
                }
            }

            return $url;
        }

        if (isset($action)) {

            if (!isset($controller)) {
                $controller = $this->_defaults['controller'];
            }

            return "/{$controller}/{$action}";
        }

        if (isset($controller)) {
            return '/' . $controller;
        }

        return '/';

//        if ((
//                !isset($action) ||
//                $action === $this->_defaults['action']
//            )
//                &&
//            (
//                !isset($controller) ||
//                $controller === $this->_defaults['controller']
//            )
//                &&
//            empty($params)
//            ) {
//
//            return '/';
//        }
//
//
//
//
//        if (!isset($controller)) {
//
//            $controller = $this->getController();
//        }
//
//        $url = '/' . $controller;
//
//        if (!isset($action)) {
//            $action = $this->getAction();
//        }
//
//        if($action === $this->_defaults['action'] && empty($params)) {
//            return $url;
//        }
//
//        $url .= '/' . $action;
//
//        if (!empty($params)) {
//
//            if(isset($params['id'])) {
//                $url .= urlencode($params['id']);
//                unset($params['id']);
//            }
//
//            $url .= '?';
//            foreach ($params as $key => $value) {
//                $url .= urlencode($key) . '=' . urlencode($value);
//            }
//        }
//
//        return $url;
    }
}

