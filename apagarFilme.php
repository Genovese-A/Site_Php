<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroFilmes.php");
    exit;
}

$filmeStr = trim((string)($_POST['filme'] ?? ''));
if ($filmeStr === '' || !ctype_digit($filmeStr)) {
    header("Location: cadastroFilmes.php");
    exit;
}

$filme = (int)$filmeStr;

$sql  = "DELETE FROM filmes WHERE filme = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar delete: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $filme);

if ($stmt->execute()) {
    header("Location: cadastroFilmes.php");
    exit;
}

echo "Erro ao apagar filme: " . $stmt->error . " <a href='cadastroFilmes.php'>Voltar</a>";
