-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 16, 2024 at 07:31 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `carteirinha23`

-- Table structure for table `usuario`
CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nome` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `matricula` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `categoria` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Table structure for table `justificativa`
CREATE TABLE `justificativa` (
  `id` int NOT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Table structure for table `status_ref`
CREATE TABLE `status_ref` (
  `id` int NOT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Table structure for table `cardapio`
CREATE TABLE `cardapio` (
  `id` int NOT NULL,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `principal` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `acompanhamento` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sobremesa` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ind_excluido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Table structure for table `horario_padrao`
CREATE TABLE `horario_padrao` (
  `id` int NOT NULL,
  `inicio_vig` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Table structure for table `refeicao`
CREATE TABLE `refeicao` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_cardapio` int NOT NULL,
  `id_status_ref` int NOT NULL,
  `id_justificativa` int DEFAULT NULL,
  `data_solicitacao` date NOT NULL,
  `hora_solicitacao` time NOT NULL,
  `outra_justificativa` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `motivo_cancelamento` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Table structure for table `notificacao`
CREATE TABLE `notificacao` (
  `id` int NOT NULL,
  `id_remetente` int NOT NULL,
  `id_destinatario` int NOT NULL,
  `assunto` text NOT NULL,
  `mensagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Insert data into `usuario`
INSERT INTO `usuario` (`id`, `nome`, `email`, `matricula`, `senha`, `categoria`, `telefone`) VALUES
(1, 'root', 'root@gmail.com', '20201180041', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00'),
(2, 'vitor', 'vitor@gmail.com', '20201180046', '58573b6d50c9bb551471d1227925c0b6', 'estudante', '00');

-- Insert data into `justificativa`
INSERT INTO `justificativa` (`id`, `descricao`) VALUES
(1, 'Aula no contra turno'),
(2, 'Transporte'),
(3, 'Projeto/TCC/Estágio'),
(4, 'Outro');

-- Insert data into `status_ref`
INSERT INTO `status_ref` (`id`, `descricao`) VALUES
(1, 'Agendada'),
(2, 'Cancelada'),
(3, 'Confirmada'),
(4, 'Não compareceu');

-- Insert data into `cardapio`
INSERT INTO `cardapio` (`id`, `data_refeicao`, `dia`, `principal`, `acompanhamento`, `sobremesa`, `ind_excluido`) VALUES
(42, '2024-07-22', 'segunda', 'Frango grelhado', 'Arroz integral com brócolis', 'Salada de frutas', 0),
(43, '2024-07-23', 'terca', 'Filé de peixe assado', 'Purê de batata doce', 'Iogurte com mel e nozes', 0),
(44, '2024-07-24', 'quarta', 'Bife acebolado', 'Legumes salteados', 'Pudim de chia com manga', 0),
(45, '2024-07-25', 'quinta', 'Almôndegas de carne', 'Espaguete de abobrinha', 'Mousse de maracujá', 0),
(46, '2024-07-26', 'sexta', 'Tofu grelhado', 'Quinoa com legumes', 'Sorvete de banana com cacau', 0);

-- Insert data into `horario_padrao`
INSERT INTO `horario_padrao` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
(1, '2024-07-17 07:10:38', '2024-07-18 07:11:14', '16:10:00'),
(2, '2024-07-18 07:11:14', '2024-07-19 07:14:12', '22:11:00'),
(3, '2024-07-19 07:14:12', '2024-07-19 07:14:33', '04:14:00'),
(4, '2024-07-19 07:14:33', '2024-07-26 12:19:36', '09:00:00'),
(5, '2024-07-26 12:19:36', '2024-09-16 19:26:52', '10:19:00'),
(6, '2024-09-16 19:26:52', NULL, '21:26:00');

-- Insert data into `refeicao`
INSERT INTO `refeicao` (`id`, `id_usuario`, `id_cardapio`, `id_status_ref`, `id_justificativa`, `data_solicitacao`, `hora_solicitacao`, `outra_justificativa`, `motivo_cancelamento`) VALUES
(14, 2, 44, 1, 1, '2024-08-14', '12:18:29', NULL, NULL),
(15, 2, 45, 1, 3, '2024-08-15', '10:21:48', NULL, NULL),
(16, 2, 42, 1, 2, '2024-09-16', '19:27:30', NULL, NULL);

-- Insert data into `notificacao`
INSERT INTO `notificacao` (`id`, `id_remetente`, `id_destinatario`, `assunto`, `mensagem`) VALUES
(1, 1, 2, 'teste', 'teste mensagem');
