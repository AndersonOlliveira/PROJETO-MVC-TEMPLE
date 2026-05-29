<?php

namespace App\Controllers\Api;


use App\Models\Mobilidades;

class ApiHomeController
{

    public function testeConection()
    {
        header("Access-Control-Allow-Origin: http://localhost:5173");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Content-Type: application/json; charset=utf-8");


        $lista = new Mobilidades();

        $dados = $lista->lista_mobilidades();

        header('Content-Type: application/json');

        echo json_encode($dados);
        exit;
    }
}
