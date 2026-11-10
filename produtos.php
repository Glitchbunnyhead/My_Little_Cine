<?php 
    session_start();
    require_once "conexao/conexao.php"; 

    if (isset($_SESSION['erro'])) {
    echo '<div class="alerta-erro">' . htmlspecialchars($_SESSION['erro']) . '</div>';
    
    unset($_SESSION['erro']);
    }

    $sqlProdutoss = "SELECT * FROM Produto ;";
    $stmtProdutoss = $conn->prepare($sqlProdutoss);
    $stmtProdutoss->execute();
    $resultadoProdutoss = $stmtProdutoss->get_result();
    $produtos = $resultadoProdutoss->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="imagens/home_icone.png" type="image/png">
     <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href="css/estilo.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/produtos.css" type="text/css" media="all">

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
                <a href="index_admin.php" class="nav-link btn">Administração</a>
            <?php endif; ?>
            <a href="perfil.php" class="nav-link">Meu Perfil</a>
            <a href="filmes.php" class="nav-link">Filmes</a>
            <a href="logout.php" class="nav-link">Logout</a>
            <a href="sobre.php" class="nav-link">Sobre</a>
        </nav>
    </header>

    <main>
        <h3>Escolha os seus produtos</h3>
        <div class="secao-produtos">
                <div class="grid-produtos">
                    <?php if (count($produtos) > 0): ?>
                        <form action="processar_produtos.php" method="POST">
                        <?php foreach ($produtos as $produto): ?>
                            <div class="produto">
                                <h4><?php echo htmlspecialchars($produto['nome']); ?></h4>
                                <p>R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></p>
                                
                                    <input type="hidden" name="id_produto" value="<?php echo htmlspecialchars($produto['id_produto']); ?>">
                                    <input type="hidden" name="nome_produto" value="<?php echo htmlspecialchars($produto['nome']); ?>">
                                    <input type="hidden" name="preco_produto" value="<?php echo htmlspecialchars($produto['preco']); ?>">
                                    <img src="<?php echo htmlspecialchars($produto['foto'] ?? ''); ?>" alt="Foto do produto">
                                    <label for="quantidade_<?php echo $produto['id_produto']; ?>">Quantidade:</label>
                                    <input type="number" id="quantidade_<?php echo $produto['id_produto']; ?>" name="quantidade[<?php echo $produto['id_produto']; ?>]" value="1" min ="0">   
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Nenhum produto disponível no momento.</p>
                    <?php endif; ?>
                </div> 
            <button type="submit">Continuar</button>
            </form>    
            <a href="assentos.php" class = "btn-voltar">Voltar</a> 
        </div>       
    </main>
                
    <footer>
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2026 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
</body>
</html>