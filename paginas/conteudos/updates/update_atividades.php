<section>
    <?php
        // Inclui o arquivo de conexão com o banco de dados
        include('../config/conexao.php');

        // Verifica se o parâmetro 'id' foi passado via GET
        if (!isset($_GET['idUpdate'])) {
            // Se não foi passado, redireciona para a página home.php
            header("Location: home.php?acao=cad_atividades");
            exit; // Encerra o script
        }

        // Obtém o valor do parâmetro 'id' e filtra como um inteiro
        $id = filter_input(INPUT_GET, 'idUpdate', FILTER_DEFAULT);

        // Prepara e executa a consulta para selecionar o contato com base no 'id'
        $select = "SELECT * FROM tb_atividade WHERE id_atividade=:id";
        try {
            $resultado = $conect->prepare($select);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            // Verifica se foi encontrado algum contato com o 'id' especificado
            $contar = $resultado->rowCount();
            if ($contar > 0) {
                // Se encontrado, obtém os dados do contato
                $show = $resultado->fetch(PDO::FETCH_OBJ);
                $id_atividade = $show->id_atividade;
                $titulo_atividade = $show->titulo_atividade;
                $id_cliente = $show->id_cliente;
                $responsavel_atividade = $show->responsavel_atividade;
                $datainicio_atividade = $show->datainicio_atividade;
                $datafinal_atividade = $show->datafinal_atividade;
                $id_servico = $show->id_servico;
                $id_user = $show->id_user;
            } else {
                // Se nenhum contato foi encontrado, exibe uma mensagem de erro
                echo '<strong>Não há dados com o id informado!</strong>';
            }
        } catch (PDOException $e) {
            // Em caso de erro na consulta PDO, exibe a mensagem de erro
            echo "<strong>ERRO DE SELECT NO PDO: </strong>" . $e->getMessage();
        }
    ?>
    <!--formulário-->
    <div class="form-container">
        <h1>Atualizar Atividade</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="titulo_atividade">Título</label>
                <input type="text" id="titulo_atividade" name="titulo_atividade" value="<?php echo $titulo_atividade?>" required>
            </div>
    
            <div class="form-group">
                <label for="id_cliente">Cliente</label>
                <select id="id_cliente" name="id_cliente" required>
                    <option value="<?php echo $id_cliente?>"><?php echo $id_cliente?></option>
                    <?php 
                        $select = "SELECT * FROM tb_cliente WHERE id_user = :id_user";
                        $result = $conect->prepare($select);
                        $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        $result->execute();
                        while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
                            echo '<option value="' . $show->id_cliente . '">' . $show->nome_cliente . '</option>';
                        }
                    ?>
                </select>
            </div>
    
            <div class="form-group">
                <label for="responsavel_atividade">Responsável</label>
                <input type="text" id="responsavel_atividade" name="responsavel_atividade" value="<?php echo $responsavel_atividade?>" required>
            </div>
    
            <div class="form-group">
                <label for="datainicio_atividade">Data Inicial</label>
                <input type="date" id="datainicio_atividade" name="datainicio_atividade" value="<?php echo $datainicio_atividade?>" required>
            </div>
    
            <div class="form-group">
                <label for="datafinal_atividade">Data Final</label>
                <input type="date" id="datafinal_atividade" name="datafinal_atividade" value="<?php echo $datafinal_atividade?>" required>
            </div>
    
            <div class="form-group">
                <label for="id_servico">Serviço</label>
                <select id="id_servico" name="id_servico" required>
                    <option value="<?php echo $id_servico?>"><?php echo $id_servico?></option>
                    <?php 
                        $select = "SELECT * FROM tb_servico WHERE id_user = :id_user";
                        $result = $conect->prepare($select);
                        $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        $result->execute();
                        while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
                            echo '<option value="' . $show->id_servico . '">' . $show->nome_servico . '</option>';
                        }
                    ?>
                </select>
            </div>
    
            <button type="submit" class="btn-save" name="upAtividade">Atualizar</button>
        </form>
        <?php
              // Verifica se o formulário foi submetido
              if (isset($_POST['upAtividade'])) {
                // Obtém os dados do formulário
                $titulo_atividade = $_POST['titulo_atividade'];
                $id_cliente = $_POST['id_cliente'];
                $responsavel_atividade = $_POST['responsavel_atividade'];
                $datainicio_atividade = $_POST['datainicio_atividade'];
                $datafinal_atividade = $_POST['datafinal_atividade'];
                $id_servico = $_POST['id_servico'];

                // Prepara e executa o comando SQL para atualizar os dados do contato
                $update = "UPDATE tb_atividade SET titulo_atividade=:titulo, id_cliente=:id_cliente, responsavel_atividade=:responsavel, datainicio_atividade=:datainicio, datafinal_atividade=:datafinal, id_servico=:id_servico WHERE id_atividade=:id";

                try {
                  $result = $conect->prepare($update);
                  $result->bindParam(':titulo', $titulo_atividade, PDO::PARAM_STR);
                  $result->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
                  $result->bindParam(':responsavel', $responsavel_atividade, PDO::PARAM_STR);
                  $result->bindParam(':datainicio', $datainicio_atividade, PDO::PARAM_STR);
                  $result->bindParam(':datafinal', $datafinal_atividade, PDO::PARAM_STR);
                  $result->bindParam(':id_servico', $id_servico, PDO::PARAM_INT);
                  $result->bindParam(':id', $id_atividade, PDO ::PARAM_INT);
                  $result->execute();

                  // Verifica se a atualização foi bem-sucedida
                  $contar = $result->rowCount();
                  if ($contar > 0) {
                    // Se sim, exibe uma mensagem de sucesso e redireciona após 5 segundos
                    echo '<script>alert("A atividade foi atualizada")</script>';
                    header("Refresh: 0, home.php?acao=cad_atividades");
                  }else{
                    // Se não, exibe uma mensagem de erro
                    echo '<script>alert("O update não foi realizado")</script>';
                  }

                } catch (PDOException $e) {
                  // Em caso de erro PDO durante a atualização, exibe a mensagem de erro
                  echo "<strong>ERRO DE PDO= </strong>" . $e->getMessage();
                }
              }
              ?>
    </div>
</section>