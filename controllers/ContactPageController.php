<?php

namespace app\controllers;

use app\core\Controller;

/**
 * Class ContactPageController
 */
class ContactPageController extends Controller
{
    public function getViewForm() {
        return $this->render('contact');
    }

    public function saveContactData() {
        return 'dsafsdfsdf';
    }
}