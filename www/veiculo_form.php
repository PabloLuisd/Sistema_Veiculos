<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

require_once("config/conecta.php");

$sql = "SELECT id, marca FROM marcas ORDER BY marca";
$resultadoMarcas = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Novo Veículo</title>

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
            Cadastro de Veículo
        </div>

        <div class="card-body">

            <form method="POST" action="back/processa_veiculo.php">

                <div class="mb-3">
                    <label class="form-label">Modelo</label>
                    <input
                        type="text"
                        name="modelo"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Marca</label>

                    <select
                        name="marca_id"
                        class="form-select"
                        required>

                        <option value="">
                            Selecione uma marca
                        </option>

                        <?php while($marca = mysqli_fetch_assoc($resultadoMarcas)): ?>

                            <option value="<?= $marca['id'] ?>">
                                <?= $marca['marca'] ?>
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
                        min="1"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ano de Fabricação</label>
                    <input
                        type="number"
                        name="ano_fabricacao"
                        class="form-control"
                        min="1900"
                        max="<?= date('Y') ?>"
                        required>
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">
                        Tipo
                    </label>

                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="tipo"
                            value="Carro"
                            required>

                        <label class="form-check-label">
                            Carro
                        </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="tipo"
                            value="Moto">

                        <label class="form-check-label">
                            Moto
                        </label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input
                            class="form-check-input"
                            type="radio"
                            name="tipo"
                            value="Caminhão">

                        <label class="form-check-label">
                            Caminhão
                        </label>
                    </div>

                </div>

                <div class="d-flex justify-content-between">

                    <a href="dashboard.php" class="btn btn-secondary">
                        Voltar
                    </a>

                    <button
                        type="submit"
                        name="salvar"
                        class="btn btn-salvar text-white">
                        Salvar Veículo
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

</body>
</html>