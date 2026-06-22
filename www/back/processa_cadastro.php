<?php

session_start();

// Verifica se o formulário foi enviado
if (!isset($_POST["cadastrar"])) {
    header("Location: ../cadastro.php");
    exit;
}

// trim remove espaços em branco
// ?? '' verifica se a variavel existe e não é nula
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';
$senhaConfirm = $_POST['senha_confirm'] ?? '';

$erros = [];

// Validações
if (empty($nome)) {
    $erros[] = "Preencha o nome.";
}

if (empty($email)) {
    $erros[] = "Preencha o e-mail.";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $erros[] = "Informe um e-mail válido.";
}

if (empty($senha)) {
    $erros[] = "Preencha a senha.";
}

if (empty($senhaConfirm)) {
    $erros[] = "Confirme a senha.";
}

if (!empty($senha) && !empty($senhaConfirm) && $senha !== $senhaConfirm) {
    $erros[] = "As senhas não coincidem.";
}

// Se houver erros, retorna para o formulário
if (!empty($erros)) {
    $_SESSION["erro"] = implode("<br>", $erros);

    header("Location: ../cadastro.php");
    exit;
}


require_once("../config/conecta.php");


$sql = "SELECT id FROM usuarios WHERE email = ?";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param($stmt, "s", $email);

mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($resultado) > 0) {

    $_SESSION["erro"] = "Este e-mail já está cadastrado.";

    header("Location: ../cadastro.php");
    exit;
}


$senhaHash = password_hash($senha, PASSWORD_DEFAULT);


$sql = "
    INSERT INTO usuarios
    (nome, email, senha)
    VALUES
    (?, ?, ?)
";

$stmt = mysqli_prepare($conn, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "sss",
    $nome,
    $email,
    $senhaHash
);

if (mysqli_stmt_execute($stmt)) {

    $_SESSION["msg"] = "Usuário cadastrado com sucesso!";
    $_SESSION["cor"] = "success";

} else {

    $_SESSION["erro"] = "Erro ao cadastrar usuário.";

    header("Location: ../cadastro.php");
    exit;
}

mysqli_close($conn);


header("Location: ../index.php");
exit;