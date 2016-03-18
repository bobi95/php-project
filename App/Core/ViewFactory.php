<?php namespace App\Core;

use App\Helpers\Redirect;

class ViewFactory {
    private function __construct() {
        
    }
    
    /**
     * Contruct a view, based on the view context
     * @param array $viewContext View context
     * @param \App\Core\Router\Route $route Executing route
     * @return \App\Core\View
     */
    public static function createView($viewContext) {
        if($viewContext['type'] === 'html') {
            
            return new Views\HtmlView($viewContext);
            
        } else if ($viewContext['type'] === 'redirect') {
                    
            $params = $viewContext['model'];
            $url = $viewContext['url'];
            
            $builtUrl = self::buildUrl($url, $params);
            
            self::redirect($builtUrl);
            
            return new Views\EmptyView();
            
        } else if ($viewContext['type'] === 'redirectAction') {
        
            $route = \App::getRoute();
            $action = $viewContext['actionName'];
            $controller = $viewContext['controllerName'];
            $params = $viewContext['model'];
            
            $actionRoute = $route->getUrlForAction($action, $controller, $params);
            Redirect::to($actionRoute);
            
            return new Views\EmptyView();
        }
    }
    
    private static function buildUrl($url, $params) {
        if (isset($params) && !empty($params)) {
            $paramStrings = [];

            foreach ($params as $key => $value) {
                $key = urlencode($key);
                $value = urlencode($value);
                $paramStrings[] = "{$key}={$value}";
            }

            $url .= '?' + implode('&', $paramStrings);
        }
        
        return $url;
    }
    
    private static function redirect($url) {
        Redirect::to($url);
        die();
    }
}
