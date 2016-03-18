<?php namespace App\Models;

/**
 * Contains members every model should have
 */
abstract class BaseModel {
    private $id;
    private $errors = [];

    public function getId() {
        return $this->id;
    }
    
    public function setId($id) {
        if(isset($id)) {
            $this->id = (int)$id;
        }
    }
    
    public function setError($propName, $error) {
        if (isset($error) && !empty($error)) {
            $this->errors[$propName] = $error;
        } else {
            unset($this->errors[$propName]);
        }
    }
    
    protected abstract function validate();
    
    public function getError($propName) {
        return isset($this->errors[$propName]) ?
            $this->errors[$propName] : '';
    }
    
    public function getAllErrors() {
        return $this->errors;
    }
    
    public function isValid() {
        $this->validate();
        return empty($this->errors);
    }
}
