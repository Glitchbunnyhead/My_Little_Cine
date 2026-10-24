<?php

session_start();

//session_unset();
$_SESSION = [];

session_destroy();

header("Location: index_usuario.php");
exit;
?>