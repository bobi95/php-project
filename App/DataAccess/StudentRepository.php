<?php namespace App\DataAccess;

use App\Models\Student;

class StudentRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'students';
    }


    protected function mapEntity($entity) {
        $result = new Student();
        $result->setId($entity->id);
        $result->setCourseId($entity->course_id);
        $result->setSpecialtyId($entity->specialty_id);
        $result->setEducationTypeId($entity->education_type_id);
        $result->setFacultyNumber($entity->faculty_number);
        return $result;
    }

    protected function getProperties() {
        return [
            'id',
            'course_id',
            'specialty_id',
            'education_type_id',
            'faculty_number'
        ];
    }

    /**
     * @param Student $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            'course_id' => $entity->getCourseId(),
            'specialty_id' => $entity->getSpecialtyId(),
            'education_type_id' => $entity->getEducationTypeId(),
            'faculty_number' => $entity->getFacultyNumber()
        ];
    }
}