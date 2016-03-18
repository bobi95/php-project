<?php namespace App\DataAccess;

use App\Models\Course;

class CourseRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'courses';
    }


    protected function mapEntity($entity) {
        $result = new Course();
        $result->setId($entity->id);
        $result->setName($entity->name);
        return $result;
    }

    protected function getProperties() {
        return ['id', 'name'];
    }

    /**
     * @param Course $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':id' => $entity->getId(),
            ':name' => $entity->getName()
        ];
    }
}