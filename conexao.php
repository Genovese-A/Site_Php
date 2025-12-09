<?php

$servidor = "localhost";
$usuario  = "root";
$senha    = "";
$dbname   = "raphael";

$conn = new mysqli($servidor, $usuario, $senha, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Garante charset correto (acentos, etc.)
$conn->set_charset('utf8mb4');
