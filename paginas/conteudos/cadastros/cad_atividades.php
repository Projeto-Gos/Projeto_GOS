<section>
    <div class="lista">
        <!--titulo-->
        <div class="box-texto">
            <h1>Atividades</h1>
            <a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=add_atividades">
                <button class="btn-novo-cliente">Nova Atividade</button>
            </a>
        </div>
        <!--cadastros-->
        <div class="box-table">
            <table>
                <thead>
                    <tr>
                        <th>Visualizar</th>
                        <th>Nome</th>
                        <th>Status</th>
                        <th>Data Inicial</th>
                        <th>Data Final</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $select = "SELECT * FROM tb_atividade WHERE id_user = :id_user ORDER BY id_atividade DESC";

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
                        <td>
                            <a href="view_atividade.html" class="eye-button">
                                <i class='bx bx-show'></i> <!-- Ícone de olho do Boxicons -->
                            </a>
                        </td>
                        <td><?php echo $show->titulo_atividade ?></td>
                        <td><?php  ?></td>
                        <td><?php echo $show->datainicio_atividade ?></td>
                        <td><?php echo $show->datafinal_atividade ?></td>
                        <td><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=update_atividades&idUpdate=<?php echo $show->id_atividade; ?>"><i class='bx bxs-pencil edit-icon'></i></a></td>
                        <td><a href="conteudos/delete/delete_atividades.php?idDelete=<?php echo $show->id_atividade; ?>" onclick="return confirm('Deseja remover a atividade <?php echo $show->titulo_atividade; ?>?')" ><i class='bx bxs-trash delete-icon'></i></a></td>
                    </tr>
                    <?php
                        }
                            }
                                else{
                                    // Se a consulta não retornar resultados, exibe uma mensagem
                                    echo '<p style="text-align:center;"><strong>Não há Atividades Cadastrados!</strong></p>';
                                }
                        }catch(Exception $e){
                        // Exibe a mensagem de erro de PDO
                        echo '<strong>ERRO DE PDO= </strong>' . $e->getMessage();
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="animacao-atividade">
        <img src="../static/gif/add_ativo.svg" alt="">
    </div>

    
</section>