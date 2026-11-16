<?php
    session_start();
    require_once "conexao/conexao.php";

    if (!isset($_SESSION['id_usuario']) || (int) $_SESSION['id_usuario'] <= 0) {
        header("Location: login.php");
        exit();
    }

    $idUsuario = (int) $_SESSION['id_usuario'];
    $valorTotal = (float) ($_POST['valor_total'] ?? 0);
    $modoPagamento = trim($_POST['modo_pagamento'] ?? '');

    if (empty($modoPagamento)) {
        $_SESSION['erro'] = "Selecione uma forma de pagamento.";
        header('Location: finalizar_pagamento.php');
        exit();
    }

    if ($valorTotal <= 0) {
        $_SESSION['erro'] = "Valor total inválido.";
        header('Location: finalizar_pagamento.php');
        exit();
    }

    $sqlVenda = "INSERT INTO Venda (valor_total, forma_pagamento, status, id_usuario) VALUES (?, ?, ?, ?)";
    $stmtVenda = $conn->prepare($sqlVenda);
    $stmtVenda->execute([$valorTotal, $modoPagamento, 'concluido', $idUsuario]);

    $_SESSION['ultima_venda_id'] = $conn->insert_id;

    header("Location: pagamento_sucesso.php");
    exit();
?>
