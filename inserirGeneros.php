<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroGeneros.php");
    exit;
}

$descricao = trim((string)($_POST['descricao'] ?? ''));

if ($descricao === '') {
    header("Location: cadastroGeneros.php");
    exit;
}

if (mb_strlen($descricao) > 50) {
    echo "Descrição muito grande (máximo 50 caracteres). <a href='cadastroGeneros.php'>Voltar</a>";
    exit;
}

/*
  Pega o menor código livre e preenche buracos:
  Ex.: 1,2,3,6 -> próximo vira 4
*/
$sqlNext = "SELECT
  CASE
    WHEN NOT EXISTS (SELECT 1 FROM generos WHERE genero = 1) THEN 1
    ELSE (
      SELECT MIN(g1.genero + 1)
      FROM generos g1
      LEFT JOIN generos g2 ON g2.genero = g1.genero + 1
      WHERE g2.genero IS NULL
    )
  END AS next_id";

$nextId = 1;
if ($res = $conn->query($sqlNext)) {
    $row = $res->fetch_assoc();
    if ($row && $row['next_id'] !== null) {
        $nextId = (int)$row['next_id'];
    }
}

$sql  = "INSERT INTO generos (genero, descricao) VALUES (?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "Erro ao preparar INSERT: " . $conn->error;
    exit;
}

$stmt->bind_param("is", $nextId, $descricao);

if ($stmt->execute()) {
    header("Location: cadastroGeneros.php");
    exit;
}

echo "Erro ao inserir gênero: " . $stmt->error . " <a href='cadastroGeneros.php'>Voltar</a>";
