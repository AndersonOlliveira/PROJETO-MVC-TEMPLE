<?php

namespace App\Models;

use Core\Model;
use PDO;
use PDOException;
use Core\Logs;

class PushDados extends Model
{
    protected $table = 'Alunos';
    protected $errors;


    public function __construct()
    {
        parent::__construct();

        Logs::iniciar();
        $this->errors = [];
    }


    public function push_aluno($dados)
    {
        $sql = "INSERT INTO $this->table  
            (nome, cpf, email, data_nascimento, telefone, data_vencimento, tipo_plano, tipo_pagamento, data_inicio, status) 
            VALUES 
            (:nome, :cpf, :email, :data_nascimento, :telefone, :data_vencimento, :tipo_plano,
             :tipo_pagamento, :data_inicio, :status)";

        $stmt = $this->db->prepare($sql);

        $stmt->bindParam(':nome', $dados['nomeCompleto']);
        $stmt->bindParam(':cpf', $dados['cpf']);
        $stmt->bindParam(':email', $dados['email']);
        $stmt->bindParam(':data_nascimento', $dados['dataNascimento']);
        $stmt->bindParam(':telefone', $dados['telefone']);
        $stmt->bindParam(':data_vencimento', $dados['dataVencimento']);
        $stmt->bindParam(':tipo_plano', $dados['tipoPlano']);
        $stmt->bindParam(':tipo_pagamento', $dados['tipoPagamento']);
        $stmt->bindParam(':data_inicio', $dados['dataInicio']);
        $stmt->bindValue(':status', 1);

        try {
            $retorno = $stmt->execute();
            return $retorno;
        } catch (PDOException $e) {
            Logs::manipuladorDeExcecoes($e);
            return ['error' => $e->getMessage()];
        }
    }

    public function verifyUsers($cpf)
    {
        $sql = "SELECT EXISTS (
                 SELECT 1 FROM $this->table WHERE cpf = :cpf);";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetch();
        } catch (PDOException $e) {

            echo "tenho erro ao buscar os dados";
            Logs::manipuladorDeExcecoes($e);
            return ['error' => $e->getMessage()];
        }
    }
}
