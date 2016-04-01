<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\RoleRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Hash;
use App\Helpers\Html;
use App\Models\Role;
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

        $filter = $data->hasFilter() ? ['like' => ['user_name' => '%' . $data->getFilter() . '%']] : [];

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
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'users', ['id' => $user->getId()]) . '">Изтриване</а>';

            $roles = $user->getRoles();
            $roleNames = [];
            foreach ($roles as $role) {
                $roleNames[] = $role->getName();
            }

            // Group data
            $usersData[] = [
                'user_id'           => $user->getId(),
                'user_name'	        => $user->getUsername(),
                'user_email'	    => $user->getEmail(),
                'user_role_id'	    => implode(', ', $roleNames),
                'options'           => $options,
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

        $userRoles = [];
        $setRoles = Input::post('role_ids');

        /** @var Role $role */
        foreach ($roles as $role) {
            if(in_array($role->getId(), $setRoles)) {
                $userRoles[] = $role;
            }
        }

        $model->setId(0);
        $repo->save($model);

        $repo->setRolesToUser($model, $userRoles);

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
            $newUser = $repo->getUserByUsername($model->getUsername());

            if ($newUser) {
                $model->setError('username', 'Username already in use');
            }
        }

        if ($model->getEmail() !== $user->getEmail()) {
            $newUser = $repo->getUserByEmail($model->getEmail());

            if ($newUser) {
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

        $userRoles = [];
        $setRoles = Input::post('role_ids');

        /** @var Role $role */
        foreach ($roles as $role) {
            if(in_array($role->getId(), $setRoles)) {
                $userRoles[] = $role;
            }
        }

        $repo->save($model);

        $repo->setRolesToUser($model, $userRoles);

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
    }

    public function delete($id)
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new UserRepository();

        /** @var User $user */
        $user = $repo->getById($id);

        if (!$user) {
            return $this->redirectToAction('index', 'users');
        }

        $repo->delete($user);

        return $this->redirectToAction('index', 'users');
    }
}
