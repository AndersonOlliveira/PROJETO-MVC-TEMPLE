<?php
// 1. Carrega o autoload do Composer (APENAS UMA VEZ)
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Helpers\Auth; // para controller de login e criacao de token de entrada 


// 2. Instancia o Roteador
$router = new \Bramus\Router\Router();

// 3. Define suas rotas (Web e API)
$router->get('/', function () {
    require_once '../app/Views/home.php';
});

$router->get('/login', function () {
    require_once '../app/Views/home.php';
});
$router->get('/home', function () {
    Auth::check();
    require_once '../app/Views/painel/index.php';
});


$router->before('GET|POST', '/api/auth/.*', function () {
    if (session_status() === PHP_SESSION_NONE) session_start();

    if (!isset($_SESSION['usuario_id'])) {
        header('Location: /login');
        exit;
    }
});

$router->post('/api/auth', function () {
    header('Content-Type: application/json');
    $controller = new \App\Controllers\Api\LoginController();
    echo $controller->autenticar();
});


$router->post('/home', function () {


    // $controller = new \App\Controllers\Api\DadosController();
    // echo $controller->salvar();

});

// 4. Executa o roteador
$router->run();
