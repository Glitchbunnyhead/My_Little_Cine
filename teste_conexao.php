<?php
session_start();
require_once "conexao/conexao.php";
$sql = "SELECT * FROM Usuario";
$stmt = $conn->prepare($sql);
$stmt->execute();
$resultado = $stmt->get_result();

while($row = $resultado->fetch_assoc()) {
    echo "ID: " . $row["id_usuario"] . "<br>";
    echo "Nome: " . $row["nome"] . "<br>";
    echo "Email: " . $row["email"] . "<br>";
    echo "CPF: " . $row["cpf"] . "<br>";
    echo "Tipo" . $row["tipo"] . "<br>";
    echo "<hr>";
}

?>