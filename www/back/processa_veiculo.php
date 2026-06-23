<?php

session_start();

if (!isset($_POST["salvar"])) {
    header("Location: ../dashboard.php");
    exit;
}

$modelo = trim($_POST["modelo"] ?? "");
$marca_id = $_POST["marca_id"] ?? "";
$potencia = trim($_POST["potencia"] ?? "");
$ano_fabricacao = trim($_POST["ano_fabricacao"] ?? "");
$tipo = trim($_POST["tipo"] ?? "");

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

    header("Location: ../veiculo_form.php");
    exit;
}

require_once("../config/conecta.php");

$sql = "
INSERT INTO veiculos
(modelo, marca_id, potencia, ano_fabricacao, tipo)
VALUES
(?, ?, ?, ?, ?)
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {

    $_SESSION["erro"] = "Erro ao preparar consulta.";

    header("Location: ../veiculo_form.php");
    exit;
}

mysqli_stmt_bind_param(
    $stmt,
    "siiss",
    $modelo,
    $marca_id,
    $potencia,
    $ano_fabricacao,
    $tipo
);

if (mysqli_stmt_execute($stmt)) {

    $_SESSION["msg"] = "Veículo cadastrado com sucesso!";

} else {

    $_SESSION["erro"] = "Erro ao cadastrar veículo.";

    header("Location: ../veiculo_form.php");
    exit;
}

mysqli_close($conn);

header("Location: ../dashboard.php");
exit;