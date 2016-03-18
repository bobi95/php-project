<?php namespace App\Core;

use \App\Interfaces\IMap;

class MapWrapper implements IMap {

    private $_collection;

    protected function __construct($collection) {
        $this->_collection = $collection;
    }

    public function get($key) {

        if(isset($this->_collection[$key])) {
            return $this->_collection[$key];
        }

        return null;
    }

    public function set($key, $value) {

        if(isset($value)) {
            $this->_collection[$key] = $value;
        }

    }

    public function exists($key) {
        return isset($this->_collection[$key]);
    }

    public function delete($key) {

        if(isset($this->_collection[$key])) {
            unset($this->_collection[$key]);
        }

    }
    
    protected function getCollection() {
        return $this->_collection;
    }
}