<?php namespace App\Models;

class Subject extends BaseModel {

    private $name;
    private $lectures;
    private $exercises;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = (string)$name;
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

        if(empty($this->name)) {
            $this->setError('name', 'Name is required.');
        } else {
            $this->setError('name', NULL);
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