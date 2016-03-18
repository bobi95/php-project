<?php
use App\Helpers\Config;

spl_autoload_register(function ($class)
{
    $dir = Config::get('server.dir', '/');

    $fileName = $dir . $class . '.php';

    if(fileExists($fileName)) {
        require_once $fileName;
    }
});