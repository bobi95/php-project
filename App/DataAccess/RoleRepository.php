<?php namespace App\DataAccess;

use App\Core\MapWrapper;
use App\Helpers\ArrayWrapper;
use App\Models\Action;
use App\Models\Role;
use App\Models\User;

class RoleRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'roles';
    }


    protected function mapEntity($entity) {
        $result = new Role();
        $result->setId($entity->role_id);
        $result->setName($entity->role_name);
        $result->setKey($entity->role_key);
        return $result;
    }

    protected function getProperties() {
        return ['role_id', 'role_name', 'role_key'];
    }

    /**
     * @param Role $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':role_id' => $entity->getId(),
            ':role_name' => $entity->getName(),
            ':role_key' => $entity->getKey()
        ];
    }

    public function setUsersToRole(Role $role, $users) {
        ManyToManyRepository::setCollectionToTarget('users_roles', $role, $users, 'ru_role_id', 'ru_user_id');
    }

    /**
     * @param User $user
     * @return array
     */
    public function getRolesForUser(User $user) {
        $entities = ManyToManyRepository::getAllFromOne('roles', $user->getId(), 'role_id', 'roles_users', 'ru_role_id', 'ru_user_id');
        $result = [];

        if(!empty($entities)) {
            foreach ($entities as $entity) {
                $result[] = $this->mapEntity($entity);
            }
        }

        return $result;
    }
}