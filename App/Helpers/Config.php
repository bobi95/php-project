<?php namespace App\Helpers;

class Config {

    private static $_instance = null;
    private static $_delimeter = '.';

    private $_config;

    public static function get($key, $default = null) {

        $config = self::instance();

        return $config->_get($key, $default);
    }

    public static function exists($key) {
        $config = self::instance();

        return $config->_exists($key);
    }

    private function _get($key, $default = null) {

        $segments = explode(self::$_delimeter, $key);

        $data = $this->_config;

        foreach ($segments as $segment) {

            if(isset($data[$segment])) {
                $data = $data[$segment];
            } else {
                $data = $default;
            }
        }

        return $data;
    }

    private function _exists($key) {
        $segments = explode(self::$_delimeter, $key);

        $data = $this->_config;

        foreach ($segments as $segment) {

            if(isset($data[$segment])) {
                $data = $data[$segment];
            } else {
                return false;
            }
        }

        return true;
    }

    private static function instance() {

        if (self::$_instance == null) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    private function __construct() {

        $string = file_get_contents(__DIR__ . '\\..\\app_config.json',
                FILE_USE_INCLUDE_PATH);
        
        $this->_config = json_decode($string, true);

        if(isset($this->_config['delimeter'])) {
            self::$_delimeter = $this->_config['delimeter'];
        }
    }
}