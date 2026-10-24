


<?php

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Lax',
    // 'secure' => true,   // ative se usar HTTPS
]);

session_start(); 

require_once __DIR__ . '/app/controller/UserController.php';
require_once __DIR__ . '/app/controller/TarefaController.php';

$userController   = new UserController();
$tarefaController = new TarefaController();

$action = $_GET['action'] ?? 'index';

switch ($action) {
    // ---------- usuário ----------
    case 'index':
        $userController->index();            // tela de login
        break;
    case 'autenticar':
        $userController->autenticar();
        break;
    case 'logout':
        $userController->logout();
        break;
    case 'cadastrar':
        $userController->formCadastro();
        break;
    case 'criar':
        $userController->criar();
        break;
    case 'atualizar':
        $userController->atualizar();
        break;
    case 'excluirConta':
        $userController->deletar();
        break;

    // ---------- tarefas ----------
    case 'painel':         
        $tarefaController->index();             
        break;
    case 'criarTarefa':
        $tarefaController->criar();
        break;
    case 'atualizarTarefa':
        $tarefaController->atualizar();
        break;
    case 'deletarTarefa':
        $tarefaController->deletar();
        break;

    default:
        http_response_code(404);
        exit('Página não encontrada.');
}