<?php
    class Webinar_m{
        static function getAllWebinar(){
            $json_url = 'https://ruangseminar.site/api/webinars?page=1&limit=4&sortby=createdAt&order=desc';
            $json = file_get_contents($json_url);
            $data = json_decode($json);

            return $data;
        }
    }
?>