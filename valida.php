<?php
session_start();

if (!isset($_SESSION['nome']) || $_SESSION['nome'] === '') {
    header("Location: index.php");
    exit;
}
