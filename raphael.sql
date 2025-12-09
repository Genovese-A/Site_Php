-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 22/11/2025 às 03:54
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- --------------------------------------------------------
-- Banco de dados: `raphael`
-- --------------------------------------------------------

CREATE DATABASE IF NOT EXISTS `raphael` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `raphael`;

-- --------------------------------------------------------
-- Estrutura para tabela `generos`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `generos` (
  `genero` int(11) NOT NULL,
  `descricao` varchar(50) NOT NULL,
  PRIMARY KEY (`genero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados iniciais
INSERT INTO `generos` (`genero`, `descricao`) VALUES
(1, 'terror'),
(2, 'comédia');

-- --------------------------------------------------------
-- Estrutura para tabela `filmes`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `filmes` (
  `filme` int(3) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `ano` int(4) NOT NULL,
  `genero` int(11) NOT NULL,
  PRIMARY KEY (`filme`),
  KEY `fk_filmes_generos` (`genero`),
  CONSTRAINT `fk_filmes_generos` FOREIGN KEY (`genero`) REFERENCES `generos` (`genero`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dados iniciais
INSERT INTO `filmes` (`filme`, `nome`, `ano`, `genero`) VALUES
(4, 'Todo mundo em pânico', 2015, 2),
(5, 'It a coisa', 2022, 1);

-- --------------------------------------------------------
-- Estrutura para tabela `usuarios`
-- --------------------------------------------------------

CREATE TABLE IF NOT EXISTS `usuarios` (
  `cpf` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `nome` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  PRIMARY KEY (`cpf`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Usuário inicial (teste)
INSERT INTO `usuarios` (`cpf`, `nome`, `senha`) VALUES
('123', '123', '456');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
