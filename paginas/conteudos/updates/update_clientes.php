<section>
    <?php
        // Inclui o arquivo de conexão com o banco de dados
        include('../config/conexao.php');

        // Verifica se o parâmetro 'id' foi passado via GET
        if (!isset($_GET['idUpdate'])) {
            // Se não foi passado, redireciona para a página home.php
            header("Location: home.php?acao=cad_clientes");
            exit; // Encerra o script
        }

        // Obtém o valor do parâmetro 'id' e filtra como um inteiro
        $id = filter_input(INPUT_GET, 'idUpdate', FILTER_DEFAULT);

        // Prepara e executa a consulta para selecionar o contato com base no 'id'
        $select = "SELECT * FROM tb_cliente WHERE id_cliente=:id";
        try {
            $resultado = $conect->prepare($select);
            $resultado->bindParam(':id', $id, PDO::PARAM_INT);
            $resultado->execute();

            // Verifica se foi encontrado algum contato com o 'id' especificado
            $contar = $resultado->rowCount();
            if ($contar > 0) {
                // Se encontrado, obtém os dados do contato
                $show = $resultado->fetch(PDO::FETCH_OBJ);
                $id_cliente = $show->id_cliente;
                $nome_cliente = $show->nome_cliente;
                $email_cliente = $show->email_cliente;
                $telefone_cliente = $show->telefone_cliente;
                $pessoa_cliente = $show->pessoa_cliente;
                $CpfCnpj_cliente = $show->CpfCnpj_cliente;
                $endereco_cliente = $show->endereco_cliente;
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
        <h1>Cliente</h1>
        <form action="" method="post">
            <div class="form-type">
                <label class="custom-radio">
                    <input type="radio" name="tipoPessoa" value="fisica" <?php if ($pessoa_cliente == 'fisica') echo 'checked' ?>>
                    <span>Pessoa Física</span>
                </label>
                
                <label class="custom-radio">
                    <input type="radio" name="tipoPessoa" value="juridica" <?php if ($pessoa_cliente == 'juridica') echo 'checked' ?>>
                    <span>Pessoa Jurídica</span>
                </label>
            </div>
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" value="<?php echo $nome_cliente ?>" required>
            </div>
    
            <div class="form-group">
                <label for="brand">Email</label>
                <input type="text" id="marca" name="email" value="<?php echo $email_cliente ?>" required>
            </div>
    
            <div class="form-group">
                <label for="model">Telefone</label>
                <input type="text" id="model" name="telefone" value="<?php echo $telefone_cliente ?>" required>
            </div>
    
            <div class="form-group">
                <label for="serial">CPF/CNPJ</label>
                <input type="text" id="serial" name="CpfCnpj" value="<?php echo $CpfCnpj_cliente ?>" required>
            </div>
    
            <div class="form-group">
                <label for="additional-info">Endereço</label>
                <textarea id="additional-info" name="endereco"><?php echo $endereco_cliente ?></textarea>
            </div>
    
            <button type="submit" class="btn-save" name="upClientes">Editar</button>
        </form>
        <?php
              // Verifica se o formulário foi submetido
              if (isset($_POST['upClientes'])) {
                // Obtém os dados do formulário
                $nome_cliente = $_POST['name'];
                $email_cliente = $_POST['email'];
                $telefone_cliente = $_POST['telefone'];
                $pessoa_cliente = $_POST['tipoPessoa'];
                $CpfCnpj_cliente = $_POST['CpfCnpj'];
                $endereco_cliente = $_POST['endereco'];

                // Prepara e executa o comando SQL para atualizar os dados do contato
                $update = "UPDATE tb_cliente SET nome_cliente=:nome, email_cliente=:email, telefone_cliente=:telefone, pessoa_cliente=:pessoa, CpfCnpj_cliente=:CpfCnpj, endereco_cliente=:endereco WHERE id_cliente=:id";

                try {
                  $result = $conect->prepare($update);
                  $result->bindParam(':nome', $nome_cliente, PDO::PARAM_STR);
                  $result->bindParam(':email', $email_cliente, PDO::PARAM_STR);
                  $result->bindParam(':telefone', $telefone_cliente, PDO::PARAM_STR);
                  $result->bindParam(':pessoa', $pessoa_cliente, PDO::PARAM_STR);
                  $result->bindParam(':CpfCnpj', $CpfCnpj_cliente, PDO::PARAM_STR);
                  $result->bindParam(':endereco', $endereco_cliente, PDO::PARAM_STR);
                  $result->bindParam(':id', $id_cliente, PDO::PARAM_INT);
                  $result->execute();

                  // Verifica se a atualização foi bem-sucedida
                  $contar = $result->rowCount();
                  if ($contar > 0) {
                    // Se sim, exibe uma mensagem de sucesso e redireciona após 5 segundos
                    echo '<script>alert("O servico foi atualizado")</script>';
                    header("Refresh: 0, home.php?acao=cad_clientes");
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