<?php namespace App\Controllers;


use App\Core\Controller;
use App\Core\HttpContext;
use App\DataAccess\RoleRepository;
use App\Helpers\DataTablesParser;
use App\Helpers\Html;
use App\Helpers\Input;
use App\Models\Role;
use App\Services\AuthenticationService;

class RolesController extends Controller {

    public function index() {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        return $this->view();
    }

    public function listroles()
    {
        $data = new DataTablesParser($_POST);

        if (!$data->isValid())
        {
            echo json_encode(['error' => 'Invalid request!']);
            exit;
        }

        // Build response & send to data tables
        $rolesData = [];

        $rolesRepo = new RoleRepository();

        $filter = $data->hasFilter() ? ['like' => ['name' => '%' . $data->getFilter() . '%']] : [];

        $roles = $rolesRepo->getAll(
            $data->getLimit(),
            $data->getOffset(),
            $data->getOrders(),
            $filter
        );

        $htmlHelper = new Html();

        /** @var Role $role */
        foreach ($roles as $role)
        {
            // Options
            $options = '';
            $options .= '<a href="' . $htmlHelper->url('edit', 'users', ['id' => $role->getId()]) . '">Редактирай</а> ';
            $options .= '<a href="' . $htmlHelper->url('delete', 'users', ['id' => $role->getId()]) . '">Изтриване</а>';

            // Group data
            $rolesData[] = [
                'id'      => $role->getId(),
                'name'    => $role->getName(),
                'options' => $options,
            ];
        }

        $count = $rolesRepo->count();

        $response = [
            'draw'				=> $data->getRequestId(),
            'recordsTotal'		=> $count,
            'recordsFiltered'	=> count($roles),
            'data'				=> $rolesData,
        ];

        echo json_encode($response);
        exit;
    }

    public function create()
    {
        if (!AuthenticationService::isUserLogged()) {
            return $this->redirectToAction('login', 'account');
        }

        $role = new Role();

        if (HttpContext::instance()->requestMethod() === 'GET') {
            return $this->view(['role' => $role]);
        }

        $role->setName(Input::post('name'));

        if (!$role->isValid()) {
            return $this->view(['role' => $role]);
        }

        $repo = new RoleRepository();

        if ($repo->count(['like' => ['name' => $role->getName()]]))
        {
            $role->setError('name', 'Роля с такова име вече същестува!');
        }

        if (!empty($role->getAllErrors())) {
            return $this->view(['role' => $role]);
        }

        $role->setId(0);
        $repo->save($role);

        return $this->redirectToAction('index', 'roles');
    }
}