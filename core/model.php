<?php

    $modelGroup = array('Webinar', 'Category');

    foreach (glob("core/model/*.php") as $filename) {
        require $filename;
    }

    foreach($modelGroup as $group){
        foreach (glob("model/".$group."/*.php") as $filename) {
            require $filename;
        }
    }

    class Model {
        protected $modelName;
        protected $driverData;
        protected static function getFromAPI($url){
            $json_url = 'https://ruangseminar.site/'.$url;
            $json = file_get_contents($json_url);
            $data = json_decode($json);

            return $data;
        }
    }

?>