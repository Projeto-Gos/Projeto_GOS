<section>
    <div class="form-container">
        <h1>Nova Atividade</h1>
        <form action="" method="post">
            <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
            <!--titulo e status-->
            <div class="form-group">
                <div class="box-titulo_status">
                    <div class="titulo">
                        <label for="name">Título</label>
                        <input type="text" id="name" name="titulo_atividade" required>
                    </div>
                    <div class="status">
                        <label for="cliente">Status</label>
                        <select id="clientes" name="clientes" required>
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
                        <input type="date" id="data-inicial" name="datainicio_atividade" required>
                    </div>

                    <div class="data-final">
                        <label for="data">Data Final</label>
                        <input type="date" id="data-final" name="datafinal_atividade" required>
                    </div>  
                </div>
            </div>
            
            <!--clientes-->
            <div class="form-group">
                <label for="cliente">Cliente</label>

                <div class="box-cliente" >
                    <select id="clientes" name="id_cliente" required>
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
                <label for="equipamento">Responsável</label>

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
    
            <!--instruções-->
            <div class="form-group">
                <label for="additional-info">Instruções </label>
                <textarea id="additional-info" name="informacao_atividade"></textarea>
            </div>

            <!--preço-->
            <div class="form-group" id="form-box">
                <div class="box-preco">
                    <label for="servico">Serviço</label>
                    <div class="box-servico">
                        <select id="servico" name="id_servico" required>
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
                            <button onclick="abrirModalServicos()"><i class='bx bx-plus' style="font-size: 20px;"></i></button>
                        </div>
                    </div> 
                </div>
            
                <div class="box-preco">
                    <label for="equipamento">Equipamento</label>
                    <div class="box-equipamento">
                        <select id="servico" name="id_equipamento" required>
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
            <button type="submit" class="btn-save" name="salvar">Salvar</button>
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

<!-- MODAIS -->
<div id="modalCliente" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModalCliente()">&times;</span>
        <h2>Cadastro rápido de novo cliente</h2>
        <form action="" method="post">
            <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
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
            </div>
    
            <div class="form-group">
                <label for="brand">Email</label>
                <input type="email" id="marca" name="email" required>
            </div>
    
            <div class="form-group">
                <label for="model">Telefone</label>
                <input type="tel" id="model" name="telefone" required>
            </div>
    
            <div class="form-group">
                <label for="serial">CPF/CNPJ</label>
                <input type="text" id="serial" name="CpfCnpj" required>
            </div>
    
            <div class="form-group">
                <label for="additional-info">Endereço</label>
                <textarea id="additional-info" name="endereco"></textarea>
            </div>
            
            <div class="btn-acao">
                <button type="submit" class="btn-save" name="salvarCliente">Salvar</button>
                <button type="button" class="btn-cancel" onclick="fecharModalCliente()">Cancelar</button>
            </div>
            
        </form>
        <?php
            include_once('../config/conexao.php');

            if(isset($_POST['salvarCliente'])){
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
                        // echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        header("Refresh: 0");
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
</div>

<div id="modalEquipamento" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModalEquipamento()">&times;</span>
        <h2>Cadastro rápido de novo equipamento</h2>
        <form action="" method="post">
            <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" required>
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
                <input type="text" id="serial" name="serial" required>
            </div>
    
            <div class="form-group">
                <label for="additional-info">Informações adicionais</label>
                <textarea id="additional-info" name="additional-info"></textarea>
            </div>
    
            <div class="btn-acao">
                <button type="submit" class="btn-save" name="salvarEquipamento">Salvar</button>
                <button type="button" class="btn-cancel" onclick="fecharModalEquipamento()">Cancelar</button>
            </div>
        </form>
        <?php
            include_once('../config/conexao.php');

            if(isset($_POST['salvarEquipamento'])){
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
                        //echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        header("Refresh: 0");
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
</div>

<div id="modalServicos" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModalServicos()">&times;</span>
        <h2>Cadastro rápido de novo serviço</h2>
        <form action="" method="post">
            <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
            <div class="form-group">
                <label for="name">Código</label>
                <input type="text" id="name" name="codigo">
            </div>

            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" required>
            </div>
    
            <div class="form-group">
                <label for="brand">Preço</label>
                <input type="number"  step="0.01" id="marca" name="preco" required>
            </div>
    
            <div class="form-group">
                <label for="model">Custo</label>
                <input type="number"  step="0.01" id="model" name="custo" required>
            </div>
    
            <div class="form-group">
                <label for="additional-info">Informações adicionais</label>
                <textarea id="additional-info" name="additional-info"></textarea>
            </div>
    
            <div class="btn-acao">
                <button type="submit" class="btn-save" name="salvarServico">Salvar</button>
                <button type="button" class="btn-cancel" onclick="fecharModalServicos()">Cancelar</button>
            </div>
        </form>
        <?php 
            include_once('../config/conexao.php');

            if(isset($_POST['salvarServico'])){
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
                        //echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        header("Refresh: 0");
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
</div>

<div id="modalFuncionarios" class="modal">
    <div class="modal-content">
        <span class="close" onclick="fecharModalFuncionarios()">&times;</span>
        <h2>Cadastro rapido de novo funcionário</h2>
        <form action="" method="post">
            <input type="hidden"  name="id_user" id="id_user" value="<?php echo $id_user ?>">
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
    
            <div class="btn-acao">
                <button type="submit" class="btn-save" name="salvarFuncionario">Salvar</button>
                <button type="button" class="btn-cancel" onclick="fecharModalCliente()">Cancelar</button>
            </div>
        </form>
        <?php
            include_once('../config/conexao.php');

            if(isset($_POST['salvarFuncionario'])){
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
                        //echo "<script>alert('Cadastro realizado com sucesso!');</script>";
                        header("Refresh: 0");
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
</div>



<script>
    // Funções para abrir e fechar os modais
    function abrirModalCliente() {
        document.getElementById("modalCliente").style.display = "block";
    }

    function fecharModalCliente() {
        document.getElementById("modalCliente").style.display = "none";
    }

    function abrirModalEquipamento() {
        document.getElementById("modalEquipamento").style.display = "block";
    }

    function fecharModalEquipamento() {
        document.getElementById("modalEquipamento").style.display = "none";
    }

    function abrirModalServicos() {
        document.getElementById("modalServicos").style.display = "block";
    }

    function fecharModalServicos() {
        document.getElementById("modalServicos").style.display = "none";
    }

    function abrirModalFuncionarios() {
        document.getElementById("modalFuncionarios").style.display = "block";
    }

    function fecharModalFuncionarios() {
        document.getElementById("modalFuncionarios").style.display = "none";
    }

    // Adiciona a funcionalidade de fechar os modais ao clicar no botão "x"
    var span = document.getElementsByClassName("close");
    var modals = document.getElementsByClassName("modal");
    for (var i = 0; i < span.length; i++) {
        span[i].onclick = function() {
            for (var j = 0; j < modals.length; j++) {
                modals[j].style.display = "none";
            }
        }
    }

    // Adiciona a funcionalidade de fechar os modais ao clicar fora deles
    window.onclick = function(event) {
        for (var i = 0; i < modals.length; i++) {
            if (event.target == modals[i]) {
                modals[i].style.display = "none";
            }
        }
    }
</script>