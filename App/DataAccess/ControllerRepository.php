<?php namespace App\DataAccess;

use App\Models\Controller;

class ControllerRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'controllers';
    }


    protected function mapEntity($entity) {
        $result = new Controller();
        $result->setId($entity->id);
        $result->setName($entity->name);
        return $result;
    }

    protected function getProperties() {
        return ['id', 'name'];
    }

    /**
     * @param Controller $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':id' => $entity->getId(),
            ':name' => $entity->getName()
        ];
    }
}