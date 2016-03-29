<?php namespace App\Models;

class Student extends BaseModel{

    private $course_id;
    private $speciality_id;
    private $firstName;
    private $lastName;
    private $email;
    private $education_form;
    private $faculty_number;

    public function getCourseId() {
        return $this->course_id;
    }

    public function setCourseId($course_id) {
        $this->course_id = (int)$course_id;
    }

    public function getSpecialityId() {
        return $this->speciality_id;
    }

    public function setSpecialityId($speciality_id) {
        $this->speciality_id = (int)$speciality_id;
    }

    public function getEducationForm() {
        return $this->education_form;
    }

    public function setEducationForm($education_form) {
        $this->education_form = $education_form;
    }

    public function getFacultyNumber() {
        return $this->faculty_number;
    }

    public function setFacultyNumber($faculty_number) {
        $this->faculty_number = (string)$faculty_number;
    }

    /**
     * @return string
     */
    public function getFirstName() {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName() {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email) {
        $this->email = $email;
    }

    protected function validate() {

        if(empty($this->course_id)) {
            $this->setError('course_id', 'Course id is required.');
        } else {
            $this->setError('course_id', NULL);
        }

        if(empty($this->speciality_id)) {
            $this->setError('speciality_id', 'Speciality id is required.');
        } else {
            $this->setError('speciality_id', NULL);
        }

        if(empty($this->education_form)) {
            $this->setError('education_form', 'Education form is required.');
        } else {
            $this->setError('education_form', NULL);
        }

        if(empty($this->faculty_number)) {
            $this->setError('faculty_number', 'Faculty number is required.');
        } else {
            $this->setError('faculty_number', NULL);
        }
    }
}