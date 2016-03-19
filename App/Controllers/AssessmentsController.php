<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\AssessmentsRepository;
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

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $assessments = $assessmentsRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var Role $role */
        foreach ($assessments as $assessment)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'assessments', ['id' => $assessment->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'assessments', ['id' => $assessment->getId()]) . '">Изтриване</а>';

            // Group data
            $assessmentsData[] = [
                'id'      => $assessment->getId(),
                'name'    => $assessment->getName(),
                'options' => $options,
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

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['assessment' => $assessment]);
        }

        $assessment->setName(Input::post('name'));

        if (!$assessment->isValid()) {
            return $this->view(['assessment' => $assessment]);
        }

        $repo = new AssessmentRepository();

        if ($repo->count(['like' => ['name' => $assessment->getName()]]))
        {
            $assessment->setError('name', 'Оценката вече същестува!');
        }

        if (!empty($assessment->getAllErrors())) {
            return $this->view(['assessment' => $assessment]);
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

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['assessment' => $assessment]);
        }

        $newName = Input::post('name');

        $assessment->setName(Input::post('name'));

        if (!$assessment->isValid()) {
            return $this->view(['assessment' => $assessment]);
        }

        // Check for duplicates in the DB
        if ($newName != $assessment->getName() && $repo->count(['like' => ['name' => $newName]]))
        {
            $assessment->setError('name', 'Оценката вече съществува в базата!');
        }

        if (!empty($assessment->getAllErrors())) {
            return $this->view(['assessment' => $assessment]);
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