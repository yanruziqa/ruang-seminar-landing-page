<?php

    class Homepage extends Controller{

        protected $controllerName = "Homepage";

        function halamanHomePage($f3){
            $data = $this->prosesDataAllWebinar();

            $components = array(
                'title' => 'Ruang Seminar | Rekan Kerja Digital Anda',
                'komponen' => array(
                    'slider', 'offcanvas-menu', 'fitur', 'kategori', 'course', 'call-to-action', 'testimonial', 'banner', 'partner'
                )
            );

            $f3->set('webinarData', $data[1]);
            $f3->set('allWebinar', $data[0]);
            $f3->set('printNama', function($gelar, $nama){
                return str_replace('|', $nama, $gelar);
            });
            
            $this->get_view($f3, $components);
        }

        function halamanWebinarById($f3){
            $id = $f3->get('PARAMS.id');

            $webinarData = Webinar_m::getWebinarById($f3, $id);

            $components = array(
                'title' => $webinarData->name.' | Ruang Seminar',
                'komponen' => array(
                    'breadcrumb', 'offcanvas-menu', 'course-info', 'course-content'
                )
            );

            $f3->set('data', $webinarData);
            $f3->set('printNama', function($gelar, $nama){
                return str_replace('|', $nama, $gelar);
            });

            $this->get_view($f3, $components);
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

        function dataMentah($f3){
            
            
            echo Cetak::pp($data);
        }

    }

?>