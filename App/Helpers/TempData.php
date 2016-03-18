<?php namespace App\Helpers;

use App\Core\MapWrapper;

class TempData extends MapWrapper {
    public static function create($collection) {
        $tempData = new TempData($collection);
        return $tempData;
    }
    
    protected function __construct($collection) {
        parent::__construct($collection);
    }
}
