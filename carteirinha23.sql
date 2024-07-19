-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           8.0.30 - MySQL Community Server - GPL
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Copiando estrutura para tabela carteirinha23.cardapio
CREATE TABLE IF NOT EXISTS `cardapio` (
  `id` int NOT NULL AUTO_INCREMENT,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `principal` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `acompanhamento` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `sobremesa` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `ind_excluido` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.cardapio: ~12 rows (aproximadamente)
INSERT INTO `cardapio` (`id`, `data_refeicao`, `dia`, `principal`, `acompanhamento`, `sobremesa`, `ind_excluido`) VALUES
	(20, '2024-04-11', 'quarta', 'teste', 'Sem acompanhamento', 'Sem sobremesa', 1),
	(21, '2024-04-12', 'quinta', 'teste', 'Sem acompanhamento', 'Sem sobremesa', 1),
	(22, '2024-04-10', 'quarta', 'teste', 'Sem acompanhamento', 'Sem sobremesa', 1),
	(23, '2024-04-11', 'quinta', 'teste', 'Sem acompanhamento', 'Sem sobremesa', 1),
	(24, '2024-04-08', 'segunda', 'peito de frango', 'batata', 'Sem sobremesa', 1),
	(25, '2024-04-10', 'quarta', 'fÃ­gado', 'feijÃ£o', 'Sem sobremesa', 1),
	(26, '2024-04-11', 'quinta', 'lazanha', 'purÃª', 'Sem sobremesa', 1),
	(27, '2024-04-12', 'sexta', 'peixe', 'farofa', 'Sem sobremesa', 1),
	(28, '2024-04-15', 'segunda', 'peito de frango', 'batata', 'Sem sobremesa', 1),
	(29, '2024-04-17', 'quarta', 'calabresa', 'macarrÃ£o', 'Sem sobremesa', 1),
	(30, '2024-04-18', 'quinta', 'lazanha', 'purÃª', 'Sem sobremesa', 1),
	(31, '2024-04-19', 'sexta', 'lasanha', 'farofa', 'Sem sobremesa', 1),
	(32, '2024-07-15', 'segunda', 'Carne cozida', '-', 'Maçã', 0),
	(33, '2024-07-16', 'terca', 'Calabresa assada', 'Alface', '-', 0),
	(34, '2024-07-17', 'quarta', 'Farofa de ovo', 'Salada', 'Banana', 0),
	(35, '2024-07-18', 'quinta', 'Feijoada', 'Farofa', '-', 0),
	(36, '2024-07-19', 'sexta', 'Macarrão', 'Batata palha', 'Abacaxi', 0);

-- Copiando estrutura para tabela carteirinha23.horario_padrao
CREATE TABLE IF NOT EXISTS `horario_padrao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `inicio_vig` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.horario_padrao: ~5 rows (aproximadamente)
INSERT INTO `horario_padrao` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
	(1, '2024-07-17 04:10:38', '2024-07-18 04:11:14', '16:10:00'),
	(2, '2024-07-18 04:11:14', '2024-07-19 04:14:12', '22:11:00'),
	(3, '2024-07-19 04:14:12', '2024-07-19 04:14:33', '04:14:00'),
	(4, '2024-07-19 04:14:33', NULL, '09:00:00');

-- Copiando estrutura para tabela carteirinha23.justificativa
CREATE TABLE IF NOT EXISTS `justificativa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.justificativa: ~3 rows (aproximadamente)
INSERT INTO `justificativa` (`id`, `descricao`) VALUES
	(1, 'Aula no contra turno'),
	(2, 'Transporte'),
	(3, 'Projeto/TCC/Estágio'),
	(4, 'Outro');

-- Copiando estrutura para tabela carteirinha23.refeicao
CREATE TABLE IF NOT EXISTS `refeicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_usuario` int NOT NULL,
  `id_cardapio` int NOT NULL,
  `id_status_ref` int NOT NULL,
  `id_justificativa` int DEFAULT NULL,
  `data_solicitacao` datetime NOT NULL,
  `outra_justificativa` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `motivo_cancelamento` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_usuario` (`id_usuario`),
  KEY `id_cardapio` (`id_cardapio`),
  KEY `id_status` (`id_status_ref`),
  KEY `id_justificativa` (`id_justificativa`),
  CONSTRAINT `refeicao_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`),
  CONSTRAINT `refeicao_ibfk_2` FOREIGN KEY (`id_cardapio`) REFERENCES `cardapio` (`id`),
  CONSTRAINT `refeicao_ibfk_3` FOREIGN KEY (`id_status_ref`) REFERENCES `status_ref` (`id`),
  CONSTRAINT `refeicao_ibfk_4` FOREIGN KEY (`id_justificativa`) REFERENCES `justificativa` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.refeicao: ~10 rows (aproximadamente)
INSERT INTO `refeicao` (`id`, `id_usuario`, `id_cardapio`, `id_status_ref`, `id_justificativa`, `data_solicitacao`, `outra_justificativa`, `motivo_cancelamento`) VALUES
	(1, 2, 27, 1, 4, '2024-07-19 02:46:04', NULL, NULL),
	(2, 2, 27, 1, 4, '2024-07-19 02:46:33', 'Atestado', NULL),
	(3, 2, 27, 1, 4, '2024-07-19 02:48:31', NULL, NULL),
	(4, 2, 27, 1, 4, '2024-07-19 02:50:23', NULL, NULL),
	(5, 2, 27, 1, 1, '2024-07-19 02:57:00', 'contra-turno', NULL),
	(6, 2, 27, 1, 4, '2024-07-19 02:57:13', 'Atestado', NULL),
	(7, 2, 27, 1, 1, '2024-07-19 02:57:32', 'contra-turno', NULL),
	(8, 2, 27, 1, 3, '2024-07-19 02:58:37', NULL, NULL),
	(9, 2, 27, 1, 3, '2024-07-19 02:58:48', NULL, NULL),
	(10, 2, 27, 1, 1, '2024-07-19 02:58:57', NULL, NULL);

-- Copiando estrutura para tabela carteirinha23.status_ref
CREATE TABLE IF NOT EXISTS `status_ref` (
  `id` int NOT NULL AUTO_INCREMENT,
  `descricao` varchar(45) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.status_ref: ~4 rows (aproximadamente)
INSERT INTO `status_ref` (`id`, `descricao`) VALUES
	(1, 'Agendada'),
	(2, 'Cancelada'),
	(3, 'Confirmada'),
	(4, 'Não compareceu');

-- Copiando estrutura para tabela carteirinha23.usuario
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(60) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `categoria` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(11) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

-- Copiando dados para a tabela carteirinha23.usuario: ~0 rows (aproximadamente)
INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `categoria`, `telefone`) VALUES
	(1, 'root', 'root@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00'),
	(2, 'vitor', 'vitor@gmail.com', '58573b6d50c9bb551471d1227925c0b6', 'estudante', '00');

-- Copiando estrutura para trigger carteirinha23.trg01_refeicao
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg01_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.id_status_ref = 1//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

-- Copiando estrutura para trigger carteirinha23.trg02_refeicao
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `trg02_refeicao` BEFORE INSERT ON `refeicao` FOR EACH ROW SET NEW.data_solicitacao = CONVERT_TZ(NOW(),'+00:00', '+00:00')//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
