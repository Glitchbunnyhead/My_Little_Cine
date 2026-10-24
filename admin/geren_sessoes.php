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
$editando = false;

//mensagens apos operacoes
if(isset($_GET["mensagem"])) {
    if ($_GET["mensagem"] == "cadastro") {
        $mensagem = "Sessão cadastrada com sucesso!";
    } elseif ($_GET["mensagem"] == "edicao") {
        $mensagem = "Sessão editada com sucesso!";
    } elseif ($_GET["mensagem"] == "exclusao") {
        $mensagem = "Sessão excluída com sucesso!";
    }
}

//valore inicias do formulario
$sessao = [
    "id_sessao" => "",
    "data" => "",
    "horario" => "",
    "tipo" => "",
    "preco" => "",
    "status" => "em exibição",
    "id_filme" => "",
    "id_idioma" => "",
    "id_sala" => ""
];

//procesa cadastro, edição e exclusao
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $acao = $_POST["acao"] ?? "";

    //excluir
    if($acao == "excluir") {
        $id_sessao = (int) ($_POST["id_sessao"] ?? 0);

        if($id_sessao <= 0) {
            $mensagem = "ID de sessão inválido.";
        } else {
            $sql = "DELETE FROM Sessao WHERE id_sessao = ?";
            $stmt = mysqli_prepare($conn, $sql);

            if($stmt) {
                mysqli_stmt_bind_param($stmt, "i", $id_sessao);

                if (mysqli_stmt_execute($stmt)) {
                    if(mysqli_stmt_affected_rows($stmt) > 0) {
                        mysqli_stmt_close($stmt);

                        header("Location: geren_sessoes.php?mensagem=exclusao");
                        exit();

                    } else {
                        $mensagem = "Nenhuma sessão encontrada para exclusão.";
                    }
                 
                } else {
                    $mensagem = "Erro na preparação da consulta: " . mysqli_error($conn);
                }

                mysqli_stmt_close($stmt);
            } else {
                
                $mensagem = "ID de sessão inválido.";

            }
            
        } 
        
    }

    //cadastrar ou editar
    if($acao == "salvar") {
        $id_sessao = (int) ($_POST["id_sessao"] ?? 0);
        $data = trim($_POST["data"] ?? "");
        $horario = $_POST["horario"] ?? "";
        $tipo = trim($_POST["tipo"] ?? "");
        $preco = str_replace(",", ".",  trim ($_POST["preco"] ?? ""));
        $status = $_POST["status"] ?? "em exibição";
        $id_filme = (int) ($_POST["id_filme"] ?? 0);
        $id_idioma = (int) ($_POST["id_idioma"] ?? 0);
        $id_sala = (int) ($_POST["id_sala"] ?? 0);

        //mantem os dados
        $sessao = [
            "id_sessao" => $id_sessao,
            "data" => $data,
            "horario" => $horario,
            "tipo" => $tipo,
            "preco" => $preco,
            "status" => $status,
            "id_filme" => $id_filme,
            "id_idioma" => $id_idioma,
            "id_sala" => $id_sala
        ];

        $editando = ($id_sessao > 0);

        if($data == "" || $horario == "" || $tipo == "" || $preco == "" || $status == "" || $id_filme <= 0 || $id_idioma <= 0 || $id_sala <= 0) {

            $mensagem = "Preencha todos os campos corretamente.";
        } else {
            $preco = (float) $preco;

            if($editando) {
                $sql = "UPDATE Sessao SET data = ?, horario = ?, tipo = ?, preco = ?, status = ?, id_filme = ?, id_idioma = ?, id_sala = ? WHERE id_sessao = ?";

                $stmt = mysqli_prepare($conn, $sql);

                if($stmt) {
                    mysqli_stmt_bind_param($stmt, "sssssiiii", $data, $horario, $tipo, $preco, $status, $id_filme, $id_idioma, $id_sala, $id_sessao);

                    if(mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_close($stmt);

                        header("Location: geren_sessoes.php?mensagem=edicao");
                        exit();
                    } else {
                        $mensagem = "Erro ao editar sessão: " . mysqli_stmt_error($stmt);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $mensagem = "Erro na preparação da consulta: " . mysqli_error($conn);
                }
            } else {
                $sql = "INSERT INTO Sessao (data, horario, tipo, preco, status, id_filme, id_idioma, id_sala) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = mysqli_prepare($conn, $sql);

                if($stmt) {
                    mysqli_stmt_bind_param($stmt, "sssssiii", $data, $horario, $tipo, $preco, $status, $id_filme, $id_idioma, $id_sala);

                    if(mysqli_stmt_execute($stmt)) {
                        mysqli_stmt_close($stmt);

                        header("Location: geren_sessoes.php?mensagem=cadastro");
                        exit();
                    } else {
                        $mensagem = "Erro ao cadastrar sessão: " . mysqli_stmt_error($stmt);
                    }

                    mysqli_stmt_close($stmt);
                } else {
                    $mensagem = "Erro na preparação da consulta: " . mysqli_error($conn);
                }
            }
        }
    }
}

if(isset($_GET["editar"]) && $_SERVER["REQUEST_METHOD"] != "POST") {
    $id_editar = (int) ($_GET["editar"]);

    if($id_editar > 0) {
        $sql = "SELECT * FROM Sessao WHERE id_sessao = ?";
        $stmt = mysqli_prepare($conn, $sql);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_editar);
            mysqli_stmt_execute($stmt);

            $resultado_edicao = mysqli_stmt_get_result($stmt);
            $dados_sessao = mysqli_fetch_assoc($resultado_edicao);

            if ($dados_sessao) {
                $sessao = $dados_sessao;
                $editando = true;
            } else {
                $mensagem = "Sessão não encontrada.";
            }

            mysqli_stmt_close($stmt);
        }
    }
}

// Busca filmes, idiomas e salas para os campos de seleção
$resultado_filmes = mysqli_query(
    $conn,
    "SELECT id_filme, titulo FROM Filme ORDER BY titulo"
);

$resultado_idiomas = mysqli_query(
    $conn,
    "SELECT id_idioma, idioma FROM Idioma ORDER BY idioma"
);

$resultado_salas = mysqli_query(
    $conn,
    "SELECT id_sala, nome FROM Sala ORDER BY nome"
);

if (!$resultado_filmes || !$resultado_idiomas || !$resultado_salas) {
    die("Erro ao carregar filmes, idiomas ou salas: "
        . mysqli_error($conn));
}

// Busca todas as sessões com os nomes relacionados
$sql_sessoes = "SELECT
                    s.id_sessao,
                    s.data,
                    s.horario,
                    s.tipo,
                    s.preco,
                    s.status,
                    f.titulo,
                    i.idioma,
                    sa.nome AS nome_sala
                FROM Sessao s
                INNER JOIN Filme f
                    ON s.id_filme = f.id_filme
                INNER JOIN Idioma i
                    ON s.id_idioma = i.id_idioma
                INNER JOIN Sala sa
                    ON s.id_sala = sa.id_sala
                ORDER BY s.data DESC, s.horario DESC";

$resultado_sessoes = mysqli_query($conn, $sql_sessoes);

if (!$resultado_sessoes) {
    die("Erro ao carregar sessões: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Sessões</title>
</head>
<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">
            <a href="index_admin.php"></a>
        </nav>
    </header>

    <main>
        <section>
            <h2>Gerenciar Sessões</h2>

            <?php if($mensagem != ""): ?>
                <p class="admin_mensagem">
                    <?php echo  htmlspecialchars($mensagem); ?>
                </p>
            <?php endif; ?>

            <h3>
                <?php echo $editando ? "Editar sessão" : "Cadastrar sessão"; ?>
            </h3>

            <form action="geren_sessoes.php" method="POST">

                <input type="hidden" name="acao" value="salvar">

                <input type="hidden" name="id_sessao" value="<?php echo (int) $sessao["id_sessao"]; ?>">

                <label for="data">Data:</label>
            <input
                type="date"
                id="data"
                name="data"
                value="<?php echo htmlspecialchars($sessao["data"]); ?>"
                required>

            <label for="horario">Horário:</label>
            <input
                type="time"
                id="horario"
                name="horario"
                value="<?php echo htmlspecialchars($sessao["horario"]); ?>"
                required>

            <label for="tipo">Tipo de sessão:</label>
            <input
                type="text"
                id="tipo"
                name="tipo"
                maxlength="40"
                placeholder="Ex.: 2D, 3D ou IMAX"
                value="<?php echo htmlspecialchars($sessao["tipo"]); ?>"
                required>

            <label for="preco">Preço do ingresso (R$):</label>
            <input
                type="number"
                id="preco"
                name="preco"
                min="0"
                step="0.01"
                value="<?php echo htmlspecialchars($sessao["preco"]); ?>"
                required>

            <label for="status">Status:</label>
            <input
                type="text"
                id="status"
                name="status"
                maxlength="20"
                placeholder="Ex.: em exibição"
                value="<?php echo htmlspecialchars($sessao["status"]); ?>"
                required>

            <label for="id_filme">Filme:</label>
            <select id="id_filme" name="id_filme" required>
                <option value="">Selecione um filme</option>

                <?php while ($filme = mysqli_fetch_assoc($resultado_filmes)): ?>
                    <option
                        value="<?php echo (int) $filme["id_filme"]; ?>"
                        <?php echo (int) $sessao["id_filme"] === (int) $filme["id_filme"] ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($filme["titulo"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="id_idioma">Idioma:</label>
            <select id="id_idioma" name="id_idioma" required>
                <option value="">Selecione um idioma</option>

                <?php while ($idioma = mysqli_fetch_assoc($resultado_idiomas)): ?>
                    <option
                        value="<?php echo (int) $idioma["id_idioma"]; ?>"
                        <?php echo (int) $sessao["id_idioma"] === (int) $idioma["id_idioma"] ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($idioma["idioma"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <label for="id_sala">Sala:</label>
            <select id="id_sala" name="id_sala" required>
                <option value="">Selecione uma sala</option>

                <?php while ($sala = mysqli_fetch_assoc($resultado_salas)): ?>
                    <option
                        value="<?php echo (int) $sala["id_sala"]; ?>"
                        <?php echo (int) $sessao["id_sala"] === (int) $sala["id_sala"] ? "selected" : ""; ?>>
                        <?php echo htmlspecialchars($sala["nome"]); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <button type="submit">
                <?php echo $editando ? "Salvar alterações" : "Cadastrar sessão"; ?>
            </button>

            <?php if ($editando): ?>
                <a href="geren_sessoes.php">Cancelar edição</a>
            <?php endif; ?>

            </form>
        </section>

        <section>
        <h3>Sessões cadastradas</h3>

        <div class="admin_tabela">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Filme</th>
                        <th>Data</th>
                        <th>Horário</th>
                        <th>Tipo</th>
                        <th>Idioma</th>
                        <th>Sala</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>
                    <?php if (mysqli_num_rows($resultado_sessoes) > 0): ?>

                        <?php while ($item = mysqli_fetch_assoc($resultado_sessoes)): ?>
                            <tr>
                                <td>
                                    <?php echo (int) $item["id_sessao"]; ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item["titulo"]); ?>
                                </td>

                                <td>
                                    <?php
                                    echo date(
                                        "d/m/Y",
                                        strtotime($item["data"])
                                    );
                                    ?>
                                </td>

                                <td>
                                    <?php echo substr($item["horario"], 0, 5); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item["tipo"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item["idioma"]); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item["nome_sala"]); ?>
                                </td>

                                <td>
                                    R$ <?php echo number_format(
                                        (float) $item["preco"],
                                        2,
                                        ",",
                                        "."
                                    ); ?>
                                </td>

                                <td>
                                    <?php echo htmlspecialchars($item["status"]); ?>
                                </td>

                                <td>
                                    <a href="geren_sessoes.php?editar=<?php echo (int) $item["id_sessao"]; ?>">
                                        Editar
                                    </a>

                                    <form
                                        action="geren_sessoes.php"
                                        method="POST"
                                        onsubmit="return confirm('Tem certeza de que deseja excluir esta sessão?');">

                                        <input
                                            type="hidden"
                                            name="acao"
                                            value="excluir">

                                        <input
                                            type="hidden"
                                            name="id_sessao"
                                            value="<?php echo (int) $item["id_sessao"]; ?>">

                                        <button type="submit">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="10">
                                Nenhuma sessão cadastrada.
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