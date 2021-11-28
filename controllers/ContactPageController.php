<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\ContactForm;

/**
 * Class ContactPageController
 */
class ContactPageController extends Controller
{
    public function getViewForm(Request $request, Response $repsonse) {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success', 'Dziękujemy za wiadomość');
                return $repsonse->redirect('/contact');
            }
        }
        return $this->render('contact', [
            'model' => $contact,
        ]);
    }

    // public function saveContactData(Request $request) {
    //     $body = $request->getBody();
    //     //  echo '<pre>';
    //     // var_dump($body);
    //     // echo '</pre>';
    //     // exit;
    //     return 'dsafsdfsdf';
    // }
}