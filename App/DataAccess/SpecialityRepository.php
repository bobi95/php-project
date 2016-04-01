<?php namespace App\DataAccess;

use App\Models\Speciality;

class SpecialityRepository extends BaseRepository {

    public function __construct() {
        parent::__construct();
        $this->_tableName = 'specialities';
        $this->_idColumn = 'speciality_id';
    }


    protected function mapEntity($entity) {
        $result = new Speciality();
        $result->setId($entity->speciality_id);
        $result->setName($entity->speciality_name_long);
        $result->setShortName($entity->speciality_name_short);
        return $result;
    }

    protected function getProperties() {
        return ['speciality_id', 'speciality_name_long', 'speciality_name_short'];
    }

    /**
     * @param Speciality $entity
     * @return array
     */
    protected function getKeyValues($entity) {
        return [
            ':speciality_id' => $entity->getId(),
            ':speciality_name_long' => $entity->getName(),
            ':speciality_name_short' => $entity->getShortName()
        ];
    }

    public function setSubjectsToSpeciality(Speciality $speciality, $subjects) {
        ManyToManyRepository::setCollectionToTarget('specialities_subjects', $speciality, $subjects, 'specialities_id', 'subject_id');
    }
}