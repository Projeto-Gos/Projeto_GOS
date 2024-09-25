<?php
    include('../../../config/conexao.php');

    if(isset($_GET['idDelete'])){
        $id = $_GET['idDelete'];

            $delete = "DELETE FROM tb_equipamento WHERE id_equipamento=:id";
            try {
                $result = $conect->prepare($delete);
                $result->bindValue(':id', $id, PDO::PARAM_INT);
                $result->execute();

                $contar = $result->rowCount();
                if ($contar > 0) {
                    header("Location: ../../home.php?acao=cad_equipamentos");
                } else {
                    header("Location: ../../home.php?acao=cad_equipamentos");
                }
            } catch (PDOException $e) {
                echo "<strong>ERRO DE DELETE: </strong>" . $e->getMessage();
            }
    } 
    else {
        // Redireciona se o registro não for encontrado
        echo '<script>alert("<strong>Equipamento Não Encontrado</strong>")</script>';
        header("Location: ../home.php?acao=cad_equipamentos");
    }       
?>