<?php

    class Controller{
        protected $controllerName;
    }

    $controllerGroup = array('Homepage');

    foreach (glob("core/controller/*.php") as $filename) {
        require $filename;
    }

    foreach($controllerGroup as $group){
        foreach (glob("controller/".$group."/*.php") as $filename) {
            require $filename;
        }
    }

?>