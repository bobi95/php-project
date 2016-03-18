<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\Helpers\Input;
use App\Models\User;
use App\Services\AuthenticationService;

class AccountController extends Controller {

    private static function mapModel(User $model) {
        $model->setId(Input::post('id'));
        $model->setFirstName(Input::post('firstName'));
        $model->setLastName(Input::post('lastName'));
        $model->setPassword(Input::post('password'));
        $model->setUsername(Input::post('username'));
        $model->setEmail(Input::post('email'));
    }

    public function login() {

        if (AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('index', 'home');
        }

        if (HttpContext::instance()->requestMethod() == 'GET') {
            return $this->view(new User());
        }

        $model = new User();
        self::mapModel($model);

        $model->isValid();

        if ($model->getError('username') || $model->getError('password')) {
            return $this->view($model);
        }

        if (AuthenticationService::logUserIn($model->getUsername(), $model->getPassword())) {
            return $this->redirectToAction('index', 'Home');
        }

        $model->setError('auth', 'Username or password are incorrect');

        return $this->view($model);
    }

    public function logout() {
        AuthenticationService::logout();

        return $this->redirectToAction('login');
    }
}