<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

require_once("config/conecta.php");

$id = $_GET["id"] ?? 0;

$sql = "SELECT * FROM marcas WHERE id = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "i", $id);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) == 0) {
    header("Location: dashboard.php");
    exit;
}

$marca = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Editar Marca</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fa;
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.card{
    width:100%;
    max-width:500px;
    padding:40px;
    border:none;
    border-radius:15px;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.btn-custom{
    background:#77c9d4;
    color:white;
    border:none;
}

.btn-custom:hover{
    background:#63b7c3;
    color:white;
}

</style>

</head>

<body>

<div class="card">

    <h3 class="text-center mb-4">
        Editar Marca
    </h3>

    <form method="POST" action="back/processa_editar_marca.php">

        <input
            type="hidden"
            name="id"
            value="<?= $marca["id"] ?>">

        <div class="mb-4">

            <label class="form-label">
                Marca
            </label>

            <input
                type="text"
                class="form-control"
                name="marca"
                value="<?= htmlspecialchars($marca["marca"]) ?>"
                required>

        </div>

        <div class="d-flex justify-content-between">

            <a
                href="dashboard.php"
                class="btn btn-secondary">
                Cancelar
            </a>

            <button
                type="submit"
                name="salvar"
                class="btn btn-custom">
                Salvar
            </button>

        </div>

    </form>

</div>

</body>
</html>