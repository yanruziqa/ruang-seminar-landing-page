<?php
    class Webinar_m extends Model{
        static function getAllWebinar(){
            return self::getFromAPI('api/webinars?sortby=createdAt&order=desc');
        }

        static function getHomePageWebinar(){
            return self::getFromAPI('api/webinars?page=1&limit=4&sortby=createdAt&order=desc');
        }

        static function setCacheAllWebinar($f3){
            $data = self::getAllWebinar();
            $webinars = array();

            foreach ($data->webinar as $webinar) {
                $webinars[$webinar->_id] = $webinar;
            }

            $f3->set('allWebinarCache', $webinars, 60*60*24*7);

            return $webinars;
        }

        static function getWebinarById($f3, $id){
            $data = $f3->get('allWebinarCache');

            if($data == NULL){
                echo "Set cache nya";
                $data = self::setCacheAllWebinar($f3);
            }

            // echo Cetak::pp($data);

            return $data[$id];
        }
    }
?>