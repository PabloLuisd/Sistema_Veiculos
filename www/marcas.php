<?php
    session_start();

    if (!isset($_SESSION["usuario_id"])) {
        header("Location: index.php");
        exit;
    }

    require_once("config/conecta.php");

    // Consulta de veículos (caso vá usar mais abaixo na página)
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

    // Consulta de marcas unificada no topo
    $sqlMarcas = "SELECT id, marca FROM marcas ORDER BY marca";
    $resMarcas = mysqli_query($conn, $sqlMarcas);
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
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body{
            background: #f4f7fa;
            font-family: Arial, Helvetica, sans-serif;
        }

        .topbar{
            background: #252547;
            color: white;
            padding: 20px 40px;
        }

        .welcome{
            background: white;
            color: #252547;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            font-weight: bold;
        }

        .logout-btn{
            background: white;
            color: #252547;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
        }

        .logout-btn:hover{
            background: #ececec;
        }

        .content{
            padding: 50px;
        }

        .card-table{
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,.08);
        }

        .table-header{
            background: #252547;
            color: white;
            padding: 15px 20px;
        }

        .btn-add{
            background: #77c9d4;
            border: none;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-add:hover{
            background: #63b7c3;
            color: white;
        }

        .table thead{
            background: #252547;
            color: white;
        }

        .table{
            margin-bottom: 0;
        }

        .acoes a{
            text-decoration: none;
            font-size: 20px;
            margin-right: 10px;
        }

        .editar{
            color: #0d6efd;
        }

        .excluir{
            color: #dc3545;
        }

        .sem-registros{
            text-align: center;
            padding: 40px;
            color: #777;
        }
    </style>
</head>

<body>

<div class="container content">

    <div class="card-table">

        <div class="table-header d-flex justify-content-between align-items-center">
            <h4 class="m-0">Marcas Cadastradas</h4>
            <a href="marca_form.php" class="btn-add">Adicionar Marca</a>
        </div>

        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="100">ID</th>
                    <th>Marca</th>
                    <th width="120">Ações</th>
                </tr>
            </thead>

            <tbody>
            <?php if(mysqli_num_rows($resMarcas) > 0): ?>
                <?php while($marca = mysqli_fetch_assoc($resMarcas)): ?>
                    <tr>
                        <td><?= $marca["id"] ?></td>
                        <td><?= htmlspecialchars($marca["marca"]) ?></td>
                        <td class="acoes">
                        <a
                            href="editar_marca.php?id=<?= $marca["id"] ?>"
                            class="editar"
                            title="Editar">
                            ✏️
                        </a>

                        <a
                            href="back/excluir_marca.php?id=<?= $marca["id"] ?>"
                            class="excluir"
                            title="Excluir"
                            onclick="return confirm('Deseja realmente excluir esta marca?')">
                            🗑️
                        </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="sem-registros">
                        Nenhuma marca cadastrada.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>