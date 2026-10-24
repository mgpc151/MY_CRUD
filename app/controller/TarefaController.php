<?php

require_once __DIR__ . "/../model/Tarefas.php";
require_once __DIR__ . "/../security/Csrf.php";

class TarefaController{
    private Tarefas $tarefaModel;
    private Csrf $csrf;

    public function __construct(){
       $this->tarefaModel = new Tarefas();
       $this->csrf = new Csrf();
    }

    public function index(){

        if (!isset($_SESSION["usuario_id"])) {
            header("Location: index.php");
            exit();
        }
        
        $tarefas = $this->tarefaModel->listar($_SESSION['usuario_id']);

        $csrf = $this->csrf;
        include __DIR__ . "/../view/painel.php";
        exit;
    }

    public function criar(){
        $this->exigirCsrf();
        
        if(isset($_POST['descricao']) && !empty(trim($_POST['descricao']))){
            $this->tarefaModel->criar(trim($_POST['descricao']),$_SESSION['usuario_id']);
            header("location: index.php?action=painel");
            exit;
        }
        $csrf = $this->csrf;
        header("location: index.php?action=painel");
        exit;
    }

    public function deletar() {
        $this->exigirCsrf();
        
        if (isset($_POST['id']) && isset($_SESSION['usuario_id'])) {
            $this->tarefaModel->deletar((int) $_POST['id'],(int) $_SESSION['usuario_id']);
            
        }
        
        $csrf = $this->csrf;
        header("Location: index.php?action=painel");
        exit;
    }

    public function atualizar(){
        $this->exigirCsrf();
         if(isset($_POST['id']) && isset($_SESSION['usuario_id']) && isset($_POST['descricao']) && !empty(trim($_POST['descricao']))){
            $this->tarefaModel->atualizar(trim($_POST['descricao']),(int) $_POST['id'],(int) $_SESSION['usuario_id']);
         }
         $csrf = $this->csrf;
         header("location: index.php?action=painel");
         exit;
    }

    private function exigirCsrf(): void
    {
        if (
            $_SERVER["REQUEST_METHOD"] !== "POST" ||
            !$this->csrf->verificarToken($_POST["csrf_token"] ?? null)
        ) {
            http_response_code(403);
            exit("Requisição inválida (token CSRF).");
        }
    }

}