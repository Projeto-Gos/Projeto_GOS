<main>
    <div class="container">
        <section class="profile">
        <div class="profile-info">
            <h2><?php echo $nome_user ?></h2>
            <p><?php echo  $email_user ?></p>
        </div>
        <div class="profile-image">
            <img src="../uploads/<?php echo $url_foto ?>" alt="Foto de Perfil" class="profile-pic" alt="Avatar do Usuário">
        </div>
        </section>

        <section class="edit-profile">
        <h2>Perfil</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
            <label for="name">Nome:</label>
            <input type="text" id="name" name="nome" value="<?php echo $nome_user; ?>">
            </div>
            <div>
            <label for="email">Endereço de E-mail:</label>
            <input type="email" id="email" name="email" value="<?php echo $email_user; ?>">
            </div>
            <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="senha">
            </div>
            <div>
            <label for="avatar">Avatar do Usuário:</label>
            <input type="file" id="avatar" name="foto">
            </div>
            <div class="bnt-perfil">
                <button type="submit" name="upPerfil">Alterar dados do usuário</button>
            </div>
        </form>
        <?php
        include('../config/conexao.php'); // Inclui o arquivo de conexão com o banco de dados

        // Verifica se o formulário foi enviado
        if (isset($_POST['upPerfil'])) {
            // Recebe os dados do formulário
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha_nova = $_POST['senha'];

            // Obter os valores antigos do banco de dados
            $query = "SELECT email_user, senha_user FROM tb_user WHERE id_user=:id";
            $stmt = $conect->prepare($query); // Prepara a consulta SQL
            $stmt->bindParam(':id', $id_user, PDO::PARAM_STR); // Vincula o parâmetro ID do usuário
            $stmt->execute(); // Executa a consulta
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // Busca os resultados como um array associativo
            $email_antigo = $row['email_user']; // Armazena o email antigo
            $senha_antiga = $row['senha_user']; // Armazena a senha antiga

            // Verificar se existe imagem para fazer o upload
            if (!empty($_FILES['foto']['name'])) {
            $formatP = array("png", "jpg", "jpeg", "gif"); // Formatos permitidos para upload
            $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION); // Obtém a extensão do arquivo

            // Verifica se a extensão do arquivo está nos formatos permitidos
            if (in_array($extensao, $formatP)) {
                $pasta = "../uploads/user/"; // Define o diretório de upload
                $temporario = $_FILES['foto']['tmp_name']; // Caminho temporário do arquivo
                $novoNome = uniqid() . ".{$extensao}"; // Gera um nome único para o arquivo

                // Excluir a imagem antiga se ela existir
                if (file_exists($pasta . $foto_user)) {
                unlink($pasta . $foto_user); // Remove o arquivo antigo
                }
                // Move o novo arquivo para o diretório de upload
                if (move_uploaded_file($temporario, $pasta . $novoNome)) {
                // Sucesso no upload da nova imagem
                } else {
                $mensagem = "Erro, não foi possível fazer o upload do arquivo!"; // Mensagem de erro
                }
            }else {
                    echo "Formato inválido"; // Mensagem de erro para formato de arquivo inválido
                }
            }else{
            $novoNome = $foto_user;
            }

            // Verificar se a senha foi alterada
            if (!empty($senha_nova)) {
            $senha = password_hash($senha_nova, PASSWORD_DEFAULT); // Hash seguro para a nova senha
            }else{
            $senha = $senha_antiga; // Mantém a senha antiga
            }

            // Atualizar o banco de dados
            $update = "UPDATE tb_user SET foto_user=:foto, nome_user=:nome, email_user=:email, senha_user=:senha WHERE id_user=:id";
            try {
            // Prepara a consulta de atualização
            $result = $conect->prepare($update);
            $result->bindParam(':id', $id_user, PDO::PARAM_STR); // Vincula o ID do usuário
            $result->bindParam(':foto', $novoNome, PDO::PARAM_STR); // Vincula o novo nome da foto
            $result->bindParam(':nome', $nome, PDO::PARAM_STR); // Vincula o nome do usuário
            $result->bindParam(':email', $email, PDO::PARAM_STR); // Vincula o email do usuário
            $result->bindParam(':senha', $senha, PDO::PARAM_STR); // Vincula a senha codificada do usuário
            $result->execute(); // Executa a consulta

            $contar = $result->rowCount(); // Conta o número de linhas afetadas
            if($contar > 0){
                echo '<script>alert("Perfil Atualizado")</script>';

            // Verificar se tanto o email quanto a senha foram alterados
            if ($email !== $email_antigo || $senha !== $senha_antiga) {
                header("Location: ?sair"); // Redireciona para sair se email ou senha foram alterados
                exit(); // Garante que o redirecionamento ocorra
            } else {
                header("Refresh: 0; home.php?acao=perfil"); // Redireciona de volta ao perfil após 3 segundos
                exit(); // Garante que o redirecionamento ocorra
            }
            }else{
                // Mensagem de erro se nenhum dado foi atualizado
                echo '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h5><i class="icon fas fa-times"></i> Erro !!!</h5>
                Perfil não foi atualizado.
            </div>';
            }
            } catch (PDOException $e) {
            // Mensagem de erro para exceções PDO
            echo "<strong>ERRO DE PDO= </strong>" . $e->getMessage();
            }
        }
        ?>
        </section>
    </div>
</main>
