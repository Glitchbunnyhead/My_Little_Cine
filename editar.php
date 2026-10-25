<?php 
session_start();

if(!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

include_once('conexao/conexao.php');

$id_usuario = $_SESSION['id_usuario'];
$mensagem = "";
$sucesso = false;

echo "id usuario " . $id_usuario;


// Verifica se o formulário foi enviado
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $cpf = trim($_POST['cpf']);
    $nascimento = trim($_POST['nascimento']);
    $tipo = trim($_POST['tipo']);

    // Atualiza os dados do usuário no banco de dados        
    $sql = "UPDATE Usuario SET nome = ?, email = ?, senha = ?, cpf = ?, data_nascimento = ?, tipo = ? WHERE id_usuario = ?";    
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $nome, $email, $senha, $cpf, $nascimento, $tipo, $id_usuario);

    if(mysqli_stmt_execute($stmt)) {
        $mensagem = "Perfil atualizado com sucesso!";        
        $sucesso = true;
    
    } else {
        $mensagem = "Erro ao atualizar o perfil: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

$sql = "SELECT * FROM Usuario WHERE id_usuario = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$usuario = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

if(!$usuario) {
    echo "Usuário não encontrado.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Press+Start+2P&family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pixelify+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/variaveis.css">
    <link rel="stylesheet" href="css/estilo.css" type="text/css" media="all">
    <link rel="stylesheet" href="css/editar.css" type="text/css" media="all">
    <title>Editar perfil</title>
</head>
<body>
    <header>
        <h2>My Little Cine</h2>

        <nav class="nav_container">
            <a href="index_usuario.php" class="nav_link">Página Inicial</a>

            <a href="perfil.php" class="nav_link">Meu Perfil</a>
        </nav>
    </header>    

    <main>
        <section class="editar">
            <div class="editar_conteudo">

                <h2>Editar perfil</h2>

                <?php if ($mensagem != ""): ?>
                <p class="editar_mensagem ">
                    <?php echo htmlspecialchars($mensagem); ?>
                </p>
                 <?php endif; ?>

                 <form action="editar.php" method="POST">
                    <div class="formulario_grupo">
                       
                        <label for="nome">Nome Completo:</label>
                        <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario["nome"]); ?>"
                        required>

                    </div>

                    <div class="formulario_grupo">
                       
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario["email"]); ?>"
                        required>
                       
                    </div>

                    <div class="formulario_grupo">
                       
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" value="<?php echo htmlspecialchars($usuario["senha"]); ?>"
                        required>
                       
                    </div>

                    <div class="formulario_grupo">
                       
                        <label for="cpf">CPF:</label>
                        <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($usuario["cpf"]); ?>"
                        required>
                       
                    </div>

                    <div class="formulario_grupo">
                       
                        <label for="nascimento">Data de Nascimento:</label>
                        <input type="date" id="nascimento" name="nascimento" value="<?php echo htmlspecialchars($usuario["data_nascimento"]); ?>"
                        required>
                       
                    </div>

                    <div class="formulario_grupo">
                       
                        <label for="tipo">Tipo de Usuário:</label>

                        <div>

                        <input 
                        type="radio" id="tipo_usuario" name="tipo" 
                        value="usuario"

                        <?php echo htmlspecialchars($usuario["tipo"] == "usuario") ? "checked" : ""; ?>

                        required>
                       
                        <label for="tipo_usuario">Usuário</label>

                        </div>

                        <div>

                        <input 
                        type="radio" 
                        id="tipo_admin" 
                        name="tipo" 
                        value="admin"

                        <?php echo htmlspecialchars($usuario["tipo"] == "admin") ? "checked" : ""; ?>
                        required>
                       
                        <label for="tipo_admin">Administrador</label>

                        </div>

                    </div>

                    <div class="formulario_botoes">
                        <button type="submit">Salvar alterações</button>

                        <a href="perfil.php" class="botao">Cancelar</a>
                    </div>

                </form>

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