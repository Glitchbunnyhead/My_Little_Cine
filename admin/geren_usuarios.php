<?php 

session_start();

if (!isset($_SESSION["usuario"]) || $_SESSION["tipo"] !== "admin") {
    header("Location: ../index_usuario.php");
    exit();
}

include_once("../conexao/conexao.php");

//verifica se é admin
$id_usuario = $_SESSION["id_usuario"];

$sql = "SELECT tipo FROM Usuario WHERE id_usuario = ?";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
$usuario_logado = mysqli_fetch_assoc($resultado);

mysqli_stmt_close($stmt);

if (!$usuario_logado || $usuario_logado["tipo"] !== "admin") {
    header("Location: ../index_usuario.php");
    exit();
}

$mensagem = "";

//mensagem apos exclusao
if (isset($_GET["resultado"]) && $_GET["exclusao"] == "sucesso") {

    $mensagem = "Usuário excluído com sucesso!";
}

//processa exclusao
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST["acao"] ?? "";

    if($acao == "excluir") {
        $id_usuario = (int) ($_POST["id_usuario"] ?? 0);

        if($id_usuario <= 0) {
            $mensagem = "ID de usuário inválido.";

        } else {

            $sql = "DELETE FROM Usuario WHERE id_usuario = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if(!$stmt) {
                $mensagem = "Erro na preparação da consulta: " . mysqli_error($conn);

            } else {
                mysqli_stmt_bind_param($stmt, "i", $id_usuario);

                if (mysqli_stmt_execute($stmt)) {
                    if(mysqli_stmt_affected_rows($stmt) > 0) {
                        mysqli_stmt_close($stmt);

                        header("Location: geren_usuarios.php?exclusao=sucesso");
                        exit;
                    } else {
                        $mensagem = "Usuario nao encontrado"; 
                    }
                } else {
                    $mensagem = "Erro ao excluir perfil: "
                              . mysqli_stmt_error($stmt);
                }

                mysqli_stmt_close($stmt);
            }
        }    
        
    }
}

//busca usuarios

$sql = "SELECT id_usuario, nome, email, senha, cpf, data_nascimento, tipo FROM Usuario";

$resultado = mysqli_query($conn, $sql);

if(!$resultado) {
    die("Erro na consulta: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
</head>
<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">
            <a href="index_admin.php">Painel Administrativo</a>

        </nav>
    </header>

    <main>
        <section>
            <div>
                <h2>Gerenciar Usuários</h2>
            </div>

            <?php if ($mensagem !== ""): ?>
                
                <p class="admin_mensagem">
                    <?php echo htmlspecialchars($mensagem); ?>
                </p>
            <?php endif; ?>

            <h3>Usuários cadastrados</h3>

            <div class="admin_tabela">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Senha</th>
                            <th>CPF</th>
                            <th>Data de Nascimento</th>
                            <th>Tipo de Usuário</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (mysqli_num_rows($resultado) > 0): ?>
                            <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
                                <tr>
                                    <td>
                                        <?php echo (int) $usuario["id_usuario"];?>
                                    </td>

                                    <td>
                                        <?php
                                    echo htmlspecialchars($usuario["nome"]);
                                    ?>
                                    </td>

                                    <td>
                                    <?php
                                    echo htmlspecialchars($usuario["email"]);
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo htmlspecialchars($usuario["senha"]);
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo htmlspecialchars($usuario["cpf"]);
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo htmlspecialchars(
                                        $usuario["data_nascimento"]
                                    );
                                    ?>
                                </td>

                                <td>
                                    <?php
                                    echo $usuario["tipo"] === "admin"
                                        ? "Administrador"
                                        : "Usuário";
                                    ?>
                                </td>

                                <td>
                                    <form action="geren_usuarios.php" method="POST" onsubmit="returnconfirm('Tem certeza que deseja excluir esse perfil?')">
                                        <input type="hidden" name="acao" value="excluir">

                                        <input type="hidden" name="id_usuario" value="<?php echo (int) $usuario["id_usuario"]; ?>">

                                        <button type="submit">
                                        Excluir
                                            
                                        </button>

                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                        <?php else :?>
                            <tr>
                                <td colspan="8">
                                    Nenhum usuário cadastrado.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </section>
    </main>

    <footer>  
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2025 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a></footer>
    
</body>
</html>