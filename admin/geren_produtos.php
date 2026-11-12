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

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $acao = $_POST["acao"];

    try {

        //cadastrar
        if ($acao === "cadastrar") {

            $nome = trim($_POST["nome"]);
            $descricao = trim($_POST["descricao"]);
            $preco = $_POST["preco"];
            $quant_estoque = $_POST["quant_estoque"];
            $foto = trim($_POST["foto"]);
            $id_categoria = $_POST["id_categoria"];

            $status = ($quant_estoque > 0) ? "com estoque" : "sem estoque";

            $sql = "INSERT INTO Produto (nome, descricao, preco, quant_estoque, foto, id_categoria, status) VALUES (?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "sdsisis", $nome, $descricao, $preco, $quant_estoque, $foto, $id_categoria, $status);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: geren_produtos.php?cadastro=sucesso");
            exit();
        }

        if ($acao === "editar") {

            $id_produto = $_POST["id_produto"];
            $nome = trim($_POST["nome"]);
            $descricao = trim($_POST["descricao"]); 
            $preco = $_POST["preco"];
            $quant_estoque = $_POST["quant_estoque"];
            $foto = trim($_POST["foto"]);
            $id_categoria = $_POST["id_categoria"];

            $status = ($quant_estoque > 0) ? "com estoque" : "sem estoque";

            $sql = "UPDATE Produto SET nome = ?, descricao = ?, preco = ?, quant_estoque = ?, foto = ?, id_categoria = ?, status = ? WHERE id_produto = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "sdsisisi", $nome, $descricao, $preco, $quant_estoque, $foto, $id_categoria, $status, $id_produto);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: geren_produtos.php?edicao=sucesso");
        }

        if ($acao === "excluir") {

            $id_produto = $_POST["id_produto"];

            $sql = "DELETE FROM Produto WHERE id_produto = ?";

            $stmt = mysqli_prepare($conn, $sql);

            mysqli_stmt_bind_param($stmt, "i", $id_produto);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            header("Location: geren_produtos.php?exclusao=sucesso");
            exit();
        }
    } catch (mysqli_sql_exception $e) {
        header("Location: geren_produtos.php?erro=operacao");
        exit();
    }
}

// buscar produto para edição

$produto_editar = null;

if (isset($_GET["editar"])) {
    $id_produto = $_GET["editar"];

    $sql = "SELECT * FROM Produto WHERE id_produto = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_produto);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_query($conn, $sql);
    $produto_editar = mysqli_fetch_assoc($resultado);

    mysqli_stmt_close($stmt);
}

//listar categorias

$sql = "SELECT * FROM CategoriaProduto ORDER BY nome";

$resultado_categorias = mysqli_query($conn, $sql);

//listar produtos

$sql = "SELECT Produto.*, CategoriaProduto.nome AS nome_categoria FROM Produto INNER JOIN CategoriaProduto ON Produto.id_categoria = CategoriaProduto.id_categoria ORDER BY Produto.nome";

$resultado_produtos = mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>

    <link rel="stylesheet" href="../css/estilo.css">
</head>

<body>
    <header>
        <h2 class="nav_titulo">My Little Cine</h2>

        <nav class="nav_container">

            <a href="index_admin.php" class="nav_link">Painel Administrativo</a>

        </nav>
    </header>

    <main>
        <section>

            <h2>Gerenciar Produtos</h2>

            <!-- mensagens de retorno -->

            <?php if (isset($_GET["cadastro"])): ?>
                <p>Produto cadastrado com sucesso!</p>

            <?php elseif (isset($_GET["edicao"])): ?>
                <p>Produto atualizado com sucesso!</p>
                
            <?php elseif (isset($_GET["exclusao"])): ?>
                <p>Produto excluído com sucesso!</p>

            <?php elseif (isset($_GET["erro"])): ?>
                <p>Não foi possível realizar a operação.</p>

            <?php endif; ?>

            <!-- formulario de cadastro e edição -->

            <div>

                <h3>
                    <?php echo $produto_editar ? "Editar Produto" : "Cadastrar Produto"; ?>
                </h3>

                <form action="geren_produtos.php" method="POST">

                    <input 
                    type="hidden"
                    name=acao
                    value="<?php echo $produto_editar ? 'editar' : 'cadastrar'; ?>">

                    <?php if ($produto_editar): ?>
                        <input type="hidden"
                        name="id_produto"
                        value="<?php echo $produto_editar['id_produto']; ?>">

                    <?php endif; ?>

                    <label for="nome">Nome do produto:</label>

                    <input type="text"
                    id="nome"
                    name="nome"
                    maxlength="100"
                    required
                    value="<?php echo htmlspecialchars($produto_editar['nome'] ?? '');?>">

                    <br>

                    <label for="descricao">Descrição do produto:</label>

                    <textarea name="descricao" id="descricao"><?php echo htmlspecialchars($produto_editar['descricao'] ?? ''); ?></textarea>

                    <br>

                    <label for="preco">Preço (R$):</label>

                    <input type="
                    number"
                    id="preco"
                    name="preco"
                    min="0.01"
                    step="0.01"
                    required
                    value="<?php echo htmlspecialchars($produto_editar['preco'] ?? ''); ?>">

                    <br>

                    <label for="quant_estoque">Quantidade em estoque:</label>

                    <input type="number"
                    id="quant_estoque"
                    name="quant_estoque"
                    min="0"
                    step="1"
                    required
                    value="<?php echo htmlspecialchars($produto_editar['quant_estoque'] ?? '0'); ?>">

                    <br>

                    <label for="foto">Foto:</label>

                    <input type="text"
                    id="foto"
                    name="foto"
                    required
                    value="<?php echo htmlspecialchars($produto_editar['foto'] ?? ''); ?>">

                    <br>

                    <label for="id_categoria">Categoria:</label>

                    <select name="id_categoria" id="id_categoria" required>

                        <option value="">Selecione uma categoria</option>

                        <?php while ($categoria = mysqli_fetch_assoc($resultado_categorias)): ?>

                            <option value="<?php echo $categoria['id_categoria']; ?>"

                                <?php if ($produto_editar&& $produto_editar['id_categoria'] == $categoria['id_categoria']) {
                                echo "selected";
                            }?>
                            
                            > 
                                <?php echo htmlspecialchars($categoria['nome']);?>
                  
                            </option>

                        <?php endwhile; ?>

                    </select>

                    <br>

                    <button type="submit">
                        <?php echo $produto_editar ? "Salvar Alterações" : "Cadastrar Produto"; ?>
                    </button>

                    <?php if ($produto_editar): ?>
                        <a href="geren_produtos.php">Cancelar edição</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- listagem dos produtos -->

            <div>

                <h3>Produtos Cadastrados</h3>

                <?php if (mysqli_num_rows($resultado_produtos) > 0): ?>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Status</th>
                                <th>Categoria</th>
                                <th>Ações</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php while ($produto = mysqli_fetch_assoc($resultado_produtos)): ?>

                                <tr>
                                    <td>
                                        <?php echo $produto['id_produto'];?>
                                    </td>

                                    <td>
                                        <img src="<?php echo htmlspecialchars($produto['foto']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($produto['nome']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($produto['descricao'] ??''); ?>
                                    </td>

                                    <td>
                                        R$
                                        <?php number_format($produto['preco'], 2, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?php echo $produto['quant_estoque'];?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($produto['status']); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($produto['nome_categoria']); ?>
                                    </td>

                                    <td>
                                        <a href="geren_produtos.php?editar=<?php echo $produto['id_produto']; ?>">
                                            Editar
                                        </a>

                                        <form action="geren_produtos.php" method="POST"
                                        onsubmit="return confirm('Deseja realmente excluir este produto?');">
                                          
                                            <input type="hidden" name="acao" value="excluir">
                                            <input type="hidden" name="id_produto" value="<?php echo $produto['id_produto']?>">

                                            <button type="submit">Excluir</button>
                                    
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; ?>

                        </tbody>
                    </table>

                <?php else:?>
                    <p>Nenhum produto cadastrado.</p>
                <?php endif; ?>

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