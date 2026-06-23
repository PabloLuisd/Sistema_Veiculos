<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET["id"] ?? 0;

if (empty($id)) {

    $_SESSION["erro"] = "Veículo não informado.";

    header("Location: ../dashboard.php");
    exit;
}

require_once("../config/conecta.php");

$sql = "DELETE FROM veiculos WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {

    $_SESSION["erro"] = "Erro ao processar exclusão.";

    header("Location: ../dashboard.php");
    exit;
}

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    $_SESSION["msg"] = "Veículo excluído com sucesso!";

} else {

    $_SESSION["erro"] = "Erro ao excluir veículo.";
}

mysqli_close($conn);

header("Location: ../dashboard.php");
exit;