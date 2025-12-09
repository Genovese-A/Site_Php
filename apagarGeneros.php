<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroGeneros.php");
    exit;
}

$generoStr = trim((string)($_POST['genero'] ?? ''));
if ($generoStr === '' || !ctype_digit($generoStr)) {
    header("Location: cadastroGeneros.php");
    exit;
}

$genero = (int)$generoStr;

$sql  = "DELETE FROM generos WHERE genero = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar delete: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $genero);

if ($stmt->execute()) {
    header("Location: cadastroGeneros.php");
    exit;
}

echo "Erro ao apagar gênero: " . $stmt->error . " <a href='cadastroGeneros.php'>Voltar</a>";
