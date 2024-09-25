<?php
    include('../../../config/conexao.php');

    if(isset($_GET['idDelete'])){
        $id = $_GET['idDelete'];

            $delete = "DELETE FROM tb_cliente WHERE id_cliente=:id";
            try {
                $result = $conect->prepare($delete);
                $result->bindValue(':id', $id, PDO::PARAM_INT);
                $result->execute();

                $contar = $result->rowCount();
                if ($contar > 0) {
                    header("Location: ../../home.php?acao=cad_clientes");
                } else {
                    header("Location: ../../home.php?acao=cad_clientes");
                }
            } catch (PDOException $e) {
                echo "<strong>ERRO DE DELETE: </strong>" . $e->getMessage();
            }
    } 
    else {
        // Redireciona se o registro não for encontrado
        echo '<script>alert("<strong>Cliente Não Encontrado</strong>")</script>';
        header("Location: ../home.php?acao=cad_clientes");
    }       
?>