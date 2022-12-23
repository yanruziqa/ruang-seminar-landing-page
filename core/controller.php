<?php

    class Controller {
        protected $controllerName;

        protected function get_view($f3, $components){
            $controllerName = $this->controllerName;

            $baseViewFolder = "/view/".$controllerName.'/';
            $baseComponentFolder = $baseViewFolder."components/";
            $baseResFolder = $f3->get('base')."res/".$controllerName.'/';

            $f3->set('baseRes', $baseResFolder);
            $f3->set('baseComponentFolder', $baseComponentFolder);
            $f3->set('components', $components);

            echo \Template::instance()->render($baseViewFolder.'index.html');
        }
    }

    $controllerGroup = array('Homepage');

    foreach($controllerGroup as $group){
        require("controller/".$group."_c.php");
    }

?>