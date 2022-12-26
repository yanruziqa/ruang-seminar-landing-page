<?php
    class MySQLModel extends Model{
        protected $driverData = "MySQL";
        protected $_table_name, $primary_key;
        protected $db;

        function __construct($table_name, $primary_key){
            $this->db=new DB\SQL(
                'mysql:host=localhost;port=3306;dbname=ruangse3_main',
                'ruangse3_admin',
                '!@#$%^&*()asdf'
            );

            $this->_table_name = $table_name;
            $this->_primary_key = $primary_key;
        }

        function get($id=NULL){
            if($id == NULL)
            {
                return $this->db->exec('SELECT * FROM '.$this->_table_name);
            } else 
            {
                return $this->db->exec(
                    'SELECT * FROM '.$this->_table_name.
                    ' WHERE '.$this->_primary_key.' = '.$id
                );
            }
        }

        function get_limit($s, $e){
            return $this->db->exec('SELECT * FROM '.$this->_table_name." LIMIT ".$s.", ".$e);
        }

        function add_limit($s, $e){
            $this->saved_query .= " LIMIT ".$s.", ".$e;
        }
    
        function get_assoc(){
            if($this->saved_query == "")
                $data = $this->get();
            else 
                $data = $this->exec_query();
            $result = array();
            foreach ($data as $key => $item) {
                $result[$item[$this->_primary_key]] = $item;
            }

            return $result;
        }

        /* Fungsi untuk mengambil data sesuai dengan kriteria
        
            Author: Yan Ruzika
            Parameter:
            - $where ARRAY parameter yang digunakan untuk filter database
                Format filter yang digunakan adalah array (column => value)
            - $single BOOLEAN (set TRUE jika ingin cuma satu row yang diambil, default false)
            
            Deskripsi:
            Fungsi ini berfungsi untuk mengambil data sesuai dengan kriteria yang akan diambil*/
        function get_by($where, $single = FALSE){
            $query = 'SELECT * FROM '.$this->_table_name. ' WHERE ';
            foreach($where as $key => $value)
            {
                if(is_array($value)){
                    $query .= "(";
                    foreach ($value as $or) {
                        if($or == "NULL")
                            $query .= $key." IS NULL".' OR ';
                        else
                            $query .= $key.'="'.$or.'" OR ';
                    }
                    $query .= ")";
                } else {
                    $query .= $key.'="'.$value.'" AND ';
                }
            }
            $query .= ' TRUE';

            $result = $this->db->exec($query);
            if($single == TRUE)
                return $result[0];
            else
                return $result;
        }

        function add_query($q){
            $this->saved_query .= $q;
        }

        function add_select_query($c = NULL, $t = NULL){
            if($t == NULL)
                $t = $this->_table_name;
            if($c == NULL)
                $saved_query = 'SELECT * FROM '.$t;
            else {
                $saved_query = "SELECT ";
                foreach ($c as $k => $v){
                    $saved_query .= $v.", ";
                }

                $saved_query = substr($saved_query, 0, -2)." FROM ".$t;
            }

            $this->saved_query = $saved_query;
        }

        /* Menyimpan query berupa join
        
            Author: Yan Ruzika
            Parameter:
            - $t STRING (tabel yang akan di join dengan tabel utama)
            - $fk STRING (foreign key dari tabel utama)
            - $fkt STRING (primary key dari tabel yang akan di join)
            
            Deskripsi:
            Fungsi ini akan menambahkan tabel untuk join dengan tabel utama berdasarkan foreign key yang ada*/
        function add_join_query($t, $fk, $fkt, $mt = NULL){
            if($mt == NULL)
                $mt = $this->_table_name;
            $this->saved_query .= ' JOIN '.$t.' ON '.$mt.'.'.$fk.' = '.$t.'.'.$fkt;
        }

        function add_left_join_query($t, $fk, $fkt, $mt = NULL){
            if($mt == NULL)
                $mt = $this->_table_name;
            $this->saved_query .= ' LEFT JOIN '.$t.' ON '.$mt.'.'.$fk.' = '.$t.'.'.$fkt;
        }

        function add_right_join_query($t, $fk, $fkt, $mt = NULL){
            if($mt == NULL)
                $mt = $this->_table_name;
            $this->saved_query .= ' RIGHT JOIN '.$t.' ON '.$mt.'.'.$fk.' = '.$t.'.'.$fkt;
        }

        function add_order_by($c, $m = 'ASC'){
            $this->saved_query .= ' ORDER BY '.$c.' '.$m;
        }

        function add_where($where, $single = FALSE){
            $query = ' WHERE ';
            if(is_array($where)){
                foreach($where as $key => $value)
                {
                    $or = false;
                    if(is_array($value)){
                        $or = true;
                        $query .= "(";
                        foreach ($value as $or) {
                            if($or == "NULL")
                                $query .= $key." IS NULL".' OR ';
                            else
                                $query .= $key.'="'.$or.'" OR ';
                        }
                    } else {
                        if($value == null)
                            $query .= $key.' IS NULL AND ';
                        else
                            $query .= $key.'="'.$value.'" AND ';
                    }
                }
                $query = substr($query, 0, -4);
                if($or)
                    $query .= ")";
            } else {
                $query .= $where;
            }

            if($single == TRUE)
                $query .= ' LIMIT 1';

            $this->saved_query .= $query;
        }

        function add_deadline($column, $date){
            $this->saved_query .= ' AND '.$column.' <= "'.$date.'"';
        }

        function add_begindate($column, $date){
            $this->saved_query .= ' AND '.$column.' >= "'.$date.'"';
        }

        /* Mengeksekusi query secara eksplisit atau query yang sudah di build
        
            Author: Yan Ruzika
            Param:
            - $query STRING (query yang akan di eksekusi)
            
            Deskripsi:
            Mengeksekusi query secara eksplisit (meskipun rentan XSS)
            Bisa juga dipakai untuk membuat sebuah query builder yang di simpan dalam variabel $saved_query*/
        function exec_query($query = NULL){
            if($query == NULL)
                $query = $this->saved_query;
            
                Return $this->db->exec($query);
        }

        /* Menyimpan data yang ada atau me-update data sesuai dengan id
        
            Author: Yan Ruzika
            Parameter:
            - $data array (data yang akan disimpan dalam tabel utama)
            - $id STRING (id dari data yang sudah diubah)
            
            Deskripsi:
            Fungsi untuk menyimpan data yang belum ada atau me-update data yang sudah ada*/
        function save($data, $id = NULL){
            if($id == NULL){
                $column = '(';
                $values = '(';
                foreach ($data as $key => $value) {
                    $column .= $key.', ';
                    $values .= '"'.addslashes($value).'", ';
                }
                $column = substr($column, 0, -2);
                $values = substr($values, 0, -2);
                $column .= ') ';
                $values .= ') ';
                $query = "INSERT INTO ".$this->_table_name.$column."VALUES".$values;
            } else {
                $query = "UPDATE ".$this->_table_name." SET ";
                foreach ($data as $key => $value) {
                    $query .= $key." = '".addslashes($value)."', ";
                }
                $query = substr($query, 0, -2);
                $query .= " WHERE ".$this->_primary_key." = '".$id."'";
            }
            // return $query;
            // echo $query;
            
            $this->db->exec($query);
            return $this->db->lastInsertId();
        }

        function delete($id){
            $query = "DELETE FROM ".$this->_table_name." WHERE ".$this->_primary_key."='".$id."'";
            $this->db->exec($query);
            // return $query;
        }
    }
?>