<?php namespace App\DataAccess;

use App\Models\Student;

class StudentRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'students';
        $this->_idColumn = 'student_id';
    }


    protected function mapEntity($entity) {
        $result = new Student();
        $result->setId($entity->student_id);
        $result->setCourseId($entity->student_course_id);
        $result->setSpecialityId($entity->student_speciality_id);
        $result->setFirstName($entity->student_fname);
        $result->setLastName($entity->student_lname);
        $result->setEmail($entity->student_email);
        $result->setEducationForm($entity->student_education_form);
        $result->setFacultyNumber($entity->student_fnumber);
        return $result;
    }

    protected function getProperties() {
        return [
            'student_id',
            'student_course_id',
            'student_speciality_id',
            'student_fname',
            'student_lname',
            'student_email',
            'student_education_form',
            'student_fnumber'
        ];
    }

    /**
     * @param Student $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':student_id' => $entity->getId(),
            ':student_course_id' => $entity->getCourseId(),
            ':student_speciality_id' => $entity->getSpecialityId(),
            ':student_fname' => $entity->getFirstName(),
            ':student_lname' => $entity->getLastName(),
            ':student_email' => $entity->getEmail(),
            ':student_education_form' => $entity->getEducationForm(),
            ':student_fnumber' => $entity->getFacultyNumber()
        ];
    }
}