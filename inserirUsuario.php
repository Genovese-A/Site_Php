<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroUsuario.php");
    exit;
}

$cpf   = trim((string)($_POST['cpf'] ?? ''));
$nome  = trim((string)($_POST['nome'] ?? ''));
$senha = trim((string)($_POST['senha'] ?? ''));

// so numeros
$cpf = preg_replace('/\D+/', '', $cpf); // remove tudo que não for número
if ($cpf === '' || !ctype_digit($cpf)) {
    header("Location: cadastroUsuario.php");
    exit;
}

$sql  = "INSERT INTO usuarios (cpf, nome, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar insert: " . $conn->error;
    exit;
}

$stmt->bind_param("sss", $cpf, $nome, $senha);

if ($stmt->execute()) {
    header("Location: cadastroUsuario.php");
    exit;
}

echo "Erro ao inserir usuário: " . $stmt->error . " <a href='cadastroUsuario.php'>Voltar</a>";
