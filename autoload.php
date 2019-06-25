<?php

    spl_autoload_register(function ($class_name) {

        $class_name = str_replace('\\','/',$class_name);
        if(stripos($class_name,'iHexiang/Requests') === 0){

            $class_path = __DIR__.'/src/' . str_replace('iHexiang/Requests/','',$class_name) . '.php';
            if(file_exists($class_path)){
                require_once $class_path;
            }
        }
    });
