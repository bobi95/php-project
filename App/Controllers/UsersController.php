<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\RoleRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Hash;
use App\Helpers\Html;
use App\Models\User;
use App\Models\Address;
use App\Models\Note;
use App\Helpers\Input;
use App\DataAccess\UserRepository;
use App\Helpers\Session;
use App\Services\AuthenticationService;
use App\Services\PagingService;

class UsersController extends Controller {
    public function index() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listusers()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $usersData = [];

        $userRepo = new UserRepository();

        $filter = $data->hasFilter() ? ['like' => ['username' => '%' . $data->getFilter() . '%']] : [];

        $users = $userRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var User $user */
        foreach ($users as $user)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'users', ['id' => $user->getId()]) . '">Редактирай</а> ';
            $options .= '<a href="' . $htmlHelper->url('delete', 'users', ['id' => $user->getId()]) . '">Изтриване</а>';

            // Group data
            $usersData[] = [
                'id'          => $user->getId(),
                'username'	  => $user->getUsername(),
                'email'		  => $user->getEmail(),
                'role_id'	  => $user->getRole()->getName(),
                'options'     => $options,
            ];
        }

        $count = $userRepo->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> count($users),
            'data'				=> $usersData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $roles = (new RoleRepository())->getAll();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['user' => new User(), 'roles' => $roles]);
        }

        $model = new User();
        self::bindUser($model);

        if ($model->getPassword() !== Input::post('password_repeat')) {
            $model->setError('password_repeat', 'Passwords don\'t match.');
        }

        if (!$model->isValid()) {
            return $this->view(['user' => $model, 'roles' => $roles ]);
        }

        $repo = new UserRepository();

        $user = $repo->getUserByUsername($model->getUsername());


        if ($user) {
            $model->setError('username', 'Username already in use.');
        }

        $user = $repo->getUserByEmail($model->getEmail());

        if ($user) {
            $model->setError('email', 'Email already in use.');
        }

        if (!empty($model->getAllErrors())) {
            return $this->view(['user' => $model, 'roles' => $roles]);
        }

        $model->setPassword(Hash::create($model->getPassword()));

        $model->setId(0);
        $repo->save($model);

        return $this->redirectToAction('index', 'users');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $roles = (new RoleRepository())->getAll();

        $repo = new UserRepository();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            $user = $repo->getById($id);

            if (!$user) {
                return $this->redirectToAction('index', 'users');
            }

            return $this->view(['user' => $user, 'roles' => $roles]);
        }

        $model = new User();
        self::bindUser($model);

        if ($model->getPassword() !== Input::post('password_repeat')) {
            $model->setError('password_repeat', 'Passwords don\'t match.');
        }

        if (!$model->isValid()) {
            return $this->view(['user' => $model, 'roles' => $roles ]);
        }

        $user = $repo->getById($model->getId());

        if (!$user) {
            return $this->redirectToAction('index', 'users');
        }

        if ($model->getUsername() !== $user->getUsername()) {
            $newuser = $repo->getUserByUsername($model->getUsername());

            if ($newuser) {
                $model->setError('username', 'Username already in use');
            }
        }

        if ($model->getEmail() !== $user->getEmail()) {
            $newuser = $repo->getUserByEmail($model->getEmail());

            if ($newuser) {
                $model->setError('email', 'Email already in use');
            }
        }

        if (!Hash::verify($model->getPassword(), $user->getPassword())) {
            $model->setError('password', 'Wrong password');
        }

        if (!empty($model->getAllErrors())) {
            return $this->view(['user' => $model, 'roles' => $roles]);
        }

        $model->setPassword($user->getPassword());
        $repo->save($model);

        return $this->redirectToAction('index', 'users');
    }
    
    /**
     * Bind the user to the post input
     * @param \App\Models\User $model
     */
    private static function bindUser($model) {
        $model->setId(Input::post('id'));
        $model->setFirstName(Input::post('first_name'));
        $model->setLastName(Input::post('last_name'));
        $model->setPassword(Input::post('password'));
        $model->setUsername(Input::post('username'));
        $model->setEmail(Input::post('email'));
        $model->setRoleId(Input::post('role_id'));
    }

//    public function Create() {
//        $model = new User();
//
//        $session = Session::instance();
//
//        if ($this->context()->requestMethod() !== 'POST') {
//            return $this->view($model);
//        }
//        self::bindUser($model);
//
//        $model->isValid();
//        $userRepo = new UserRepository();
//
//        if(!$model->getError('username')) {
//            $user = $userRepo->getByUsername($model->getUsername());
//
//            if($user) {
//                $model->setError('username', 'Username already in use.');
//            }
//        }
//
//        if(!$model->getError('email')) {
//            $user = $userRepo->getByEmail($model->getEmail());
//
//            if($user) {
//                $model->setError('email', 'Email already in use.');
//            }
//        }
//
//        if(empty($model->getAllErrors())) {
//            return $this->redirectToAction('Index');
//        }
//
//        return $this->view($model);
//    }
}
