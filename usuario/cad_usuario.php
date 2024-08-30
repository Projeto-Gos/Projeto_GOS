<?php
    include_once('config/conexao.php'); // Inclui o arquivo de conexão com o banco de dados

    // Verifica se o formulário foi enviado
    if (isset($_POST['botao'])) {
        // Recebe os dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT); // Usando hash seguro para a senha

        // Verifica se foi enviado algum arquivo de foto
        if (!empty($_FILES['foto']['name'])) {
            $formatosPermitidos = array("png", "jpg", "jpeg"); // Formatos permitidos
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo

            // Verifica se a extensão do arquivo está nos formatos permitidos
            if (in_array(strtolower($extensao), $formatosPermitidos)) {
                $pasta = "img/user/"; // Define o diretório para upload
                $temporario = $_FILES['foto']['tmp_name']; // Caminho temporário do arquivo
                $novoNome = uniqid() . ".$extensao"; // Gera um nome único para o arquivo

                // Move o arquivo para o diretório de imagens
                if (move_uploaded_file($temporario, $pasta . $novoNome)) {
                    // Sucesso no upload da imagem
                } else {
                    echo '<div class="container">
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Erro!</h5>
                                Não foi possível fazer o upload do arquivo.
                            </div>
                        </div>';
                    exit(); // Termina a execução do script após o erro
                }
            } else {
                echo '<div class="container">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Formato Inválido!</h5>
                            Formato de arquivo não permitido.
                        </div>
                    </div>';
                exit(); // Termina a execução do script após o erro
            }
        } else {
            // Define um avatar padrão caso não seja enviado nenhum arquivo de foto
            $novoNome = 'avatar-padrao.png'; // Nome do arquivo de avatar padrão
        }

        // Prepara a consulta SQL para inserção dos dados do usuário
        $cadastro = "INSERT INTO tb_user (foto_user, nome_user, email_user, senha_user) VALUES (:foto, :nome, :email, :senha)";

        try {
            $result = $conect->prepare($cadastro);
            $result->bindParam(':nome', $nome, PDO::PARAM_STR);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->bindParam(':senha', $senha, PDO::PARAM_STR);
            $result->bindParam(':foto', $novoNome, PDO::PARAM_STR);
            $result->execute();
            
            $contar = $result->rowCount();

            if ($contar > 0) {
                echo '<div class="container">
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> OK!</h5>
                            Dados inseridos com sucesso !!!
                        </div>
                    </div>';
            } else {
                echo '<div class="container">
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h5><i class="icon fas fa-check"></i> Erro!</h5>
                            Dados não inseridos !!!
                        </div>
                    </div>';
            }
        } catch (PDOException $e) {
            // Loga a mensagem de erro em vez de exibi-la para o usuário
            error_log("ERRO DE PDO: " . $e->getMessage());
            echo '<div class="container">
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Erro!</h5>
                        Ocorreu um erro ao tentar inserir os dados.
                    </div>
                </div>';
        }
    }
?>