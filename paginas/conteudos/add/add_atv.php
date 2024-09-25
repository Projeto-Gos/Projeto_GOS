<section>
    <!--formulário-->
    <div class="form-container">
        <h1>Nova Atividade</h1>
        <form action="" method="post">
            <!--titulo-->
            <div class="form-group">
                <div class="box-titulo_status">
                    <div class="titulo">
                        <label for="titulo_atividade">Título</label>
                        <input type="text" id="titulo_atividade" name="titulo_atividade" required>
                        <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
                    </div>
                    <div class="status">
                        <label for="cliente">Status</label>
                        <select id="clientes" name="status" required>
                            <option value="" disabled selected>Selecione o Status</option>
                            <option value="finalizado" class="finalizado">Finalizado</option>
                            <option value="andamento" id="andamento">Em Andamento</option>
                            <option value="atrasado" id="atrasado">Atrasado</option>
                        </select>
                    </div>
                </div>
            </div>

            <!--datas-->
            <div class="form-group" id="data">
               <div class="box-data">
                    <div class="data-inicial">
                        <label for="data">Data Inicial</label>
                        <input type="date" id="data-inicio" name="datainicio_atividade" required>
                    </div>
               
                    <div class="data-final">
                        <label for="datafinal_atividade">Data Final</label>
                        <input type="date" id="data-final" name="datafinal_atividade" required>
                    </div>
                </div>  
            </div>
            
            <!--clientes-->
            <div class="form-group">
                <label for="id_cliente">Cliente</label>
                <div class="box-cliente">
                    <select id="id_cliente" name="id_cliente" required>
                        <option value="" disabled selected>Selecione um Cliente</option>
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
                    <div class="abrir-modal">
                        <button onclick="abrirModalCliente()"><i class='bx bx-plus' style="font-size: 20px;"></i></button>
                    </div>
                </div>
            </div>
        
            <!--responsável-->
            <div class="form-group">
                <label for="funcionario">Responsável</label>

                <div class="box-funcionario">
                    <select id="funcionario" name="id_funcionario" required>
                        <option value="" disabled selected>Selecione um Responsável</option>
                        <?php 
                            $select = "SELECT * FROM tb_funcionario WHERE id_user = :id_user";
                            $result = $conect->prepare($select);
                            $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                            $result->execute();
                            while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
                                echo '<option value="' . $show->id_funcionario . '">' . $show->nome_funcionario . '</option>';
                            }
                        ?>
                    </select>
                    <div class="abrir-modal">
                        <button onclick="abrirModalFuncionarios()"><i class='bx bx-plus' style="font-size: 20px;"></i></button>
                    </div>
                </div>
            </div>
        
            <!-- instruções -->
            <div class="form-group">
                <label for="informacao_atividade">Instruções </label>
                <textarea id="informacao_atividade" name="informacao_atividade"></textarea>
            </div>

            <!--preço-->
            <div class="form-group" id="preco">
                <div class="box-preco">
                    <label for="id_servico">Serviço</label>
                    <div class="box-servico">
                        <select id="id_servico" name="id_servico" required>
                            <option value="" disabled selected>Selecione um Serviço</option>
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
                        <div class="abrir-modal">
                            <button onclick="abrirModalEquipamento()"><i class='bx bx-plus' style="font-size: 20px;"></i></button>
                        </div>
                    </div>
                </div>
                <div class="box-preco">
                    <label for="id_equipamento">Equipamento</label>
                    <div class="box-equipamento">
                        <select id="id_equipamento" name="id_equipamento" required>
                            <option value="" disabled selected>Selecione um Equipamento</option>
                            <?php 
                                $select = "SELECT * FROM tb_equipamento WHERE id_user = :id_user";
                                $result = $conect->prepare($select);
                                $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                                $result->execute();
                                while ($show = $result->FETCH(PDO::FETCH_OBJ)) {
                                    echo '<option value="' . $show->id_equipamento . '">' . $show->nome_equipamento . '</option>';
                                }
                            ?>
                        </select>
                        <div class="abrir-modal" class="tooltip">
                            <button onclick="abrirModalEquipamento()"><i class='bx bx-plus' style="font-size: 20px;"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn-save" name="salvar">Salvar nova atividade</button>
        </form>
        <?php
            include_once('../config/conexao.php');

            if(isset($_POST['salvar'])){
                $titulo_atividade = $_POST['titulo_atividade'];
                $id_cliente = $_POST['id_cliente'];
                $datainicio_atividade = $_POST['datainicio_atividade'];
                $datafinal_atividade = $_POST['datafinal_atividade'];
                $id_servico = $_POST['id_servico'];
                $id_funcionario = $_POST['id_funcionario'];
                $id_user = $_POST['id_user'];

                $cadastro = "INSERT INTO tb_atividade (titulo_atividade, id_cliente, datainicio_atividade, datafinal_atividade, id_servico, id_funcionario, id_user) VALUES (:titulo, :id_cliente, :datainicio, :datafinal, :id_servico, :funcionario, :id_user)";

                try{
                    $result = $conect->prepare($cadastro);
                    $result->bindParam(':titulo', $titulo_atividade, PDO::PARAM_STR);
                    $result->bindParam(':id_cliente', $id_cliente, PDO::PARAM_INT);
                    $result->bindParam(':datainicio', $datainicio_atividade, PDO::PARAM_STR);
                    $result->bindParam(':datafinal', $datafinal_atividade, PDO::PARAM_STR);
                    $result->bindParam(':id_servico', $id_servico, PDO::PARAM_INT);
                    $result->bindParam(':funcionario', $id_funcionario, PDO::PARAM_STR);
                    $result->bindParam(':id_user', $id_user, PDO::PARAM_INT);
                    $result->execute();
                    $contar = $result->rowCount();
                    if ($contar > 0) {
                        // Se a inserção for bem-sucedida, exibe mensagem de sucesso
                        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        header("Refresh: 1, home.php?acao=home");
                    } else {
                        // Se a inserção falhar, exibe mensagem de erro
                        echo "<script>alert('Erro ao cadastrar atividade.');</script>";
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