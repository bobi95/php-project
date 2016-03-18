<?php namespace App\Controllers;

use App\Core\Controller;
use App\Services\AuthenticationService;

class HomeController extends Controller {

    public function Index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }
}