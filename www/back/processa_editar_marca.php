<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit;
}

$id = $_POST["id"] ?? 0;
$marca = trim($_POST["marca"] ?? "");

if (empty($marca)) {

    $_SESSION["erro"] = "Informe o nome da marca.";

    header("Location: ../editar_marca.php?id=".$id);
    exit;
}

require_once("../config/conecta.php");


//verifica marca com mesmo nome
$sql = "
SELECT id
FROM marcas
WHERE marca = ?
AND id <> ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "si", $marca, $id);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) > 0){

    $_SESSION["erro"] = "Já existe uma marca com esse nome.";

    header("Location: ../editar_marca.php?id=".$id);
    exit;
}

$sql = "
UPDATE marcas
SET marca = ?
WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "si", $marca, $id);

if(mysqli_stmt_execute($stmt)){

    $_SESSION["msg"] = "Marca atualizada com sucesso.";

}else{

    $_SESSION["erro"] = "Erro ao atualizar a marca.";

}

header("Location: ../marcas.php");
exit;