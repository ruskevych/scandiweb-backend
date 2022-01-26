<?php


function autoload($class_name) 
{

    $parts = explode('\\', $class_name);
    $path = sprintf("Factory/%s.php", end($parts));

    if( file_exists($path) ){
        require_once $path;
    }
    else{
        $path = sprintf("Helpers/%s.php", end($parts));
        require_once $path;
    }

}

spl_autoload_register('autoload');