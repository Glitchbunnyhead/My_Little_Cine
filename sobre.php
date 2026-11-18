<?php 
    session_start();
    require_once "conexao/conexao.php"; 


?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/em_cartaz_icone.png" type="image/png">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href="css/estilo.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/sobre.css" type="text/css" media="all">

    <title>My Little Cine</title>
</head>
<body>
    <header>
        <h2 class="nav-titulo">My Little Cine</h2>
          <nav class="nav-container">
            <a href="index_usuario.php" class="nav-logo">
                <img src="imagens/home_icone.png" alt="Logo">
            </a>
            <?php if ($_SESSION["tipo"] == "admin"): ?>
                <a href="admin/index_admin.php" class="nav-link btn">Administração</a>
            <?php endif; ?>
            <a href="perfil.php" class="nav-link">Meu Perfil</a>
            <a href="filmes.php" class="nav-link">Filmes</a>
            <a href="logout.php" class="nav-link">Logout</a>
            <a href="sobre.php" class="nav-link">Sobre</a>
        </nav>
    </header>

    <main>
        <section class="sobre">
            <div class="sobre_conteudo">

                <h2 class="nav-titulo">Sobre o My Little Cine</h2>
                
                <p>Para nós, ir ao cinema não é apenas assistir filmes. Cinema, trata-se de uma experiência, de criar memórias e laços que duram para toda vida. Com esse propósito, a My Little Cine surgiu para garantir a experiência do nosso cliente. Se você acha que cinco salas com poltronas reclináveis de couro legítimo, uma tela 12K extra large ultra plus e som de alta resolução ainda é pouco, temos também nossas salas Premium, com suporte a 3D, som 360 e poltronas equipadas que acompanham os movimentos do filme, que garantem máxima imersão. Claro, antes de ir para a aventura audiovisual, é necessário levar todos os suprimentos necessários. Pensando nisso, oferecemos para nossos clientes a My Little Shop, uma loja com uma variedade enorme de guloseimas personalizadas, além de bebidas e brindes temáticos dos filmes em exibição. Nossos funcionários super educados estão sempre dispostos a atendê-los, garantindo que ninguém se perca em nossa viagem a outros universos. Apertem os cintos, que nossa jornada está prestes a começar!
                </p>

            </div>
        </section>
    </main>

    <footer>
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2026 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
</body>
</html>