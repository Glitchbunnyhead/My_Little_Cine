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
    <link rel="stylesheet" href="css/finalizar_pagamento.css" type="text/css" media="all">
    <title>Finalizar Pagamento </title>
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
        <form action="processar_pagamento.php" method="POST" class="pagamento-form">
            <input type="hidden" name="valor_total" value="<?php echo htmlspecialchars($valorTotal ?? ''); ?>">
            
            <h1>Finalizar Pagamento</h1>

            <!-- Seção do Filme -->
            <div class="info-filme">
                <img src="<?php echo htmlspecialchars($filme['poster'] ?? ''); ?>" class="filme-poster" alt="Poster do filme">
                <div class="filme-info">
                    <h2><?php echo htmlspecialchars($filme['titulo'] ?? ''); ?></h2>
                    <p><span>Ano:</span> <?php echo $filme['ano_lancamento'] ?? ''; ?></p>
                    <p><span>Classificação:</span> <?php echo htmlspecialchars($filme['classificacao_etaria'] ?? 'L'); ?></p>
                    <p><span>Duração:</span> <?php echo htmlspecialchars($filme['duracao_minutos'] ?? ''); ?> minutos</p>
                </div>
            </div>
            
            <!-- Seção da Sessão e Assentos -->
            <div class="info-sessao-assentos">
                <h2>Detalhes da Sessão</h2>
                <p><span>Data:</span> <?php echo htmlspecialchars($sessao['data'] ?? ''); ?></p>
                <p><span>Horário:</span> <?php echo htmlspecialchars($sessao['horario'] ?? ''); ?></p>
                <p><span>Tipo:</span> <?php echo htmlspecialchars($sessao['tipo'] ?? ''); ?></p>
                <p><span>Assentos Reservados:</span> <?php echo $_SESSION['qntAssentos'] ?? 0; ?></p>
            </div>

            <!-- Resumo Financeiro -->
            <div class="resumo-pagamento">
                <h2>Resumo do Pedido</h2>
                <p>Total de Ingressos Inteiras: <span>R$ <?php echo number_format($totalInteiras, 2, ',', '.'); ?></span></p>
                <p>Total de Ingressos Meias: <span>R$ <?php echo number_format($totalMeias, 2, ',', '.'); ?></span></p>
                <p>Total de Produtos: <span>R$ <?php echo number_format($totalProdutos, 2, ',', '.'); ?></span></p>
                <h3>Valor Total: R$ <?php echo number_format($valorTotal, 2, ',', '.'); ?></h3>
            </div>

            <!-- Modos de Pagamento -->
            <div class="modos-pagamento">
                <h2>Escolha o Pagamento</h2>
                <div class="opcoes-pagamento">
                    <label>
                        <input type="radio" name="modo_pagamento" value="credito" required> Cartão de Crédito
                    </label>
                    <label>
                        <input type="radio" name="modo_pagamento" value="debito" required> Cartão de Débito
                    </label>
                    <label>
                        <input type="radio" name="modo_pagamento" value="pix" required> PIX
                    </label>
                </div>
            </div>
            
            <!-- Botões de Ação -->
            <div class="btn-ingressos">    
                <button type="submit" class="btn-comprar">Confirmar Compra</button>
                <a href="index_usuario.php" class="btn-voltar">Voltar à página inicial</a>         
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