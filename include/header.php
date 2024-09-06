<?php
// Inicia o buffer de saída
ob_start();

// Inicia a sessão apenas se ainda não tiver sido iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se as variáveis de sessão estão definidas
if (!isset($_SESSION['loginUser'])) {
    // Redireciona para a página inicial com a mensagem de acesso negado
    header("Location: ../login.php?acao=negado");
    exit;
}

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
    } else {
        // Exibe uma mensagem de aviso se não houver dados de perfil
        echo '<strong>Aviso!</strong> Não há dados de perfil';
    }
} catch (PDOException $e) {
    // Registra a mensagem de erro no log do servidor em vez de exibi-la ao usuário
    error_log("ERRO DE LOGIN DO PDO: " . $e->getMessage());
    
    // Exibe uma mensagem de erro genérica para o usuário
    echo '<strong>Aviso!</strong> Ocorreu um erro ao tentar acessar os dados do perfil.';
}
?>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <a href="index.php" class="logo">
                <img src="../static/img/logo_coral.svg" alt="Logo" />
            </a>
            
            <ul class="nav-links">
                <li><a href="index.php">Início</a></li>
                <li><a href="#about">Atividades</a></li>
                <li><a href="#services">Cadastros</a></li>
                <li><a href="#contact">Relatório</a></li>
            </ul>

            <div class="entrar">
                <a href="login.php">Entrar</a> 
            </div>
        </nav>
    </header>