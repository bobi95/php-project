<?php namespace App\Controllers;

use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\ActionRepository;
use App\DataAccess\ControllerRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Action;
use App\Services\AuthenticationService;

class ActionsController extends Controller {

    public function index() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listactions()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $actionData = [];

        $actionRepository = new ActionRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $actions = $actionRepository->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var Action $action */
        foreach ($actions as $action)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'actions', ['id' => $action->getId()]) . '">Редактирай</а> ';
            $options .= '<a class="delete-button" href="javascript:void(0);" data-href="' . $htmlHelper->url('delete', 'actions', ['id' => $action->getId()]) . '">Изтриване</а>';

            // Group data
            $actionData[] = [
                'id'          => $action->getId(),
                'name'	      => $action->getName(),
                'controller_id' => $action->getController()->getName(),
                'options'     => $options,
            ];
        }

        $count = $actionRepository->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> $count,
            'data'				=> $actionData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create() {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $controllers = (new ControllerRepository())->getAll();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['action' => new Action(), 'controllers' => $controllers]);
        }

        $model = new Action();
        self::bindAction($model);

        if (!$model->isValid()) {
            return $this->view(['action' => $model, 'controllers' => $controllers]);
        }

        $repo = new ActionRepository();

        $repo->save($model);

        return $this->redirectToAction('index', 'actions');
    }

    public function edit($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $controllers = (new ControllerRepository())->getAll();
        $repo = new ActionRepository();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            $model = $repo->getById($id);

            if (!$model) {
                return $this->redirectToAction('index', 'actions');
            }

            return $this->view(['action' => $model, 'controllers' => $controllers]);
        }

        $model = new Action();
        self::bindAction($model);

        if (!$model->isValid()) {
            return $this->view(['action' => $model, 'controllers' => $controllers]);
        }

        $action = $repo->getById($model->getId());

        if (!$action) {
            return $this->redirectToAction('index', 'actions');
        }

        $repo->save($model);

        return $this->redirectToAction('index', 'actions');
    }

    public function delete($id) {

        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $repo = new ActionRepository();

        /** @var Action $action */
        $action = $repo->getById($id);

        if (!$action) {
            return $this->redirectToAction('index', 'actions');
        }

        $repo->delete($action);

        return $this->redirectToAction('index', 'actions');
    }

    private static function bindAction(Action $action) {
        $action->setId(Input::post('id'));
        $action->setName(Input::post('name'));
        $action->setControllerId(Input::post('controller_id'));
    }

}