<?php
include_once('../includes/header.php');

// Sanitização de entrada
$acao = filter_var(isset($_GET['acao']) ? $_GET['acao'] : 'home', FILTER_SANITIZE_STRING);

// Definir caminhos em variáveis
$paginas = [
    'home' => 'conteudos/cadastros/cad_atividades.php',
    'editar' => 'conteudos/update_contato.php',
    'perfil' => 'conteudos/perfil.php',
    'relatorio' => 'conteudos/relatorio.php'
];

// Verificar se a ação existe no array, caso contrário, usar a página padrão
$pagina_incluir = isset($paginas[$acao]) ? $paginas[$acao] : $paginas['logado'];

// Incluir a página correspondente
include_once($pagina_incluir);

include_once('../includes/footer.php');