<?php 
    session_start();
    require_once "conexao/conexao.php";

    $totalInteiras = $_SESSION['valorIngressosInteiras'] ?? 0;
    $totalMeias =  $_SESSION['valorIngressosMeias'] ?? 0;
    $totalIngressos = $totalInteiras + $totalMeias;

    $totalProdutos = $_SESSION['valorTotalProdutos'] ?? 0;
    $valorTotal = $totalIngressos + $totalProdutos;

    $idFilme = $_SESSION['id_filme'] ?? 0;
    $sqlFilme = "SELECT * FROM Filme WHERE id_filme = ? ;";
    $stmtFilme = $conn->prepare($sqlFilme);
    $stmtFilme->execute([$idFilme]);
    $resultadoFilme = $stmtFilme->get_result();
    $filme = $resultadoFilme->fetch_assoc();

    $idSessao = $_SESSION['id_sessao'] ?? 0;
    $sqlSessao = "SELECT * FROM Sessao WHERE id_Sessao = ? ;";
    $stmtSessao = $conn->prepare($sqlSessao);
    $stmtSessao->execute([$idSessao]);
    $resultadoSessao = $stmtSessao->get_result();
    $sessao = $resultadoSessao->fetch_assoc();
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
    <main<!DOCTYPE html>
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
        <form action="processar_pagamento.php" method="POST">
        <input type="hidden" name="valor_total" value="<?php echo htmlspecialchars($valorTotal ?? ''); ?>">
        
        <h1>Finalizar Pagamento</h1>
            <div class = "info-filme">
                <img src="<?php echo htmlspecialchars($filme['poster'] ?? ''); ?>"  class = "filme-poster" alt="Poster do filme">
                <div class="filme-info">
                    <h2><?php echo htmlspecialchars($filme['titulo'] ?? ''); ?></h2>
                    <p>Ano: <?php echo $filme['ano_lancamento']; ?></p>
                    <p>Classificação: <?php echo htmlspecialchars($filme['classificacao_etaria'] ?? 'L'); ?></p>
                    <p>Duração: <?php echo htmlspecialchars($filme['duracao_minutos'] ?? ''); ?> minutos</p>
                </div>
            </div>
            
            <div class = "info-sessao-assentos">
                <h2>Informações da Sessão e Assentos</h2>
                <p>Data: <?php echo htmlspecialchars($sessao['data'] ?? ''); ?></p>
                <p>Horário: <?php echo htmlspecialchars($sessao['horario'] ?? ''); ?></p>
                <p>Tipo de Sessão: <?php echo htmlspecialchars($sessao['tipo'] ?? ''); ?></p>
                <p>Quantidade de Assentos : <?php echo $_SESSION['qntAssentos'] ; ?></p>
            </div>

        <div class="resumo-pagamento">
            <h2>Resumo do Pagamento</h2>
            <p>Total de Ingressos Inteiras: R$ <?php echo number_format($totalInteiras, 2, ',', '.'); ?></p>
            <p>Total de Ingressos Meias: R$ <?php echo number_format($totalMeias, 2, ',', '.'); ?></p>
            <p>Total de Produtos: R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></p>
            <h3>Valor Total: R$ <?php echo number_format($valorTotal, 2, ',', '.'); ?></h3>
        </div>
        <div class="modos-pagamento">
            <h2>Escolha o Modo de Pagamento</h2>
            <label>
                <input type="radio" name="modo_pagamento" value="cartao" required> Cartão de Crédito
            </label>
            <label>
                <input type="radio" name="modo_pagamento" value="cartao" required> Cartão de Débito
            </label>
            <label>
                <input type="radio" name="modo_pagamento" value="pix" required> PIX
            </label>
            
        </div>
        
        <div class="btn-ingressos">    
            <button type="submit" class="btn-comprar">Confirmar Compra</button>
            <a href="index_usuario.php">Voltar à página inicial</a>         
        </div>
        </form>
                
    </main>
    
</body>
</html>