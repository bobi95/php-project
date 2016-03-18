<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\RoleRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Hash;
use App\Helpers\Html;
use App\Models\Course;
use App\Helpers\Input;
use App\DataAccess\CourseRepository;
use App\Helpers\Session;
use App\Services\AuthenticationService;
use App\Services\PagingService;

class CoursesController extends Controller {
    public function index() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function create() {
        return $this->view(['course' => new Course()]);
    }

    public function listcourses()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $coursesData = [];

        $courseRepo = new CourseRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $courses = $courseRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var User $user */
        foreach ($courses as $course)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'courses', ['id' => $course->getId()]) . '">Редактирай</а> ';
            $options .= '<a href="' . $htmlHelper->url('delete', 'courses', ['id' => $course->getId()]) . '">Изтриване</а>';

            // Group data
            $coursesData[] = [
                'id'          => $course->getId(),
                'name'	      => $course->getName(),                
                'options'     => $options,
            ];
        }

        $count = $courseRepo->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> $count,
            'data'				=> $coursesData,
        ];

        echo json_encode($response);
        exit;
    }

    // public function create() {

    //     if (!AuthenticationService::isUserLogged()) {
    //         return $this->redirectToAction('login', 'account');
    //     }

    //     $roles = (new RoleRepository())->getAll();

    //     if (HttpContext::instance()->requestMethod() === 'GET') {
    //         return $this->view(['user' => new User(), 'roles' => $roles]);
    //     }

    //     $model = new User();
    //     self::bindUser($model);

    //     if ($model->getPassword() !== Input::post('password_repeat')) {
    //         $model->setError('password_repeat', 'Passwords don\'t match.');
    //     }

    //     if (!$model->isValid()) {
    //         return $this->view(['user' => $model, 'roles' => $roles ]);
    //     }

    //     $repo = new UserRepository();

    //     $user = $repo->getUserByUsername($model->getUsername());


    //     if ($user) {
    //         $model->setError('username', 'Username already in use.');
    //     }

    //     $user = $repo->getUserByEmail($model->getEmail());

    //     if ($user) {
    //         $model->setError('email', 'Email already in use.');
    //     }

    //     if (!empty($model->getAllErrors())) {
    //         var_dump_pre($model->getAllErrors());
    //         return $this->view(['user' => $model, 'roles' => $roles]);
    //     }

    //     $model->setPassword(Hash::create($model->getPassword()));

    //     $model->setId(0);
    //     $repo->save($model);

    //     return $this->redirectToAction('index', 'users');
    // }

    // public function edit($id) {

    //     if (!AuthenticationService::isUserLogged()) {
    //         return $this->redirectToAction('login', 'account');
    //     }

    //     $roles = (new RoleRepository())->getAll();

    //     $repo = new UserRepository();

    //     if (HttpContext::instance()->requestMethod() === 'GET') {
    //         $user = $repo->getById($id);

    //         if (!$user) {
    //             return $this->redirectToAction('index', 'users');
    //         }

    //         return $this->view(['user' => $user, 'roles' => $roles]);
    //     }

    //     $model = new User();
    //     self::bindUser($model);

    //     if ($model->getPassword() !== Input::post('password_repeat')) {
    //         $model->setError('password_repeat', 'Passwords don\'t match.');
    //     }

    //     if (!$model->isValid()) {
    //         return $this->view(['user' => $model, 'roles' => $roles ]);
    //     }

    //     $user = $repo->getById($model->getId());

    //     if (!$user) {
    //         return $this->redirectToAction('index', 'users');
    //     }

    //     if ($model->getUsername() !== $user->getUsername()) {
    //         $newuser = $repo->getUserByUsername($model->getUsername());

    //         if ($newuser) {
    //             $model->setError('username', 'Username already in use');
    //         }
    //     }

    //     if ($model->getEmail() !== $user->getEmail()) {
    //         $newuser = $repo->getUserByEmail($model->getEmail());

    //         if ($newuser) {
    //             $model->setError('email', 'Email already in use');
    //         }
    //     }

    //     if (!Hash::verify($model->getPassword(), $user->getPassword())) {
    //         $model->setError('password', 'Wrong password');
    //     }

    //     if (!empty($model->getAllErrors())) {
    //         return $this->view(['user' => $model, 'roles' => $roles]);
    //     }

    //     $model->setPassword($user->getPassword());
    //     $repo->save($model);

    //     return $this->redirectToAction('index', 'users');
    // }
    
    /**
     * Bind the user to the post input
     * @param \App\Models\User $model
     */
    // private static function bindUser($model) {
    //     $model->setId(Input::post('id'));
    //     $model->setFirstName(Input::post('first_name'));
    //     $model->setLastName(Input::post('last_name'));
    //     $model->setPassword(Input::post('password'));
    //     $model->setUsername(Input::post('username'));
    //     $model->setEmail(Input::post('email'));
    //     $model->setRoleId(Input::post('role_id'));
    // }

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
