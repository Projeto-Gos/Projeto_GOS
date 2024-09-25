<section>
        <!-- <div class="animation-ativo">
            <img src="../static/gif/add_ativo.svg" alt="">
        </div> -->
        <!--formulário-->
        <div class="form-container">
            <h1>Novo Ativo</h1>
            <form action="" method="post">
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" id="name" name="name" required>
                    <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
                </div>
        
                <div class="form-group">
                    <label for="brand">Marca</label>
                    <input type="text" id="marca" name="marca" required>
                </div>
        
                <div class="form-group">
                    <label for="model">Modelo</label>
                    <input type="text" id="model" name="model" required>
                </div>
        
                <div class="form-group">
                    <label for="serial">Número de Série</label>
                    <input type="number" id="serial" name="serial" required>
                </div>
        
                <div class="form-group">
                    <label for="additional-info">Informações adicionais</label>
                    <textarea id="additional-info" name="additional-info"></textarea>
                </div>
        
                <button type="submit" class="btn-save" name="salvar">Salvar novo ativo</button>
            </form>
            <?php
                include_once('../config/conexao.php');

                if(isset($_POST['salvar'])){
                    $nome_equipamento = $_POST['name'];
                    $marca_equipamento = $_POST['marca'];
                    $modelo_equipamento = $_POST['model'];
                    $nSerie_equipamento = $_POST['serial'];
                    $infor_adicionais = $_POST['additional-info'];
                    $id_user = $_POST['id_user'];

                    $cadastro = "INSERT INTO tb_equipamento (nome_equipamento, marca_equipamento, modelo_equipamento, nSerie_equipamento , informacao_equipamento, id_user) VALUES (:nome, :marca, :modelo, :nSerie, :informacao, :id_user)";

                    try{
                        $result = $conect->prepare($cadastro);
                        $result->bindParam(':nome', $nome_equipamento, PDO::PARAM_STR);
                        $result->bindParam(':marca', $marca_equipamento, PDO::PARAM_STR);
                        $result->bindParam(':modelo', $modelo_equipamento, PDO::PARAM_STR);
                        $result->bindParam(':nSerie', $nSerie_equipamento, PDO::PARAM_STR);
                        $result->bindParam(':informacao', $infor_adicionais, PDO::PARAM_STR);
                        $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                        $result->execute();
                        $contar = $result->rowCount();
                        if ($contar > 0) {
                            // Se a inserção for bem-sucedida, exibe mensagem de sucesso
                            echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                            header("Refresh: 1, home.php?acao=cad_equipamentos");
                        } else {
                            // Se a inserção falhar, exibe mensagem de erro
                            echo "<script>alert('Erro ao cadastrar equipamento.');</script>";
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