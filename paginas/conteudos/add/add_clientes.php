<section>
        <!-- <div class="animation-ativo">
            <img src="../static/gif/add_ativo.svg" alt="">
        </div> -->
        <!--formulário-->
        <div class="form-container">
            <h1>Novo Cliente</h1>
            <form action="" method="post">
            <div class="form-type">
                    <label class="custom-radio">
                        <input type="radio" name="tipoPessoa" value="fisica">
                        <span>Pessoa Física</span>
                    </label>
                    
                    <label class="custom-radio">
                        <input type="radio" name="tipoPessoa" value="juridica">
                        <span>Pessoa Jurídica</span>
                    </label>
                </div>
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="name" required>
                    <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
                </div>
        
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="marca" name="email" required>
                </div>
        
                <div class="form-group">
                    <label for="model">Telefone</label>
                    <input type="text" id="model" name="telefone" required>
                </div>
        
                <div class="form-group">
                    <label for="serial">CPF/CNPJ</label>
                    <input type="text" id="serial" name="CpfCnpj" required>
                </div>
        
                <div class="form-group">
                    <label for="additional-info">Endereço</label>
                    <textarea id="additional-info" name="endereco"></textarea>
                </div>
        
                <button type="submit" class="btn-save" name="salvar">Salvar novo ativo</button>
            </form>
            <?php
                include_once('../config/conexao.php');

                if(isset($_POST['salvar'])){
                    $nome_cliente = $_POST['name'];
                    $email_cliente = $_POST['email'];
                    $telefone_cliente = $_POST['telefone'];
                    $pessoa_cliente = $_POST['tipoPessoa'];
                    $CpfCnpj_cliente = $_POST['CpfCnpj'];
                    $endereco_cliente = $_POST['endereco'];
                    $id_user = $_POST['id_user'];

                    $cadastro = "INSERT INTO tb_cliente (nome_cliente, email_cliente, telefone_cliente, pessoa_cliente , CpfCnpj_cliente  ,endereco_cliente, id_user) VALUES (:nome, :email, :telefone, :pessoa, :CpfCnpj, :endereco, :id_user)";

                    try{
                        $result = $conect->prepare($cadastro);
                        $result->bindParam(':nome', $nome_cliente, PDO::PARAM_STR);
                        $result->bindParam(':email', $email_cliente, PDO::PARAM_STR);
                        $result->bindParam(':telefone', $telefone_cliente, PDO::PARAM_STR);
                        $result->bindParam(':pessoa', $pessoa_cliente, PDO::PARAM_STR);
                        $result->bindParam(':CpfCnpj', $CpfCnpj_cliente, PDO::PARAM_STR);
                        $result->bindParam(':endereco', $endereco_cliente, PDO::PARAM_STR);
                        $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        $result->execute();
                        $contar = $result->rowCount();
                        if ($contar > 0) {
                            // Se a inserção for bem-sucedida, exibe mensagem de sucesso
                            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                            header("Refresh: 1, home.php?acao=cad_clientes");
                        } else {
                            // Se a inserção falhar, exibe mensagem de erro
                            echo "<script>alert('Erro ao cadastrar cliente.');</script>";
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