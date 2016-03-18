<?php namespace App\Helpers;

class Input {

    public static function get($key) {

        if(isset($_GET[$key])) {
            return $_GET[$key];
        }

        return null;
    }

    public static function post($key) {

        if(isset($_POST[$key])) {
            return $_POST[$key];
        }

        return null;
    }

    public static function any($key) {

        if(isset($_POST[$key])) {
            return $_POST[$key];
        }

        if(isset($_GET[$key])) {
            return $_GET[$key];
        }

        return null;
    }
}