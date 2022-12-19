<?php

    $f3->route('GET /data-mentah', 'Homepage->dataMentah');
    $f3->route('GET /data-matang', 'Homepage->dataMatang');
    $routeGroup = array('Homepage');

    foreach($routeGroup as $group){
        foreach (glob("route/".$group."_r.php") as $filename) {
            require $filename;
        }
    }

    ?>