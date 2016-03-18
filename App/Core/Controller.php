<?php namespace App\Core;

use App\Helpers\Redirect;
use App\Core\HttpContext;

class Controller {
    
    /**
     * Current route
     * 
     * @var \App\Core\Router\Route Current route
     */
    private $_route;

    public function __construct() {
        $this->_route = HttpContext::instance()->getRoute();
    }
    
    /**
     * Get http context
     * @return \App\Core\HttpContext
     */
    protected function context() {
        return HttpContext::instance();
    }

    /**
     * Get temp data
     * @return \App\Helpers\TempData
     */
    protected function tempData() {
        return $this->context()->getTempData();
    }

    /**
     * Redirect user to a URL
     * @param string $url URL
     * @param array $params URL parameters
     */
    protected function redirect($url, $params = []) {
        $context = $this->tempData();
        return [
            'type' => 'redirect',
            'controllerName' => $context->get('controller'),
            'actionName' => $context->get('action'),
            'viewName' => '',
            'url' => $url,
            'model' => $params
        ];
    }
    
    /**
     * Redirect user to a controller's action with given URL parameterss
     * @param string $action Action name
     * @param string $controllerName Controller name
     * @param array $params URL parameters
     * @param array Always returns null
     * @return array Redirect information
     */
    protected function redirectToAction($action, $controllerName = null, $params = []) {
//        $url = $this->_route->getUrlForAction($action, $controllerName, $params);
//        Redirect::to($url);
        
        $context = $this->tempData();
        $result = [
            'type' => 'redirectAction',
            'controllerName' => isset($controllerName) ? $controllerName : $context->get('controller'),
            'actionName' => isset($action) ? $action : $context->get('action'),
            'viewName' => '',
            'url' => '',
            'model' => isset($params) ? $params : []
        ];
        
        return $result;
    }

    /**
     * Use an HTML view with the given model
     * @param any $model Model
     * @param string $viewName File name
     * @return array
     */
    protected function view($model = null, $viewName = null) {

        $context = $this->tempData();
        
        if(empty($viewName)) {
            $viewName = $context->get('action');
        }

        $result = [
            'type' => 'html',
            'controllerName' => $context->get('controller'),
            'actionName' => $context->get('action'),
            'viewName' => $viewName,
            'url' => $context->get('url'),
            'model' => $model
        ];

        return $result;
    }
}