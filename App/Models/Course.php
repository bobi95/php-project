<?php namespace App\Models;

class Course extends BaseModel {

    private $name;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = (string)$name;
    }
    protected function validate() {

        if(empty($this->name)) {
            $this->setError('name', 'Name is required.');
        } else {
            $this->setError('name', NULL);
        }
    }
}