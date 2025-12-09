<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroFilmes.php");
    exit;
}

$filmeIdStr = trim((string)($_POST['filmeId'] ?? ($_POST['filme'] ?? '')));
$nome = trim((string)($_POST['nome'] ?? ''));
$anoStr = trim((string)($_POST['ano'] ?? ''));
$generoStr = trim((string)($_POST['genero'] ?? ''));

if ($filmeIdStr === '' || $nome === '' || $anoStr === '' || $generoStr === '') {
    echo "Preencha todos os campos. <a href='cadastroFilmes.php'>Voltar</a>";
    exit;
}

if (!ctype_digit($filmeIdStr) || !ctype_digit($anoStr) || !ctype_digit($generoStr)) {
    echo "ID, Ano e Gênero devem ser numéricos. <a href='cadastroFilmes.php'>Voltar</a>";
    exit;
}

$filmeId = (int)$filmeIdStr;
$ano = (int)$anoStr;
$genero = (int)$generoStr;

$sql  = "UPDATE filmes SET nome = ?, ano = ?, genero = ? WHERE filme = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar update: " . $conn->error;
    exit;
}

$stmt->bind_param("siii", $nome, $ano, $genero, $filmeId);

if ($stmt->execute()) {
    header("Location: cadastroFilmes.php");
    exit;
}

echo "Erro ao alterar filme: " . $stmt->error . " <a href='cadastroFilmes.php'>Voltar</a>";
