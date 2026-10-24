<?php
    session_start();
    require_once "conexao/conexao.php";

    $idFilme = [$_GET["id"] ?? ""];

    $sqlSalaSessao = "SELECT Sessao.data, Sessao.horario, Sessao.tipo, Sessao.preco, Sessao.status, Sessao.id_filme, Sessao.id_idioma, Sessao.id_sala, Sala.nome, Sala.capacidade FROM Sessao INNER JOIN Sala ON Sessao.id_sala = Sala.id_sala WHERE Sessao.id_filme = ?";
    $stmtSalaSessao = $conn->prepare($sqlSalaSessao);
    $stmtSalaSessao->execute($idFilme);
    $resultadoSalaSessao = $stmtSalaSessao->get_result();
    $salasSessao = $resultadoSalaSessao->fetch_all(MYSQLI_ASSOC);

    $sqlFilmes = "SELECT * FROM Filme WHERE id_filme = ? ;";
    $stmtFilmes = $conn->prepare($sqlFilmes);
    $stmtFilmes->execute($idFilme);
    $resultadoFilmes = $stmtFilmes->get_result();
    $filme = $resultadoFilmes->fetch_assoc();

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
    <link rel="stylesheet" href="css/sessao.css" type="text/css" media="all">

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
        <div class = "filmes-sessoes">
            <h1><?php echo htmlspecialchars($filme['titulo'] ?? ''); ?></h1>
            <div class="filme-card-item">
                    <img src="<?php echo htmlspecialchars($filme['poster'] ?? ''); ?>"  class = "filme-poster" alt="Poster do filme">
                    <div class="filme-info">
                        <p class="filme-meta">
                            <span class="badge-classificacao"><?php echo htmlspecialchars($filme['classificacao_etaria'] ?? 'L'); ?></span>
                            <span> | ano de lançamento : <?php echo $filme['ano_lancamento']; ?></span> 
                            <span> | duração : <?php echo $filme['duracao_minutos']; ?> min</span>
                            <span> | sinopse : <?php echo $filme['sinopse']; ?> </span>
                        </p>
                    </div>
                </div>

        </div>
        <div class = "sessoes">
        <h2>Sessoes para esse filme</h2> <!-- depois inserir o nome do filme aqui -->
        <div class="sessoes-opcoes">
            <?php if (count($salasSessao) > 0): ?>
                <?php foreach ($salasSessao as $sessao): ?>
                    <div class="sessao-item">
                        <div class="sessao-info">
                            <h3><?php echo htmlspecialchars($sessao['data'] ?? ''); ?></h3>
                            <p> | horário : <?php echo htmlspecialchars($sessao['horario'] ?? ''); ?> <br>
                                | sala : <?php echo htmlspecialchars($sessao['nome'] ?? ''); ?> <br>
                                | tipo : <?php echo htmlspecialchars($sessao['tipo'] ?? ''); ?> <br>
                                | preço : <?php echo htmlspecialchars($sessao['preco'] ?? ''); ?> <br>
                            </p>
                            <div class="sessoes-acoes">
                               <a href="assentos.php?id=<?php echo $sessao['id_sala']; ?>" class = "btn-comprar">Reservar Assentos</a> 
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color: #b3b3b3;">Nenhum filme em cartaz no momento.</p>
            <?php endif; ?>    
    </main>

    <footer>
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2026 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
</body>
</html> 