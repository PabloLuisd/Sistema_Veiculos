<?php
session_start();

if (isset($_SESSION["usuario_id"])) {
    header("Location: dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Cadastro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fa;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .cadastro-card {
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .1);
        }

        .logo {
            font-size: 50px;
            text-align: center;
            color: #77c9d4;
        }

        .btn-custom {
            background: #77c9d4;
            border: none;
        }

        .btn-custom:hover {
            background: #63b7c3;
        }

        .link-login {
            color: #77c9d4;
            text-decoration: none;
        }

        .alert {
            border-radius: 10px;
        }
    </style>
</head>

<body>

    <div class="card cadastro-card">

        <div class="logo">🚗</div>

        <h3 class="text-center mb-4">
            Criar Conta
        </h3>

        <?php if (isset($_SESSION['erro'])) : ?>
            <div class="alert alert-danger text-center">
                <?= $_SESSION['erro']; ?>
            </div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>

        <form method="POST" action="back/processa_cadastro.php">

            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input
                    type="text"
                    class="form-control"
                    name="nome"
                    placeholder="Digite seu nome"
                    required
                    minlength="3">
            </div>

            <div class="mb-3">
                <label class="form-label">E-mail</label>
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    placeholder="Digite seu e-mail"
                    required>
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input
                    type="password"
                    class="form-control"
                    name="senha"
                    placeholder="Digite sua senha"
                    required
                    minlength="6">
            </div>

            <div class="mb-4">
                <label class="form-label">Confirmar Senha</label>
                <input
                    type="password"
                    class="form-control"
                    name="senha_confirm"
                    placeholder="Confirme sua senha"
                    required
                    minlength="6">
            </div>

            <button
                type="submit"
                name="cadastrar"
                class="btn btn-custom text-white w-100">
                Cadastrar
            </button>

        </form>

        <div class="text-center mt-3">
            Já possui conta?
            <a href="index.php" class="link-login">
                Entrar
            </a>
        </div>

    </div>

    <script>
        document.querySelector("form").addEventListener("submit", function(e) {

            const nome = document.querySelector('[name="nome"]').value.trim();
            const email = document.querySelector('[name="email"]').value.trim();
            const senha = document.querySelector('[name="senha"]').value;
            const senhaConfirm = document.querySelector('[name="senha_confirm"]').value;

            if (nome.length < 3) {
                alert("O nome deve ter pelo menos 3 caracteres.");
                e.preventDefault();
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                alert("Informe um e-mail válido.");
                e.preventDefault();
                return;
            }

            if (senha.length < 6) {
                alert("A senha deve ter no mínimo 6 caracteres.");
                e.preventDefault();
                return;
            }

            if (senha !== senhaConfirm) {
                alert("As senhas não coincidem.");
                e.preventDefault();
                return;
            }

        });
    </script>

</body>

</html>