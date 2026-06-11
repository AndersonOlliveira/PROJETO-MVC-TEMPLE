<?php

namespace App\Models;

use Core\Model;


class Pagamento extends Model
{

    protected $table = 'tipo_pagamentos';
    protected $errors;


    public function listPag()
    {

        $sql = "SELECT * FROM $this->table";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
