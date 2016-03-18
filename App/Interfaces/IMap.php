<?php namespace App\Interfaces;

interface IMap {
    function get($key);
    function set($key, $value);
    function exists($key);
    function delete($key);
}