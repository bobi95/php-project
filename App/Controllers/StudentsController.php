<?php namespace App\Controllers;


use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\CourseRepository;
use App\DataAccess\EducationTypeRepository;
use App\DataAccess\SpecialityRepository;
use App\DataAccess\StudentRepository;
use App\DataAccess\UserRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Hash;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Student;
use App\Models\User;
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

        // Build response & send to data tables
        $studentsData = [];

        $studentRepo = new StudentRepository();

        $filter = $data->hasFilter() ? ['like' => ['student_fnumber' => $data->getFilter() . '%']] : [];

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
                'student_id'              => $student->getId(),
                'student_names'           => $student->getFirstName() . ' ' . $student->getLastName(),
                'student_course_id'	      => $coursesRepo->getById($student->getCourseId())->getName(),
                'student_speciality_id'   => $specialityRepo->getById($student->getSpecialityId())->getName(),
                'student_education_form'  => $student->getEducationForm(),
                'student_fnumber'         => $student->getFacultyNumber(),
                'options'                 => $options
            ];
        }

        $count = $studentRepo->count($filter);

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
        $user = new User();

        $models = [
            'student'        => $student,
            'user'           => $user,
            'courses'        => (new CourseRepository())->getAll(),
            'specialties'    => (new SpecialityRepository())->getAll(),
            'educationTypes' => ['Р', 'З']
        ];

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view($models);
        }

        self::bindStudents($student);
        self::bindUser($user);

        $student->setFirstName($user->getFirstName());
        $student->setLastName($user->getLastName());
        $student->setEmail($user->getEmail());

        if ($user->getPassword() !== Input::post('password_repeat')) {
            $user->setError('password_repeat', 'Passwords don\'t match.');
        }

        if (!$student->isValid() || !$user->isValid()) {
            return $this->view($models);
        }

        $studentRepo = new StudentRepository();
        $userRepo = new UserRepository();

        $otherUser = $userRepo->getUserByUsername($user->getUsername());

        if ($otherUser) {
            $user->setError('username', 'Username already in use.');
        }

        $otherUser = $userRepo->getUserByEmail($user->getEmail());

        if ($otherUser) {
            $user->setError('email', 'Email already in use.');
        }

        if (!empty($user->getAllErrors())) {
            return $this->view($models);
        }

        $user->setPassword(Hash::create($user->getPassword()));

        $user->setId(0);
        $student->setId(0);

        $userRepo->save($user);
        $studentRepo->save($student);

        return $this->redirectToAction('index', 'students');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $studentRepository = new StudentRepository();
        $usersRepository   = new UserRepository();

        /** @var Student $student */
        $student = $studentRepository->getById($id);

        if (!$student) {
            return $this->redirectToAction('index', 'students');
        }

        $user = $usersRepository->getUserByEmail($student->getEmail());

        if (!$user) {
            $user = new User();
            $user->setId(0);
            $user->setFirstName($student->getFirstName());
            $user->setLastName($student->getLastName());
            $user->setEmail($student->getEmail());
        }

        $models = [
            'student'        => $student,
            'user'           => $user,
            'courses'        => (new CourseRepository())->getAll(),
            'specialties'    => (new SpecialityRepository())->getAll(),
            'educationTypes' => ['Р', 'З']
        ];

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view($models);
        }

        $oldUsername = $user->getUsername();
        $oldEmail = $user->getEmail();

        self::bindStudents($student);
        self::bindUser($user);

        $student->setFirstName($user->getFirstName());
        $student->setLastName($user->getLastName());
        $student->setEmail($user->getEmail());

        if ($user->getPassword() !== Input::post('password_repeat')) {
            $user->setError('password_repeat', 'Passwords don\'t match.');
        }

        if (!$student->isValid() || !$user->isValid()) {
            return $this->view($models);
        }

        if (\strtolower($user->getUsername()) !== \strtolower($oldUsername)) {
            $otherUser = $usersRepository->getUserByUsername($user->getUsername());

            if ($otherUser) {
                $user->setError('username', 'Username already in use.');
            }
        }

        if (\strtolower($user->getEmail()) !== \strtolower($oldEmail)) {
            $otherUser = $usersRepository->getUserByEmail($user->getEmail());

            if ($otherUser) {
                $user->setError('email', 'Email already in use.');
            }
        }

        if (!empty($user->getAllErrors())) {
            return $this->view($models);
        }

        $user->setPassword(Hash::create($user->getPassword()));

        $usersRepository->save($user);
        $studentRepository->save($student);

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
        $entity->setEducationForm(Input::post('education_form'));
        $entity->setFacultyNumber(Input::post('faculty_number'));
    }

    private static function bindUser(User $entity) {
        $entity->setId(Input::post('user_id'));
        $entity->setFirstName(Input::post('first_name'));
        $entity->setLastName(Input::post('last_name'));
        $entity->setUsername(Input::post('username'));
        $entity->setPassword(Input::post('password'));
        $entity->setEmail(Input::post('email'));
    }
}