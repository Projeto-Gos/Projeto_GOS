<section>
    <?php
        // Inclui o arquivo de conexão com o banco de dados
        include('../config/conexao.php');

        // Verifica se o parâmetro 'id' foi passado via GET
        if (!isset($_GET['idUpdate'])) {
            // Se não foi passado, redireciona para a página home.php
            header("Location: home.php?acao=cad_equipamentos");
            exit; // Encerra o script
        }

        // Obtém o valor do parâmetro 'id' e filtra como um inteiro
        $id = filter_input(INPUT_GET, 'idUpdate', FILTER_DEFAULT);

        // Prepara e executa a consulta para selecionar o contato com base no 'id'
        $select = "SELECT * FROM tb_equipamento WHERE id_equipamento=:id";
        try {
            $resultado = $conect->prepare($select);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            // Verifica se foi encontrado algum contato com o 'id' especificado
            $contar = $resultado->rowCount();
            if ($contar > 0) {
                // Se encontrado, obtém os dados do contato
                $show = $resultado->fetch(PDO::FETCH_OBJ);
                $id_equipamento = $show->id_equipamento;
                $nome_equipamento = $show->nome_equipamento;
                $marca_equipamento = $show->marca_equipamento;
                $modelo_equipamento = $show->modelo_equipamento;
                $nSerie_equipamento = $show->nSerie_equipamento;
                $informacao_equipamento = $show->informacao_equipamento;
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
        <h1>Ativo</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="<?php echo $nome_equipamento?>" required>
            </div>
    
            <div class="form-group">
                <label for="brand">Marca</label>
                <input type="text" id="marca" name="marca" value="<?php echo $marca_equipamento?>" required>
            </div>
    
            <div class="form-group">
                <label for="model">Modelo</label>
                <input type="text" id="model" name="model" value="<?php echo $modelo_equipamento?>" required>
            </div>
    
            <div class="form-group">
                <label for="serial">Número de Série</label>
                <input type="text" id="serial" name="serial" value="<?php echo $nSerie_equipamento?>" required>
            </div>
    
            <div class="form-group">
                <label for="additional-info">Informações adicionais</label>
                <textarea id="additional-info" name="additional-info"><?php echo $informacao_equipamento?></textarea>
            </div>
    
            <button type="submit" class="btn-save" name="upEquipamento">Editar</button>
        </form>
        <?php
              // Verifica se o formulário foi submetido
              if (isset($_POST['upEquipamento'])) {
                // Obtém os dados do formulário
                $nome_equipamento = $_POST['name'];
                $marca_equipamento = $_POST['marca'];
                $modelo_equipamento = $_POST['model'];
                $nSerie_equipamento = $_POST['serial'];
                $infor_adicionais = $_POST['additional-info'];

                // Prepara e executa o comando SQL para atualizar os dados do contato
                $update = "UPDATE tb_equipamento SET nome_equipamento=:nome, marca_equipamento=:marca, modelo_equipamento=:modelo, nSerie_equipamento=:nSerie, informacao_equipamento=:informacao WHERE id_equipamento=:id";

                try {
                  $result = $conect->prepare($update);
                  $result->bindParam(':nome', $nome_equipamento, PDO::PARAM_STR);
                  $result->bindParam(':marca', $marca_equipamento, PDO::PARAM_STR);
                  $result->bindParam(':modelo', $modelo_equipamento, PDO::PARAM_STR);
                  $result->bindParam(':nSerie', $nSerie_equipamento, PDO::PARAM_STR);
                  $result->bindParam(':informacao', $infor_adicionais, PDO::PARAM_STR);
                  $result->bindParam(':id', $id_equipamento, PDO::PARAM_INT);
                  $result->execute();

                  // Verifica se a atualização foi bem-sucedida
                  $contar = $result->rowCount();
                  if ($contar > 0) {
                    // Se sim, exibe uma mensagem de sucesso e redireciona após 5 segundos
                    echo '<script>alert("O servico foi atualizado")</script>';
                    header("Refresh: 0, home.php?acao=cad_equipamentos");
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
