<?php namespace App\DataAccess;

use App\Models\Subject;

class SubjectRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'subjects';
    }

    protected function mapEntity($entity) {
        $result = new Subject();
        $result->setId($entity->id);
        $result->setName($entity->name);
        $result->setLectures($entity->lectures);
        $result->setExercises($entity->exercises);
        return $result;
    }

    protected function getProperties() {
        return ['id', 'name', 'lectures', 'exercises'];
    }


    /**
     * @param Subject $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':name' => $entity->getName(),
            ':lectures' => $entity->getLectures(),
            ':exercises' => $entity->getExercises()
        ];
    }

    public function setSpecialtiesToSubject(Subject $subject, $specialties) {
        ManyToManyRepository::setCollectionToTarget('specialties_subjects', $subject, $specialties, 'subject_id', 'specialties_id');
    }
}