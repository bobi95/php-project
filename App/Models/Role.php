<?php namespace App\Models;

class Role extends BaseModel {
    private $name;
    private $key;

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = (string)$name;
    }

    public function getKey() {
        return $this->key;
    }

    public function setKey($key) {
        $this->key = (string)$key;
    }

    protected function validate() {

        if(empty($this->name)) {
            $this->setError('name', 'Name is required.');
        } else {
            $this->setError('name', NULL);
        }

        if(empty($this->key)) {
            $this->setError('key', 'Key is required.');
        } else {
            $this->setError('key', NULL);
        }
    }
}