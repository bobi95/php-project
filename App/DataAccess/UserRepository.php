<?php namespace App\DataAccess;

use App\Models\User;

class UserRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'users';
        $this->_idColumn = 'user_id';
    }

    protected function mapEntity($entity) {
        $result = new User();
        $result->setId($entity->user_id);
        $result->setUsername($entity->user_name);
        $result->setFirstName($entity->user_fname);
        $result->setLastName($entity->user_lname);
        $result->setEmail($entity->user_email);
        $result->setPassword($entity->user_password);

        return $result;
    }

    protected function getProperties() {
        return [
            'user_id',
            'user_name',
            'user_fname',
            'user_lname',
            'user_email',
            'user_password'
        ];
    }

    /**
     * @param User $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':user_id' => $entity->getId(),
            ':user_name' => $entity->getUsername(),
            ':user_fname' => $entity->getFirstName(),
            ':user_lname' => $entity->getLastName(),
            ':user_email' => $entity->getEmail(),
            ':user_password' => $entity->getPassword()
        ];
    }

    public function setRolesToUser(User $user, $roles) {
        ManyToManyRepository::setCollectionToTarget('roles_users', $user, $roles, 'ru_user_id', 'ru_role_id');
    }

    public function getUserByUsername($username) {
        $entity = $this->_db->query('SELECT * FROM `users` WHERE LOWER(user_name) = LOWER(:user_name) LIMIT 1', [
            ':user_name' => $username
        ]);

        if ($entity) {
            return $this->mapEntity($entity);
        }

        return NULL;
    }

    public function getUserByEmail($email) {
        $entity = $this->_db->query('SELECT * FROM `users` WHERE LOWER(user_email) = LOWER(:user_email) LIMIT 1', [
            ':user_email' => $email
        ]);

        if ($entity) {
            return $this->mapEntity($entity);
        }

        return null;
    }
}