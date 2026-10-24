<?php /** @var Csrf $csrf */ ?>

<center>

<div id="Editar_Tarefa" class="modal">

    <div class="modal-conteudo">

        <h2>Editar tarefa</h2>

        <form action="index.php?action=atualizarTarefa" method="POST">
            <?= $csrf->campoHidden() ?>
            <input type="hidden" name="id" id="TarefaId">

            <input type="text" name="descricao" id="TarefaDescricao">

            <button type="submit"> Salvar </button>

            <button type="button" onclick="fecharTarefa()">Cancelar</button>

        </form>

    </div>

</div>

</center>

