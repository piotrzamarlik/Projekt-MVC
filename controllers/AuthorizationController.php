<?php

namespace app\controllers;


use app\core\Controller;
use app\core\Request;
use app\models\Register as RegisterModel;

/**
 * Class AuthorizationController
 */
class AuthorizationController extends Controller
{
    public function login(Request $request) {    
        $this->setLayout('auth');
        return $this->render('login');
    }

    public function register(Request $request) {  
        $this->setLayout('auth'); 
        if ($request->isPost()) {
            $register = new RegisterModel();
            $register->loadData($request->getBody());
            if ($register->validate() && $register->register()) {
                return 'Succes';
            }
            return $this->render('register');
        }
        return $this->render('register');
    }
}