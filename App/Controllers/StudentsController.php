<?php namespace App\Controllers;


use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\CourseRepository;
use App\DataAccess\EducationTypeRepository;
use App\DataAccess\SpecialityRepository;
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

        $coursesRepo = new CourseRepository();
        $specialityRepo = new SpecialityRepository();
        $educationTypeRepo = new EducationTypeRepository();

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
            $options .= '<a href="' . $htmlHelper->url('edit', 'students', ['id' => $student->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'students', ['id' => $student->getId()]) . '">Изтриване</а>';

            // Group data
            $studentsData[] = [
                'id'          => $student->getId(),
                'course_id'	      => $coursesRepo->getById($student->getCourseId())->getName(),
                'specialty_id'  => $specialityRepo->getById($student->getSpecialityId())->getName(),
                'education_type_id'  => $educationTypeRepo->getById($student->getEducationForm())->getName(),
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

        $student = new Student();

        $models = [
            'student'        => $student,
            'courses'        => (new CourseRepository())->getAll(),
            'specialties'    => (new SpecialityRepository())->getAll(),
            'educationTypes' => (new EducationTypeRepository())->getAll(),
        ];

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view($models);
        }

        self::bindStudents($student);

        if (!$student->isValid()) {
            return $this->view(['student' => $models]);
        }

        $repo = new StudentRepository();

        $repo->save($student);

        return $this->redirectToAction('index', 'students');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new StudentRepository();

        /** @var Student $student */
        $student = $repo->getById($id);

        if (!$student) {
            return $this->redirectToAction('index', 'students');
        }

        $models = [
            'student'        => $student,
            'courses'        => (new CourseRepository())->getAll(),
            'specialties'    => (new SpecialityRepository())->getAll(),
            'educationTypes' => (new EducationTypeRepository())->getAll(),
        ];

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view($models);
        }

        self::bindStudents($student);

        if (!$student->isValid()) {
            return $this->view($models);
        }

        $repo->save($student);

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
        $entity->setCourseId(Input::post('course_id'));
        $entity->setSpecialityId(Input::post('specialty_id'));
        $entity->setEducationForm(Input::post('education_type_id'));
        $entity->setFacultyNumber(Input::post('faculty_number'));
    }
}