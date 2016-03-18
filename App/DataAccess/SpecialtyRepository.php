<?php namespace App\DataAccess;

use App\Models\Specialty;

class SpecialtyRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'specialties';
    }


    protected function mapEntity($entity) {
        $result = new Specialty();
        $result->setId($entity->id);
        $result->setName($entity->name);
        $result->setShortName($entity->short_name);
        return $result;
    }

    protected function getProperties() {
        return ['id', 'name', 'short_name'];
    }

    /**
     * @param Specialty $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':name' => $entity->getName(),
            ':short_name' => $entity->getShortName()
        ];
    }

    public function setSubjectsToSpecialty(Specialty $specialty, $subjects) {
        ManyToManyRepository::setCollectionToTarget('specialties_subjects', $specialty, $subjects, 'specialties_id', 'subject_id');
    }
}