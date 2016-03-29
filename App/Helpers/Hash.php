<?php namespace App\Helpers;

/**
 * Provides methods for hashing and verifying passwords
 */
class Hash {
    public static function create($password) {
        return sha1($password);
//        return password_hash($password, PASSWORD_DEFAULT);
    }
    
    public static function verify($password, $hash) {
        return self::create($password) === $hash;
//        return password_verify($password, $hash);
    }
}
