<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    $_SESSION["erro"] = "Faça login para acessar o sistema.";
    header("Location: index.php");
    exit;
}
?>