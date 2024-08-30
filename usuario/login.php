<?php
    session_start(); 
  
    // Verifica se o usuário está autenticado (verifica se a sessão está ativa e se o usuário está logado)
    if (isset($_SESSION['loginUser']) && $_SESSION['senhaUser'] === true) {
        // Redireciona para a página home
        header("Location: paginas/home.php");
    }
?>
<!-- -------------------------------------------------------------------------------------------------------------------------------------- -->
<?php
    include_once('config/conexao.php');
                
    // Exibir mensagens com base na ação
    if (isset($_GET['acao'])) {
        $acao = $_GET['acao'];
        if ($acao == 'negado') {
            echo '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Erro ao Acessar o sistema!</strong> Efetue o login ;(</div>';
            
        } elseif ($acao == 'sair') {
            echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Você acabou de sair da Agenda Eletrônica!</strong> :(</div>';
            
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
      
                          echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">×</button>
                          <strong>Logado com sucesso!</strong> Você será redirecionado para a agenda :)</div>';
      
                          header("Refresh: 3; url=paginas/home.php?acao=bemvindo");
                      } else {
                          echo '<div class="alert alert-danger">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <strong>Erro!</strong> Senha incorreta, tente novamente.</div>';
                          header("Refresh: 5; url=index.php");
                      }
                  } else {
                      echo '<div class="alert alert-danger">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>Erro!</strong> E-mail não encontrado, verifique seu login ou faça o cadastro.</div>';
                      header("Refresh: 7; url=index.php");
                  }
              } catch (PDOException $e) {
                  // Log the error instead of displaying it to the user
                  error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
                  echo '<div class="alert alert-danger">
                  <button type="button" class="close" data-dismiss="alert">×</button>
                  <strong>Erro!</strong> Ocorreu um erro ao tentar fazer login. Por favor, tente novamente mais tarde.</div>';
              }
          } else {
              echo '<div class="alert alert-danger">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Erro!</strong> Todos os campos são obrigatórios.</div>';
          }
      }
?>