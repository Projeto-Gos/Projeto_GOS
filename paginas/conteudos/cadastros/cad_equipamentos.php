<section>
    <div class="lista">
        <!--titulo-->
    <div class="box-texto">
        <h1>Cadastro de Ativos</h1>

        <a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=add_equipamentos">
            <button class="btn-novo-cliente">Novo Equipamento</button>
        </a>
    </div>

    <!--cadastros-->
    <div class="box-table">
        <table>
            <thead>
                <tr>
                    <th>Número de Série</th>
                    <th>Nome</th>
                    <th>Pertencente</th>
                    <th>Modelo</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $select = "SELECT * FROM tb_equipamento WHERE id_user = :id_user ORDER BY id_equipamento DESC";

                    try{
                        // Prepara a consulta SQL com o parâmetro :id_user
                        $result = $conect->prepare($select);
                        // Inicializa o contador de linhas
                        $cont = 1;
                        // Vincula o ID do usuário ao parâmetro :id_user
                        $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        // Executa a consulta SQL
                        $result->execute();
                  
                        // Verifica se a consulta retornou algum resultado
                        $contar = $result->rowCount();

                        if ($contar > 0) {
                            // Itera sobre cada linha de resultado da consulta
                            while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
                ?>
                <tr>
                    <td><?php echo $show->nSerie_equipamento; ?></td>
                    <td><?php echo $show->nome_equipamento; ?></td>
                    <td>Cliente Exemplo 2</td>
                    <td><?php echo $show->modelo_equipamento; ?></td>
                    <td><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=update_equipamentos&idUpdate=<?php echo $show->id_equipamento; ?>"><i class='bx bxs-pencil edit-icon'></i></a></td>
                    <td><a href="conteudos/delete/delete_equipamentos.php?idDelete=<?php echo $show->id_equipamento; ?>" onclick="return confirm('Deseja remover o equipamento <?php echo $show->nome_equipamento; ?>?')" ><i class='bx bxs-trash delete-icon'></i></a></td>
                </tr>
                <?php
                    }
                        }
                            else{
                                // Se a consulta não retornar resultados, exibe uma mensagem
                                echo '<strong>Não há Equipamentos Cadastrados!</strong>';
                            }
                    }catch(Exception $e){
                    // Exibe a mensagem de erro de PDO
                    echo '<strong>ERRO DE PDO= </strong>' . $e->getMessage();
                    }
                ?> 
            </tbody>
        </table>
    </div>

    <!--exportar-->
    <div class="export-buttons">
        <button class="export-btn">COPIAR</button>
        <button class="export-btn">CSV</button>
        <button class="export-btn">EXCEL</button>
        <button class="export-btn">PDF</button>
        <button class="export-btn">PRINT</button>
    </div>
    </div>
</section>