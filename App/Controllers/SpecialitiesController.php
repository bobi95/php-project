<?php namespace App\Controllers;


use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\SpecialityRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Speciality;
use App\Services\AuthenticationService;

class SpecialitiesController extends Controller {

    public function index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listspecialties() {

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
        $specialtiesData = [];

        $specialtyRepo = new SpecialityRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $specialties = $specialtyRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var Speciality $specialty */
        foreach ($specialties as $specialty)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'specialties', ['id' => $specialty->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'specialties', ['id' => $specialty->getId()]) . '">Изтриване</а>';

            // Group data
            $specialtiesData[] = [
                'id'          => $specialty->getId(),
                'name'	      => $specialty->getName(),
                'short_name'  => $specialty->getShortName(),
                'options'     => $options
            ];
        }

        $count = $specialtyRepo->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> $count,
            'data'				=> $specialtiesData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['specialty' => new Speciality()]);
        }

        $model = new Speciality();
        self::bindSpecialties($model);

        if (!$model->isValid()) {
            return $this->view(['specialty' => $model]);
        }

        $repo = new SpecialityRepository();

        $repo->save($model);

        return $this->redirectToAction('index', 'specialties');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new SpecialityRepository();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            $model = $repo->getById($id);

            if (!$model) {
                return $this->redirectToAction('index', 'specialties');
            }

            return $this->view(['specialty' => $model]);
        }

        $model = new Speciality();
        self::bindSpecialties($model);

        if (!$model->isValid()) {
            return $this->view(['specialty' => $model]);
        }

        $specialty = $repo->getById($model->getId());

        if (!$specialty) {
            return $this->redirectToAction('index', 'specialties');
        }

        $repo->save($model);

        return $this->redirectToAction('index', 'specialties');
    }

    public function delete($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new SpecialityRepository();

        /** @var Speciality $specialty */
        $specialty = $repo->getById($id);

        if (!$specialty) {
            return $this->redirectToAction('index', 'specialties');
        }

        $repo->delete($specialty);

        return $this->redirectToAction('index', 'specialties');
    }

    private static function bindSpecialties(Speciality $entity) {
        $entity->setId(Input::post('id'));
        $entity->setName(Input::post('name'));
        $entity->setShortName(Input::post('short_name'));
    }
}