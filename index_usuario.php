<?php 
    session_start();
    require_once "conexao/conexao.php";
    $sqlFilmes = "SELECT * FROM Filme";
    $stmtFilmes = $conn->prepare($sqlFilmes);
    $stmtFilmes->execute();
    $resultadoFilmes = $stmtFilmes->get_result();
    $filmes = $resultadoFilmes->fetch_all(MYSQLI_ASSOC);
    $sqlSnacks = "SELECT * FROM Produto";
    $stmtSnacks = $conn->prepare($sqlSnacks);
    $stmtSnacks->execute();
    $resultadoSnacks = $stmtSnacks->get_result();
    $snacks = $resultadoSnacks->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/home_icone.png">
    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href = "css/home.css" type = "text/css" media ="all">
    <title>My Little Cine</title>
</head>
<body>
    <header>
        <h2>My Little Cine</h2>
        <nav class = "nav_container">
            <a href="#" class="nav__logo">
                <img src="imagens/home_icone.png" alt="Logo">
            </a>
            <?php if (isset($_SESSION["usuario_id"])): ?>
                <a href="perfil.php" class = "nav__link">Meu Perfil</a>
                <a href="em_cartaz.php" class = "nav__link">Em Cartaz</a>
                <a href="snacks.php" class = "nav__link">SnackBar</a>
                <a href="sair.php" class = "nav__link">Logout</a>

                <?php if ($_SESSION["usuario_tipo"] == "admin"): ?>
                    <a href="admin.php" class = "nav__link">Administração</a>
                <?php endif; ?>

            <?php else: ?>
                <a href="login.php" class = "nav__link">Login</a>
                <a href="cadastro.php" class = "nav__link">Cadastro</a>

            <?php endif; ?>
            <a href="sobre.php" class = "nav__link">Sobre</a>
        </nav>
    </header>
    <main>
       <section class = "hero">
            <div class = "hero__content">
                <h1>Bem-vindo ao My Little Cine</h1>
                <p>O melhor lugar para assistir aos seus filmes favoritos!</p>
                <div class = "hero_image">
                <!-- inserir aqui algum cartaz de filme-->
                </div>
            </div>
        </section>

        <section class = "em_cartaz">
            <div class = "em_cartaz__content">
                <h2>Em Cartaz</h2>
                <p>Confira os filmes que estão em cartaz no momento!</p>
                <a href="em_cartaz.php" class = "em_cartaz__link">Veja os filmes</a>
            </div>
            <div class = "carrossel_filmes">
               <?php if (count($filmes) > 0): 
                    foreach ($filmes as $filme): ?>
                        <div class="card-filme">
                            <img src="<?php echo htmlspecialchars($filme['poster']); ?>">
                                <div class="card-info">
                                    <h3><?php echo htmlspecialchars($filme['titulo']); ?></h3>
                                    <p><?php echo htmlspecialchars($filme['sinopse']); ?> <?php echo $filme['duracao_minutos']; ?> min</p>
                            </div>
                        <?php endforeach; 
                    else: ?>
                        <p style="color: #b3b3b3;">Nenhum filme em cartaz no momento.</p>
                    <?php endif; ?>
                </div>
            </div>
            
        </section>

        <section class = "snacks">
            <div class = "snacks__content">
                <h2>Snacks e Bebidas</h2>
                <p>Deliciosos snacks e bebidas para acompanhar seu filme!</p>
                <a href="snacks.php" class = "snacks__link">Confira nosso cardápio</a>
            </div>

            <div class ="carrossel_snacks"></div>
             <?php if (count($snacks) > 0): 
                    foreach ($snacks as $snack): ?>
                        <div class="card-snack">
                            <div class="snack-info">
                                    <h3><?php echo htmlspecialchars($snack['nome']); ?></h3>
                                    <img src="<?php echo htmlspecialchars($snack['foto']); ?>">
                                    <p><?php echo htmlspecialchars($snack['descricao']); ?> • R$ <?php echo number_format($snack['preco'], 2, ',', '.'); ?></p>
                                </div>
                            
                                
                        </div>
                    <?php endforeach; 
                    else: ?>
                        <p style="color: #b3b3b3;">Nenhum snack ou produtodisponível no momento.</p>
                    <?php endif; ?>
        </section>
    </main>

    <footer>
    <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2025 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
        
        

</body>
</html>