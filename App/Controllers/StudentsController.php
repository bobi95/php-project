<?php namespace App\Controllers;


use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\StudentRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Student;
use App\Services\AuthenticationService;

class StudentsController extends Controller {

    public function index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function liststudents() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $studentsData = [];

        $studentRepo = new StudentRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $students = $studentRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var Student $student */
        foreach ($students as $student)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'specialties', ['id' => $student->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'specialties', ['id' => $student->getId()]) . '">Изтриване</а>';

            // Group data
            $studentsData[] = [
                'id'          => $student->getId(),
                'course_id'	      => $student->getCourseId(),
                'specialty_id'  => $student->getSpecialtyId(),
                'education_type_id'  => $student->getEducationTypeId(),
                'faculty_number'  => $student->getFacultyNumber(),
                'options'     => $options
            ];
        }

        $count = $studentRepo->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> $count,
            'data'				=> $studentsData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['student' => new Student()]);
        }

        $model = new Student();
        self::bindStudents($model);

        if (!$model->isValid()) {
            return $this->view(['student' => $model]);
        }

        $repo = new StudentRepository();

        $repo->save($model);

        return $this->redirectToAction('index', 'students');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new StudentRepository();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            $model = $repo->getById($id);

            if (!$model) {
                return $this->redirectToAction('index', 'students');
            }

            return $this->view(['student' => $model]);
        }

        $model = new Student();
        self::bindStudents($model);

        if (!$model->isValid()) {
            return $this->view(['student' => $model]);
        }

        $student = $repo->getById($model->getId());

        if (!$student) {
            return $this->redirectToAction('index', 'students');
        }

        $repo->save($model);

        return $this->redirectToAction('index', 'students');
    }

    public function delete($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new StudentRepository();

        /** @var Student $student */
        $student = $repo->getById($id);

        if (!$student) {
            return $this->redirectToAction('index', 'students');
        }

        $repo->delete($student);

        return $this->redirectToAction('index', 'students');
    }

    private static function bindStudents(Student $entity) {
        $entity->setId(Input::post('id'));
        $entity->setCourseId(Input::post('course_id'));
        $entity->setSpecialtyId(Input::post('specialty_id'));
        $entity->setEducationTypeId(Input::post('education_type_id'));
        $entity->setFacultyNumber(Input::post('faculty_number'));
    }
}