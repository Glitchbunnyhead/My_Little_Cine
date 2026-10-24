<?php 
session_start();

if(!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

include_once('conexao/conexao.php');

$id_usuario = $_SESSION['id_usuario'];

$sql = "SELECT * FROM Usuario WHERE id_usuario = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);

if(!$usuario) {
    echo "Usuário não encontrado.";
    exit();
}

mysqli_stmt_close($stmt);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu perfil</title>
</head>
<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">
            <a href="index_usuario.php" class="nav_link">Página Inicial</a>

            <a href="logout.php">Sair</a>
        </nav>
    </header>

    <main>
        <section class="perfil">
            <div class="perfil_conteudo">
                
                <h2>Meu Perfil</h2>

                <div class="perfil_info">
                    <div class="perfil_campo">
                        <strong>Nome Completo:</strong>
                        <?php echo htmlspecialchars($usuario["nome"]); ?>
                    </div>

                    <div class="perfil_campo">
                        <strong>Email:</strong>
                        <?php echo htmlspecialchars($usuario["email"]); ?>
                    </div>

                    <div class="perfil_campo">
                        <strong>Senha:</strong>
                        <?php echo htmlspecialchars($usuario["senha"]); ?>
                    </div>

                    <div class="perfil_campo">
                    <strong>CPF:</strong>
                    <?php echo htmlspecialchars($usuario["cpf"]); ?>
                    </div>

                    <div class="perfil_campo">
                        <strong>Data de Nascimento:</strong>
                        <?php echo htmlspecialchars($usuario["data_nascimento"]); ?>
                    </div>

                    <div class="perfil_campo">
                        <strong>Tipo:</strong>
                        <?php echo htmlspecialchars($usuario["tipo"]); ?>
                    </div>
  
                </div>

                <div class="perfil_botoes">
                    <a href="editar.php" class="botao">Editar perfil</a>
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