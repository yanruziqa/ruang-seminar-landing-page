<?php
    $f3->route('GET /', 'HomepageView->halamanHomePage');
    $f3->route('GET /webinar/@id', 'HomepageView->halamanWebinarById');
    $f3->route('GET /become-an-instructor', 'HomepageView->halamanBecomeInstructor');
?>