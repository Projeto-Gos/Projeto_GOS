<?php
  session_start(); 

  // Verifica se o usuário está autenticado (verifica se a sessão está ativa e se o usuário está logado)
  if (isset($_SESSION['loginUser']) && $_SESSION['senhaUser'] === true) {
      // Redireciona para a página home
      header("Location: ../paginas/home.php");
  }
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOS</title>
    <link rel="stylesheet" href="../static/css/style_naoLogado.css">
    <link rel="stylesheet" href="../static/css/login.css">

    <!--box link icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!--remix link icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css">
</head>

<body>

    <header>
        <nav class="navbar">
                <a href="../index.php" class="logo">
                    <img src="../static/img/logo_coral.svg" alt="Logo">
                </a>

                <div class="entrar">
                    <a href="../usuario/login.php">Entrar</a> 
                </div>
        </nav>
    </header>

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
                        echo '<script>alert("Erro ao Acessar o sistema! Efetue o login")</script>';
                        
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
                                    //echo '<strong>Erro!</strong> Senha incorreta, tente novamente.';
                                    header("Refresh: 1; url=login.php?acao=negado");
                                }
                            } else {
                                //echo '<strong>Erro!</strong> E-mail não encontrado, verifique seu login ou faça o cadastro.';
                                header("Refresh: 1; url=login.php?acao=negado");
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

    <footer>
        <div class="footer-container">
            <div class="footer-box">
                <h3>GOS</h3>
                <p>É tudo uma questão de seus sonhos.</p>
                <div class="icons-sociais">
                    <a href="#"><i class="bx bxl-instagram"></i></a>
                    <a href="#"><i class="bx bxl-facebook"></i></a>
                    <a href="#"><i class="bx bxl-whatsapp"></i></a>
                </div>
            </div>
            
            <div class="footer-box">
                <h3>Navegação</h3>
                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Atividades</a></li>
                    <li><a href="#">Cadastros</a></li>
                    <li><a href="#">Relatório</a></li>
                </ul>
            </div>
            
            <div class="footer-box">
                <h3>Suporte</h3>
                <ul>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Central de Ajuda</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>
            
            <div class="footer-box">
                <h3>Inscreva-se</h3>
                <p>Digite seu e-mail para ser notificado sobre nossas notícias</p>
                <div class="inscreva-form">
                    <input type="email" placeholder="Seu email" required>
                    <button type="submit"><i class="bx bx-envelope" style="color: #191B24; font-size: 15px;" ></i></button>
                </div>
            </div>
        </div>
        <div class="footer-btn">
            <p>© 2024 todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html>