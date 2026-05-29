<?php

namespace App\Models;

use Core\Model;

class Mobilidades extends Model
{
    public function lista_mobilidades()
    {
        $sql = "SELECT * FROM mobilidade";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
