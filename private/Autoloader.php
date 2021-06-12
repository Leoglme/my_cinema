<?php

// Class Autoloader
class Autoloader
{
    public static function __autoload(array $classname)
    {
        for ($i = 0; $i < count($classname); $i++) {
            require('' . __DIR__ . '/' . $classname[$i] . '.php');
        }
    }
}