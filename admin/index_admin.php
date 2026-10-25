<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Área administrativa</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../css/variaveis.css">
    <link rel="stylesheet" href="../css/estilo.css" type="text/css" media="all">
    <link rel="stylesheet" href="../css/index_admin.css" type="text/css" media="all">
</head>

<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">
            <a href="../index_usuario.php" class="nav_link">Página Inicial</a>
        </nav>
    </header>

    <main>
        <section class="index_admin">
            <div class="index_admin_conteudo"> <!-- Corrigido para class -->

                <h2>Área Administrativa</h2>

                <div class="index_admin_opcoes">

                    <div class="admin_card">
                        <h3>Filmes</h3>
                        <a href="geren_filmes.php" class="botao">Gerenciar Filmes</a>
                    </div>

                    <div class="admin_card">
                        <h3>Sessões</h3>
                        <a href="geren_sessoes.php" class="botao">Gerenciar sessões</a>
                    </div>

                    <div class="admin_card">
                        <h3>Cadastrar Salas</h3>
                        <a href="cadastrar_sala.php" class="botao">Cadastrar Salas</a>
                    </div>

                    <div class="admin_card">
                        <h3>Usuários</h3>
                        <a href="geren_usuarios.php" class="botao">Gerenciar Usuários</a>
                    </div>
                    
                    <div class="admin_card">
                        <h3>Produtos</h3>
                        <a href="geren_produtos.php" class="botao">Gerenciar Produtos</a>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <footer>
        <img src="../imagens/home_icone.png" alt="Icone">
        <p>© 2025 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>
</body>
</html>