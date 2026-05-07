<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class Auth
{
    public static function check()
    {
        // $key = "8zP>9aL$2h!Wq@5mN*7vX&3pZ#1kR9tY";
        $key = $_ENV['JWT_TOKEN'];
        $token = null;

        // 1. Tenta pegar o token do Cookie (útil para navegação/redirecionamento)
        if (isset($_COOKIE['jwt_token'])) {
            $token = $_COOKIE['jwt_token'];
        }

        // 2. Se não tem cookie, tenta pegar do cabeçalho Authorization (útil para chamadas AJAX de API)
        else {
            $headers = getallheaders();
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }

        // 3. Se encontrou um token em algum lugar, tenta validar
        if ($token) {
            try {
                return JWT::decode($token, new Key($key, 'HS256'));
            } catch (Exception $e) {
                // Token inválido ou expirado - segue para o erro abaixo
            }
        }

        // 4. Se chegou aqui, não há token válido. 
        // Se for uma requisição de página (não AJAX), redireciona.
        // Se for uma requisição de API (AJAX), retorna JSON.
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
            header('Content-Type: application/json');
            header('Location: /login');

            echo json_encode(['success' => false, 'error' => 'Não autorizado']);
        } else {
            header('Location: /login');
        }
        exit;
    }
}
