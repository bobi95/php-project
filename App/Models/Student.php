<?php namespace App\Models;

class Student extends BaseModel{

    private $course_id;
    private $specialty_id;
    private $education_type_id;
    private $faculty_number;

    public function getCourseId() {
        return $this->course_id;
    }

    public function setCourseId($course_id) {
        $this->course_id = (int)$course_id;
    }

    public function getSpecialtyId() {
        return $this->specialty_id;
    }

    public function setSpecialtyId($specialty_id) {
        $this->specialty_id = (int)$specialty_id;
    }

    public function getEducationTypeId() {
        return $this->education_type_id;
    }

    public function setEducationTypeId($education_type_id) {
        $this->education_type_id = (int)$education_type_id;
    }

    public function getFacultyNumber() {
        return $this->faculty_number;
    }

    public function setFacultyNumber($faculty_number) {
        $this->faculty_number = (string)$faculty_number;
    }

    protected function validate() {

        if(empty($this->course_id)) {
            $this->setError('course_id', 'Course id is required.');
        } else {
            $this->setError('course_id', NULL);
        }

        if(empty($this->specialty_id)) {
            $this->setError('specialty_id', 'Specialty id is required.');
        } else {
            $this->setError('specialty_id', NULL);
        }

        if(empty($this->education_type_id)) {
            $this->setError('education_type_id', 'Education type id is required.');
        } else {
            $this->setError('education_type_id', NULL);
        }

        if(empty($this->faculty_number)) {
            $this->setError('faculty_number', 'Faculty number is required.');
        } else {
            $this->setError('faculty_number', NULL);
        }
    }
}