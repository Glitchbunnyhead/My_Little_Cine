<?php 
    session_start();
    require_once "conexao/conexao.php";

    $sqlFilmes = "SELECT * FROM Filme ;";
    $stmtFilmes = $conn->prepare($sqlFilmes);
    $stmtFilmes->execute();
    $resultadoFilmes = $stmtFilmes->get_result();
    $filmes = $resultadoFilmes->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/home_icone.png" type="image/png">
    <!-- Importando fonte -->
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href="css/estilo.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/filmes.css" type="text/css" media="all">

    <title>My Little Cine</title>
</head>
<body>
    <header>
        <h2 class="nav-titulo">My Little Cine</h2>
        <nav class="nav-container">
            <a href="#" class="nav-logo">
                <img src="imagens/home_icone.png" alt="Logo">
            </a>
            <?php if ($_SESSION["tipo"] == "admin"): ?>
                <a href="index_admin.php" class="nav-link btn">Administração</a>
            <?php endif; ?>
            <a href="perfil.php" class="nav-link">Meu Perfil</a>
            <a href="filmes.php" class="nav-link">Filmes</a>
            <a href="logout.php" class="nav-link">Logout</a>
            <a href="sobre.php" class="nav-link">Sobre</a>
        </nav>
    </header>

    <main>
        <div class = "filmes-cartaz">
            <h2>Filmes em Cartaz</h2>
            <div class="filmes-cartaz-caixas">
               <?php if (count($filmes) > 0): ?>
                    <?php foreach ($filmes as $filme): ?>
                        <div class="filme-card-item">

                            <img src="<?php echo htmlspecialchars($filme['poster'] ?? ''); ?>"  class = "filme-poster" alt="Poster do filme">
                            <div class="filme-info">
                                <h3><?php echo htmlspecialchars($filme['titulo'] ?? ''); ?></h3>
                                <p class="filme-meta">
                                    <span class="badge-classificacao"><?php echo htmlspecialchars($filme['classificacao_etaria'] ?? 'L'); ?></span>
                                    <span>Ano: <?php echo $filme['ano_lancamento']; ?></span> | 
                                    <span>Duração: <?php echo $filme['duracao_minutos']; ?> min</span>
                                </p>
                                <p class="filme-sinopse"><strong>Sinopse:</strong> <?php echo htmlspecialchars($filme['sinopse'] ?? ''); ?></p>
                                <div class="filme-acoes">
                                    <a href="sessao.php?id=<?php echo $filme['id'] ?? 0; ?>" class="btn-comprar">Comprar Ingressos</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #b3b3b3;">Nenhum filme em cartaz no momento.</p>
                <?php endif; ?>    
                 
        </div>       

    </main>

     <footer>
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2026 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
</body>
</html> 