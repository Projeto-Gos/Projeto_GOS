<?php
if(isset($_REQUEST['sair'])){
    session_destroy();
    header("Location: ../usuario/login.php?acao=sair");
}