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

$mensagem_erro = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $acao = $_POST["acao"] ?? "";

    //cadastrar sala
    if ($acao === "cadastrar") {

        $nome = trim($_POST["nome"] ?? "");
        $capacidade = (int) $_POST["capacidade"];
        $tipo = trim($_POST["tipo"]);

        if ($nome === "" || $capacidade <= 0 || $tipo === "") {

            $mensagem_erro = "Todos os campos são obrigatórios.";
        } else {

            $sql = "INSERT INTO Sala (nome, capacidade, tipo) VALUES (?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "sis", $nome, $capacidade, $tipo);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: geren_salas.php?cadastro=sucesso");
            exit();
        }
    }

    //editar sala

    elseif ($acao === "editar") {

        $id_sala = (int) ($_POST["id_sala"] ?? 0);
        $nome = trim($_POST["nome"] ?? "");
        $capacidade = (int) $_POST["capacidade"];
        $tipo = trim($_POST["tipo"]);

        if ($id_sala <= 0 || $nome === "" || $capacidade <= 0 || $tipo === "") {
            $mensagem_erro = "Todos os campos são obrigatórios.";
        } else {
            $sql = "UPDATE Sala SET nome = ?, capacidade = ?, tipo = ? WHERE id_sala = ?";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sisi", $nome, $capacidade, $tipo, $id_sala);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: geren_salas.php?edicao=sucesso");
            exit();
        }
    }

    //excluir salas
    elseif ($acao === "excluir") {
        $id_sala = (int) ($_POST["id_sala"] ?? 0);

        if ($id_sala <= 0) {

            $mensagem_erro = "ID de sala inválido.";
        } else {
            try {
                $sql = "DELETE FROM Sala WHERE id_sala = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $id_sala);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);

                header("Location: geren_salas.php?exclusao=sucesso");
                exit();
            } catch (mysqli_sql_exception $e) {
                $mensagem_erro = "Erro ao excluir sala: " . $e->getMessage();
            }
        }
    }
}

//buscar sala para edição

$sala_edição = null;

if (isset($_GET["editar"])) {

    $id_sala = (int) $_GET["editar"];

    $sql = "SELECT * FROM Sala WHERE id_sala = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id_sala);

    mysqli_stmt_execute($stmt);

    $resultado_edicao = mysqli_stmt_get_result($stmt);

    $sala_edição = mysqli_fetch_assoc($resultado_edicao);

    mysqli_stmt_close($stmt);

    if (!$sala_edição) {
        $mensagem_erro = "Sala não encontrada para edição.";
    }
}

//listar salas

$sql = "SELECT * FROM Sala";

$resultado_salas = mysqli_query($conn, $sql);

if (!$resultado_salas) {
    die("Erro ao buscar salas: " . mysqli_error($conn));
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Salas</title>

    <link rel="stylesheet" href="../css/estilo.css">

</head>

<body>

    <header>
        <h1>Gerenciar Salas</h1>

        <a href="index_admin.php">Painel do Administrador</a>
    </header>

    <main>
        <!-- mensagens de sucesso -->

        <?php if (isset($_GET["cadastro"])): ?>
            <p>Salas encontrada com sucesso!</p>
        <?php endif; ?>

        <?php if (isset($_GET["edicao"])): ?>
            <p>Salas atualizada com sucesso!</p>
        <?php endif; ?>

        <?php if (isset($_GET["exclusao"])): ?>
            <p>Salas excluída com sucesso!</p>
        <?php endif; ?>

        <!-- mensagens de erro -->

        <?php if ($mensagem_erro !== ""): ?>
            <p>
                <?php echo htmlspecialchars($mensagem_erro); ?>
            </p>
        <?php endif; ?>

        <section>
            <?php if ($sala_edicao): ?>

                <h2>Editar Sala</h2>

                <form action="geren_salas.php" method="POST">

                    <input type="hidden" name="acao" value="editar">

                    <input type="hidden" name="id_sala" value="<?php echo htmlspecialchars($sala_edicao["id_sala"]); ?>">

                    <label for="nome">Nome da sala: </label>

                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($sala_edicao["nome"]);
                    ?>" required>

                    <br><br>

                    <label for="capacidade">Capacidade: </label>

                    <input type="number" id="capacidade" name="capacidade" 
                    min="1"
                    value="<?php echo $sala_edicao["capacidade"]; ?>"
                    required >

                    <br><br>

                    <label for="tipo">Tipo de sala: </label>

                    <input type="text"
                    id="tipo"
                    name="tipo"
                    value="<?php echo htmlspecialchars($sala_edicao["tipo"]); ?>"
                    required>

                    <br><br>

                    <button type="submit">Salvar Alterações</button>

                    <a href="geren_salas.php">Cancelar edição</a>

                </form>

            <?php else: ?>

                <h2>Cadastrar Nova Sala</h2>

                <form action="geren_salas.php" method="POST">

                    <input type="hidden" name="acao" value="cadastrar">

                    <label for="nome">Nome da sala: </label>

                    <input type="text" id="nome" name="nome"
                    placeholder="Ex.: Sala 01" required>

                    <br><br>

                    <label for="capacidade">Capacidade: </label>

                    <input type="number" id="capacidade" name="capacidade" min="1" required>

                    <br><br>

                    <label for="tipo">Tipo de sala: </label>

                    <input type="text" id="tipo" name="tipo" 
                    palceholder="Ex.: 2D, 3D, VIP"
                    required>

                    <br><br>

                    <button type="submit">Cadastrar Sala</button>

                </form>

            <?php endif; ?>

        </section>

        <!-- listagem das salas -->

        <section>

            <h2>Salas Cadastradas</h2>

            <?php if (mysqli_num_rows($resultado_salas) > 0): ?>

                <table border="1">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Capacidade</th>
                            <th>Tipo</th>
                            <th>Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php while ($sala = mysqli_fetch_assoc($resultado_salas)): ?>
                            <tr>
                                <td>
                                    <?php echo $sala["id_sala"];?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($sala["nome"]);?>
                                </td>

                                <td>
                                    <?php echo $sala["capacidade"];?> lugares
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($sala["tipo"]); ?>
                                </td>

                                <td>
                                    <a href="geren_salas.php?editar=<?php echo $sala["id_sala"]; ?>">Editar</a>

                                    <form action="geren_salas.php" method="POST"
                                    style="display:inline;"
                                    onsubmit="return confrim('Tem certeza que deseja excluir esta sala?')">

                                        <input type="hidden" name="acao" value="excluir">

                                        <input type="hidden" name="id_sala"
                                        value="<?php echo $sala["id_sala"];?>">

                                        <button type="submit">Excluir</button>
                                
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Nenhuma sala cadastrada.</p>
            <?php endif; ?>
        </section>

    </main>

    <footer>
        <img src="../imagens/home_icone.png" alt="Icone">
        <p>© 2025 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>

</body>

</html>