<?php


namespace App\Controllers\Api;


use App\Models\Mobilidades;
use App\Models\Pagamento;
use App\Models\Planos;
use App\Models\PushDados;
use Core\Controller;
use Core\Functions as CoreFunctions;

class ApiHomeController extends Controller
{

    protected $validar;
    protected $alunos;

    public function __construct()
    {
        $this->setApiHeaders(); // Reaproveita de forma explícita

        $this->validar = new CoreFunctions();
        $this->alunos = new PushDados();
    }
    public function testeConection()
    {
        $lista = new Mobilidades();

        $dados = $lista->lista_mobilidades();

        header('Content-Type: application/json');
        $this->json([
            'status' => 'success',
            'data' => $dados
        ]);

        // echo json_encode($dados);
        exit;
    }

    public function cadAlunosUsers()
    {
        // $this->setApiHeaders();
        $input = json_decode(file_get_contents('php://input'), true);

        $lista = new PushDados();

        $dados = $lista->push_aluno($input);



        if (!isset($dados['error'])) {
            $this->json([
                'status' => 'success',
                'message' => 'Aluno cadastrado com sucesso!'
            ], 201);
        } else {
            $this->json([
                'status' => 'error',
                'message' => 'Erro ao cadastrar aluno.' . $dados['error']
            ], 403);
        }
    }
    public function listaPlanos()
    {
        $listaPlanos = new Planos();
        $dados = $listaPlanos->list_planos();

        header('Content-Type: application/json');
        $this->json([
            'status' => 'success',
            'data' => $dados
        ]);

        exit;
    }

    public function getCpf($data)
    {

        $retorno = $this->validar->tratarCpf($data['cpf']);

        if ($retorno['valid'] == 0) {

            header('Content-Type: application/json');
            $this->json([
                'status' => 'false',
                'data' => $retorno,
                'mensagem' => 'CPF ESTA COM O FORMATO INVALIDO'
            ], 400);

            exit;
        }

        $retornoDadoLimpo = $this->validar->limparDados($data['cpf']);

        $retornoVerify =  $this->alunos->verifyUsers($retornoDadoLimpo);

        if ($retornoVerify) {
            header('Content-Type: application/json');
            $this->json([
                'status' => 'false',
                'data' => $retornoVerify,
                'mensagem' => 'CPF JÁ CADASTRADO NA BASE'
            ], 409);

            exit;
        }
    }

    public function listPg()
    {
        $listTipoPag = new Pagamento();
        $dados = $listTipoPag->listPag();

        header('Content-Type: application/json');
        $this->json([
            'status' => 'success',
            'data' => $dados
        ], 200);

        exit;
    }
}
