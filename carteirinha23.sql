-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Jul-2024 às 15:03
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

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
-- Estrutura da tabela `cardapio`
--

CREATE TABLE `cardapio` (
  `id` int(11) NOT NULL,
  `data_refeicao` date NOT NULL,
  `dia` varchar(255) NOT NULL,
  `principal` varchar(255) NOT NULL,
  `acompanhamento` varchar(255) NOT NULL,
  `sobremesa` varchar(255) NOT NULL,
  `ind_excluido` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `cardapio`
--

INSERT INTO `cardapio` (`id`, `data_refeicao`, `dia`, `principal`, `acompanhamento`, `sobremesa`, `ind_excluido`) VALUES
(42, '2024-07-22', 'segunda', 'Frango grelhado', 'Arroz integral com brócolis', 'Salada de frutas', 0),
(43, '2024-07-23', 'terca', 'Filé de peixe assado', 'Purê de batata doce', 'Iogurte com mel e nozes', 0),
(44, '2024-07-24', 'quarta', 'Bife acebolado', 'Legumes salteados', 'Pudim de chia com manga', 0),
(45, '2024-07-25', 'quinta', 'Almôndegas de carne', 'Espaguete de abobrinha', 'Mousse de maracujá', 0),
(46, '2024-07-26', 'sexta', 'Tofu grelhado', 'Quinoa com legumes', 'Sorvete de banana com cacau', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `horario_padrao`
--

CREATE TABLE `horario_padrao` (
  `id` int(11) NOT NULL,
  `inicio_vig` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fim_vig` timestamp NULL DEFAULT NULL,
  `horario` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `horario_padrao`
--

INSERT INTO `horario_padrao` (`id`, `inicio_vig`, `fim_vig`, `horario`) VALUES
(1, '2024-07-17 07:10:38', '2024-07-18 07:11:14', '16:10:00'),
(2, '2024-07-18 07:11:14', '2024-07-19 07:14:12', '22:11:00'),
(3, '2024-07-19 07:14:12', '2024-07-19 07:14:33', '04:14:00'),
(4, '2024-07-19 07:14:33', '2024-07-26 12:19:36', '09:00:00'),
(5, '2024-07-26 12:19:36', NULL, '10:19:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `justificativa`
--

CREATE TABLE `justificativa` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Extraindo dados da tabela `justificativa`
--

INSERT INTO `justificativa` (`id`, `descricao`) VALUES
(1, 'Aula no contra turno'),
(2, 'Transporte'),
(3, 'Projeto/TCC/Estágio'),
(4, 'Outro');

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
-- Estrutura da tabela `status_ref`
--

CREATE TABLE `status_ref` (
  `id` int(11) NOT NULL,
  `descricao` varchar(45) NOT NULL
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
-- Estrutura da tabela `usuario`
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
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nome`, `email`, `senha`, `categoria`, `telefone`) VALUES
(1, 'root', 'root@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'adm', '00'),
(2, 'vitor', 'vitor@gmail.com', '58573b6d50c9bb551471d1227925c0b6', 'estudante', '00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `cardapio`
--
ALTER TABLE `cardapio`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `horario_padrao`
--
ALTER TABLE `horario_padrao`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `justificativa`
--
ALTER TABLE `justificativa`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `refeicao`
--
ALTER TABLE `refeicao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_cardapio` (`id_cardapio`),
  ADD KEY `id_status` (`id_status_ref`),
  ADD KEY `id_justificativa` (`id_justificativa`);

--
-- Índices para tabela `status_ref`
--
ALTER TABLE `status_ref`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `cardapio`
--
ALTER TABLE `cardapio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT de tabela `horario_padrao`
--
ALTER TABLE `horario_padrao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `justificativa`
--
ALTER TABLE `justificativa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restrições para despejos de tabelas
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
