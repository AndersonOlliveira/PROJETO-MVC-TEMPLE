<?php
// 1. Carrega o autoload do Composer (APENAS UMA VEZ)
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use App\Helpers\Auth; // para controller de login e criacao de token de entrada 
use Core\Controller;

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

$router->get('/auth/api', function () {
    Auth::check();
    require_once '../app/Views/painel/index.php';
});


// $router->before('GET|POST', '/api/auth/.*', function () {
//     if (session_status() === PHP_SESSION_NONE) session_start();

//     if (!isset($_SESSION['usuario_id'])) {
//         header('Location: /login');
//         exit;
//     }
// });

$router->before('OPTIONS', '/api/.*', function () {
    Controller::handleCorsPreflight();
    http_response_code(204);
    exit();
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


$router->get('/api/listaMobilidade', function () {
    $controller = new \App\Controllers\Api\ApiHomeController();
    $controller->testeConection();
});

//TRAZER OS PLANOS PARA O FRONTEND
$router->get('/api/listPlanos', function () {
    $controller = new \App\Controllers\Api\ApiHomeController();
    $controller->listaPlanos();
});

//VERRIFICAR SE JÁ EXISTE
$router->get('/api/bycpf', function () {
    $controller = new \App\Controllers\Api\ApiHomeController();
    $controller->getCpf($_REQUEST);
});
// ROTA PARA CADASTRO DE ALUNOS
$router->post('/api/cadAlunosUsers', function () {
    $controller = new \App\Controllers\Api\ApiHomeController();
    $controller->cadAlunosUsers();
});

// ROTA PARA LISTAR OS DADOS DE PAGAMENTOS
$router->get('/api/listPgamentos', function () {
    $controller = new \App\Controllers\Api\ApiHomeController();
    $controller->listPg();
});

// 4. Executa o roteador
$router->run();
