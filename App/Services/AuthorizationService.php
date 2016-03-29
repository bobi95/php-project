<?php namespace App\Services;

use App\Models\Role;

class AuthorizationService {
    public static function requireRole($roleKey) {
        if (!AuthenticationService::isUserLogged()) {
            return false;
        }

        $user = AuthenticationService::getLoggedUser();
        $roles = $user->getRoles();

        for($i = 0, $count = count($roles); $i < $count; $i++) {
            /** @var Role $role */
            $role = $roles[$i];
            if ($role->getKey() === $roleKey) return true;
        }

        return false;
    }
}