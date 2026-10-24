<?php 

session_start();

require_once ('conexao/conexao.php');

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = "SELECT * FROM Usuario WHERE email = ? AND senha = ?";

$stmt = $conn -> prepare($sql);

$stmt -> bind_param("ss", $email, $senha);

$stmt -> execute();

$resultado = $stmt -> get_result();

// echo "consulta encontrada";
// echo "usuarios encontrados: " . $resultado -> num_rows;
// exit;

if ($resultado -> num_rows == 1) {
    $usuario = $resultado -> fetch_assoc();

    $_SESSION['usuario'] = $usuario;
    $_SESSION['id_usuario'] = $usuario['id_usuario'];
    $_SESSION['nome'] = $usuario['nome'];
    $_SESSION['email'] = $usuario['email'];
    $_SESSION['senha'] = $usuario['senha'];
    $_SESSION['cpf'] = $usuario['cpf'];
    $_SESSION['data_nascimento'] = $usuario['data_nascimento'];
    $_SESSION['tipo'] = $usuario['tipo'];
    
    
   
    header("Location: index_usuario.php");

    exit;
    

} else {
    header("Location: login.php?erro=credenciais");
    exit;
}


?>