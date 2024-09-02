<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GOS</title>
    <link rel="stylesheet" href="static/css/style.css">
    <link rel="stylesheet" href="static/css/cad_user.css">

    <!--box link icons-->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!--remix link icons-->
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
    

</head>

<body>

    <header>
        <nav class="navbar">
            <a href="index.html" class="logo">
                <img src="static/img/logo_coral.svg" alt="Logo" />
            </a>
            
            <ul class="nav-links">
                <li><a href="index.html">Início</a></li>
                <li><a href="#about">Atividades</a></li>
                <li><a href="#services">Cadastros</a></li>
                <li><a href="#contact">Relatório</a></li>
            </ul>

            <div class="entrar">
                <a href="login.html">Entrar</a> 
            </div>
        </nav>
    </header>

    <section>

        <!--formulário-->
        <div class="cadastro-container">
            <form action="cadastro.php" method="post" class="cadastro-form" enctype="multipart/form-data">
    
                <h2>Cadastro</h2>
    
                <div class="form-group">
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                    <i class='bx bxs-camera' style='color:#fffcf2'></i>
                </div>
    
                <div class="form-group">
                    <input type="text" id="nome" name="nome" placeholder="Nome" required>
                    <i class='bx bxs-user' style='color:#fffcf2'></i>
                </div>
    
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Email" required>
                    <i class='bx bxs-envelope' style='color:#fffcf2'></i>
                </div>
    
                <div class="form-group">
                    <input type="password" id="senha" name="senha" placeholder="Senha" required>
                    <i class='bx bxs-lock-alt' style='color:#fffcf2'></i>
                </div>
    
                <button type="submit" class="cadastro-btn">Cadastrar</button>
    
                <div class="login">
                    <p>Já possui uma conta? <a href="login.html">Entrar</a></p>
                </div>
            </form>
        </div>
        <!--animação-->
        <div class="animacao-cadastro">
            <img src="static/gif/cad_user.svg" alt="Animação de Cadastro">
        </div>
    </section>
    
    <footer>
        <div class="footer-container">
            <div class="footer-box">
                <h3>GOS</h3>
                <p>É tudo uma questão de seus sonhos.</p>
                <div class="icons-sociais">
                    <a href="#"><i class="bx bxl-instagram"></i></a>
                    <a href="#"><i class="bx bxl-facebook"></i></a>
                    <a href="#"><i class="bx bxl-whatsapp"></i></a>
                </div>
            </div>
            
            <div class="footer-box">
                <h3>Navegação</h3>
                <ul>
                    <li><a href="#">Início</a></li>
                    <li><a href="#">Atividades</a></li>
                    <li><a href="#">Cadastros</a></li>
                    <li><a href="#">Relatório</a></li>
                </ul>
            </div>
            
            <div class="footer-box">
                <h3>Suporte</h3>
                <ul>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Central de Ajuda</a></li>
                    <li><a href="#">Contato</a></li>
                </ul>
            </div>
            
            <div class="footer-box">
                <h3>Inscreva-se</h3>
                <p>Digite seu e-mail para ser notificado sobre nossas notícias</p>
                <div class="inscreva-form">
                    <input type="email" placeholder="Seu email" required>
                    <button type="submit"><i class="bx bx-envelope" style="color: #191B24; font-size: 15px;" ></i></button>
                </div>
            </div>
        </div>
        <div class="footer-btn">
            <p>© 2024 todos os direitos reservados</p>
        </div>
    </footer>
</body>
</html>
    