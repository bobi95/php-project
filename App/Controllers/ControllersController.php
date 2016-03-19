<?php namespace App\Controllers;

use App\Core\Controller as BaseController;
use App\Core\HttpContext;
use App\DataAccess\ControllerRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Controller;
use App\Services\AuthenticationService;

class ControllersController extends BaseController {

    public function index() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listcontrollers()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $controllerData = [];

        $controllerRepository = new ControllerRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $controllers = $controllerRepository->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var Controller $controller */
        foreach ($controllers as $controller)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'controllers', ['id' => $controller->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'controllers', ['id' => $controller->getId()]) . '">Изтриване</а>';

            // Group data
            $controllerData[] = [
                'id'          => $controller->getId(),
                'name'	      => $controller->getName(),
                'options'     => $options,
            ];
        }

        $count = $controllerRepository->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> $count,
            'data'				=> $controllerData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['controller' => new Controller()]);
        }

        $model = new Controller();
        self::bindController($model);

        if (!$model->isValid()) {
            return $this->view(['controller' => $model]);
        }

        $repo = new ControllerRepository();

        $repo->save($model);

        return $this->redirectToAction('index', 'controllers');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new ControllerRepository();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            $model = $repo->getById($id);

            if (!$model) {
                return $this->redirectToAction('index', 'controllers');
            }

            return $this->view(['controller' => $model]);
        }

        $model = new Controller();
        self::bindController($model);

        if (!$model->isValid()) {
            return $this->view(['controller' => $model]);
        }

        $controller = $repo->getById($model->getId());

        if (!$controller) {
            return $this->redirectToAction('index', 'controllers');
        }

        $repo->save($model);

        return $this->redirectToAction('index', 'controllers');
    }

    public function delete($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new ControllerRepository();

        /** @var Controller $controller */
        $controller = $repo->getById($id);

        if (!$controller) {
            return $this->redirectToAction('index', 'controllers');
        }

        $repo->delete($controller);

        return $this->redirectToAction('index', 'controllers');
    }

    private static function bindController(Controller $controller) {
        $controller->setId(Input::post('id'));
        $controller->setName(Input::post('name'));
    }

}