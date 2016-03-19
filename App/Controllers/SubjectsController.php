<?php namespace App\Controllers;


use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\SubjectRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Subject;
use App\Services\AuthenticationService;

class SubjectsController extends Controller {

    public function index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listsubjects()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $subjectsData = [];

        $subjectsRepo = new SubjectRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $subjects = $subjectsRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var Subject $subject */
        foreach ($subjects as $subject)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'subjects', ['id' => $subject->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'subjects', ['id' => $subject->getId()]) . '">Изтриване</а>';

            // Group data
            $subjectsData[] = [
                'id'      => $subject->getId(),
                'name'    => $subject->getName(),
                'lectures'    => $subject->getLectures(),
                'exercises'    => $subject->getExercises(),
                'options' => $options,
            ];
        }

        $count = $subjectsRepo->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> count($subjects),
            'data'				=> $subjectsData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create()
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $subject = new Subject();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['subject' => $subject]);
        }

        $subject->setName(Input::post('name'));
        $subject->setLectures(Input::post('lectures'));
        $subject->setExercises(Input::post('exercises'));

        if (!$subject->isValid()) {
            return $this->view(['subject' => $subject]);
        }

        $repo = new SubjectRepository();

        if ($repo->count(['like' => ['name' => $subject->getName()]]))
        {
            $subject->setError('name', 'Дисциплина с такова име вече същестува!');
        }

        if (!empty($subject->getAllErrors())) {
            return $this->view(['subject' => $subject]);
        }

        $subject->setId(0);
        $repo->save($subject);

        return $this->redirectToAction('index', 'subjects');
    }

    public function edit($id)
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new SubjectRepository();

        /** @var Subject $subject */
        $subject = $repo->getById($id);

        if (!$subject) {
            return $this->redirectToAction('index', 'subjects');
        }

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['subject' => $subject]);
        }

        $newName = Input::post('name');
           // Check for duplicates in the DB
        if ($newName != $subject->getName() && $repo->count(['like' => ['name' => $newName]]))
        {
            $subject->setError('name', 'Ролята вече съществува в базата!');
        }

        if (!empty($subject->getAllErrors())) {
            return $this->view(['subject' => $subject]);
        }

        $subject->setName(Input::post('name'));
        $subject->setLectures(Input::post('lectures'));
        $subject->setExercises(Input::post('exercises'));

        if (!$subject->isValid()) {
            return $this->view(['subject' => $subject]);
        }



        $repo->save($subject);

        return $this->redirectToAction('index', 'subjects');
    }

    public function delete($id)
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new SubjectRepository();

        /** @var Subject $subject */
        $subject = $repo->getById($id);

        if (!$subject) {
            return $this->redirectToAction('index', 'subjects');
        }

        $repo->delete($subject);

        return $this->redirectToAction('index', 'subjects');
    }
}