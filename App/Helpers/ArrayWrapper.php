<?php namespace App\Helpers;

use App\Core\MapWrapper;

class ArrayWrapper extends MapWrapper {
    protected function __construct($collection) {
        parent::__construct($collection);
    }

    /**
     * @param array $collection
     * @return ArrayWrapper
     */
    public static function construct($collection) {
        return new ArrayWrapper($collection);
    }
}