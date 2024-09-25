<section>
<?php
        // Inclui o arquivo de conexão com o banco de dados
        include('../config/conexao.php');

        // Verifica se o parâmetro 'id' foi passado via GET
        if (!isset($_GET['idUpdate'])) {
            // Se não foi passado, redireciona para a página home.php
            header("Location: home.php?acao=cad_funcionarios");
            exit; // Encerra o script
        }

        // Obtém o valor do parâmetro 'id' e filtra como um inteiro
        $id = filter_input(INPUT_GET, 'idUpdate', FILTER_DEFAULT);

        // Prepara e executa a consulta para selecionar o contato com base no 'id'
        $select = "SELECT * FROM tb_funcionario WHERE id_funcionario=:id";
        try {
            $resultado = $conect->prepare($select);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            // Verifica se foi encontrado algum contato com o 'id' especificado
            $contar = $resultado->rowCount();
            if ($contar > 0) {
                // Se encontrado, obtém os dados do contato
                $show = $resultado->fetch(PDO::FETCH_OBJ);
                $id_funcionario = $show->id_funcionario;
                $sexo_funcionario = $show->sexo_funcionario;
                $nome_funcionario = $show->nome_funcionario;
                $telefone_funcionario = $show->telefone_funcionario;
                $cpf_funcionario = $show->cpf_funcionario;
                $cargo_funcionario = $show->cargo_funcionario;
                $endereco_funcionario = $show->endereco_funcionario;
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
        <h1>Funcionário</h1>
        <form action="" method="post">
            <div class="form-type">
                <label class="custom-radio">
                    <input type="radio" name="sexo" value="feminino" <?php if ($sexo_funcionario == 'feminino') echo 'checked' ?>>
                    <span>Feminino</span>
                </label>
                
                <label class="custom-radio">
                    <input type="radio" name="sexo" value="masculino" <?php if ($sexo_funcionario == 'masculino') echo 'checked' ?>>
                    <span>Masculino</span>
                </label>
            </div>
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="nome" value="<?php echo $nome_funcionario ?>" required>
            </div>
    
            <div class="form-group">
                <label for="brand">Telefone</label>
                <input type="tel" id="tel" name="telefone" value="<?php echo $telefone_funcionario ?>" required>
            </div>

            <div class="form-group">
                <label for="serial">CPF</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo $cpf_funcionario ?>" required>
            </div>
    
            <div class="form-group">
                <label for="model">Cargo</label>
                <input type="text" id="cargo" name="cargo" value="<?php echo $cargo_funcionario ?>" required>
            </div>
    
            <div class="form-group">
                <label for="endereco">Endereço</label>
                <textarea id="endereco" name="endereco"><?php echo $endereco_funcionario ?></textarea>
            </div>
    
            <button type="submit" class="btn-save" name="upFuncionario">Salvar novo funcionário</button>
        </form>
        <?php
              // Verifica se o formulário foi submetido
              if(isset($_POST['upFuncionario'])){
                $sexo_funcionario = $_POST['sexo'];
                $nome_funcionario = $_POST['nome'];
                $telefone_funcionario = $_POST['telefone'];
                $cpf_funcionario = $_POST['cpf'];
                $cargo_funcionario = $_POST['cargo'];
                $endereco_funcionario = $_POST['endereco'];

                // Prepara e executa o comando SQL para atualizar os dados do contato
                $update = "UPDATE tb_funcionario SET sexo_funcionario=:sexo, nome_funcionario=:nome, telefone_funcionario=:telefone, cpf_funcionario=:cpf, cargo_funcionario=:cargo, endereco_funcionario=:endereco WHERE id_funcionario=:id";

                try {
                    $result = $conect->prepare($update);
                    $result->bindParam(':sexo', $sexo_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':nome', $nome_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':telefone', $telefone_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':cpf', $cpf_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':cargo', $cargo_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':endereco', $endereco_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':id', $id_funcionario, PDO::PARAM_INT);
                    $result->execute();

                  // Verifica se a atualização foi bem-sucedida
                  $contar = $result->rowCount();
                  if ($contar > 0) {
                    // Se sim, exibe uma mensagem de sucesso e redireciona após 5 segundos
                    echo '<script>alert("O Funcionário foi atualizado")</script>';
                    header("Refresh: 0, home.php?acao=cad_funcionarios");
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