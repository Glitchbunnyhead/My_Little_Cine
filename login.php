<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">
            <a href="index_usuario.php" class="nav_link">Página Inicial</a>

            <a href="cadastrar.php" class="nav_link">Criar conta</a>
        </nav>
    </header>

    <main>
        <section>
            <div>
                <h2>Bem-vindo de volta!</h2>

                <form action="autenticar.php" method="POST">
                    
                    <div class="formulario_grupo">
                   
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" placeholder="Digite seu email" required>

                    </div>

                    <div class="formulario_grupo">

                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" placeholder="Digite sua senha" required>

                    </div>

                    <div class="formulario_botoes">

                    <button type="submit">Entrar</button>

                    </div>
                    
                </form>

                <div class="login_cadastro">
                    <p>Ainda não tem conta?</p>
                    <a href="cadastrar.php">Cadastre-se</a>
                </div>

            </div>
        </section>
    </main>

    <footer></footer>
   
</body>
</html>

        