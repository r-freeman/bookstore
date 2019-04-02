<?php

function autoload($className)
{
    $file = 'classes/' . $className . '.php';
    if (file_exists($file)) {
        require $file;
    }
}

spl_autoload_register('autoload');