<?php namespace App\Core\Views;

use App\Core\View;

class EmptyView extends View {
    public function __construct() {
        parent::__construct(null);
    }
    
    public function render() {
        
    }
}
