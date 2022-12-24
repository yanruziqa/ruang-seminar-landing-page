<?php
    class ViewController extends Controller{
        protected function get_view($f3, $components){
            $controllerName = $this->controllerName;

            $baseViewFolder = "/view/".$controllerName.'/';
            $baseComponentFolder = $baseViewFolder."components/";
            $baseResFolder = $f3->get('base')."res/".$controllerName.'/';

            $f3->set('baseRes', $baseResFolder);
            $f3->set('baseComponentFolder', $baseComponentFolder);
            $f3->set('components', $components);
            $f3->set('str_replace', function($w, $h, $hw){
                return str_replace($w, $h, $hw);
            });

            echo \Template::instance()->render($baseViewFolder.'index.html');
        }
    }
?>