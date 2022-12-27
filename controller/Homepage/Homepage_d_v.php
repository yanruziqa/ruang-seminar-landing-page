<?php
    class HomepageData extends DataController{

        function __construct(){
            $this->webinarModel = new Webinar_db_m();
            $this->categoryModel = new Category_db_m();
        }

        // For WebinarById
        function getWebinarForWebinarById($id){
            $this->webinarModel->add_select_query();
            $this->webinarModel->add_join_query('kategori', 'kategori', 'id_kategori');
            $this->webinarModel->add_where(array('id_webinar' => $id), TRUE);
            $res = $this->webinarModel->exec_query();

            return $res[0];
        }

        // For Homepage
        function getForHomepage(){
            $this->webinarModel->add_select_query();
            $this->webinarModel->add_join_query('kategori', 'kategori', 'id_kategori');
            $this->webinarModel->add_limit(1,5);
            $webinarData = $this->webinarModel->exec_query();

            $res['webinar'] = $webinarData;
            $categories = array();

            foreach ($webinarData as $key => $webinar) {
                // Proses tanggal
                $curr = new DateTime($webinar['tanggal']);
                $res['webinar'][$key]['hari'] = $curr->format('d');
                $res['webinar'][$key]['bulan'] = $curr->format('M');

                // Proses pembagian kategori
                if(!array_key_exists($webinar['nama_kategori'], $categories)){
                    $categories[$webinar['nama_kategori']] = array();
                }

                array_push($categories[$webinar['nama_kategori']], $res['webinar'][$key]);
            }

            $res['categories'] = $categories;

            // echo Cetak::pp($categories);
            return $res;
        }

        function getCategoryForHomepage(){
            $this->categoryModel->add_select_query();
            $this->categoryModel->add_limit(1,8);
            return $this->categoryModel->exec_query();
        }

        // For Category
        function getWebinarForCategory($id){
            $this->categoryModel->add_select_query();
            $this->categoryModel->add_join_query('webinar', 'id_kategori', 'kategori');
            $this->categoryModel->add_where(array('id_kategori' => $id));
            // echo $this->categoryModel->saved_query;
            $res = $this->categoryModel->exec_query();

            // echo $this->categoryModel->saved_query;

            foreach ($res as $key => $webinar) {
                // Proses tanggal
                $curr = new DateTime($webinar['tanggal']);
                $res[$key]['hari'] = $curr->format('d');
                $res[$key]['bulan'] = $curr->format('M');
            }
            return $res;
        }
        
    }
?>