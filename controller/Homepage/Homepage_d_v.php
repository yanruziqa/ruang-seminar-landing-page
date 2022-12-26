<?php
    class HomepageData extends DataController{

        function __construct(){
            $this->webinarModel = new Webinar_db_m();
            $this->categoryModel = new Category_db_m();
        }

        function prosesDataAllWebinar(){
            $data = Webinar_m::getHomePageWebinar();

            $webinarData = array();

            foreach($data->webinar as $key => $webinar){
                $currentWebinar = array(
                    '_id' => $webinar->_id,
                    'name' => $webinar->name,
                    'desc' => $webinar->description,
                    'speakers' => $webinar->speakers,
                    'location' => $webinar->location
                );

                $tags = $webinar->tags;

                foreach($tags as $tag){
                    if(!array_key_exists($tag, $webinarData)){
                        $webinarData[$tag] = array(
                            'daftar_webinar' => array(),
                            'total' => 0
                        );
                    }
                    array_push($webinarData[$tag]['daftar_webinar'], $currentWebinar);
                    $webinarData[$tag]['total'] += 1;
                }
            }
            
            // echo Cetak::pp($webinarData);

            return array($data, $webinarData);
        }

        function getDataAllWebinar(){
            return $this->webinarModel->get();
        }

        function getWebinarForWebinarById($id){
            $this->webinarModel->add_select_query();
            $this->webinarModel->add_join_query('kategori', 'kategori', 'id_kategori');
            $this->webinarModel->add_where(array('id_webinar' => $id), TRUE);
            $res = $this->webinarModel->exec_query();

            return $res[0];
        }

        function getForHomepage(){
            $this->webinarModel->add_select_query();
            $this->webinarModel->add_join_query('kategori', 'kategori', 'id_kategori');
            $this->webinarModel->add_limit(1,10);
            $res['webinar'] = $this->webinarModel->exec_query();
            foreach ($res['webinar'] as $key => $webinar) {
                $curr = new DateTime($webinar['tanggal']);

                $res['webinar'][$key]['hari'] = $curr->format('d');
                $res['webinar'][$key]['bulan'] = $curr->format('M');
            }

            // echo Cetak::pp($res);
            return $res['webinar'];
        }

        function getCategoryForHomepage(){
            $this->categoryModel->add_select_query();
            $this->categoryModel->add_limit(1,8);
            return $this->categoryModel->exec_query();
        }
        
    }
?>