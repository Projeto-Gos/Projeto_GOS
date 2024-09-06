<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOS</title>
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/cad_user.css">

    <!--box link icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!--remix link icons-->
    <link  rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css">
    

</head>

<body>
    <?php include_once('../include/header.php') ?>

    <section>

        <!--formulário-->
        <div class="cadastro-container">
            <form action="" method="post" class="cadastro-form" enctype="multipart/form-data">
    
                <h2>Cadastro</h2>
    
                <div class="form-group">
                    <input type="file" id="foto" name="foto">
                    <i class='bx bxs-camera' style='color:#fffcf2'></i>
                </div>
    
                <div class="form-group">
                    <input type="text" id="nome" name="nome" placeholder="Nome" required>
                    <i class='bx bxs-user' style='color:#fffcf2'></i>
                </div>
    
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope' style='color:#fffcf2'></i>
                </div>
    
                <div class="form-group">
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                    <i class='bx bxs-lock-alt' style='color:#fffcf2'></i>
                </div>
    
                <button type="submit" class="cadastro-btn" name="cadastrar">Cadastrar</button>
    
                <div class="login">
                    <p>Já possui uma conta? <a href="login.php">Entrar</a></p>
                </div>
            </form>
            <?php
               include_once('../config/conexao.php');

               //VERIFICAR FORM
               if (isset($_POST['cadastrar'])){
                   $nome = $_POST['nome'];
                   $email = $_POST['email'];
                   $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
               
                   // Define o caminho absoluto para o diretório de upload
                   $pasta = __DIR__ . "/../uploads/user/"; 
                   
                   // Define o nome do arquivo para o banco de dados
                   $novoNome = '';
               
                   //VERIFICA FOTO
                   if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])){
                       $formatosPermitidos = array("png", "jpg", "jpeg");
                       $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
               
                       //VERIFICA EXTENSÃO
                       if (in_array(strtolower($extensao), $formatosPermitidos)){
                           $temporario = $_FILES['foto']['tmp_name'];
               
                           if (is_uploaded_file($temporario)) {
                               // Gera um nome único para o arquivo
                               $novoNome = uniqid() . ".$extensao";
               
                               //MOVE PARA O DIRETÓRIO
                               if (move_uploaded_file($temporario, $pasta . $novoNome)){
                                //SUCESSO UPLOAD
                                //echo "<h1>Upload realizado com sucesso!</h1>";
                               }
               
                               else{
                                   //MSG DE ERROR NO FORMATO
                                   //echo "<h1>Erro ao mover o arquivo: " . error_get_last()['message'] . "</h1>";
                                   exit(); // TERMINAR A EXECUÇÃO
                               }
                           }
               
                           else {
                               //echo "<h1>Formato de arquivo não permitido.</h1>";
                               exit(); // Termina a execução em caso de erro
                           }
                       
                       }
                   } else {
                       $novoNome = 'avatar_padrao.jpg'; // Redefine o nome da foto para o padrão
                   }
               
                   //PREPARANDO CONSULTA SQL
                   $cadastro = "INSERT INTO tb_user (foto_user, nome_user, email_user, senha_user) VALUES (:foto, :nome, :email, :senha)";
                   
                   try{
                       $result = $conect->prepare($cadastro);
                       $result->bindParam(':nome', $nome, PDO::PARAM_STR);
                       $result->bindParam(':email', $email, PDO::PARAM_STR);
                       $result->bindParam(':senha', $senha, PDO::PARAM_STR);
                       $result->bindParam(':foto', $novoNome, PDO::PARAM_STR);
                       $result->execute();
                       
                       $contar = $result->rowCount();
               
                       if ($contar > 0) {
                          //MSG DE "DADOS INSERIDOS"
                         // echo "<h1>Img foi inserido</h1>";
                       }
               
                       else{
                           //MSG DE "DADOS NÃO INSERIDOS"
                          // echo "<h1>Img não foi inserido</h1>";
                       }
                   }
                   catch(PDOException $e){
                       //MSG DE ERROR
                       error_log("ERRO DE PDO: " . $e->getMessage());
                       //MSG DE ERROR AO TENTAR INSERIR OS DADOS
                   }
               }
            ?>
        </div>
        <!--animação-->
        <div class="animacao-cadastro">
            <img src="../static/gif/cad_user.svg" alt="Animação de Cadastro">
        </div>
    </section>
    <?php include_once('../include/footer.php') ?>
</body>
</html>
    