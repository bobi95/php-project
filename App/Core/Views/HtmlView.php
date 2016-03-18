<?php namespace App\Core\Views;

use App\Core\View;
use App\Helpers\Config;
use App\Helpers\Html;

class HtmlView extends View {
    
    private $viewsFolder;
    private $layout;
    private $viewName;
    private $viewData;
    private $sections;
    private $body;
    
    public function __construct($actionResult) {
        parent::__construct($actionResult);
        
        $this->viewName = $actionResult['viewName'];
        $this->viewsFolder = Config::get('views.folder');
        $this->layout = Config::get('views.layout');
    }
    
    public function render(){
        $this->body = $this->runBody();
        $html = new Html();
        require_once $this->viewsFolder . $this->layout;
    }
    
    protected function getViewData($key) {
        return isset($this->viewData[$key]) ? $this->viewData[$key] : null;
    }
    
    private function runBody() {
        $model = $this->getModel();
        $viewData = [];
        $tempData = \App\Core\HttpContext::instance()->getTempData();
        $sections = [];
        $html = new Html();
        ob_start();
        require_once "{$this->viewsFolder}{$this->getControllerName()}\\{$this->viewName}.php";
        $body = ob_get_clean();
        $this->viewData = $viewData;
        $this->sections = $sections;
        return $body;
    }
    
    protected function renderBody() {
        echo isset($this->body) ? $this->body : '';
    }
    
    protected function renderSection($name, $isRequired = false) {
        if($isRequired && !isset($this->sections[$name])) {
            throw new Exception('Required section not included');
        }
        
        if(isset($this->sections[$name])) {
            $this->sections[$name]();
        }
    }
}
