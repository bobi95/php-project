<?php namespace App\Models;

class Action extends BaseModel {

    private $controller_id;
    private $name;

    public function getControllerId() {
        return $this->controller_id;
    }

    public function getName() {
        return $this->name;
    }

    public function setControllerId($id) {
        $this->controller_id = (int)$id;
    }

    public function setName($action){
        $this->name = (string)$action;
    }

    protected function validate()
    {
        if(empty($this->controller_id)) {
            $this->setError('controller_id', 'Controller id is required.');
        } else {
            $this->setError('controller_id', NULL);
        }

        if(empty($this->name)) {
            $this->setError('name', 'Name is required.');
        } else {
            $this->setError('name', NULL);
        }
    }
}