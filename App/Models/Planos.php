<?php

namespace App\Models;

use Core\Model;

class Planos extends Model
{
    public function list_planos()
    {
        $sql = "SELECT * FROM infoPgs WHERE status = true";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}
