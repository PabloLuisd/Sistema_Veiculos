<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Cadastro de Marca</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f4f7fa;
}

.container-form{
    max-width:600px;
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
}

</style>

</head>

<body>

<div class="container-form">

    <div class="card">

        <div class="card-header">
            Cadastro de Marca
        </div>

        <div class="card-body">

            <?php if(isset($_SESSION["erro"])): ?>
                <div class="alert alert-danger">
                    <?= $_SESSION["erro"] ?>
                </div>
                <?php unset($_SESSION["erro"]); ?>
            <?php endif; ?>

            <form method="POST" action="back/processa_marca.php">

                <div class="mb-3">
                    <label class="form-label">
                        Nome da Marca
                    </label>

                    <input
                        type="text"
                        name="marca"
                        class="form-control"
                        required>
                </div>

                <a href="dashboard.php" class="btn btn-secondary">
                    Voltar
                </a>

                <button
                    type="submit"
                    name="salvar"
                    class="btn btn-success">
                    Salvar
                </button>

            </form>

        </div>

    </div>

</div>

</body>
</html>