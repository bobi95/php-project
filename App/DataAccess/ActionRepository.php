<?php namespace App\DataAccess;

use App\Models\Action;
use App\Models\Role;

class ActionRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'actions';
    }

    protected function mapEntity($entity) {
        $result = new Action();
        $result->setId($entity->id);
        $result->setControllerId($entity->controller_id);
        $result->setName($entity->name);
        return $result;
    }

    protected function getProperties() {
        return ['id','controller_id', 'name'];
    }

    /**
     * @param Action $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':id' => $entity->getId(),
            ':controller_id' => $entity->getControllerId(),
            ':name' => $entity->getName()
        ];
    }

    /**
     * @param Action $action
     * @param Role[] $roles
     */
    public function setActionsToRole(Action $action, $roles) {
        ManyToManyRepository::setCollectionToTarget('roles_actions', $action, $roles, 'action_id', 'role_id');
    }
}