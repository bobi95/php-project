<?php namespace App\Core;

use App\Helpers\Config;

abstract class View {

    private $model;
    private $controllerName;
    private $actionName;

    public function __construct($actionResult) {
        if(!isset($actionResult)) return;
        
        $this->controllerName = $actionResult['controllerName'];
        $this->actionName = $actionResult['actionName'];
        $this->model = $actionResult['model'];
    }
    
    protected function getModel() {
        return $this->model;
    }
    
    protected function getControllerName() {
        return $this->controllerName;
    }
    
    protected function getActionName() {
        return $this->actionName;
    }

    public abstract function render();
}