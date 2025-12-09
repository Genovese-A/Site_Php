<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroUsuario.php");
    exit;
}

$cpf = trim((string)($_POST['cpf'] ?? ''));

if ($cpf === '') {
    header("Location: cadastroUsuario.php");
    exit;
}

$sql  = "DELETE FROM usuarios WHERE cpf = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar delete: " . $conn->error;
    exit;
}

$stmt->bind_param("s", $cpf);

if ($stmt->execute()) {
    header("Location: cadastroUsuario.php");
    exit;
}

echo "Erro ao apagar usuário: " . $stmt->error . " <a href='cadastroUsuario.php'>Voltar</a>";
