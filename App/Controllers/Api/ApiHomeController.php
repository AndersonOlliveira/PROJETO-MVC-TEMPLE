<?php

namespace App\Controllers\Api;


use App\Models\Mobilidades;

class ApiHomeController
{

    public function testeConection()
    {

        $lista = new Mobilidades();

        $dados = $lista->lista_mobilidades();
        echo '<pre>';
        print_r($dados);
        echo '</pre>';
    }
}
