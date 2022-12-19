<?php

    class Controller {
        protected $controllerName;

        protected function get_view($f3, $viewName){
            $controllerName = $this->controllerName;
            $baseViewFolder = "/view/".$controllerName.'/';
            $baseResFolder = $f3->get('base')."res/".$controllerName.'/';

            $f3->set('baseRes', $baseResFolder);
            echo \Template::instance()->render($baseViewFolder.$viewName);
        }
    }

    $controllerGroup = array('Homepage');

    foreach($controllerGroup as $group){
        foreach (glob("controller/".$group."_c.php") as $filename) {
            require $filename;
        }
    }

?>