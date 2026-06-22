<?php
session_start();

if (isset($_SESSION["usuario_id"])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_SESSION['msg'])) {
    echo "<script>alert('" . $_SESSION['msg'] . "');</script>";
    unset($_SESSION['msg']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Login</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body{
        background:#f4f7fa;
        height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
    }

    .login-card{
        width:100%;
        max-width:400px;
        padding:40px;
        border:none;
        border-radius:15px;
        box-shadow:0 5px 20px rgba(0,0,0,.1);
    }

    .btn-custom{
        background:#77c9d4;
        border:none;
    }

    .btn-custom:hover{
        background:#63b7c3;
    }

    .logo{
        color:#77c9d4;
        font-size:50px;
        text-align:center;
    }
</style>

</head>


<div class="card login-card">

    <div class="logo">
        🚗
    </div>

    <h3 class="text-center mb-4">
        Sistema de Veículos
    </h3>

    <form method="POST" action="back/processa_login.php">

        <?php if (isset($_SESSION['erro'])) : ?>
            <div class="alert alert-danger text-center">
                <?= $_SESSION['erro']; ?>
            </div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>

        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control">
        </div>

        <div class="mb-4">
            <label class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control">
        </div>

        <button class="btn btn-custom text-white w-100" name="enviar">
            Entrar
        </button>

        <div class="text-center mt-3">
            Não possui conta?
        <a href="cadastro.php" style="color:#77c9d4;text-decoration:none;">
            Cadastre-se
        </a>
</div>

    </form>

</div>

</body>
</html>