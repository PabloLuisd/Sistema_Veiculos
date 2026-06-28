<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

require_once("config/conecta.php");

$id = $_GET["id"] ?? 0;
$editar = false;

$modelo = "";
$marca_id = "";
$potencia = "";
$ano_fabricacao = "";
$tipo = "";

if ($id > 0) {

    $editar = true;

    $sql = "SELECT * FROM veiculos WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 0) {
        header("Location: dashboard.php");
        exit;
    }

    $veiculo = mysqli_fetch_assoc($resultado);

    $modelo = $veiculo["modelo"];
    $marca_id = $veiculo["marca_id"];
    $potencia = $veiculo["potencia"];
    $ano_fabricacao = $veiculo["ano_fabricacao"];
    $tipo = $veiculo["tipo"];
}

$sql = "SELECT id, marca FROM marcas ORDER BY marca";
$resultadoMarcas = mysqli_query($conn, $sql);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?= $editar ? "Editar Veículo" : "Novo Veículo" ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

    body{
        background:#f4f7fa;
    }

    .container-form{
        max-width:700px;
        margin:50px auto;
    }

    .card{
        border:none;
        border-radius:15px;
        box-shadow:0 5px 20px rgba(0,0,0,.1);
    }

    .card-header{
        background:#252547;
        color:white;
        font-size:20px;
        font-weight:bold;
    }

    .btn-salvar{
        background:#77c9d4;
        border:none;
    }

    .btn-salvar:hover{
        background:#63b7c3;
}

</style>

</head>

<body>

<div class="container-form">

<div class="card">

<div class="card-header">
<?= $editar ? "Editar Veículo" : "Cadastro de Veículo" ?>
</div>

<div class="card-body">

<form method="POST" action="<?= $editar ? "back/editar_veiculo.php" : "back/processa_veiculo.php" ?>">

<?php if($editar): ?>
<input type="hidden" name="id" value="<?= $id ?>">
<?php endif; ?>

<div class="mb-3">

<label class="form-label">Modelo</label>

<input
type="text"
name="modelo"
class="form-control"
value="<?= htmlspecialchars($modelo) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Marca</label>

<select
name="marca_id"
class="form-select"
required>

<option value="">Selecione uma marca</option>

<?php while($marca = mysqli_fetch_assoc($resultadoMarcas)): ?>

<option
value="<?= $marca["id"] ?>"
<?= $marca["id"] == $marca_id ? "selected" : "" ?>>

<?= htmlspecialchars($marca["marca"]) ?>

</option>

<?php endwhile; ?>

</select>

</div>

<div class="mb-3">

<label class="form-label">Potência (CV)</label>

<input
type="number"
name="potencia"
class="form-control"
value="<?= htmlspecialchars($potencia) ?>"
required>

</div>

<div class="mb-3">

<label class="form-label">Ano de Fabricação</label>

<input
type="number"
name="ano_fabricacao"
class="form-control"
min="1900"
max="<?= date("Y") ?>"
value="<?= htmlspecialchars($ano_fabricacao) ?>"
required>

</div>

<div class="mb-4">

<label class="form-label d-block">Tipo</label>

<?php
$tipos = ["Carro","Moto","Caminhão"];

foreach($tipos as $t):
?>

<div class="form-check form-check-inline">

<input
class="form-check-input"
type="radio"
name="tipo"
value="<?= $t ?>"
<?= $tipo == $t ? "checked" : "" ?>
required>

<label class="form-check-label">

<?= $t ?>

</label>

</div>

<?php endforeach; ?>

</div>

<div class="d-flex justify-content-between">

<a href="dashboard.php" class="btn btn-secondary">

Voltar

</a>

<button
type="submit"
name="salvar"
class="btn btn-salvar text-white">

<?= $editar ? "Atualizar Veículo" : "Salvar Veículo" ?>

</button>

</div>

</form>

</div>

</div>

</div>

</body>
</html>