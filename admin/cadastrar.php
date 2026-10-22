<?php 

if (isset($_POST['submit'])) {
   
    include_once('../conexao/conexao.php');
   
    $nome = $_POST['name'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $nascimento = $_POST['nascimento'];
    $tipo = "Cliente";

    $result = mysqli_query($conn, "INSERT INTO Usuario(nome, email, senha, cpf, data_nascimento, tipo) VALUES ('$nome','$email','$senha','$cpf','$nascimento', '$tipo')");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <header>


    </header>


    <main>
        <form action="cadastrar.php" method="POST">


        <label for="name">Nome completo:</label>
        <input type="text" id="name" name="name" required>

        <br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <br>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>
       
        <br>

        <label for="cpf">CPF:</label>
        <input type="cpf" id="cpf" name="cpf" required>

        <br>

        <label for="nascimento">Data de Nascimento:</label>
        <input type="date" id="nascimento" name="nascimento" required>

        <br>

        <!-- <label for="tipo">Tipo:</label>
        <input type="tipo" id="tipo" name="tipo" required>
        <br> -->


        <button type="submit" name="submit">Cadastrar</button>


        <button type="reset">Limpar</button>
       
        </form>


        <a href="../login.php">Já tenho uma conta - fazer login</a>
        <!-- esse link para voltar para a pagina de apresnetação que tem as opcoes de cadastro e login -->
    </main>


    <footer></footer>
   
</body>
</html>
