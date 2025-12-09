<?php
require_once "conexao.php";
require_once "valida.php";

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header("Location: cadastroGeneros.php");
    exit;
}

$generoStr         = trim((string)($_POST['genero'] ?? ''));
$generoAnteriorStr = trim((string)($_POST['generoAnterior'] ?? ''));
$descricao         = trim((string)($_POST['descricao'] ?? ''));

if ($generoStr === '' || $generoAnteriorStr === '' || $descricao === '') {
    echo "Preencha todos os campos. <a href='cadastroGeneros.php'>Voltar</a>";
    exit;
}

if (!ctype_digit($generoStr) || !ctype_digit($generoAnteriorStr)) {
    echo "O código do gênero deve ser numérico. <a href='cadastroGeneros.php'>Voltar</a>";
    exit;
}

$genero = (int)$generoStr;
$generoAnterior = (int)$generoAnteriorStr;

// Se só mudou a descrição (mesmo ID), faz update simples
if ($genero === $generoAnterior) {
    $stmt = $conn->prepare("UPDATE generos SET descricao = ? WHERE genero = ?");
    if (!$stmt) {
        echo 'Erro ao preparar update: ' . $conn->error;
        exit;
    }
    $stmt->bind_param("si", $descricao, $genero);
    if ($stmt->execute()) {
        header("Location: cadastroGeneros.php");
        exit;
    }
    echo 'Erro ao alterar descrição: ' . $stmt->error;
    exit;
}

// Verifica se o novo código já existe (compatível mesmo sem mysqlnd)
$checkStmt = $conn->prepare("SELECT COUNT(*) FROM generos WHERE genero = ?");
if (!$checkStmt) {
    echo 'Erro ao preparar check: ' . $conn->error;
    exit;
}
$checkStmt->bind_param("i", $genero);
if (!$checkStmt->execute()) {
    echo 'Erro ao executar check: ' . $checkStmt->error;
    exit;
}
$checkStmt->bind_result($cnt);
$checkStmt->fetch();
$checkStmt->close();

if ((int)$cnt > 0) {
    echo 'Erro: já existe um gênero com esse código. Escolha outro código. <a href="cadastroGeneros.php">Voltar</a>';
    exit;
}

// Atualiza filmes + gênero em transação
$conn->begin_transaction();
try {
    $updFilmes = $conn->prepare("UPDATE filmes SET genero = ? WHERE genero = ?");
    if (!$updFilmes) {
        throw new Exception('Erro ao preparar UPDATE filmes: ' . $conn->error);
    }
    $updFilmes->bind_param("ii", $genero, $generoAnterior);
    if (!$updFilmes->execute()) {
        throw new Exception('Erro ao executar UPDATE filmes: ' . $updFilmes->error);
    }

    $updGeneros = $conn->prepare("UPDATE generos SET genero = ?, descricao = ? WHERE genero = ?");
    if (!$updGeneros) {
        throw new Exception('Erro ao preparar UPDATE generos: ' . $conn->error);
    }
    $updGeneros->bind_param("isi", $genero, $descricao, $generoAnterior);
    if (!$updGeneros->execute()) {
        throw new Exception('Erro ao executar UPDATE generos: ' . $updGeneros->error);
    }

    $conn->commit();
    header("Location: cadastroGeneros.php");
    exit;

} catch (Exception $e) {
    $conn->rollback();
    echo 'Transação falhou: ' . $e->getMessage() . ' <a href="cadastroGeneros.php">Voltar</a>';
    exit;
}
