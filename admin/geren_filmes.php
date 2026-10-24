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
$filme_edicao = null;

//cadastrar ou editar
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $acao = $_POST["acao"] ?? "";

    if ($acao == "cadastrar" || $acao == "editar") {
        $titulo = trim($_POST["titulo"] ?? "");
        $sinopse = trim($_POST["sinopse"] ?? "");
        $ano = (int) ($_POST["ano_lancamento"] ?? 0);
        $duracao = (int) ($_POST["duracao_minutos"] ?? 0);
        $classificacao = ($_POST["classificacao_etaria"] ?? "");
        $poster = trim($_POST["poster"] ?? "");

        $classificacoes_validas = ["Livre", "12", "14", "16", "18"];

        if (
            $titulo == "" ||
            $sinopse == "" ||
            $ano <= 0 ||
            $duracao <= 0 ||
            !in_array($classificacao, $classificacoes_validas) || $poster == ""
        ) {

            $mensagem = "Todos os campos são obrigatórios e devem ser válidos.";
        } else {

            if ($acao == "cadastrar") {
                $sql = "INSERT INTO Filme (titulo, sinopse, ano_lancamento, duracao_minutos, classificacao_etaria, poster) VALUES (?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "ssiiss", $titulo, $sinopse, $ano, $duracao, $classificacao, $poster);

                if (mysqli_stmt_execute($stmt)) {
                    $mensagem = "Filme cadastrado com sucesso!";
                } else {
                    $mensagem = "Erro ao cadastrar filme: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            } else {
                $id_filme = (int) ($_POST["id_filme"] ?? 0);

                $sql = "UPDATE Filme SET titulo = ?, sinopse = ?, ano_lancamento = ?, duracao_minutos = ?, classificacao_etaria = ?, poster = ? WHERE id_filme = ?";

                $stmt = mysqli_prepare($conn, $sql);

                mysqli_stmt_bind_param($stmt, "ssiissi", $titulo, $sinopse, $ano, $duracao, $classificacao, $poster, $id_filme);

                if (mysqli_stmt_execute($stmt)) {
                    $mensagem = "Filme atualizado com sucesso!";
                } else {
                    $mensagem = "Erro ao atualizar filme: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt);
            }
        }

        //excluir
    }
    if ($acao == "excluir") {
        $id_filme = (int) ($_POST["id_filme"] ?? 0);

        $sql = "DELETE FROM Filme WHERE id_filme = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $id_filme);

        if (mysqli_stmt_execute($stmt)) {
            $mensagem = "Filme excluído com sucesso!";
        } else {
            $mensagem = "Erro ao excluir filme: " . mysqli_error($conn);
        }

        mysqli_stmt_close($stmt);
    }
}

//carregar filme para edicao
if (isset($_GET["editar"])) {
    $id_filme = (int) ($_GET["editar"]);

    $sql = "SELECT * FROM Filme WHERE id_filme = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_filme);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);
    $filme_edicao = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($stmt);

    if (!$filme_edicao) {
        $mensagem = "Filme não encontrado para edição.";
    }
}

$sql = "SELECT * FROM Filme";
$resultado = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Filmes</title>
</head>

<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">

            <a href="index_admin.php" class="nav_link">Painel Administrativo</a>

        </nav>
    </header>

    <main>
        <section class="admin">
            <div class="admin_introducao">
                <h2>Gerenciar Filmes</h2>
            </div>

            <?php if ($mensagem != ""): ?>
                <p class="admin_mensagem">
                    <?php echo htmlspecialchars($mensagem); ?>
                </p>
            <?php endif; ?>

            <section class="admin_formulario">
                <h3>
                    <?php echo $filme_edicao ? "Editar filme" : "Cadastrar novo filme"; ?>
                </h3>

                <form action="geren_filmes.php" method="POST">
                    <input
                        type="hidden"
                        name="acao"
                        value="<?php echo $filme_edicao ? "editar" : "cadastrar"; ?>">

                    <?php if ($filme_edicao): ?>
                        <input type="hidden"
                            name="id_filme"
                            value="<?php echo (int) $filme_edicao["id_filme"]; ?>">
                    <?php endif; ?>

                    <div class="formulario_grupo">
                        <label for="titulo">Título:</label>

                        <input type="text"
                            id="titulo"
                            name="titulo"
                            maxlength="100"
                            value="<?php echo htmlspecialchars($filme_edicao["titulo"] ?? ""); ?>"
                            required>
                    </div>

                    <div class="formulario_grupo">
                        <label for="sinopse">Sinopse:</label>
                        <textarea name="sinopse" id="sinopse" required>
                                <?php echo htmlspecialchars($filme_edicao["sinopse"] ?? ""); ?>
                            </textarea>
                    </div>

                    <div class="formulario_grupo">
                        <label for="ano_lancamento">Ano de Lançamento:></label>

                        <input type="number"
                            id="ano_lancamento"
                            value="<?php echo htmlspecialchars((string) ($filme_edicao["ano_lancamento"] ?? "")); ?>"
                            required>
                    </div>

                    <div class="formulario_grupo">
                        <label for="duracao_minutos">Duração (minutos)</label>

                        <input type="number"
                            id="duracao_minutos"
                            min="1"
                            value="<?php echo htmlspecialchars((string) ($filme_edicao["duracao_minutos"] ?? "")); ?>"
                            required>
                    </div>

                    <div class="formulario_grupo">
                        <label for="classificacao">Classificação etária:</label>

                        <select name="classificacao" id="classificacao" required>

                            <?php
                            $classificacao = $filme_edicao["classificacao_etaria"] ?? "";
                            $opcoes = ["LIVRE" => "Livre", "12" => "12 anos", "14" => "14 anos", "16" => "16 anos", "18" => "18 anos"];
                            ?>

                            <option value="">Selecione</option>

                            <?php foreach ($opcoes as $valor => $texto): ?>

                                <option value="<?php echo $valor; ?>"
                                    <?php echo ($classificacao == $valor) ? "selected" : ""; ?>>

                                    <?php echo $texto; ?>
                                </option>

                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="formulario_grupo">
                        <label for="poster">Endereço da imagem do pôster:</label>

                        <input type="url"
                        id="poster"
                        name="poster"
                        value="<?php htmlspecialchars($filme_edicao["poster"] ?? ""); ?>"
                        required>
                    </div>

                    <div class="formulario_botoes">
                        <button type="submit">
                            <?php echo $filme_edicao ? "Salvar alterações" : "Cadastrar filme"; ?>
                        </button>

                        <?php if ($filme_edicao): ?>
                            <a href="geren_filmes.php" class="botao">Cancelar</a>
                        <?php endif; ?>    
                    </div>
                </form>
            </section>

            <section class="admin_listagem">
                <h3>Filmes cadastrados</h3>

                <?php if (mysqli_num_rows($resultado) > 0): ?>

                    <div class="admin_tabela">
                        <table>
                            <thead>
                                <tr>
                                    <th>Pôster</th>
                                    <th>Título</th>
                                    <th>Ano</th>
                                    <th>Duração</th>
                                    <th>Classificação</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php while ($filme = mysqli_fetch_assoc($resultado)): ?>

                                    <tr>
                                        <td>
                                            <img src="<?php echo htmlspecialchars($filme["poster"]); ?>" alt="Pôster de <?php echo htmlspecialchars($filme["titulo"]); ?>"
                                            width="65">
                                        </td>

                                        <td><?php echo htmlspecialchars($filme["titulo"]); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($filme["ano_lancamento"])); ?></td>

                                        <td><?php echo (int)($filme["duracao"]); ?> min</td>

                                        <td><?php echo htmlspecialchars($filme["classificacao_etaria"]); ?></td>

                                        <td>
                                            <a href="geren_filmes.php?editar=<?php echo (int) $filme["id_filme"];?>" 
                                            class="botao">

                                            Editar
                                            </a>

                                            <form action="geren_filme.php" method="POST"
                                            onsubmit="return confirm('Tem certeza que deseja excluir esse filme?'); ">

                                                <input type="hidden" name="id_filme" value="<?php echo (int) $filme["id_filme"]; ?>">

                                                <button type="submit">Excluir</button>
                                        
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>

                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p>Nenhum filme cadastrado ainda.</p>
                <?php endif; ?>

            </section>
        </section>
    </main>

    <footer>
        <img src="imagens/home_icone.png" alt="Icone">
        <p>© 2025 IFSUL MY LITTLE CINE</p>
        <a href="https://github.com/Glitchbunnyhead/My_Little_Cine" target="_blank">GitHub</a>
    </footer>

</body>
</html>