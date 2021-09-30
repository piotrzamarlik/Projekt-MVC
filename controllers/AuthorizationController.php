<?php

namespace app\controllers;


use app\core\Controller;
use app\core\Request;

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
            return 'Dane z requesta';
        }
        return $this->render('register');
    }
}