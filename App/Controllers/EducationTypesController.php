<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\RoleRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Hash;
use App\Helpers\Html;
use App\Models\EducationType;
use App\Helpers\Input;
use App\DataAccess\EducationTypeRepository;
use App\Helpers\Session;
use App\Services\AuthenticationService;
use App\Services\PagingService;

class EducationTypesController extends Controller {
    public function index() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listeducationTypes()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $educationTypesData = [];

        $educationTypeRepo = new EducationTypeRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $educationTypes = $educationTypeRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var EducationType $educationType */
        foreach ($educationTypes as $educationType)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'educationTypes', ['id' => $educationType->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'educationTypes', ['id' => $educationType->getId()]) . '">Изтриване</а>';

            // Group data
            $educationTypesData[] = [
                'id'          => $educationType->getId(),
                'name'	      => $educationType->getName(), 
                'number'      => $educationType->getNumber(), 
                'options'     => $options,
            ];
        }

        $count = $educationTypeRepo->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> $count,
            'data'				=> $educationTypesData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['educationType' => new EducationType()]);
        }

        $model = new EducationType();
        self::bindEducationType($model);

        if (!$model->isValid()) {
            return $this->view(['educationType' => $model]);
        }

        $repo = new EducationTypeRepository();

        $repo->save($model);

        return $this->redirectToAction('index', 'educationTypes');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new EducationTypeRepository();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            $model = $repo->getById($id);

            if (!$model) {
                return $this->redirectToAction('index', 'educationTypes');
            }

            return $this->view(['educationType' => $model]);
        }

        $model = new EducationType();
        self::bindEducationType($model);

        if (!$model->isValid()) {
            return $this->view(['educationType' => $model]);
        }

        $educationType = $repo->getById($model->getId());

        if (!$educationType) {
            return $this->redirectToAction('index', 'educationTypes');
        }

        $repo->save($model);

        return $this->redirectToAction('index', 'educationTypes');
    }

    public function delete($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new EducationTypeRepository();

        /** @var EducationType $educationType */
        $educationType = $repo->getById($id);

        if (!$educationType) {
            return $this->redirectToAction('index', 'educationTypes');
        }

        $repo->delete($educationType);

        return $this->redirectToAction('index', 'educationTypes');
    }

    private static function bindEducationType(EducationType $type) {
        $type->setId(Input::post('id'));
        $type->setName(Input::post('name'));
        $type->setNumber(Input::post('number'));
    }
}