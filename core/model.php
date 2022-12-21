<?php

    $modelGroup = array('Webinar');

    foreach($modelGroup as $group){
        require 'model/'.$group.'_m.php';
    }

    class Model {
        protected static function getFromAPI($url){
            $json_url = 'https://ruangseminar.site/'.$url;
            $json = file_get_contents($json_url);
            $data = json_decode($json);

            return $data;
        }
    }

?>