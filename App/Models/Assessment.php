<?php namespace App\Models;

class Assessment extends BaseModel {

    private $student_id;
    private $subject_id;
    private $grade;
    private $lectures;
    private $exercises;

    public function getStudentId() {
        return $this->student_id;
    }

    public function setStudentId($student_id) {
        $this->student_id = (int)$student_id;
    }

    public function getSubjectId() {
        return $this->subject_id;
    }

    public function setSubjectId($subject_id) {
        $this->subject_id = (int)$subject_id;
    }

    public function getGrade() {
        return $this->grade;
    }

    public function setGrade($grade) {
        $this->grade = (double)$grade;
    }

    public function getLectures() {
        return $this->lectures;
    }

    public function setLectures($lectures) {
        $this->lectures = (int)$lectures;
    }

    public function getExercises() {
        return $this->exercises;
    }

    public function setExercises($exercises) {
        $this->exercises = (int)$exercises;
    }

    protected function validate() {
        if(empty($this->student_id)) {
            $this->setError('student_id', 'Student id is required.');
        } else {
            $this->setError('student_id', NULL);
        }

        if(empty($this->subject_id)) {
            $this->setError('subject_id', 'Subject id is required.');
        } else {
            $this->setError('subject_id', NULL);
        }

        if(empty($this->grade)) {
            $this->setError('grade', 'Grade is required.');
        } else {
            $this->setError('grade', NULL);
        }

        if(empty($this->lectures)) {
            $this->setError('lectures', 'Lectures is required.');
        } else {
            $this->setError('lectures', NULL);
        }

        if(empty($this->exercises)) {
            $this->setError('exercises', 'Exercises is required.');
        } else {
            $this->setError('exercises', NULL);
        }
    }
}