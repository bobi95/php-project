<?php namespace App\DataAccess;

use App\Models\Course;

class CourseRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'courses';
        $this->_idColumn = 'course_id';
    }


    protected function mapEntity($entity) {
        $result = new Course();
        $result->setId($entity->course_id);
        $result->setName($entity->course_name);
        return $result;
    }

    protected function getProperties() {
        return ['course_id', 'course_name'];
    }

    /**
     * @param Course $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':course_id' => $entity->getId(),
            ':course_name' => $entity->getName()
        ];
    }
}