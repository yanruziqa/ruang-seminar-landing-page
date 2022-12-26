<?php
    class Webinar_db_m extends MySQLModel {
        function __construct(){
            parent::__construct("webinar", 'id_webinar');
        }

        function get_with_category(){
            
        }
    }
?>