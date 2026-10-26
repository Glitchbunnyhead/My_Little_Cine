<?php
    session_start();
    require_once "conexao/conexao.php"; 

    $qntReservados = isset($_SESSION['qntAssentos']) ? (int)$_SESSION['qntAssentos'] : 0;
    $ingressosInteiras = (int)$_POST["qntInteira"] ?? 0;
    $ingressosMeia = (int)$_POST["qntMeia"] ?? 0;
    $precoInteira = (float)$_POST["inteira"] ?? 0;
    $precoMeia = (float)$_POST["meia"] ?? 0;

    if ((empty($ingressosInteiras) && empty($ingressosMeia)) || ($ingressosInteiras + $ingressosMeia) != $qntReservados){
        header("Location: ingressos.php?erro=quantidade_invalida");
        exit;
    }
    else{
        $_SESSION['valorIngressosInteiras'] = $ingressosInteiras * $precoInteira ;
        $_SESSION['valorIngressosMeias'] = $ingressosMeia * $precoMeia;
        header("Location: produtos.php");
        exit;
    }

?>