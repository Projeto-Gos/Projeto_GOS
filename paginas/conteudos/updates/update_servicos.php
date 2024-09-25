<section>
    <?php
        // Inclui o arquivo de conexão com o banco de dados
        include('../config/conexao.php');

        // Verifica se o parâmetro 'id' foi passado via GET
        if (!isset($_GET['idUpdate'])) {
            // Se não foi passado, redireciona para a página home.php
            header("Location: home.php?acao=cad_servicos");
            exit; // Encerra o script
        }

        // Obtém o valor do parâmetro 'id' e filtra como um inteiro
        $id = filter_input(INPUT_GET, 'idUpdate', FILTER_DEFAULT);

        // Prepara e executa a consulta para selecionar o contato com base no 'id'
        $select = "SELECT * FROM tb_servico WHERE id_servico=:id";
        try {
            $resultado = $conect->prepare($select);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            // Verifica se foi encontrado algum contato com o 'id' especificado
            $contar = $resultado->rowCount();
            if ($contar > 0) {
                // Se encontrado, obtém os dados do contato
                $show = $resultado->fetch(PDO::FETCH_OBJ);
                $id_servico = $show->id_servico;
                $codigo_servico = $show->codigo_servico;
                $nome_servico = $show->nome_servico;
                $preco_servico = $show->preco_servico;
                $custo_servico = $show->custo_servico;
                $informacao_servico = $show->informacao_servico;
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
        <h1>Serviço</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Código</label>
                <input type="text" id="name" name="codigo"  value="<?php echo $codigo_servico; ?>" required>
            </div>

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="<?php echo $nome_servico?>" required>
            </div>
    
            <div class="form-group">
                <label for="brand">Preço</label>
                <input type="text" id="marca" name="preco" value="<?php echo $preco_servico ?>" required>
            </div>
    
            <div class="form-group">
                <label for="model">Custo</label>
                <input type="text" id="model" name="custo" value="<?php echo $custo_servico ?>" required>
            </div>
    
            <div class="form-group">
                <label for="additional-info">Informações adicionais</label>
                <textarea id="additional-info" name="additional-info"><?php echo $informacao_servico ?></textarea>
            </div>
    
            <button type="submit" class="btn-save" name="upServico">Editar</button>
        </form>
        <?php
              // Verifica se o formulário foi submetido
              if (isset($_POST['upServico'])) {
                // Obtém os dados do formulário
                $codigo_servico = $_POST['codigo'];
                $nome_servico = $_POST['name'];
                $preco_servico = $_POST['preco'];
                $custo_servico = $_POST['custo'];
                $informacao_servico = $_POST['additional-info'];

                // Prepara e executa o comando SQL para atualizar os dados do contato
                $update = "UPDATE tb_servico SET codigo_servico=:codigo, nome_servico=:nome, preco_servico=:preco, custo_servico=:custo, informacao_servico=:informacao WHERE id_servico=:id";

                try {
                    $result = $conect->prepare($update);
                    $result->bindParam(':codigo', $codigo_servico, PDO::PARAM_STR);
                    $result->bindParam(':nome', $nome_servico, PDO::PARAM_STR);
                    $result->bindParam(':preco', $preco_servico, PDO::PARAM_STR);
                    $result->bindParam(':custo', $custo_servico, PDO::PARAM_STR);
                    $result->bindParam(':informacao', $informacao_servico, PDO::PARAM_STR);
                    $result->bindParam(':id', $id_servico, PDO::PARAM_INT);
                    $result->execute();

                  // Verifica se a atualização foi bem-sucedida
                  $contar = $result->rowCount();
                  if ($contar > 0) {
                    // Se sim, exibe uma mensagem de sucesso e redireciona após 5 segundos
                    echo '<script>alert("O serviço foi atualizado")</script>';
                    header("Refresh: 0, home.php?acao=cad_servicos");
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