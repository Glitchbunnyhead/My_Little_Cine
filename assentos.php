<?php 
    session_start();
    require_once "conexao/conexao.php";

    $idSala = [$_GET["id"] ?? ""];

    $sqlAssentos = "SELECT * FROM Assento WHERE id_sala = ? ;";
    $stmtAssentos = $conn->prepare($sqlAssentos);
    $stmtAssentos->execute($idSala);
    $resultadoAssentos = $stmtAssentos->get_result();
    $assentos = $resultadoAssentos->fetch_all(MYSQLI_ASSOC);
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
    <link rel="stylesheet" href="css/assentos.css" type="text/css" media="all">

    <title>My Little Cine</title>
</head>
<body>
    <header>
        <h2 class="nav-titulo">My Little Cine</h2>
        <nav class="nav-container">
            <a href="index_usuario.php" class="nav-logo">
                <img src="imagens/home_icone.png" alt="Logo">
            </a>
            <?php if (isset($_SESSION["tipo"]) && $_SESSION["tipo"] == "admin"): ?>
                <a href="index_admin.php" class="nav-link btn">Administração</a>
            <?php endif; ?>
            <a href="perfil.php" class="nav-link">Meu Perfil</a>
            <a href="filmes.php" class="nav-link">Filmes</a>
            <a href="logout.php" class="nav-link">Logout</a>
            <a href="sobre.php" class="nav-link">Sobre</a>
        </nav>
    </header>

    <main>
        <form action="processar_reserva.php" method="POST">
            <input type="hidden" name="id_sala" value="<?php echo htmlspecialchars($idSala[0] ?? ''); ?>">
            <input type="hidden" name="id_usuario" value="<?php echo htmlspecialchars($_SESSION['id_usuario'] ?? ''); ?>">
            <input type="hidden" name="id_filme" value="<?php echo htmlspecialchars($_GET['id_filme'] ?? ''); ?>">
            <input type="hidden" name="id_sessao" value="<?php echo htmlspecialchars($_GET['id_sessao'] ?? ''); ?>">

            <div class="secao-assentos">
                <h3>Escolha os seus assentos</h3>
                <p class="instrucao">Marque as caixas dos lugares desejados:</p>

                <div class="grid-assentos">
                    <?php if (count($assentos) > 0): ?>
                        <?php foreach ($assentos as $assento): 
                            $codigoAssento = $assento["fileira"] . $assento["numero"]; 
                        ?>
                            <div class="assento-item">
                                <input type="checkbox" id="assentos_<?php echo $codigoAssento; ?>" name="assentos[]" value="<?php echo $codigoAssento; ?>" />  
                                <label for="assentos_<?php echo $codigoAssento; ?>">Assento <?php echo $codigoAssento; ?></label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div> 

                <div class="btn-ingressos">    
                    <button type="submit" class="btn-comprar">Selecionar Ingressos</button>
                </div>         
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