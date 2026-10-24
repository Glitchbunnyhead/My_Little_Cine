<?php 
    session_start();
    require_once "conexao/conexao.php"; 

    $idSala = $_POST["id_sala"] ?? "";
    $assentosSelecionados = $_POST['assentos'] ?? [];

    if (count($assentosSelecionados) == 0) {
        header("Location: assentos.php?id=" . $idSala . "&erro=nenhum_assento");
        exit;
    } else {
        foreach ($assentosSelecionados as $assento) { 
            $assentoFileira = substr($assento, 0, 1); 
            $assentoNumero = substr($assento, 1);    

            $sqlAssentos = "UPDATE Assento SET estado = 'ocupado' WHERE id_sala = ? AND fileira = ? AND numero = ?";
            $stmtAssentos = $conn->prepare($sqlAssentos);
            
            $stmtAssentos->execute([$idSala, $assentoFileira, $assentoNumero]);
        }
    }
  
    $_SESSION['qntAssentos'] = count($assentosSelecionados);
    
    
    header("Location: ingressos.php");
    exit;
?>