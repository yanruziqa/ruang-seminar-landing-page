<?php
    class HomepageView extends ViewController{
        protected $controllerName = "Homepage";

        function __construct(){
            $this->data = new HomepageData();
        }

        function halamanHomePage($f3){
            // $data = $homepageData->prosesDataAllWebinar();

            $dataWebinar = $this->data->getForHomepage();
            $dataKategori = $this->data->getCategoryForHomepage();

            // echo Cetak::pp($data);

            $components = array(
                'title' => 'Ruang Seminar | Rekan Kerja Digital Anda',
                'page' => 'home',
                'komponen' => array(
                    '~/slider', 'offcanvas-menu', '~/fitur', '~/kategori', '~/course', '~/call-to-action', '~/testimonial'
                )
            );

            $f3->set('webinarData', $dataWebinar);
            $f3->set('dataKategori', $dataKategori);
            
            $this->get_view($f3, $components);
        }

        function halamanWebinarById($f3){
            $id = $f3->get('PARAMS.id');

            $webinarData = $this->data->getWebinarForWebinarById($id);

            $components = array(
                'title' => $webinarData['judul'].' | Ruang Seminar',
                'page' => 'webinar',
                'komponen' => array(
                    'breadcrumb', 'offcanvas-menu', '~/course-info'
                )
            );

            $f3->set('data', $webinarData);

            // echo Cetak::pp($webinarData);

            $this->get_view($f3, $components);
        }

        function halamanBecomeInstructor($f3){
            $components = array(
                'title' => 'Ruang Seminar | Rekan Kerja Digital Anda',
                'page' => 'instructor',
                'komponen' => array(
                    'offcanvas-menu', '~/banner', '~/edumall', 'counter', '~/how', '~/cta'
                )
            );
            
            $this->get_view($f3, $components);
        }
    }
?>