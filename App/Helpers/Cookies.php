<?php namespace App\Helpers;

use App\Core\MapWrapper;

class Cookies extends MapWrapper {

    private static $_instance = null;

    public static function instance() {

        if(self::$_instance == null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    protected function __construct() {
        parent::__construct($_COOKIE);
    }
}