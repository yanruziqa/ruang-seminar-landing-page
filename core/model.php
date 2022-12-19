<?php

    $modelGroup = array('Webinar');

    foreach($modelGroup as $group){
        require 'model/'.$group.'_m.php';
    }

?>