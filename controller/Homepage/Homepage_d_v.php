<?php
    class HomepageData extends DataController{

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
        
    }
?>