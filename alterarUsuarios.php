<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroUsuario.php");
    exit;
}

$cpfAnterior = trim((string)($_POST['cpfAnterior'] ?? ''));
$cpf         = trim((string)($_POST['cpf'] ?? ''));
$nome        = trim((string)($_POST['nome'] ?? ''));
$senha       = trim((string)($_POST['senha'] ?? ''));

if ($cpfAnterior === '' || $cpf === '' || $nome === '' || $senha === '') {
    echo "Preencha todos os campos. <a href='cadastroUsuario.php'>Voltar</a>";
    exit;
}

$sql  = "UPDATE usuarios SET cpf = ?, senha = ?, nome = ? WHERE cpf = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar update: " . $conn->error;
    exit;
}

$stmt->bind_param("ssss", $cpf, $senha, $nome, $cpfAnterior);

if ($stmt->execute()) {
    header("Location: cadastroUsuario.php");
    exit;
}

echo "Erro ao alterar usuário: " . $stmt->error . " <a href='cadastroUsuario.php'>Voltar</a>";
