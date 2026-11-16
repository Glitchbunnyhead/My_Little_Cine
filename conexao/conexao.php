<?php
    $host = "db";
    $usuario = "root";
    $senha = "root";
    $banco = "WEBSITE_CINEMA";
    
    $conn = new mysqli($host, $usuario, $senha, $banco);
    
    if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
     } 
?>