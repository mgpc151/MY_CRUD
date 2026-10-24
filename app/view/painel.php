
<?php /** @var Csrf $csrf */ ?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MYPROJETC</title>

	<link rel="stylesheet" href="/app/view/style/style.css">
</head>
<body>
	



<center>
    <h1>Bem-vindo ao painel, <?= htmlspecialchars($_SESSION['usuario_nome']) ?></h1>

    <nav>

        <form method="POST" action="index.php?action=logout">
            <?= $csrf->campoHidden() ?>
            <button type="submit">Sair</button>
        </form>

        <button type="button" id="btnEditar">Editar</button>

        <button id="BtnConfimar">Deletar</button>
    </nav>

</center>

<?php include __DIR__ . "/../view/listar.php"; ?>
<?php include __DIR__ . "/../view/deletarModal.php"; ?>

<script>
        const usuario = <?= json_encode([
            'id'    => (int) $_SESSION['usuario_id'],
            'nome'  => $_SESSION['nome'] ?? '',
            'email' => $_SESSION['email'] ?? '',
        ], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;

        function abrirUsuario() {
            document.getElementById("UsuarioId").value = usuario.id;
            document.getElementById("UsuarioNome").value = usuario.nome;
            document.getElementById("UsuarioEmail").value = usuario.email;
            document.getElementById("Editar_Usuario").style.display = "block";
        }

        function fecharUsuario() {
            document.getElementById("Editar_Usuario").style.display = "none";
        }

        function abrirConfimar() {
            document.getElementById("Deletar_modal").style.display = "block";
        }

        function fecharConfimar() {
            document.getElementById("Deletar_modal").style.display = "none";
        }


        document.getElementById("BtnConfimar").addEventListener("click", abrirConfimar);


        document.getElementById("btnEditar").addEventListener("click", abrirUsuario);

</script>

</body>
</html>