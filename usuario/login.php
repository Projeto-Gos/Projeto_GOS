<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOS</title>
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="stylesheet" href="../static/css/login.css">

    <!--box link icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!--remix link icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css">
    

</head>

<body>

    <?php include_once('../include/header.php') ?>

    <section>
        <div class="animacao-login">
            <img src="../static/gif/login.svg" alt="Animação de Login">
        </div>

        <div class="login-container">
            <form action="login.php" method="post" class="login-form">

                <h2>Login</h2>

                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email">
                    <i class='bx bxs-user' style='color:#fffcf2'></i>
                </div>

                <div class="form-group">
                    <input type="password" id="password" name="senha" placeholder="Senha">
                    <i class='bx bxs-lock-alt' style='color:#fffcf2'></i>
                </div>

                <button type="submit" class="btn" name="login">Entrar</button>

                <div class="cadastro">
                    <p>Não possui uma conta? <a href="cad_usuario.php">Cadastre-se</a></p>
                </div>
            </form>
            <?php
                include_once('../config/conexao.php');
                            
                // Exibir mensagens com base na ação
                if (isset($_GET['acao'])) {
                    $acao = $_GET['acao'];
                    if ($acao == 'negado') {
                        echo '<strong>Erro ao Acessar o sistema!</strong> Efetue o login ';
                        
                    } elseif ($acao == 'sair') {
                        echo '<strong>Você acabou de sair!</strong>';    
                    }
                }
                
                // Processar o formulário de login
                if (isset($_POST['login'])) {
                    $login = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                    $senha = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
                
                    if ($login && $senha) {
                        $select = "SELECT * FROM tb_user WHERE email_user = :emailLogin";
                
                        try {
                            $resultLogin = $conect->prepare($select);
                            $resultLogin->bindParam(':emailLogin', $login, PDO::PARAM_STR);
                            $resultLogin->execute();
                
                            $verificar = $resultLogin->rowCount();
                            if ($verificar > 0) {
                                $user = $resultLogin->fetch(PDO::FETCH_ASSOC);
                
                                // Verifica a senha
                                if (password_verify($senha, $user['senha_user'])) {
                                    // Criar sessão
                                    $_SESSION['loginUser'] = $login;
                                    $_SESSION['senhaUser'] = $user['id_user'];
                
                                    //echo '<strong>Logado com sucesso!</strong> Você será redirecionado';
                
                                    header("Refresh: 0; url=../paginas/home.php?acao=home");
                                } else {
                                    echo '<strong>Erro!</strong> Senha incorreta, tente novamente.';
                                    header("Refresh: 5; url=../usuario/login.php");
                                }
                            } else {
                                echo '<strong>Erro!</strong> E-mail não encontrado, verifique seu login ou faça o cadastro.';
                                header("Refresh: 5; url=../usuario/login.php");
                            }
                        } catch (PDOException $e) {
                            // Log the error instead of displaying it to the user
                            error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
                            //echo '<strong>Erro!</strong> Ocorreu um erro ao tentar fazer login. Por favor, tente novamente mais tarde.';
                        }
                    } else {
                       // echo '<strong>Erro!</strong> Todos os campos são obrigatórios.';
                    }
                }
            ?>
        </div>
    </section>
    <?php include_once('../include/footer.php') ?>
</body>
</html>