<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroFilmes.php");
    exit;
}

$nome = trim((string)($_POST['nome'] ?? ''));
$anoStr = trim((string)($_POST['ano'] ?? ''));
$generoStr = trim((string)($_POST['genero'] ?? ''));

if ($nome === '' || $anoStr === '' || $generoStr === '') {
    echo "Preencha Nome, Ano e Gênero. <a href='cadastroFilmes.php'>Voltar</a>";
    exit;
}

if (!ctype_digit($anoStr) || !ctype_digit($generoStr)) {
    echo "Ano e Gênero devem ser numéricos. <a href='cadastroFilmes.php'>Voltar</a>";
    exit;
}

$ano = (int)$anoStr;
$genero = (int)$generoStr;

$sql  = "INSERT INTO filmes (nome, ano, genero) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar insert: " . $conn->error;
    exit;
}

$stmt->bind_param("sii", $nome, $ano, $genero);

if ($stmt->execute()) {
    header("Location: cadastroFilmes.php");
    exit;
}

echo "Erro ao inserir filme: " . $stmt->error . " <a href='cadastroFilmes.php'>Voltar</a>";
