-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/08/2026 às 19:49
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `autocar`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agendamentos`
--

CREATE TABLE `agendamentos` (
  `id` int(11) NOT NULL,
  `nome_cliente` varchar(100) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `modelo_carro` varchar(100) DEFAULT NULL,
  `placa` varchar(10) DEFAULT NULL,
  `servico_id` int(11) DEFAULT NULL,
  `data_agendamento` date DEFAULT NULL,
  `hora_agendamento` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `agendamentos`
--

INSERT INTO `agendamentos` (`id`, `nome_cliente`, `telefone`, `modelo_carro`, `placa`, `servico_id`, `data_agendamento`, `hora_agendamento`) VALUES
(1, 'Marcos Paulo', '(44)99999-9999', 'Gol G6', 'ABC1D23', 1, '2026-06-20', '14:30:00'),
(2, 'João Silva', '(44)98888-7777', 'Honda Civic', 'DEF4G56', 3, '2026-06-22', '09:00:00'),
(3, 'Ana Souza', '(44)97777-6666', 'Toyota Corolla', 'GHI7J89', 2, '2026-06-23', '10:30:00'),
(4, 'Carlos Pereira', '(44)96666-5555', 'Chevrolet Onix', 'JKL1M23', 4, '2026-06-24', '15:00:00'),
(5, 'pedro santos', '123123123123', '123123123', '123123123', 3, '2222-02-12', '11:11:00'),
(6, 'prega', '44991419608', 'Xaiomi 22', 'ABD5C78', 3, '2026-06-29', '21:44:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produtos`
--

INSERT INTO `produtos` (`id`, `nome`, `descricao`, `preco`) VALUES
(1, 'Shampoo Automotivo', 'Limpeza profunda sem agredir a pintura', 29.90),
(2, 'Cera Protetora', 'Brilho intenso e proteção da pintura', 39.90),
(3, 'Pretinho para Pneus', 'Acabamento profissional para pneus', 19.90);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto_servico`
--

CREATE TABLE `produto_servico` (
  `produto_id` int(11) NOT NULL,
  `servico_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto_servico`
--

INSERT INTO `produto_servico` (`produto_id`, `servico_id`) VALUES
(1, 1),
(1, 2),
(1, 4),
(2, 1),
(2, 3),
(3, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `descricao` text DEFAULT NULL,
  `preco` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id`, `nome`, `descricao`, `preco`) VALUES
(1, 'Troca de óleo', 'Troca completa de óleo e filtro', 120.00),
(2, 'Alinhamento e balanceamento', 'Correção da direção', 80.00),
(3, 'Revisão completa', 'Revisão geral do veículo', 250.00),
(4, 'Troca de freios', 'Troca de pastilhas', 180.00);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- Índices de tabela `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `produto_servico`
--
ALTER TABLE `produto_servico`
  ADD PRIMARY KEY (`produto_id`,`servico_id`),
  ADD KEY `servico_id` (`servico_id`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `agendamentos`
--
ALTER TABLE `agendamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `agendamentos`
--
ALTER TABLE `agendamentos`
  ADD CONSTRAINT `agendamentos_ibfk_1` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`);

--
-- Restrições para tabelas `produto_servico`
--
ALTER TABLE `produto_servico`
  ADD CONSTRAINT `produto_servico_ibfk_1` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  ADD CONSTRAINT `produto_servico_ibfk_2` FOREIGN KEY (`servico_id`) REFERENCES `servicos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
