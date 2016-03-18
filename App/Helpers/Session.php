<?php namespace App\Helpers;

use App\Core\MapWrapper;

class Session extends MapWrapper {

    private static $_instance = null;

    /**
     * Get session instance
     * @return Session
     */
    public static function instance() {

        if(self::$_instance == null) {
            \session_start();
            self::$_instance = new self;
        }

        return self::$_instance;
    }
    
    public static function save() {
        $_SESSION = self::instance()->getCollection();
    }

    protected function __construct() {
        parent::__construct($_SESSION);
    }
}