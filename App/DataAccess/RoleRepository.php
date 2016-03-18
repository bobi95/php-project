<?php namespace App\DataAccess;

use App\Core\MapWrapper;
use App\Helpers\ArrayWrapper;
use App\Models\Action;
use App\Models\Role;

class RoleRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'roles';
    }


    protected function mapEntity($entity) {
        $result = new Role();
        $result->setId($entity->id);
        $result->setName($entity->name);
        return $result;
    }

    protected function getProperties() {
        return ['id', 'name'];
    }

    /**
     * @param Role $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':id' => $entity->getId(),
            ':name' => $entity->getName()
        ];
    }

    /**
     * @param Role $role
     * @param Action[] $actions
     */
    public function setActionsToRole(Role $role, $actions) {
        ManyToManyRepository::setCollectionToTarget('roles_actions', $role, $actions, 'role_id', 'action_id');
    }

    public function setUsersToRole(Role $role, $users) {
        ManyToManyRepository::setCollectionToTarget('users_roles', $role, $users, 'role_id', 'user_id');
    }
}