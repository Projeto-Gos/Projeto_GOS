<?php
include_once('../include/header.php');

// Sanitização de entrada
$acao = filter_var(isset($_GET['acao']) ? $_GET['acao'] : 'home', FILTER_SANITIZE_STRING);

// Definir caminhos em variáveis
$paginas = [
    'home' => 'conteudos/cadastros/cad_atividades.php',
    'cad_clientes'=>  'conteudos/cadastros/cad_clientes.php',
    'cad_equipamentos' => 'conteudos/cadastros/cad_equipamentos.php',
    'cad_funcionarios' => 'conteudos/cadastros/cad_funcionarios.php',
    'cad_servicos' =>  'conteudos/cadastros/cad_servicos.php',
    'add_atividades' => 'conteudos/add/add_atividades.php',
    'add_clientes' =>  'conteudos/add/add_clientes.php',
    'add_equipamentos' =>  'conteudos/add/add_equipamentos.php',
    'add_funcionarios' =>  'conteudos/add/add_funcionarios.php',
    'add_servicos' =>  'conteudos/add/add_servicos.php',
    'update_atividades' =>  'conteudos/updates/update_atividades',
    'update_clientes' => 'conteudos/updates/update_clientes.php',
    'update_equipamentos' => 'conteudos/updates/update_equipamentos.php',
    'update_funcionarios' => 'conteudos/updates/update_funcionarios.php',
    'update_servicos' => 'conteudos/updates/update_servicos.php',
    'perfil' => 'conteudos/perfil.php',
    'relatorio' => 'conteudos/relatorio.php'
];

// Verificar se a ação existe no array, caso contrário, usar a página padrão
$pagina_incluir = isset($paginas[$acao]) ? $paginas[$acao] : $paginas['home'];

// Incluir a página correspondente
include_once($pagina_incluir);

include_once('../include/footer.php');