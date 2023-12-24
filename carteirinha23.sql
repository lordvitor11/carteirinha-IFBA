-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 24/12/2023 às 07:06
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `carteirinha23`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `id` int(11) NOT NULL,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) NOT NULL,
  `principal` varchar(255) NOT NULL,
  `acompanhamento` varchar(255) NOT NULL,
  `sobremesa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Acionadores `cardapio`
--
DELIMITER $$
CREATE TRIGGER `copiar_historico_cardapio` BEFORE DELETE ON `cardapio` FOR EACH ROW BEGIN
    -- Copia os dados específicos da linha excluída para a tabela de histórico
    INSERT INTO historico_cardapio (id, data_refeicao, dia, principal, acompanhamento, sobremesa)
    VALUES (OLD.id, OLD.data_refeicao, OLD.dia, OLD.principal, OLD.acompanhamento, OLD.sobremesa);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `historico_cardapio`
--

CREATE TABLE `historico_cardapio` (
  `id` int(11) NOT NULL,
  `data_refeicao` varchar(255) NOT NULL,
  `dia` varchar(255) NOT NULL,
  `principal` varchar(255) NOT NULL,
  `acompanhamento` varchar(255) NOT NULL,
  `sobremesa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `horario_padrão`
--

CREATE TABLE `horario_padrão` (
  `id` int(11) NOT NULL,
  `inicio_vig` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `horario_padrão`
--

INSERT INTO `horario_padrão` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
(38, '2023-11-12 03:00:00', '2023-11-14 03:00:00', '00:00:00'),
(39, '2023-11-14 03:00:00', '2023-11-30 03:00:00', '00:00:00'),
(40, '2023-11-30 03:00:00', '2023-11-20 03:00:00', '00:00:00'),
(41, '2023-11-20 03:00:00', '2023-11-22 03:00:00', '00:00:00'),
(42, '2023-11-22 03:00:00', NULL, '00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `justificativa`
--

CREATE TABLE `justificativa` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `justificativa`
--

INSERT INTO `justificativa` (`id`, `descricao`) VALUES
(1, 'Aula no contra turno'),
(2, 'Transporte'),
(3, 'Projeto/TCC/Estágio');

-- --------------------------------------------------------

--
-- Estrutura para tabela `refeicao`
--

CREATE TABLE `refeicao` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_cardapio` int(11) NOT NULL,
  `id_status_ref` int(11) NOT NULL,
  `id_justificativa` int(11) DEFAULT NULL,
  `data_solicitacao` datetime NOT NULL,
  `outra_justificativa` varchar(100) DEFAULT NULL,
  `motivo_cancelamento` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

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
-- Estrutura para tabela `status_ref`
--

CREATE TABLE `status_ref` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `status_ref`
--

INSERT INTO `status_ref` (`id`, `descricao`) VALUES
(1, 'Agendada'),
(2, 'Cancelada'),
(3, 'Confirmada'),
(4, 'Não compareceu');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tabela_temporaria`
--

CREATE TABLE `tabela_temporaria` (
  `id` int(11) NOT NULL,
  `inicio_vig` datetime DEFAULT NULL,
  `fim_vig` datetime DEFAULT NULL,
  `horario` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `tabela_temporaria`
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
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(60) NOT NULL,
  `categoria` varchar(255) NOT NULL,
  `telefone` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `categoria`, `telefone`) VALUES
(1, 'root', 'root@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `horario_padrão`
--
ALTER TABLE `horario_padrão`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `justificativa`
--
ALTER TABLE `justificativa`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `refeicao`
--
ALTER TABLE `refeicao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cardapio` (`id_cardapio`),
  ADD KEY `id_status` (`id_status_ref`),
  ADD KEY `id_justificativa` (`id_justificativa`);

--
-- Índices de tabela `status_ref`
--
ALTER TABLE `status_ref`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tabela_temporaria`
--
ALTER TABLE `tabela_temporaria`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `horario_padrão`
--
ALTER TABLE `horario_padrão`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT de tabela `justificativa`
--
ALTER TABLE `justificativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `refeicao`
--
ALTER TABLE `refeicao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `status_ref`
--
ALTER TABLE `status_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `tabela_temporaria`
--
ALTER TABLE `tabela_temporaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `refeicao`
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
