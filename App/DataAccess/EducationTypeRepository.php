<?php namespace App\DataAccess;

use App\Models\EducationType;

class EducationTypeRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'education_types';
    }


    protected function mapEntity($entity) {
        $result = new EducationType();
        $result->setId($entity->id);
        $result->setName($entity->name);
        $result->setNumber($entity->number);
        return $result;
    }

    protected function getProperties() {
        return ['id', 'name', 'number'];
    }

    /**
     * @param EducationType $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':id' => $entity->getId(),
            ':name' => $entity->getName(),
            ':number' => $entity->getNumber()
        ];
    }
}