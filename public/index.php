<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use app\controllers\AuthorizationController;
use app\controllers\ContactPageController;
use app\controllers\HomePageController;
use app\core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'userClass' => app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
];

// dirname(__DIR__) - pobranie nazwy katalogu głównego systemu
$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [HomePageController::class, 'getHomePage']);
$app->router->get('/contact', [ContactPageController::class, 'getViewForm']);
$app->router->post('/contact', [ContactPageController::class, 'saveContactData']);

$app->router->get('/login', [AuthorizationController::class, 'login']);
$app->router->post('/login', [AuthorizationController::class, 'login']);
$app->router->get('/register', [AuthorizationController::class, 'register']);
$app->router->post('/register', [AuthorizationController::class, 'register']);
$app->router->get('/logout', [AuthorizationController::class, 'logout']);
$app->run();
