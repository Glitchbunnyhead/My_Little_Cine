<?php
    session_start();
    require_once "conexao/conexao.php"; 

     $qnt_produtos = $_POST["quantidade"];
     foreach ($qnt_produtos as $id_produto => $qnt ){
        $qnt = (int) $qnt;
        if ($qnt <= 0) {
            continue; 
        }
        else{ 
            $sqlProdutos = "SELECT * FROM Produto WHERE id_produto = ? ";
            $stmtProdutos = $conn -> prepare($sqlProdutos);
            $stmtProdutos -> bind_param("i",$id_produto);
            $stmtProdutos->execute();
            $resultadoProdutos = $stmtProdutos->get_result();
            $produto = $resultadoProdutos->fetch_assoc();

            if ($qnt > $produto['quant_estoque'] ){
                $_SESSION['erro'] = "A quantidade solicitada de um dos itens é maior que o estoque disponível (". $produto['quant_estoque'] . " unidades).";
                header('Location: produtos.php');
                exit;
            }
        }
     }
    
     $precoTotal = 0;
     foreach ($qnt_produtos as $id_produto => $qnt){
        $qnt = (int) $qnt;
        if ($qnt <= 0){
            continue;
        }
        $sqlProdutos = "SELECT * FROM Produto WHERE id_produto = ? ";
        $stmtProdutos = $conn -> prepare($sqlProdutos);
        $stmtProdutos -> bind_param("i",$id_produto);
        $stmtProdutos->execute();
        $resultadoProdutos = $stmtProdutos->get_result();
        $produto = $resultadoProdutos->fetch_assoc();

        $sqlAtualizarEst = "UPDATE Produto SET quant_estoque = quant_estoque - ? WHERE id_produto = ? ";
        $stmtAtualizarEst = $conn->prepare($sqlAtualizarEst);
        $stmtAtualizarEst->bind_param("ii",$qnt,$id_produto);
        $stmtAtualizarEst->execute();
        $precoTotal = $precoTotal + ($qnt * $produto['preco']);
        
        
     }
        $_SESSION['valorTotalProdutos'] = $precoTotal;
        header('Location: finalizar_pagamento.php');
        exit;
     

?>