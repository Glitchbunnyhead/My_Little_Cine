<?php
    $host = "db";
    $usuario = "root";
    $senha = "root";
    $banco = "WEBSITE_CINEMA";
    
    $conn = new mysqli($host, $usuario, $senha, $banco);
    
    if ($conn->connect_error) {
    die("Falha na conexão: " . 
    
    $conn->connect_error);

     } 
    //  else {
    //     echo "conexao efetuada com sucesso!";
    // } 


    // comentario de vitoria: troquei o valor do host para "locaçhost" e deixei a senha em branco para funcionar no meu computador, mas acho que isso vai ficar mudando de computador pra computador mesmo
?>;