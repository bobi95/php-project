<?php namespace App\DataAccess;

use App\Models\Assessment;

class AssessmentRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'assessments';
    }

    protected function mapEntity($entity) {
        $result = new Assessment();
        $result->setId($entity->id);
        $result->setStudentId($entity->student_id);
        $result->setSubjectId($entity->subject_id);
        $result->setGrade($entity->grade);
        $result->setLectures($entity->lectures);
        $result->setExercises($entity->exercises);
        return $result;
    }

    protected function getProperties() {
        return ['id', 'student_id', 'subject_id', 'grade', 'lectures', 'exercises'];
    }


    /**
     * @param Assessment $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':id' => $entity->getId(),
            ':student_id' => $entity->getStudentId(),
            ':subject_id' => $entity->getSubjectId(),
            ':grade' => $entity->getGrade(),
            ':lectures' => $entity->getLectures(),
            ':exercises' => $entity->getExercises()
        ];
    }
}