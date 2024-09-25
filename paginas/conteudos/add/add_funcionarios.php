<section>
    <!--formulário-->
    <div class="form-container">
        <h1>Novo Funcionário</h1>
        <form action="" method="post">
            <div class="form-type">
                <label class="custom-radio">
                    <input type="radio" name="sexo" value="feminino">
                    <span>Feminino</span>
                </label>
                
                <label class="custom-radio">
                    <input type="radio" name="sexo" value="masculino">
                    <span>Masculino</span>
                </label>
            </div>
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" required>
                <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
            </div>
    
            <div class="form-group">
                <label for="brand">Telefone</label>
                <input type="tel" id="tel" name="telefone" required>
            </div>

            <div class="form-group">
                <label for="serial">CPF</label>
                <input type="text" id="cpf" name="cpf" required>
            </div>
    
            <div class="form-group">
                <label for="model">Cargo</label>
                <input type="text" id="cargo" name="cargo" required>
            </div>
    
            <div class="form-group">
                <label for="endereco">Endereço</label>
                <textarea id="endereco" name="endereco"></textarea>
            </div>
    
            <button type="submit" class="btn-save" name="salvar">Salvar novo funcionário</button>
        </form>
        <?php
            include_once('../config/conexao.php');

            if(isset($_POST['salvar'])){
                $sexo_funcionario = $_POST['sexo'];
                $nome_funcionario = $_POST['name'];
                $telefone_funcionario = $_POST['telefone'];
                $cpf_funcionario = $_POST['cpf'];
                $cargo_funcionario = $_POST['cargo'];
                $endereco_funcionario = $_POST['endereco'];
                $id_user = $_POST['id_user'];

                $cadastro = "INSERT INTO tb_funcionario (sexo_funcionario, nome_funcionario, telefone_funcionario, cpf_funcionario, cargo_funcionario, endereco_funcionario, id_user) VALUES (:sexo, :nome, :telefone, :cpf, :cargo, :endereco, :id_user)";

                try{
                    $result = $conect->prepare($cadastro);
                    $result->bindParam(':sexo', $sexo_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':nome', $nome_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':telefone', $telefone_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':cpf', $cpf_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':cargo', $cargo_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':endereco', $endereco_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $result->execute();
                    $contar = $result->rowCount();
                    if ($contar > 0) {
                        // Se a inserção for bem-sucedida, exibe mensagem de sucesso
                        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        header("Refresh: 1, home.php?acao=cad_funcionarios");
                    } else {
                        // Se a inserção falhar, exibe mensagem de erro
                        echo "<script>alert('Erro ao cadastrar funcionário.');</script>";
                    }
                }
                catch(PDOException $e){
                    // Exibe mensagem de erro se ocorrer um erro de PDO
                    echo "<strong>ERRO DE PDO= </strong>" . $e->getMessage() . "<br>";                   
                }
            }
        ?>
    </div>

</section>