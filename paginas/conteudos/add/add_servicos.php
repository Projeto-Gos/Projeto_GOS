<section>
    <!-- <div class="animation-servico">
        <img src="../static/gif/add_servico.svg" alt="">
    </div> -->
    <!--formulário-->
    <div class="form-container">
        <h1>Novo Serviço</h1>
        <form action="" method="post">
            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" name="codigo">
            </div>

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" required>
                <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
            </div>
    
            <div class="form-group">
                <label for="preco">Preço</label>
                <input type="number" step="0.01" id="preco" name="preco" required>
            </div>
    
            <div class="form-group">
                <label for="custo">Custo</label>
                <input type="number" step="0.01" id="custo" name="custo" required>
            </div>
    
            <div class="form-group">
                <label for="additional-info">Informações adicionais</label>
                <textarea id="additional-info" name="additional-info"></textarea>
            </div>
    
            <button type="submit" class="btn-save" name='salvar'>Salvar novo serviço</button>
        </form>
        <?php 
            include_once('../config/conexao.php');

            if(isset($_POST['salvar'])){
                $codigo_servico = $_POST['codigo'];
                $nome_servico = $_POST['name'];
                $preco_servico = $_POST['preco'];
                $custo_servico = $_POST['custo'];
                $infor_adicionais = $_POST['additional-info'];
                $id_user = $_POST['id_user'];

                $cadastro = "INSERT INTO tb_servico (codigo_servico, nome_servico, preco_servico, custo_servico, informacao_servico, id_user) VALUES (:codigo, :nome, :preco, :custo, :informacao, :id_user)";

                try{
                    $result = $conect->prepare($cadastro);
                    $result->bindParam(':codigo', $codigo_servico, PDO::PARAM_STR);
                    $result->bindParam(':nome', $nome_servico, PDO::PARAM_STR);
                    $result->bindParam(':preco', $preco_servico, PDO::PARAM_STR);
                    $result->bindParam(':custo', $custo_servico, PDO::PARAM_STR);
                    $result->bindParam(':informacao', $infor_adicionais, PDO::PARAM_STR);
                    $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $result->execute();
                    $contar = $result->rowCount();
                    if ($contar > 0) {
                        // Se a inserção for bem-sucedida, exibe mensagem de sucesso
                        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        header("Refresh: 1, home.php?acao=cad_servicos");
                    } else {
                        // Se a inserção falhar, exibe mensagem de erro
                        echo "<script>alert('Erro ao cadastrar serviço.');</script>";
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