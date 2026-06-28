<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit;
}

$id = $_GET["id"] ?? 0;

if (empty($id)) {

    $_SESSION["erro"] = "Marca não informada.";

    header("Location: ../dashboard.php");
    exit;
}

require_once("../config/conecta.php");

//verifica se tem veiculo utilizando a marca
$sql = "
SELECT id
FROM veiculos
WHERE marca_id = ?
LIMIT 1
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    $_SESSION["erro"] =
        "Não é possível excluir esta marca, pois existem veículos vinculados a ela.";

    header("Location: ../marcas.php");
    exit;
}

$sql = "
DELETE FROM marcas
WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    $_SESSION["msg"] =
        "Marca excluída com sucesso!";

} else {

    $_SESSION["erro"] =
        "Erro ao excluir marca.";
}

mysqli_close($conn);

header("Location: ../dashboard.php");
exit;