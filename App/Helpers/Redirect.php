<?php namespace App\Helpers;

class Redirect {
    
    public static function to($url) {
        if($url) {
            header("Location: {$url}");
        }
    }
}
