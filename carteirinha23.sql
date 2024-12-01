-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 02, 2024 at 06:35 PM
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
(47, '2024-10-21', 'segunda', 'Carne cozida', 'Arroz e feijão', 'Maçã', 0),
(48, '2024-10-22', 'terca', 'Calabresa assada', 'Alface', 'Laranja', 0),
(49, '2024-10-23', 'quarta', 'Farofa de ovo', 'Salada', 'Banana', 0),
(50, '2024-10-24', 'quinta', 'Feijoada', 'Farofa', 'a', 0),
(51, '2024-10-25', 'sexta', 'Macarrão', 'Batata palha', 'Abacaxi', 0);

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
(5, '2024-07-26 12:19:36', '2024-09-16 19:26:52', '10:19:00'),
(6, '2024-09-16 19:26:52', NULL, '21:26:00');

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
  `mensagem` text NOT NULL,
  `lida` tinyint(1) NOT NULL DEFAULT '0',
  `transferencia` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `notificacao`
--

INSERT INTO `notificacao` (`id`, `id_remetente`, `id_destinatario`, `assunto`, `mensagem`, `lida`, `transferencia`) VALUES
(4, 2, 3, 'Transferencia de Almoço', 'Saudações Botteste, o estudante Vitor fez a você uma solicitação de transferência de almoço!', 0, 1);

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
(17, 2, 47, 1, 1, '2024-12-02', '17:20:02', NULL, NULL);

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
-- Table structure for table `status_msg`
--

CREATE TABLE `status_msg` (
  `id` int NOT NULL,
  `descricao` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `status_msg`
--

INSERT INTO `status_msg` (`id`, `descricao`) VALUES
(1, 'Lida'),
(2, 'Não Lida');

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
  `matricula` varchar(255) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `categoria` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `matricula`, `senha`, `categoria`, `telefone`) VALUES
(1, 'root', 'root@gmail.com', '20201180041', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00'),
(2, 'vitor', 'vitor@gmail.com', '20201180046', '58573b6d50c9bb551471d1227925c0b6', 'estudante', '00'),
(3, 'botteste', 'botteste@gmail.com', '20201180011', '202cb962ac59075b964b07152d234b70', 'estudante', '75982777354');

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
-- Indexes for table `status_msg`
--
ALTER TABLE `status_msg`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `horario_padrao`
--
ALTER TABLE `horario_padrao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `justificativa`
--
ALTER TABLE `justificativa`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notificacao`
--
ALTER TABLE `notificacao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `refeicao`
--
ALTER TABLE `refeicao`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `status_msg`
--
ALTER TABLE `status_msg`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `status_ref`
--
ALTER TABLE `status_ref`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
