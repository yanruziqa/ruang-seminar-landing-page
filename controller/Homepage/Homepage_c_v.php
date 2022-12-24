<?php
    class HomepageView extends ViewController{
        protected $controllerName = "Homepage";

        function halamanHomePage($f3){
            $homepageData = new HomepageData();
            $data = $homepageData->prosesDataAllWebinar();

            $components = array(
                'title' => 'Ruang Seminar | Rekan Kerja Digital Anda',
                'page' => 'home',
                'komponen' => array(
                    '~/slider', 'offcanvas-menu', '~/fitur', '~/kategori', '~/course', '~/call-to-action', '~/testimonial', '~/banner', '~/partner'
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
                'page' => 'webinar',
                'komponen' => array(
                    'breadcrumb', 'offcanvas-menu', '~/course-info', '~/course-content'
                )
            );

            $f3->set('data', $webinarData);
            $f3->set('printNama', function($gelar, $nama){
                return str_replace('|', $nama, $gelar);
            });

            $this->get_view($f3, $components);
        }

        function halamanBecomeInstructor($f3){
            $components = array(
                'title' => 'Ruang Seminar | Rekan Kerja Digital Anda',
                'page' => 'instructor',
                'komponen' => array(
                    'offcanvas-menu', 'breadcrumb', '~/banner', '~/edumall', 'counter', '~/how', '~/cta'
                )
            );
            
            $this->get_view($f3, $components);
        }
    }
?>