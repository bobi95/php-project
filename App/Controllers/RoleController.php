<?php namespace App\Controllers;


use App\Core\Controller;
use App\Services\AuthenticationService;

class RoleController extends Controller {

    public function index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view([''])
    }
}