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

    // public function create() {
    //     return $this->view(['course' => new Course()]);
    // }

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

        $filter = $data->hasFilter() ? ['like' => ['course_name' => '%' . $data->getFilter() . '%']] : [];

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
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'courses', ['id' => $course->getId()]) . '">Изтриване</а>';

            // Group data
            $coursesData[] = [
                'course_id'           => $course->getId(),
                'course_name'	      => $course->getName(),
                'options'             => $options,
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

    public function create() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $course = new Course();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['course' => $course]);
        }

        $course->setName(Input::post('name'));

        if (!$course->isValid()) {
            return $this->view(['course' => $course]);
        }

        $repo = new CourseRepository();

        if ($repo->count(['like' => ['course_name' => $course->getName()]]))
        {
            $course->setError('name', 'Курс с такова име вече същестува!');
        }

        if (!empty($course->getAllErrors())) {
            return $this->view(['course' => $course]);
        }

        $course->setId(0);
        $repo->save($course);

        return $this->redirectToAction('index', 'courses');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new CourseRepository();

        /** @var Role $role */
        $course = $repo->getById($id);

        if (!$course) {
            return $this->redirectToAction('index', 'courses');
        }

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['course' => $course]);
        }

        $newName = Input::post('name');

        $course->setName(Input::post('name'));

        if (!$course->isValid()) {
            return $this->view(['course' => $course]);
        }

        // Check for duplicates in the DB
        if ($newName != $course->getName() && $repo->count(['like' => ['name' => $newName]]))
        {
            $course->setError('name', 'Курсът вече съществува в базата!');
        }

        if (!empty($course->getAllErrors())) {
            return $this->view(['course' => $course]);
        }

        $repo->save($course);

        return $this->redirectToAction('index', 'courses');
    }

    public function delete($id)
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new CourseRepository();

        /** @var Role $role */
        $course = $repo->getById($id);

        if (!$course) {
            return $this->redirectToAction('index', 'courses');
        }

        $repo->delete($course);

        return $this->redirectToAction('index', 'courses');
    }
}