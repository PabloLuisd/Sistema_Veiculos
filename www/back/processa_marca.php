<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit;
}

if (!isset($_POST["salvar"])) {
    header("Location: ../marca_form.php");
    exit;
}

$marca = trim($_POST["marca"] ?? "");

if (empty($marca)) {

    $_SESSION["erro"] = "Informe o nome da marca.";

    header("Location: ../marca_form.php");
    exit;
}

require_once("../config/conecta.php");

$sql = "SELECT id FROM marcas WHERE marca = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $marca);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    $_SESSION["erro"] = "Esta marca já está cadastrada.";

    mysqli_close($conn);

    header("Location: ../marca_form.php");
    exit;
}

$sql = "INSERT INTO marcas (marca) VALUES (?)";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $marca);

if (mysqli_stmt_execute($stmt)) {

    $_SESSION["msg"] = "Marca cadastrada com sucesso!";

} else {

    $_SESSION["erro"] = "Erro ao cadastrar a marca.";

}

mysqli_close($conn);

header("Location: ../marcas.php");
exit;