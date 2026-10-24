<?php
    session_start();
    require_once "conexao/conexao.php";
    echo "Quantidade de ingressos reservados: " . htmlspecialchars($_SESSION['qntAssentos'] ?? '0');  
    ?>