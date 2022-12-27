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

            $f3->set('webinarData', $dataWebinar['webinar']);
            $f3->set('dataKategoriWebinar', $dataWebinar['categories']);
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
                    '~/banner', 'offcanvas-menu', '~/course-info'
                )
            );
            $breadcrumbItem = array(
                'Home' => $f3->get('base'),
                $webinarData['nama_kategori'] => $f3->get('base')."category/".$webinarData['id_kategori'],
                $webinarData['judul'] => $f3->get('base')."webinar/".$webinarData['id_webinar']
            );

            $f3->set('data', $webinarData);
            $f3->set('breadcrumb', $breadcrumbItem);
            
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

        function halamanCategory($f3){
            $id = $f3->get('PARAMS.id');

            $webinarData = $this->data->getWebinarForCategory($id);

            $components = array(
                'title' => 'Webinar dalam Kategori '.$webinarData[0]['nama_kategori'].' | Ruang Seminar',
                'page' => 'category',
                'komponen' => array(
                    'offcanvas-menu', '~/banner', '~/course-grid'
                )
            );
            $breadcrumbItem = array(
                'Home' => $f3->get('base'),
                $webinarData[0]['nama_kategori'] => $f3->get('base')."category/".$webinarData[0]['id_kategori']
            );

            $f3->set('data', $webinarData);
            $f3->set('breadcrumb', $breadcrumbItem);

            // echo Cetak::pp($webinarData);

            $this->get_view($f3, $components);
        }
    }
?>