<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: ../index.php");
    exit;
}

require_once("../config/conecta.php");

$id = $_POST["id"];
$modelo = $_POST["modelo"];
$marca_id = $_POST["marca_id"];
$potencia = $_POST["potencia"];
$ano_fabricacao = $_POST["ano_fabricacao"];
$tipo = $_POST["tipo"];

$erros = [];

if (empty($modelo)) {
    $erros[] = "Informe o modelo.";
}

if (empty($marca_id)) {
    $erros[] = "Selecione uma marca.";
}

if (empty($potencia)) {
    $erros[] = "Informe a potência.";
}

if (empty($ano_fabricacao)) {
    $erros[] = "Informe o ano de fabricação.";
}
if($ano_fabricacao > date("Y")){
    $erros[] =
    "Ano de fabricação inválido.";
}

if (empty($tipo)) {
    $erros[] = "Selecione o tipo do veículo.";
}

if (!empty($erros)) {

    $_SESSION["erro"] = implode("<br>", $erros);

    header("Location: ../dashboard.php");
    exit;
}

$sql = "
UPDATE veiculos
SET
    modelo = ?,
    marca_id = ?,
    potencia = ?,
    ano_fabricacao = ?,
    tipo = ?
WHERE id = ?
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "siiisi",
    $modelo,
    $marca_id,
    $potencia,
    $ano_fabricacao,
    $tipo,
    $id
);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION["msg"] = "Veículo atualizado com sucesso!";
} else {
    $_SESSION["erro"] = "Erro ao atualizar veículo.";
}

header("Location: ../dashboard.php");
exit;