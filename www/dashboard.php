<?php
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: index.php");
    exit;
}

require_once("config/conecta.php");

$sql = "
SELECT
    v.id,
    v.modelo,
    v.marca_id,
    m.marca,
    v.potencia,
    v.ano_fabricacao,
    v.tipo
FROM veiculos v
INNER JOIN marcas m ON m.id = v.marca_id
ORDER BY v.modelo
";

$resultado = mysqli_query($conn, $sql);

$sqlMarcas = "SELECT id, marca FROM marcas ORDER BY marca";
$resultadoMarcas = mysqli_query($conn, $sqlMarcas);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f4f7fa;
            font-family:Arial, Helvetica, sans-serif;
        }

        .topbar{
            background:#252547;
            color:white;
            padding:20px 40px;
        }

        .welcome{
            background:white;
            color:#252547;
            padding:10px 20px;
            border-radius:5px;
            display:inline-block;
            font-weight:bold;
        }

        .logout-btn{
            background:white;
            color:#252547;
            text-decoration:none;
            padding:10px 20px;
            border-radius:5px;
            font-weight:bold;
        }

        .logout-btn:hover{
            background:#ececec;
        }

        .content{
            padding:50px;
        }

        .card-table{
            background:white;
            border-radius:10px;
            overflow:hidden;
            box-shadow:0 5px 15px rgba(0,0,0,.08);
        }

        .table-header{
            background:#252547;
            color:white;
            padding:15px 20px;
        }

        .btn-add{
            background:#77c9d4;
            border:none;
            color:white;
            padding:10px 15px;
            border-radius:5px;
            text-decoration:none;
            font-weight:bold;
        }

        .btn-add:hover{
            background:#63b7c3;
            color:white;
        }

        .table thead{
            background:#252547;
            color:white;
        }

        .table{
            margin-bottom:0;
        }

        .acoes a{
            text-decoration:none;
            font-size:20px;
            margin-right:10px;
        }

        .editar{
            color:#0d6efd;
        }

        .excluir{
            color:#dc3545;
        }

        .sem-registros{
            text-align:center;
            padding:40px;
            color:#777;
        }
    </style>
</head>

<body>

    <div class="topbar">
        <div class="container-fluid d-flex justify-content-between align-items-center">

            <div class="welcome">
                Bem-vindo, <?= htmlspecialchars($_SESSION["usuario_nome"]); ?>
            </div>

            <a href="back/logout.php" class="logout-btn">
                Logout
            </a>

        </div>
    </div>

    <div class="content">

        <?php if(isset($_SESSION['msg'])): ?>
            <div class="alert alert-success">
                <?= $_SESSION['msg']; ?>
            </div>
            <?php unset($_SESSION['msg']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['erro'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['erro']; ?>
            </div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>

        <div class="card-table">

            <div class="table-header d-flex justify-content-between align-items-center">

                <h4 class="m-0">
                    Veículos Cadastrados
                </h4>

                <div>

                   <div class="d-flex gap-2">

                        <a href="marcas.php" class="btn-add">
                            Adicionar Marca
                        </a>

                        <a href="veiculo_form.php" class="btn-add">
                            Adicionar Veículo
                        </a>
                        
                    </div>
                </div>
            </div>

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Potência</th>
                        <th>Ano Fabricação</th>
                        <th>Tipo</th>
                        <th width="120">Ações</th>
                    </tr>
                </thead>

                <tbody>

                <?php if(mysqli_num_rows($resultado) > 0): ?>

                    <?php while($veiculo = mysqli_fetch_assoc($resultado)): ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($veiculo["modelo"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($veiculo["marca"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($veiculo["potencia"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($veiculo["ano_fabricacao"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($veiculo["tipo"]) ?>
                        </td>

                        <td class="acoes">

                           <a
                                href="#"
                                class="editar"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEditar"
                                data-id="<?= $veiculo["id"] ?>"
                                data-modelo="<?= htmlspecialchars($veiculo["modelo"]) ?>"
                                data-marca="<?= $veiculo["marca_id"] ?>"
                                data-potencia="<?= $veiculo["potencia"] ?>"
                                data-ano="<?= $veiculo["ano_fabricacao"] ?>"
                                data-tipo="<?= $veiculo["tipo"] ?>"
                                title="Editar">
                                ✏️
                            </a>

                            <a
                                href="back/excluir_veiculo.php?id=<?= $veiculo["id"] ?>"
                                class="excluir"
                                title="Excluir"
                                onclick="return confirm('Deseja realmente excluir este veículo?')">
                                🗑️
                            </a>

                        </td>

                    </tr>

                    <?php endwhile; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="6" class="sem-registros">
                            Nenhum veículo cadastrado.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>
</div>

    </div>

    <!-- EDITAR -->
<div class="modal fade" id="modalEditar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="POST" action="back/editar_veiculo.php">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Editar Veículo
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="id" id="edit-id">

                    <div class="mb-3">
                        <label class="form-label">Modelo</label>

                        <input
                            type="text"
                            name="modelo"
                            id="edit-modelo"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Marca</label>

                        <select
                            name="marca_id"
                            id="edit-marca"
                            class="form-select"
                            required>

                            <?php
                            mysqli_data_seek($resultadoMarcas, 0);

                            while($marca = mysqli_fetch_assoc($resultadoMarcas)):
                            ?>

                                <option value="<?= $marca['id'] ?>">
                                    <?= $marca['marca'] ?>
                                </option>

                            <?php endwhile; ?>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Potência
                        </label>

                        <input
                            type="number"
                            name="potencia"
                            id="edit-potencia"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Ano de Fabricação
                        </label>

                        <input
                            type="number"
                            name="ano_fabricacao"
                            id="edit-ano"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">

                        <label class="form-label d-block">
                            Tipo
                        </label>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="tipo"
                                value="Carro"
                                id="tipoCarro">

                            <label class="form-check-label">
                                Carro
                            </label>

                        </div>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="tipo"
                                value="Moto"
                                id="tipoMoto">

                            <label class="form-check-label">
                                Moto
                            </label>

                        </div>

                        <div class="form-check form-check-inline">

                            <input
                                class="form-check-input"
                                type="radio"
                                name="tipo"
                                value="Caminhão"
                                id="tipoCaminhao">

                            <label class="form-check-label">
                                Caminhão
                            </label>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="btn btn-success">
                        Salvar Alterações
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>

document.querySelectorAll('.editar').forEach(botao => {

    botao.addEventListener('click', function() {

        document.getElementById('edit-id').value =
            this.dataset.id;

        document.getElementById('edit-modelo').value =
            this.dataset.modelo;

        document.getElementById('edit-marca').value =
            this.dataset.marca;

        document.getElementById('edit-potencia').value =
            this.dataset.potencia;

        document.getElementById('edit-ano').value =
            this.dataset.ano;

        document.querySelectorAll('input[name="tipo"]').forEach(radio => {

            radio.checked =
                radio.value === this.dataset.tipo;

        });

    });

});

</script>
</body>
</html>