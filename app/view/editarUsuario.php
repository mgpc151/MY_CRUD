<?php /** @var Csrf $csrf */ ?>

<center>

    <div id="Editar_Usuario" class="modal">

        <div class="modal-conteudo">

            <h2>Editar Usuario</h2>

            <form method="POST" action="index.php?action=atualizar">
                <?= $csrf->campoHidden() ?>
                <input type="hidden" name="id" id="UsuarioId">

                <p>
                    <label>Nome</label>
                    <input type="text" name="nome" id="UsuarioNome" required>
                </p>

                <p>
                    <label>E-mail</label>
                    <input type="email" name="email" id="UsuarioEmail" required>
                </p>

                <p>
                    <label>Nova senha (deixe vazio para manter)</label>
                    <input type="password" name="senha" id="UsuarioSenha" autocomplete="new-password">
                </p>

                <button type="submit">Salvar</button>
                <button type="button" onclick="fecharUsuario()">Cancelar</button>
            </form>

        </div>

    </div>

</center>
