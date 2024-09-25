<?php
// Inicia o buffer de saída
ob_start();

// Inicia a sessão apenas se ainda não tiver sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se as variáveis de sessão estão definidas
if (!isset($_SESSION['loginUser'])) {
    // Redireciona para a página de login com a mensagem de acesso negado
    header("Location: ../usuario/login.php?acao=negado");
    exit;
}
// SAIR DO CONTA
include_once('sair.php');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOS</title>
    <link rel="stylesheet" href="../static/css/style.css">
    <link rel="shortcut icon" type="image/x-icon" href="../static/img/logo_coral.ico">
    <!-- PAGINA DE CADASTRO ATIVIDADE -->
    <?php
      $UrlAtualCad = $_SERVER['REQUEST_URI'];
      $path = parse_url($UrlAtualCad, PHP_URL_PATH);
      $query = parse_url($UrlAtualCad, PHP_URL_QUERY);
      
      $paginasCad = array('home.php?acao=home',);
      
      $urlToCompare = $path . '?' . $query;
      foreach ($paginasCad as $paginaCad) {
          if (strpos($urlToCompare, $paginaCad) !== false) {
              echo '<link rel="stylesheet" href="../static/css/cad_atividade.css">';
              break;
          }
      }
    ?>
    <!-- PAGINAS DE CADASTROS -->
    <?php
      $UrlAtualCad = $_SERVER['REQUEST_URI'];
      $path = parse_url($UrlAtualCad, PHP_URL_PATH);
      $query = parse_url($UrlAtualCad, PHP_URL_QUERY);
      
      $paginasCad = array('home.php?home','home.php?acao=cad_clientes','home.php?acao=cad_equipamentos', 'home.php?acao=cad_funcionarios', 'home.php?acao=cad_servicos');
      
      $urlToCompare = $path . '?' . $query;
      foreach ($paginasCad as $paginaCad) {
          if (strpos($urlToCompare, $paginaCad) !== false) {
              echo '<link rel="stylesheet" href="../static/css/cad_table.css">';
              break;
          }
      }
    ?>
    <!-- PAGINA DE ADD ATIVIDADE -->
    <?php
      $UrlAtualCad = $_SERVER['REQUEST_URI'];
      $path = parse_url($UrlAtualCad, PHP_URL_PATH);
      $query = parse_url($UrlAtualCad, PHP_URL_QUERY);
      
      $paginasCad = array('home.php?acao=add_atividades',);
      
      $urlToCompare = $path . '?' . $query;
      foreach ($paginasCad as $paginaCad) {
          if (strpos($urlToCompare, $paginaCad) !== false) {
              echo '<link rel="stylesheet" href="../static/css/add_atividade.css">';
              break;
          }
      }
    ?>
    <!-- PAGINAS DE ADD -->
    <?php
        $UrlAtualAdd = $_SERVER['REQUEST_URI'];
        $path = parse_url($UrlAtualAdd, PHP_URL_PATH);
        $query = parse_url($UrlAtualAdd, PHP_URL_QUERY);
        
        $paginasCad = array('home.php?acao=add_equipamentos',  'home.php?acao=add_clientes', 'home.php?acao=add_funcionarios', 'home.php?acao=add_servicos');
        
        $urlToCompare = $path . '?' . $query;
        foreach ($paginasCad as $paginaCad) {
            if (strpos($urlToCompare, $paginaCad) !== false) {
                echo '<link rel="stylesheet" href="../static/css/add_form.css">';
                break;
            }
        }
    ?>
    <!-- PAGINAS DE UPDATE -->
    <?php
        $UrlAtualUpdate = $_SERVER['REQUEST_URI'];
        $path = parse_url($UrlAtualUpdate, PHP_URL_PATH);
        $query = parse_url($UrlAtualUpdate, PHP_URL_QUERY);
        
        $paginasCad = array('home.php?acao=update_equipamentos',  'home.php?acao=update_clientes', 'home.php?acao=update_funcionarios', 'home.php?acao=update_servicos');
        
        $urlToCompare = $path . '?' . $query;
        foreach ($paginasCad as $paginaCad) {
            if (strpos($urlToCompare, $paginaCad) !== false) {
                echo '<link rel="stylesheet" href="../static/css/update_form.css">';
                break;
            }
        }
    ?>
    <!-- UPDATE ATIVIDADE -->
    <?php
        $UrlAtualUpdate = $_SERVER['REQUEST_URI'];
        $path = parse_url($UrlAtualUpdate, PHP_URL_PATH);
        $query = parse_url($UrlAtualUpdate, PHP_URL_QUERY);
        
        $paginasCad = array('home.php?acao=update_atividades');
        
        $urlToCompare = $path . '?' . $query;
        foreach ($paginasCad as $paginaCad) {
            if (strpos($urlToCompare, $paginaCad) !== false) {
                echo '<link rel="stylesheet" href="../static/css/update_atividade.css">';
                break;
            }
        }
    ?>
    <?php
        $UrlAtualPerfil = $_SERVER['REQUEST_URI'];
        $path = parse_url($UrlAtualPerfil, PHP_URL_PATH);
        $query = parse_url($UrlAtualPerfil, PHP_URL_QUERY);
        
        $paginaPerfil = array('home.php?acao=perfil');
        
        $urlToCompare = $path . '?' . $query;
        foreach ($paginaPerfil as $paginaPerfil) {
            if (strpos($urlToCompare, $paginaPerfil) !== false) {
                echo '<link rel="stylesheet" href="../static/css/perfil.css">';
                break;
            }
        }
    ?>

    <!--box link icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!--remix link icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"> 
</head>
<body>

    <header>
    <?php
        include_once('../config/conexao.php');

        // Obtém o email do usuário logado a partir da sessão
        $usuarioLogado = $_SESSION['loginUser'];

        // Define a consulta SQL para selecionar todos os campos do usuário com base no email
        $selectUser = "SELECT * FROM tb_user WHERE email_user=:emailUserLogado";

        try {
            // Prepara a consulta SQL
            $resultadoUser = $conect->prepare($selectUser);
            
            // Vincula o parâmetro :emailUserLogado ao valor da variável $usuarioLogado
            $resultadoUser->bindParam(':emailUserLogado', $usuarioLogado, PDO::PARAM_STR);
            
            // Executa a consulta preparada
            $resultadoUser->execute();

            // Conta o número de linhas retornadas pela consulta
            $contar = $resultadoUser->rowCount();
            
            // Se houver uma ou mais linhas retornadas
            if ($contar > 0) {
                // Obtém a próxima linha do conjunto de resultados como um objeto
                $show = $resultadoUser->fetch(PDO::FETCH_OBJ);
                
                // Atribui os valores dos campos do usuário às variáveis PHP
                $id_user = $show->id_user;
                $foto_user = $show->foto_user;
                $nome_user = $show->nome_user;
                $email_user = $show->email_user;
                if ($foto_user == 'avatar_padrao.jpg'){
                    $url_foto = 'avatar_p/'.$foto_user;
                }
                else{
                    $url_foto = 'user/'.$foto_user;
                }
            } else {
                // Exibe uma mensagem de aviso se não houver dados de perfil
               // echo '<strong>Aviso!</strong> Não há dados de perfil';
            }
        } catch (PDOException $e) {
            // Registra a mensagem de erro no log do servidor em vez de exibi-la ao usuário
            //error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
            
            // Exibe uma mensagem de erro genérica para o usuário
            echo '<strong>Aviso!</strong> Ocorreu um erro ao tentar acessar os dados do perfil.';
        }
        ?>
        <nav class="navbar">
            <a href="../index.php" class="logo">
                <img src="../static/img/logo_coral.svg" alt="Logo">
            </a>
       
            <ul class="nav-links">
                <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=home">Atividades</a></li>
                <li class="dropdown">
                    <a href="#">Cadastros</a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=cad_clientes">Clientes</a></li>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=cad_equipamentos">Equipamentos</a></li>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=cad_funcionarios">Funcionários</a></li>
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=cad_servicos">Serviços</a></li>
                    </ul>
                </li>
                <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=relatorio">Relatório</a></li>
            </ul>
            <ul class="dropdown">
                <li>
                    <a href="#" class="profile-menu">
                        <img src="../uploads/<?php echo $url_foto ?>" alt="Foto de Perfil" class="profile-pic">
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="<?php echo dirname($_SERVER['PHP_SELF']) ?>/home.php?acao=perfil">Configurações</a></li>
                        <li><a href="?sair">Sair</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
</header>