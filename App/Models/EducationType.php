<?php namespace App\Models;

class EducationType extends BaseModel {

    private $name;
    private $number;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = (string)$name;
    }

    public function getNumber() {
        return $this->number;
    }

    public function setNumber($number) {
        $this->number = (string)$number;
    }

    protected function validate() {

        if(empty($this->name)) {
            $this->setError('name', 'Name is required.');
        } else {
            $this->setError('name', NULL);
        }

        if(empty($this->number)) {
            $this->setError('number', 'Number is required.');
        } else {
            $this->setError('number', NULL);
        }
    }
}