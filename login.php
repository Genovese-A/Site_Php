<?php
require_once "conexao.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: index.php');
    exit;
}

$cpf   = trim((string)($_POST['cpf'] ?? ''));
$senha = trim((string)($_POST['senha'] ?? ''));

if ($cpf === '' || $senha === '') {
    echo "CPF e senha são obrigatórios. <a href='index.php'>Voltar</a>";
    exit;
}

$sql  = "SELECT nome, cpf FROM usuarios WHERE cpf = ? AND senha = ? LIMIT 1";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar consulta: " . $conn->error;
    exit;
}

$stmt->bind_param("ss", $cpf, $senha);

if (!$stmt->execute()) {
    echo "Erro ao executar consulta: " . $stmt->error;
    exit;
}

// Compatível mesmo sem mysqlnd (não usa get_result)
$stmt->bind_result($nome, $cpfOut);
$stmt->fetch();

if (!empty($nome)) {
    session_start();
    $_SESSION['nome'] = $nome;
    $_SESSION['cpf']  = $cpfOut;

    header("Location: principal.php");
    exit;
}

echo "CPF ou senha inválidos. <a href='index.php'>Voltar</a>";
