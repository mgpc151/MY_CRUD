<?php /** @var Csrf $csrf */ ?>

<center>

    <div id="Deletar_modal" class="modal">

        <div class="modal-conteudo">

            <h2>Comfirmar exclusão</h2>
            <label>Ação irreversível: sua conta e todas as tarefas serão apagadas.</label>

            <nav>
                <form method="POST" action="index.php?action=excluirConta">
                    <?= $csrf->campoHidden() ?>
                    
                    <button type="submit">Deletar</button>
                </form>
                
                <form method="POST" action="index.php?action=index">
                    <?= $csrf->campoHidden() ?>
                    <button type="submit">Cancelar</button>
                </form>
                
            </nav>


    </div>

</center>
