<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;

/**
 * Class ContactPageController
 */
class ContactPageController extends Controller
{
    public function getViewForm() {
        return $this->render('contact');
    }

    public function saveContactData(Request $request) {
        $body = $request->getBody();
        //  echo '<pre>';
        // var_dump($body);
        // echo '</pre>';
        // exit;
        return 'dsafsdfsdf';
    }
}