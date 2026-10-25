<?php

if (isset($_POST['submit'])) {

    include_once('conexao/conexao.php');

    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $nascimento = $_POST['nascimento'];
    $tipo = $_POST['tipo'];

    $result = mysqli_query($conn, "INSERT INTO Usuario(nome, email, senha, cpf, data_nascimento, tipo) VALUES ('$nome','$email','$senha','$cpf','$nascimento', '$tipo')");
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href="css/estilo.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/cadastro.css" type="text/css" media="all">
    <title>Cadastro</title>
</head>

<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">

            <a href="index_usuario.php" class="nav_link">Página Inicial</a>

            <a href="login.php" class="nav_link">Login</a>

        </nav>
    </header>

    <main>
        <section class="cadastro">
            <div class="cadastro_conteudo">

                <h2>Crie sua conta</h2>

                <form action="cadastrar.php" method="POST">

                    <div class="formulario_grupo">

                        <label for="name">Nome completo:</label>
                        <input type="text" id="name" name="name" required>

                    </div>

                    <div class="formulario_grupo">

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>

                    </div>

                    <div class="formulario_grupo">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" required>

                    </div>

                    <div class="formulario_grupo">

                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" required>

                    </div>

                    <div class="formulario_grupo">

                        <label for="nascimento">Data de Nascimento:</label>
                        <input type="date" id="nascimento" name="nascimento" required>

                    </div>

                    <div class="formulario_grupo">

                        <label for="tipo">Tipo:</label>

                        <select id="tipo" name="tipo" required>
                            <option value="usuario">Usuário</option>
                            <option value="admin">Administrador</option>
                        </select>

                    </div>

                    <div class="formulario_botoes">

                        <button type="submit" name="submit">Cadastrar</button>

                        <button type="reset">Limpar</button>
                    </div>

                </form>

                <div class="cadastro_login">
                    <p>Já tem uma conta?</p>
                    <a href="login.php"> Faça login</a>
                </div>

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