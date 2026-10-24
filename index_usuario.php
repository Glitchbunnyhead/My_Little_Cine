<?php 
    session_start();
    require_once "conexao/conexao.php";

    $sqlFilmes = "SELECT * FROM Filme";
    $stmtFilmes = $conn->prepare($sqlFilmes);
    $stmtFilmes->execute();
    $resultadoFilmes = $stmtFilmes->get_result();
    $filmes = $resultadoFilmes->fetch_all(MYSQLI_ASSOC);

    $sqlprodutos = "SELECT * FROM Produto";
    $stmtprodutos = $conn->prepare($sqlprodutos);
    $stmtprodutos->execute();
    $resultadoprodutos = $stmtprodutos->get_result();
    $produtos = $resultadoprodutos->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/home_icone.png">
    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href="css/home.css" type="text/css" media="all">
    <title>My Little Cine</title>
</head>
<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>
        <nav class="nav_container">
            <a href="#" class="nav__logo">
                <img src="imagens/home_icone.png" alt="Logo">
            </a>
            <?php if (isset($_SESSION["usuario"])): ?>
                <a href="perfil.php" class="nav_link">Meu Perfil</a>
                <a href="filmes.php" class="nav_link">Em Cartaz</a>
                <a href="produtos.php" class="nav_link">SnackBar</a>
                <a href="sair.php" class="nav_link">Logout</a>

                <?php if ($_SESSION["usuario_tipo"] == "admin"): ?>
                    <a href="admin.php" class="nav_link">Administração</a>
                <?php endif; ?>

            <?php else: ?>
                <a href="login.php" class="nav_link">Login</a>
                <a href="cadastro.php" class="nav_link">Cadastro</a>
            <?php endif; ?>
            <a href="sobre.php" class="nav_link">Sobre</a>
        </nav>
    </header>

    <main>
       <section class="hero">
            <div class="hero__conteudo">
                <h2>Bem-vindo ao My Little Cine</h2>
                <p>O melhor lugar para assistir aos seus filmes favoritos!</p>
                <div class="hero_image"></div>
            </div>
        </section>

        <section class="em__cartaz">
            <div class="em__cartaz__content">
                <h2>Em Cartaz</h2>
                <p>Confira os filmes que estão em cartaz no momento!</p>
                <a href="filmes.php" class="em__cartaz__link">Veja os filmes</a>
            </div>

            <!-- Container do Carrossel de Filmes -->
            <div class="carrossel__filmes">
               <?php if (count($filmes) > 0): ?>
                    <?php foreach ($filmes as $filme): ?>
                        <div class="card-filme">
                            <img src="<?php echo htmlspecialchars($filme['poster']); ?>" alt="Poster do filme">
                            <div class="card-info">
                                <h3><?php echo htmlspecialchars($filme['titulo']); ?></h3>
                                <p><?php echo htmlspecialchars($filme['sinopse']); ?> - <?php echo $filme['duracao_minutos']; ?> min</p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #b3b3b3;">Nenhum filme em cartaz no momento.</p>
                <?php endif; ?>
            </div>
        </section>

        <section class="produtos">
            <div class="produtos__content">
                <h2>produtos e Bebidas</h2>
                <p>Deliciosos produtos e bebidas para acompanhar seu filme!</p>
                <a href="produtos.php" class="produtos__link">Confira nosso cardápio</a>
            </div>

            <!-- Container do Carrossel de produtos -->
            <div class="carrossel_produtos">
               <?php if (count($produtos) > 0): ?>
                    <?php foreach ($produtos as $snack): ?>
                        <div class="card-produtos">
                            <div class="produtos-info">
                                <h3><?php echo htmlspecialchars($produtos['nome']); ?></h3>
                                <img src="<?php echo htmlspecialchars($produtos['foto']); ?>" alt="Foto do produtos">
                                <p><?php echo htmlspecialchars($produtos['descricao']); ?> R$ <?php echo number_format($produtos['preco'], 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #b3b3b3;">Nenhum snack ou produto disponível no momento.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2025 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
</body>
</html>