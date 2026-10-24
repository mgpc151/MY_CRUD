<?php
/** @var Csrf $csrf */
?>

<?php $tarefas = $tarefas ?? []; ?>

    <div class="painel_lista">
        <div class="head_lista">
            <h1>TO-DO List</h1>

            <form action="index.php?action=criarTarefa" method="POST">
                <?= $csrf->campoHidden() ?>
                <input type="text" name="descricao" placeholder="Descrição da tarefa">
                <button type="submit">Adicionar</button>
            </form>
        </div>

         <h2>Suas tarefas</h2>
        
         <?php if (!empty($tarefas)): ?>
                
                <ul id="lista">
                    <?php foreach ($tarefas as $tarefa): ?>
                        <li class="tarefas" id="tarefa-<?php echo (int) $tarefa[
                            "id"
                        ]; ?>">
                            <?php echo (int) $tarefa["id"]; ?>

                            <span><?php echo htmlspecialchars(
                                $tarefa["descricao"],
                            ); ?></span>

                            <form method="POST" action="index.php?action=deletarTarefa">
                                <?= $csrf->campoHidden() ?>
                                <input type="hidden" name="id" value="<?php echo (int) $tarefa[
                                    "id"
                                ]; ?>">
                                <button type="submit">Excluir</button>
                            </form>

                            <button onclick='abrirTarefa(<?php echo (int) $tarefa["id"]; ?>, <?php echo json_encode($tarefa["descricao"]); ?>)'>
                                Editar
                            </button>
                        </li>
                    <?php endforeach; ?>
    
                </ul>


         <?php else: ?>
             <p>Não há tarefas ainda!</p>
             <?php endif; ?>

        <?php include __DIR__ . "/../view/editarTarefa.php"; ?>
        <?php include __DIR__ . "/../view/editarUsuario.php"; ?>
        


        <script>

            function abrirTarefa(id, descricao){
                document.getElementById("TarefaId").value = id
                document.getElementById("TarefaDescricao").value = descricao
                document.getElementById("Editar_Tarefa").style.display = "block";
            }

            function fecharTarefa(){
                document.getElementById("Editar_Tarefa").style.display = "none";
            }

        </script>

    </div>
