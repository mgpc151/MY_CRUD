<?php
/** @var Csrf $csrf */
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <link rel="stylesheet" href="/app/view/style/AuthStyle.css">
</head>
<body>

<div>

    <h1>Crier a sua conta</h1>

    <?php if (isset($erro)): ?>
        <p style="color: red;">
            <?php echo htmlspecialchars($erro); ?>
        </p>
    <?php endif; ?>

    <form action="index.php?action=criar" method="POST">
            <?= $csrf->campoHidden() ?>
        <p class="input">
            <label>Nome</label>
            <input type="text" name="nome">
        </p>
        
        <p class="input">
            <label>E-mail</label>
            <input type="email" name="email">
        </p>

        <p class="input">
            <label>Senha</label>
            <input type="password" name="senha">
        </p>

        <p>
            <button type="submit">criar</button>
        </p>
    </form>
        <p>
        <form action="index.php?action=index" method="POST">
            <button type="re">voltar</button>
        </form>
        </p>

</div>
</body>
</html>
