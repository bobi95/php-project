<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\AssessmentRepository;
use App\DataAccess\StudentRepository;
use App\DataAccess\SubjectRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Assessment;
use App\Services\AuthenticationService;

class AssessmentsController extends Controller {

    public function index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listassessments()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $assessmentsData = [];

        $assessmentsRepo = new AssessmentRepository();
        $studentsRepo = new StudentRepository();
        $subjectRepo = new SubjectRepository();

        $assessments = $assessmentsRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            []
        );

        $htmlHelper = new Html();

        /** @var Assessment $assessment */
        foreach ($assessments as $assessment)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'assessments', ['id' => $assessment->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'assessments', ['id' => $assessment->getId()]) . '">Изтриване</а>';

            // Group data
            $assessmentsData[] = [
                'sa_id'                  => $assessment->getId(),
                'sa_student_id'          => $studentsRepo->getById($assessment->getStudentId())->getFacultyNumber(),
                'sa_subject_id'          => $subjectRepo->getById($assessment->getSubjectId())->getName(),
                'sa_assesment'           => $assessment->getAssessment(),
                'sa_workload_lectures'   => $assessment->getLectures(),
                'sa_workload_exercises'  => $assessment->getExercises(),
                'options'                => $options,
            ];
        }

        $count = $assessmentsRepo->count();

        $response = [
            'draw'              => $data->getRequestId(),
            'recordsTotal'      => $count,
            'recordsFiltered'   => count($assessments),
            'data'              => $assessmentsData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create()
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $assessment = new Assessment();

        $models = [
            'assessment' => $assessment,
            'subjects' => (new SubjectRepository())->getAll(),
            'students' => (new StudentRepository())->getAll(),
        ];

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view($models);
        }

        $assessment->setStudentId(Input::post('student_id'));
        $assessment->setSubjectId(Input::post('subject_id'));
        $assessment->setAssessment(Input::post('assessment'));
        $assessment->setLectures(Input::post('lectures'));
        $assessment->setExercises(Input::post('exercises'));

        if (!$assessment->isValid()) {
            return $this->view($models);
        }

        $repo = new AssessmentRepository();


        /** @var Assessment[] $otherAssessments */
        $otherAssessments = $repo->getAll(1,0,[],[
            '=' => [
                'sa_student_id' => $assessment->getStudentId(),
                'sa_subject_id' => $assessment->getSubjectId()
            ]
        ]);

        if ($otherAssessments) {
            $assessment->setError('student_id', "Student already has an assessment ({$otherAssessments[0]->getAssessment()})");
            $models['assessment'] = $assessment;
            return $this->view($models);
        }

        $assessment->setId(0);
        $repo->save($assessment);

        return $this->redirectToAction('index', 'assessments');
    }

    public function edit($id)
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new AssessmentRepository();

        /** @var Assessment $assessment */
        $assessment = $repo->getById($id);

        if (!$assessment) {
            return $this->redirectToAction('index', 'assessments');
        }

        $models = [
            'assessment' => $assessment,
            'subjects' => (new SubjectRepository())->getAll(),
            'students' => (new StudentRepository())->getAll(),
        ];

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view($models);
        }

        $assessment->setStudentId(Input::post('student_id'));
        $assessment->setSubjectId(Input::post('subject_id'));
        $assessment->setAssessment(Input::post('assessment'));
        $assessment->setLectures(Input::post('lectures'));
        $assessment->setExercises(Input::post('exercises'));

        if (!$assessment->isValid()) {
            return $this->view($models);
        }

        $repo->save($assessment);

        return $this->redirectToAction('index', 'assessments');
    }

    public function delete($id)
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new AssessmentRepository();

        /** @var Assessment $assessment */
        $assessment = $repo->getById($id);

        if (!$assessment) {
            return $this->redirectToAction('index', 'assessments');
        }

        $repo->delete($assessment);

        return $this->redirectToAction('index', 'assessments');
    }
}