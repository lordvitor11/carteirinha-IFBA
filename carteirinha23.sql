-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 179.188.16.7
-- Generation Time: 17-Dez-2023 às 22:32
-- Versão do servidor: 5.7.32-35-log
-- PHP Version: 5.6.40-0+deb8u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
-- Estrutura da tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `id` int(11) NOT NULL,
  `descricao` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `data_refeicao` date NOT NULL,
  `foto` varchar(255) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `cardapio`
--

INSERT INTO `cardapio` (`id`, `descricao`, `data_refeicao`, `foto`) VALUES
(1, 'Cardápio teste', '2023-11-08', 'N/A');

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario_padrão`
--

CREATE TABLE `horario_padrão` (
  `id` int(11) NOT NULL,
  `inicio_vig` timestamp NOT NULL,
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `horario_padrão`
--

INSERT INTO `horario_padrão` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
(38, '2023-11-12 03:00:00', '2023-11-14 03:00:00', '00:00:00'),
(39, '2023-11-14 03:00:00', '2023-11-30 03:00:00', '00:00:00'),
(40, '2023-11-30 03:00:00', '2023-11-20 03:00:00', '00:00:00'),
(41, '2023-11-20 03:00:00', '2023-11-22 03:00:00', '00:00:00'),
(42, '2023-11-22 03:00:00', NULL, '00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `justificativa`
--

CREATE TABLE `justificativa` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `justificativa`
--

INSERT INTO `justificativa` (`id`, `descricao`) VALUES
(1, 'Aula no contra turno'),
(2, 'Transporte'),
(3, 'Projeto/TCC/Estágio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `refeicao`
--

CREATE TABLE `refeicao` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cardapio` int(11) NOT NULL,
  `id_status_ref` int(11) NOT NULL,
  `id_justificativa` int(11) DEFAULT NULL,
  `data_solicitacao` datetime NOT NULL,
  `outra_justificativa` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `motivo_cancelamento` varchar(100) COLLATE latin1_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `refeicao`
--

INSERT INTO `refeicao` (`id`, `id_usuario`, `id_cardapio`, `id_status_ref`, `id_justificativa`, `data_solicitacao`, `outra_justificativa`, `motivo_cancelamento`) VALUES
(11, 1, 1, 1, NULL, '2023-11-08 09:03:20', NULL, NULL);

--
-- Acionadores `refeicao`
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
-- Estrutura da tabela `status_ref`
--

CREATE TABLE `status_ref` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `status_ref`
--

INSERT INTO `status_ref` (`id`, `descricao`) VALUES
(1, 'Agendada'),
(2, 'Cancelada'),
(3, 'Confirmada'),
(4, 'Não compareceu');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tabela_temporaria`
--

CREATE TABLE `tabela_temporaria` (
  `id` int(11) NOT NULL,
  `inicio_vig` datetime DEFAULT NULL,
  `fim_vig` datetime DEFAULT NULL,
  `horario` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `tabela_temporaria`
--

INSERT INTO `tabela_temporaria` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
(49, '2023-11-14 00:00:00', NULL, '00:00:00'),
(50, '2023-11-30 00:00:00', NULL, '00:00:00'),
(51, '2023-11-20 00:00:00', NULL, '00:00:00'),
(52, '2023-11-22 00:00:00', NULL, '00:00:00');

--
-- Acionadores `tabela_temporaria`
--
DELIMITER $$
CREATE TRIGGER `trg_atualiza_vigencia` AFTER INSERT ON `tabela_temporaria` FOR EACH ROW BEGIN
    DECLARE id_anterior_temp INT;
    DECLARE fim_vig_anterior_temp DATETIME;

    -- Encontrar o ID do registro anterior na tabela_temporaria_intermediaria
    SET id_anterior_temp := (
        SELECT MAX(id)
        FROM horario_padrão
        WHERE id < NEW.id
    );

    -- Verificar se existe um registro anterior
    IF id_anterior_temp IS NOT NULL THEN
        -- Obter o fim_vig do registro anterior na tabela_temporaria_intermediaria
        SET fim_vig_anterior_temp := (
            SELECT inicio_vig
            FROM horario_padrão
            WHERE id = id_anterior_temp
        );

        -- Atualizar o campo 'fim_vig' do registro anterior na tabela horario_padrão
        UPDATE horario_padrão
        SET fim_vig = NEW.inicio_vig
        WHERE id = id_anterior_temp;
        
        INSERT INTO horario_padrão (inicio_vig, fim_vig, horario)
        VALUES (NEW.inicio_vig, NULL, NEW.horario);
        
        -- INSERT INTO horario_padrão (id, inicio_vig, fim_vig, horario)
        -- VALUES (NEW.id, NEW.inicio_vig, fim_vig_anterior_temp, horario)
        -- ON duplicate key update fim_vig = NEW
        
        -- Inserir os dados manipulados na tabela horario_padrão
        -- INSERT INTO horario_padrão (id, inicio_vig, fim_vig, horario)
        -- VALUES (NEW.id, NEW.inicio_vig, fim_vig_anterior_temp, NEW.horario);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `email` varchar(100) COLLATE latin1_general_ci NOT NULL,
  `senha` varchar(60) COLLATE latin1_general_ci NOT NULL,
  `telefone` varchar(11) COLLATE latin1_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `telefone`) VALUES
(1, 'root', 'root@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', '00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `data_refeicao` (`data_refeicao`);

--
-- Indexes for table `horario_padrão`
--
ALTER TABLE `horario_padrão`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `justificativa`
--
ALTER TABLE `justificativa`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tabela_temporaria`
--
ALTER TABLE `tabela_temporaria`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `horario_padrão`
--
ALTER TABLE `horario_padrão`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `justificativa`
--
ALTER TABLE `justificativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `refeicao`
--
ALTER TABLE `refeicao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `status_ref`
--
ALTER TABLE `status_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tabela_temporaria`
--
ALTER TABLE `tabela_temporaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `refeicao`
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
