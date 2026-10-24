<?php

require_once __DIR__ . "/../model/usuario.php";
require_once __DIR__ . "/../security/Csrf.php";

class UserController
{
    private Usuario $usuarioModel;
    private Csrf $csrf;

    public function __construct()
    {
        $this->usuarioModel = new Usuario();
        $this->csrf = new Csrf();
    }

    public function index()
    {
        // se já está logado, vai direto para o painel
        if (isset($_SESSION["usuario_id"])) {
            header("Location: index.php?action=painel");
            exit();
        }

        $csrf = $this->csrf;
        include __DIR__ . "/../view/login.php";
    }

    public function autenticar()
    {
        $this->exigirCsrf();

        if (!isset($_POST["email"], $_POST["senha"])) {
            header("Location: index.php");
            exit();
        }

        $email = trim($_POST["email"]);
        $senha = $_POST["senha"];

        if (empty($email) || empty($senha)) {
            $erro = "Preencha seu email e senha";
            $csrf = $this->csrf;
            include __DIR__ . "/../view/login.php";
            exit();
        }

        $usuario = $this->usuarioModel->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario["senha"])) {
            session_regenerate_id(true);
            $_SESSION["usuario_id"] = $usuario["id"];
            $_SESSION["usuario_nome"] = $usuario["nome"];
            $_SESSION["usuario_email"] = $usuario["email"];
            $_SESSION["usuario_senha"] = $usuario["senha"];
            $this->csrf->renovar();

            header("Location: index.php?action=painel");
            exit();
        }

        $erro = "E-mail ou senha estão incorretos";
        $csrf = $this->csrf;
        include __DIR__ . "/../view/login.php";
    }

    public function painel()
    {
        if (!isset($_SESSION["usuario_id"])) {
            header("Location: index.php");
            exit();
        }
        $csrf = $this->csrf;
        include __DIR__ . "/../view/painel.php";
    }

    public function logout()
    {
        $this->exigirCsrf();

        $_SESSION = [];
        session_destroy();

        header("Location: index.php");
        exit();
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

    private function exigirLogin(): void
    {
        if (!isset($_SESSION["usuario_id"])) {
            header("Location: index.php");
            exit();
        }
    }

    # Mostra o formulário de cadastro (GET)
    public function formCadastro()
    {
        if (isset($_SESSION["usuario_id"])) {
            header("Location: index.php?action=painel");
            exit();
        }
        $csrf = $this->csrf;
        include __DIR__ . "/../view/cadastrar.php";
    }

    # CRIAR (público: não exige login, mas exige token)
    public function criar()
    {
        $this->exigirCsrf();

        $nome = trim($_POST["nome"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $senha = $_POST["senha"] ?? "";

        $erro = null;
        if ($nome === "" || $senha === "") {
            $erro = "Preencha todos os campos";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "E-mail inválido";
        } elseif (strlen($senha) < 8) {
            $erro = "A senha deve ter pelo menos 8 caracteres";
        } elseif ($this->usuarioModel->emailExiste($email)) {
            $erro = "Este e-mail já está em uso";
        }

        if ($erro !== null) {
            $csrf = $this->csrf;
            include __DIR__ . "/../view/cadastrar.php";
            exit();
        }

        $hash = password_hash($senha, PASSWORD_DEFAULT);
        $this->usuarioModel->criar($nome, $email, $hash);

        header("Location: index.php");
        exit();
    }

    # ATUALIZAR (usuário logado edita a própria conta)
    public function atualizar()
    {
        $this->exigirLogin();
        $this->exigirCsrf();

        $id = (int) $_SESSION["usuario_id"];
        $nome = trim($_POST["nome"] ?? "");
        $email = trim($_POST["email"] ?? "");
        $senha = $_POST["senha"] ?? "";

        $erro = null;
        if ($nome === "") {
            $erro = "Informe o nome";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "E-mail inválido";
        } elseif ($senha !== "" && strlen($senha) < 8) {
            $erro = "A nova senha deve ter pelo menos 8 caracteres";
        } elseif ($this->usuarioModel->emailExiste($email, $id)) {
            $erro = "Este e-mail já está em uso";
        }

        if ($erro !== null) {
            $csrf = $this->csrf;
            include __DIR__ . "/../view/painel.php";
            exit();
        }

        $hash = $senha !== "" ? password_hash($senha, PASSWORD_DEFAULT) : null;
        $this->usuarioModel->atualizar($id, $nome, $email, $hash);

        $_SESSION["usuario_nome"] = $nome;
        $_SESSION["usuario_email"] = $email;

        header("Location: index.php?action=painel");
        exit();
    }

    # DELETAR (exclui a própria conta)
    public function deletar()
    {
        $this->exigirLogin();
        $this->exigirCsrf();

        $this->usuarioModel->deletar((int) $_SESSION["usuario_id"]);

        $_SESSION = [];
        session_destroy();

        header("Location: index.php");
        exit();
    }
}
