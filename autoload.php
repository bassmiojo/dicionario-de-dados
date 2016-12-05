<?php

function __autoload($class_name)
{


    $class = WWW_ROOT . DS . str_replace('\\', DS, $class_name) . ".php";


  
    if ($class_name == 'App\Exception') {
        return false;
    }

    if (!file_exists($class)) {

        throw new Exception("Class não encontrada {$class} ");

        //require_once 'App/'.$class_name.".php";
    }

    require_once $class;


}