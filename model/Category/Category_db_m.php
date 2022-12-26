<?php
    class Category_db_m extends MySQLModel {
        function __construct(){
            parent::__construct("kategori", 'id_kategori');
        }
    }
?>