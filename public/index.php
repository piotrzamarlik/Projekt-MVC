<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\ContactPageController;
use app\controllers\HomePageController;
use app\core\Application;

// dirname(__DIR__) - pobranie nazwy katalogu głównego systemu
$app = new Application(dirname(__DIR__));

$app->router->get('/', [HomePageController::class, 'getHomePage']);
$app->router->get('/contact', [ContactPageController::class, 'getViewForm']);
$app->router->post('/contact', [ContactPageController::class, 'saveContactData']);
$app->run();