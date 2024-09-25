<section>
    <div class="lista">
                <!--titulo-->
                <div class="box-texto">
            <h1>Cadastro de Serviços</h1>
    
            <a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=add_servicos"><button class="btn-novo-cliente">Novo Serviço</button></a>
        </div>

        <!--cadastros-->
        <div class="box-table">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $select = "SELECT * FROM tb_servico WHERE id_user = :id_user ORDER BY id_servico DESC";

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
                        <td><?php echo $show->codigo_servico; ?></td>
                        <td><?php echo $show->nome_servico; ?></td>
                        <td><?php echo $show->preco_servico; ?></td>
                        <td><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=update_servicos&idUpdate=<?php echo $show->id_servico; ?>"><i class='bx bxs-pencil edit-icon'></i></a></td>
                        <td><a href="conteudos/delete/delete_servicos.php?idDelete=<?php echo $show->id_servico; ?>" onclick="return confirm('Deseja remover o serviço <?php echo $show->nome_servico; ?>?')" ><i class='bx bxs-trash delete-icon'></i></a></td>
                    </tr>
                    <?php
                        }
                            }
                                else{
                                    // Se a consulta não retornar resultados, exibe uma mensagem
                                    echo '<strong>Não há Serviços Cadastrados!</strong>';
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