<?php

    class Homepage extends Controller{

        protected $controllerName = "Homepage";

        function index($f3){
            $data = $this->dataMatang();

            $f3->set('webinarData', $data[1]);
            $f3->set('allWebinar', $data[0]);
            $f3->set('printNama', function($gelar, $nama){
                return str_replace('|', $nama, $gelar);
            });
            
            $this->get_view($f3, 'index.html');
        }

        function dataMentah($f3){
            $data = Webinar_m::getAllWebinar();
            
            echo Cetak::pp($data);
        }

        function dataMatang(){
            $data = Webinar_m::getAllWebinar();

            $webinarData = array();

            foreach($data->webinar as $key => $webinar){
                $currentWebinar = array(
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

    }

?>