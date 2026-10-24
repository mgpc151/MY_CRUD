<?php /** @var Csrf $csrf */ ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="/app/view/style/AuthStyle.css">
</head>
<body>
<div>

    <h1>Acesse sua conta</h1>

    <?php if(isset($erro)): ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($erro); ?>
        </p>
    <?php endif; ?>

    <form action="index.php?action=autenticar" method="POST">
        <p class="input">
            <?= $csrf->campoHidden() ?>
            <label>E-mail</label>
            <input type="email" name="email">
        </p>

        <p class="input">
            <label>Senha</label>
            <input type="password" name="senha">
        </p>

        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>
        <p>
        <form action="index.php?action=cadastrar" method="POST">
            <button type="re">Criar</button>
        </form>
        </p>

</div>
</body>
</html>
