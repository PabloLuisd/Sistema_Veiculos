<?php

session_start();

if (!isset($_POST["enviar"])) {
    header("Location: ../index.php");
    exit;
}

$email = trim($_POST["email"] ?? "");
$senha = $_POST["senha"] ?? "";

$erros = [];

if (empty($email)) {
    $erros[] = "Preencha o e-mail.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "Informe um e-mail válido.";
}

if (empty($senha)) {
    $erros[] = "Informe a senha.";
}

if (!empty($erros)) {

    $_SESSION["erro"] = implode("<br>", $erros);

    header("Location: ../index.php");
    exit;
}

require_once("../config/conecta.php");

$sql = "
    SELECT id, nome, email, senha
    FROM usuarios
    WHERE email = ?
";

$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    $_SESSION["erro"] = "Erro ao processar login.";
    header("Location: ../index.php");
    exit;
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) === 0) {

    $_SESSION["erro"] = "E-mail ou senha inválidos.";

    header("Location: ../index.php");
    exit;
}

$usuario = mysqli_fetch_assoc($resultado);

if (!password_verify($senha, $usuario["senha"])) {

    $_SESSION["erro"] = "E-mail ou senha inválidos.";

    header("Location: ../index.php");
    exit;
}

$_SESSION["usuario_id"] = $usuario["id"];
$_SESSION["usuario_nome"] = $usuario["nome"];
$_SESSION["usuario_email"] = $usuario["email"];

mysqli_close($conn);

header("Location: ../dashboard.php");
exit;