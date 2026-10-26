<?php 
    session_start();
    require_once "conexao/conexao.php"; 

    $qntReservados = isset($_SESSION['qntAssentos']) ? (int)$_SESSION['qntAssentos'] : 0;
    $precoInteira = 30.00;
    $precoMeia = $precoInteira / 2;
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
    <link rel="stylesheet" href="css/ingressos.css" type="text/css" media="all">

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
        <h3>Escolha os seu tipo de ingresso</h3>
        <form action="processar_ingressos.php" method="POST">
            <input type="hidden" name="qntAssentos" value="<?php echo htmlspecialchars($qntReservados); ?>">
            <input type="hidden" name="inteira" value="<?php echo htmlspecialchars($precoInteira); ?>">
            <input type="hidden" name="meia" value="<?php echo htmlspecialchars($precoMeia); ?>">

            <div class="secao-ingressos">
                <div class="grid-ingressos">
                    <?php if ($qntReservados > 0): ?>
                        <h4>Inteira</h4>
                        <label>
                            <input type="number" name="qntInteira" min="0" max="<?php echo $qntReservados; ?>" value="0">  R$ <?php echo number_format($precoInteira, 2, ',', '.'); ?>
                        </label>
                        <h4>Meia</h4>
                        <label>
                            <input type="number" name="qntMeia" min="0" max="<?php echo $qntReservados; ?>" value="0"> R$ <?php echo number_format($precoMeia, 2, ',', '.'); ?>
                        </label>
                    <?php endif; ?>
                </div> 
                <button type="submit">Continuar</button>
            </div>
        </form>
        </main>

                
    <footer>
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2026 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
</body>
</html>