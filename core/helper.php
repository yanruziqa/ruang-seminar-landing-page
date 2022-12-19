<?php

    $controllerGroup = array('View');

    foreach($controllerGroup as $group){
        require 'helper/'.$group.'_h.php';
    }

?>