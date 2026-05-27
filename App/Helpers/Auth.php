<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class Auth
{
    public static function check()
    {
        $key = $_ENV['JWT_TOKEN'];
        $token = null; # INICIAL COMO NULL

        // 1. Identifica se a requisição quer JSON (Postman, AJAX, APIs)
        $headers = getallheaders();
        $acceptHeader = $headers['Accept'] ?? $headers['accept'] ?? '';
        $isJsonRequest = str_contains($acceptHeader, 'application/json') ||
            isset($_SERVER['HTTP_X_REQUESTED_WITH']);

        // 2. Procura o token no Cookie (Navegador)
        if (isset($_COOKIE['jwt_token'])) {
            $token = $_COOKIE['jwt_token'];
        }
        // 3. Se não tem cookie, procura no Header Authorization (Postman / AJAX)
        else {
            $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? '';


            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                $token = $matches[1];
            }
        }

        // 4. Validação do Token
        if ($token) {

            try {

                $decoded = JWT::decode($token, new Key($key, 'HS256'));

                // Se a API pediu JSON (Postman ou AJAX), devolve a resposta estruturada
                if ($isJsonRequest) {
                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode([
                        'success' => true,
                        'msg'     => 'Autorizado',
                        'user'    => $decoded
                    ]);
                    exit;
                }
                if (!isset($decoded->exp) || time() >= $decoded->exp) {
                    throw new Exception("Este token não possui data de expiração ou já expirou.");
                }
                // Se for navegação normal no browser, apenas retorna os dados e abre a página
                return $decoded;
            } catch (Exception $e) {
                $errorMsg = 'Token inválido ou expirado: ' . $e->getMessage();
            }
        } else {
            $errorMsg = 'Token não fornecido no Cookie ou Authorization Header.';
        }
        // 5. Tratamento de Erro (Não Autorizado)
        // Resposta false
        if (!$isJsonRequest) {
            // Resposta para Postman, Mobile ou AJAX do Navegador
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error'   => 'Não autorizado',
                'msg'     => $errorMsg
            ]);
            exit;
        } else {
            // Resposta para o utilizador comum a navegar no Browser
            setcookie('jwt_token', '', time() - $_ENV['JWT_TIME'], '/'); // Limpa cookie inválido
            header('Location: /login');
            exit;
        }
    }
}
