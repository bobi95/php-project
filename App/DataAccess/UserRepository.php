<?php namespace App\DataAccess;

use App\Models\User;

class UserRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'users';
    }

    protected function mapEntity($entity) {
        $result = new User();
        $result->setId($entity->id);
        $result->setUsername($entity->username);
        $result->setFirstName($entity->first_name);
        $result->setLastName($entity->last_name);
        $result->setEmail($entity->email);
        $result->setPassword($entity->password);
        $result->setRoleId($entity->role_id);

        return $result;
    }

    protected function getProperties() {
        return [
            'id',
            'username',
            'first_name',
            'last_name',
            'email',
            'password',
            'role_id'
        ];
    }

    /**
     * @param User $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':id' => $entity->getId(),
            ':username' => $entity->getUsername(),
            ':first_name' => $entity->getFirstName(),
            ':last_name' => $entity->getLastName(),
            ':email' => $entity->getEmail(),
            ':password' => $entity->getPassword(),
            ':role_id' => $entity->getRoleId()
        ];
    }

    public function setRolesToUser(User $user, $roles) {
        ManyToManyRepository::setCollectionToTarget('users_roles', $user, $roles, 'user_id', 'role_id');
    }

    public function getUserByUsername($username) {
        $entity = $this->_db->query('SELECT * FROM `users` WHERE LOWER(username) = LOWER(:username) LIMIT 1', [
            ':username' => $username
        ]);

        if ($entity) {
            return $this->mapEntity($entity);
        }

        return NULL;
    }

    public function getUserByEmail($email) {
        $entity = $this->_db->query('SELECT * FROM `users` WHERE LOWER(email) = LOWER(:email) LIMIT 1', [
            ':email' => $email
        ]);

        if ($entity) {
            return $this->mapEntity($entity);
        }

        return null;
    }
}