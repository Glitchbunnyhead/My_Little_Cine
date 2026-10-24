<?php 
session_start();

if(!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit();
}

include_once('conexao/conexao.php');

$id_usuario = $_SESSION['usuario'];
$mensagem = "";
$sucesso = false;

// Verifica se o formulário foi enviado
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    $cpf = trim($_POST['cpf']);
    $nascimento = trim($_POST['nascimento']);
    $tipo = trim($_POST['tipo']);

    // Atualiza os dados do usuário no banco de dados
    $sql = "UPDATE Usuario SET nome = ?, email = ?, senha = ?, cpf = ?, nascimento = ?, tipo = ? WHERE id_usuario = ?";
    
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

                <?php if ($mensagem != ""):
                ?>
                <p class="editar_mensagem "></p>

            </div>

        </section>

    </main>
</body>
</html>