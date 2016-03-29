<?php namespace App\DataAccess;

use App\Models\Assessment;

class AssessmentRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'students_assessments';
    }

    protected function mapEntity($entity) {
        $result = new Assessment();
        $result->setId($entity->sa_id);
        $result->setStudentId($entity->sa_student_id);
        $result->setSubjectId($entity->sa_subject_id);
        $result->setAssessment($entity->sa_assessment);
        $result->setLectures($entity->sa_workload_lectures);
        $result->setExercises($entity->sa_workload_exercises);
        return $result;
    }

    protected function getProperties() {
        return ['sa_id', 'sa_student_id', 'sa_subject_id', 'sa_assessment', 'sa_workload_lectures', 'sa_workload_exercises'];
    }


    /**
     * @param Assessment $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':sa_id' => $entity->getId(),
            ':sa_student_id' => $entity->getStudentId(),
            ':sa_subject_id' => $entity->getSubjectId(),
            ':sa_assessment' => $entity->getAssessment(),
            ':sa_workload_lectures' => $entity->getLectures(),
            ':sa_workload_exercises' => $entity->getExercises()
        ];
    }
}