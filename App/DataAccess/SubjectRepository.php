<?php namespace App\DataAccess;

use App\Models\Subject;

class SubjectRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'subjects';
    }

    protected function mapEntity($entity) {
        $result = new Subject();
        $result->setId($entity->subject_id);
        $result->setName($entity->subject_name);
        $result->setLectures($entity->subject_workload_lectures);
        $result->setExercises($entity->subject_workload_exercises);
        return $result;
    }

    protected function getProperties() {
        return ['subject_id', 'subject_name', 'subject_workload_lectures', 'subject_workload_exercises'];
    }


    /**
     * @param Subject $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':subject_id' => $entity->getId(),
            ':subject_name' => $entity->getName(),
            ':subject_workload_lectures' => $entity->getLectures(),
            ':subject_workload_exercises' => $entity->getExercises()
        ];
    }

    public function setSpecialtiesToSubject(Subject $subject, $specialities) {
        ManyToManyRepository::setCollectionToTarget('specialities_subjects', $subject, $specialities, 'subject_id', 'specialities_id');
    }
}