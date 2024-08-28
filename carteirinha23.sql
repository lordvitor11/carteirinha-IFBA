-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 28, 2024 at 11:04 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carteirinha23`
--

-- --------------------------------------------------------

--
-- Table structure for table `cardapio`
--

CREATE TABLE `cardapio` (
  `id` int NOT NULL,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `principal` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `acompanhamento` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sobremesa` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ind_excluido` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `cardapio`
--

INSERT INTO `cardapio` (`id`, `data_refeicao`, `dia`, `principal`, `acompanhamento`, `sobremesa`, `ind_excluido`) VALUES
(42, '2024-07-22', 'segunda', 'Frango grelhado', 'Arroz integral com brócolis', 'Salada de frutas', 0),
(43, '2024-07-23', 'terca', 'Filé de peixe assado', 'Purê de batata doce', 'Iogurte com mel e nozes', 0),
(44, '2024-07-24', 'quarta', 'Bife acebolado', 'Legumes salteados', 'Pudim de chia com manga', 0),
(45, '2024-07-25', 'quinta', 'Almôndegas de carne', 'Espaguete de abobrinha', 'Mousse de maracujá', 0),
(46, '2024-07-26', 'sexta', 'Tofu grelhado', 'Quinoa com legumes', 'Sorvete de banana com cacau', 0);

-- --------------------------------------------------------

--
-- Table structure for table `horario_padrao`
--

CREATE TABLE `horario_padrao` (
  `id` int NOT NULL,
  `inicio_vig` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `horario_padrao`
--

INSERT INTO `horario_padrao` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
(1, '2024-07-17 07:10:38', '2024-07-18 07:11:14', '16:10:00'),
(2, '2024-07-18 07:11:14', '2024-07-19 07:14:12', '22:11:00'),
(3, '2024-07-19 07:14:12', '2024-07-19 07:14:33', '04:14:00'),
(4, '2024-07-19 07:14:33', '2024-07-26 12:19:36', '09:00:00'),
(5, '2024-07-26 12:19:36', NULL, '10:19:00');

-- --------------------------------------------------------

--
-- Table structure for table `justificativa`
--

CREATE TABLE `justificativa` (
  `id` int NOT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `justificativa`
--

INSERT INTO `justificativa` (`id`, `descricao`) VALUES
(1, 'Aula no contra turno'),
(2, 'Transporte'),
(3, 'Projeto/TCC/Estágio'),
(4, 'Outro');

-- --------------------------------------------------------

--
-- Table structure for table `notificacao`
--

CREATE TABLE `notificacao` (
  `id` int NOT NULL,
  `id_remetente` int NOT NULL,
  `id_destinatario` int NOT NULL,
  `assunto` text NOT NULL,
  `mensagem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `refeicao`
--

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

--
-- Dumping data for table `refeicao`
--

INSERT INTO `refeicao` (`id`, `id_usuario`, `id_cardapio`, `id_status_ref`, `id_justificativa`, `data_solicitacao`, `hora_solicitacao`, `outra_justificativa`, `motivo_cancelamento`) VALUES
(14, 2, 44, 1, 1, '2024-08-14', '12:18:29', NULL, NULL),
(15, 2, 45, 1, 3, '2024-08-15', '10:21:48', NULL, NULL);

--
-- Triggers `refeicao`
--
DELIMITER $$
CREATE TRIGGER `trg01_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.id_status_ref = 1
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg02_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.data_solicitacao = CONVERT_TZ(NOW(),'+00:00', '+00:00')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `status_ref`
--

CREATE TABLE `status_ref` (
  `id` int NOT NULL,
  `descricao` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `status_ref`
--

INSERT INTO `status_ref` (`id`, `descricao`) VALUES
(1, 'Agendada'),
(2, 'Cancelada'),
(3, 'Confirmada'),
(4, 'Não compareceu');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int NOT NULL,
  `nome` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `categoria` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `categoria`, `telefone`) VALUES
(1, 'root', 'root@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00'),
(2, 'vitor', 'vitor@gmail.com', '58573b6d50c9bb551471d1227925c0b6', 'estudante', '00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `horario_padrao`
--
ALTER TABLE `horario_padrao`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `justificativa`
--
ALTER TABLE `justificativa`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notificacao`
--
ALTER TABLE `notificacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_remetente` (`id_remetente`),
  ADD KEY `fk_destinatario` (`id_destinatario`);

--
-- Indexes for table `refeicao`
--
ALTER TABLE `refeicao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cardapio` (`id_cardapio`),
  ADD KEY `id_status` (`id_status_ref`),
  ADD KEY `id_justificativa` (`id_justificativa`);

--
-- Indexes for table `status_ref`
--
ALTER TABLE `status_ref`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `horario_padrao`
--
ALTER TABLE `horario_padrao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `justificativa`
--
ALTER TABLE `justificativa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notificacao`
--
ALTER TABLE `notificacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `refeicao`
--
ALTER TABLE `refeicao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `status_ref`
--
ALTER TABLE `status_ref`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notificacao`
--
ALTER TABLE `notificacao`
  ADD CONSTRAINT `fk_destinatario` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_remetente` FOREIGN KEY (`id_remetente`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `refeicao`
--
ALTER TABLE `refeicao`
  ADD CONSTRAINT `refeicao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `refeicao_ibfk_2` FOREIGN KEY (`id_cardapio`) REFERENCES `cardapio` (`id`),
  ADD CONSTRAINT `refeicao_ibfk_3` FOREIGN KEY (`id_status_ref`) REFERENCES `status_ref` (`id`),
  ADD CONSTRAINT `refeicao_ibfk_4` FOREIGN KEY (`id_justificativa`) REFERENCES `justificativa` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
