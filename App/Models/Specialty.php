<?php namespace App\Models;

class Specialty extends BaseModel {

    private $name;
    private $short_name;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = (string)$name;
    }

    public function getShortName() {
        return $this->short_name;
    }

    public function setShortName($short_name) {
        $this->short_name = (string)$short_name;
    }

    protected function validate() {

        if(empty($this->name)) {
            $this->setError('name', 'Name is required.');
        } else {
            $this->setError('name', NULL);
        }

        if(empty($this->short_name)) {
            $this->setError('short_name', 'Short name is required.');
        } else {
            $this->setError('short_name', NULL);
        }
    }
}