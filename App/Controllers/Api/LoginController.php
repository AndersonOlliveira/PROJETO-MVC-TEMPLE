<?php

namespace App\Controllers\Api;

use Firebase\JWT\JWT;
use Firebase\JWT\Key; // Importante para as versões novas do Firebase JWT


class LoginController
{

    public function autenticar()
    {
        // 1. Recebe os dados
        $email = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';



        // 2. Valida no seu Model (Simulação)
        // $user = $this->model->findUser($email, $senha);
        $user = ($email === 'admin@teste.com' && $senha === '123') ? (object)['id' => 1] : null;

        if ($user) {
            // 3. Se deu certo, gera o Token

            // $key = "8zP>9aL$2h!Wq@5mN*7vX&3pZ#1kR9tY";
            $key = $_ENV['JWT_TOKEN'];

            $payload = [
                'iat' => time(),            // Horário que foi criado
                'exp' => time() + $_ENV['JWT_TIME'],     // Expira em 1 hora
                'uid' => $user->id          // ID do usuário
            ];

            $token = JWT::encode($payload, $key, 'HS256');

            // echo '<pre>';

            // print_r($token);

            setcookie('jwt_token', $token, [
                'expires' => time() + 3600,
                'path' => '/',
                'httponly' => true, // Segurança contra ataques XSS
                'samesite' => 'Lax'
            ]);


            // 4. Retorna para o JavaScript
            return json_encode([
                'success' => true,
                'token' => $token
            ]);
        }

        return json_encode(['success' => false, 'message' => 'Credenciais inválidas']);
    }
}
