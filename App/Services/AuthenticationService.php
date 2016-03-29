<?php namespace App\Services;

use App\DataAccess\UserRepository;
use App\Helpers\Hash;
use App\Helpers\Session;
use App\Models\User;

class AuthenticationService {
    private static $key = '__loggedUser';
    
    private function __construct() {
    }
    
    public static function isUserLogged() {
        return Session::instance()->exists(self::$key);
    }

    /**
     * @return User
     */
    public static function getLoggedUser() {
        return Session::instance()->get(self::$key);
    }
    
    public static function logUserIn($username, $password) {
        self::logout();

        $repo = new UserRepository();
        $user = $repo->getUserByUsername($username);

        if (!$user || !Hash::verify($password, $user->getPassword())) {
            return false;
        }

        Session::instance()->set(self::$key, $user);
        return true;
    }

    public static function logout() {
        Session::instance()->delete(self::$key);
    }
}
