<?php 
    session_start();
    require_once "conexao/conexao.php";

    $sqlFilmes = "SELECT * FROM Filme";
    $stmtFilmes = $conn->prepare($sqlFilmes);
    $stmtFilmes->execute();
    $resultadoFilmes = $stmtFilmes->get_result();
    $filmes = $resultadoFilmes->fetch_all(MYSQLI_ASSOC);

    $sqlProdutos = "SELECT * FROM Produto";
    $stmtProdutos = $conn->prepare($sqlProdutos);
    $stmtProdutos->execute();
    $resultadoProdutos = $stmtProdutos->get_result();
    $produtos = $resultadoProdutos->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/home_icone.png">
    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href="" type="text/css" media="all">
    <title>My Little Cine</title>
</head>
<body>
    <header>
        <h2 class="nav-titulo">My Little Cine</h2>
        <nav class="nav-container">
            <a href="#" class="nav-logo">
                <img src="imagens/home_icone.png" alt="Logo">
            </a>
            <?php if (isset($_SESSION["usuario"])): ?>
                <a href="perfil.php" class="nav-link">Meu Perfil</a>
                <a href="filmes.php" class="nav-link">Filmes</a>
                <a href="sair.php" class="nav-link">Logout</a>

                <?php if ($_SESSION["usuario_tipo"] == "admin"): ?>
                    <a href="index_admin.php" class="nav-link">Administração</a>
                <?php endif; ?>

            <?php else: ?>
                <a href="login.php" class="nav-link">Login</a>
                <a href="cadastro.php" class="nav-link">Cadastro</a>
            <?php endif; ?>
            <a href="sobre.php" class="nav-link">Sobre</a>
        </nav>
    </header>

    <main>
       <section class="hero">
            <div class="hero-conteudo">
                <h2>Bem-vindo ao My Little Cine</h2>
                <p>O melhor lugar para assistir aos seus filmes favoritos!</p>
                <div class="hero-image"></div>
            </div>
        </section>

        <section class="filmes">
            <div class="filmes-content">
                <h2>Filmes em Cartaz</h2>
                <a href="filmes.php" class="filmes-link">Veja os filmes</a>
            </div>

            <!-- Container do Carrossel de Filmes -->
            <div class="carrossel-filmes">
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
            <div class="produtos-conteudo">
                <h2>Guloseimas e Bebidas</h2>
            </div>

            <!-- Container do Carrossel de Produtos -->
            <div class="carrossel-produtos">
            
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