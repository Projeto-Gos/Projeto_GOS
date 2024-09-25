<?php
if (!isset($_SESSION['loginUser'])) {
  // Redireciona para a página de login com a mensagem de acesso negado
  $link = dirname($_SERVER['PHP_SELF']);
  header("Location: $link/usuario/login.php?acao=negado");
  exit;
}
?>