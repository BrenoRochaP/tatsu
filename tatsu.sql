-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/11/2024 às 04:34
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
-- Banco de dados: `tatsu`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `carrinho`
--

CREATE TABLE `carrinho` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `usuario_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `carrinho`
--

INSERT INTO `carrinho` (`id`, `usuario_id`, `item_id`, `quantidade`, `usuario_email`) VALUES
(7, 6, 2, 5, NULL),
(8, 6, 1, 2, NULL),
(9, 0, 5, 2, NULL),
(10, 0, 4, 2, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `delivery`
--

CREATE TABLE `delivery` (
  `ID_RESERVA` int(6) UNSIGNED NOT NULL,
  `NOME_CLIENTE` varchar(100) NOT NULL,
  `EMAIL_CLIENTE` varchar(100) NOT NULL,
  `QUANTIDADE_PESSOAS` int(11) NOT NULL,
  `DIA_RESERVA` date NOT NULL,
  `HORA_RESERVA` time NOT NULL,
  `AREA_RESTAURANTE` varchar(100) NOT NULL,
  `TIPO_RESERVA` varchar(100) NOT NULL,
  `OBSERVACOES` varchar(255) NOT NULL,
  `ID_USUARIO` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `enderecos`
--

CREATE TABLE `enderecos` (
  `id` int(11) NOT NULL,
  `rua` varchar(255) NOT NULL,
  `numero` varchar(10) NOT NULL,
  `complemento` varchar(255) DEFAULT NULL,
  `cep` varchar(10) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `enderecos`
--

INSERT INTO `enderecos` (`id`, `rua`, `numero`, `complemento`, `cep`, `bairro`, `cidade`, `estado`) VALUES
(1, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(2, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(3, 'Rua Luiz de Carvalho Gonçalves', '402', 'Sim', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(4, 'Rua Luiz de Carvalho Gonçalves', '402', 'Sim', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(5, 'Rua Luiz de Carvalho Gonçalves', '402', 'Sim', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(6, 'Rua Luiz de Carvalho Gonçalves', '402', 'Sim', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(7, 'Rua Luiz de Carvalho Gonçalves', '402', 'Sim', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(8, '', '', '', '', '', '', ''),
(9, '', '', '', '', '', '', ''),
(10, 'Rua Luiz de Carvalho Gonçalves', '402', 'Sim', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(11, '', '', '', '', '', '', ''),
(12, '', '', '', '', '', '', ''),
(13, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(14, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(15, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(16, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(17, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(18, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(19, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(20, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(21, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(22, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(23, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(24, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(25, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(26, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(27, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(28, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(29, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(30, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(31, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(32, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(33, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(34, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(35, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(36, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(37, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(38, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(39, 'Rua Olavo Bilac', '47', 'Casa', '12289350', 'Vila Paraíba', 'Caçapava', 'SP'),
(40, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(41, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(42, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(43, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(44, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP'),
(45, 'Rua Luiz de Carvalho Gonçalves', '402', 'Casa', '12283-870', 'Parque Residencial Santo André', 'Caçapava', 'SP');

-- --------------------------------------------------------

--
-- Estrutura para tabela `item`
--

CREATE TABLE `item` (
  `id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `imagem` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `item`
--

INSERT INTO `item` (`id`, `nome`, `preco`, `imagem`) VALUES
(1, 'Sushi de Salmão', 35.00, 'assets/images/prato_1.jpg'),
(2, 'Rámen', 45.00, 'assets/images/prato_2.jpg'),
(3, 'Tempurá', 40.00, 'assets/images/prato_3.jpg'),
(4, 'Cheesecake', 22.00, 'assets/images/doce_4.jpg'),
(5, 'Mochi', 18.00, 'assets/images/doce_3.jpg'),
(6, 'Dorayaki', 15.00, 'assets/images/doce_2.jpg'),
(7, 'Taiyaki', 20.00, 'assets/images/doce_1.jpg'),
(8, 'Yakisoba', 30.00, 'assets/images/prato_4.jpg'),
(9, 'Ceviche', 40.00, 'assets/images/prato_5.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL,
  `preco` decimal(10,2) NOT NULL,
  `produto_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`id`, `pedido_id`, `item_id`, `quantidade`, `preco`, `produto_id`) VALUES
(9, 3, 1, 1, 35.00, NULL),
(10, 3, 3, 2, 40.00, NULL),
(11, 4, 1, 1, 35.00, NULL),
(12, 4, 8, 3, 30.00, NULL),
(13, 4, 4, 4, 22.00, NULL),
(14, 5, 1, 3, 35.00, NULL),
(15, 5, 7, 4, 20.00, NULL),
(16, 6, 1, 2, 35.00, NULL),
(17, 6, 3, 1, 40.00, NULL),
(18, 7, 2, 1, 45.00, NULL),
(19, 7, 7, 3, 20.00, NULL),
(20, 7, 8, 2, 30.00, NULL),
(21, 8, 1, 1, 35.00, NULL),
(22, 9, 1, 1, 35.00, NULL),
(23, 10, 4, 1, 22.00, NULL),
(24, 11, 4, 7, 22.00, 1),
(25, 18, 0, 1, 0.00, 1),
(26, 19, 0, 1, 0.00, 4),
(27, 20, 0, 2, 0.00, 1),
(28, 21, 0, 5, 0.00, 7),
(29, 22, 2, 6, 0.00, 2),
(30, 23, 0, 4, 0.00, 1),
(31, 23, 0, 3, 0.00, 6),
(32, 24, 0, 4, 0.00, 1),
(33, 11, 0, 10, 0.00, 8),
(34, 24, 0, 6, 0.00, 3),
(35, 25, 0, 6, 0.00, 4),
(36, 26, 0, 2, 0.00, 2),
(37, 31, 0, 1, 0.00, 2),
(38, 32, 0, 6, 0.00, 1),
(39, 32, 0, 9, 0.00, 6),
(40, 33, 0, 8, 0.00, 1),
(41, 34, 0, 2, 0.00, 1),
(42, 38, 4, 8, 22.00, NULL),
(43, 39, 8, 6, 30.00, NULL),
(44, 40, 5, 6, 18.00, NULL),
(45, 40, 9, 4, 40.00, NULL),
(46, 42, 1, 2, 35.00, NULL),
(47, 42, 5, 2, 18.00, NULL),
(48, 44, 2, 5, 45.00, NULL),
(49, 45, 7, 8, 20.00, NULL),
(50, 45, 9, 5, 40.00, NULL),
(51, 46, 1, 8, 35.00, NULL),
(52, 47, 2, 8, 45.00, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `data_pedido` datetime DEFAULT current_timestamp(),
  `status_pagamento` enum('Pago','Pago na Entrega') NOT NULL,
  `endereco_id` int(11) DEFAULT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`id`, `usuario_id`, `total`, `data_pedido`, `status_pagamento`, `endereco_id`, `status`) VALUES
(47, 1, 0.00, '2024-11-11 00:32:01', 'Pago na Entrega', 45, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `reserva`
--

CREATE TABLE `reserva` (
  `ID_RESERVA` int(6) UNSIGNED NOT NULL,
  `NOME_CLIENTE` varchar(100) NOT NULL,
  `EMAIL_CLIENTE` varchar(100) NOT NULL,
  `QUANTIDADE_PESSOAS` int(11) NOT NULL,
  `DIA_RESERVA` date NOT NULL,
  `HORA_RESERVA` time NOT NULL,
  `AREA_RESTAURANTE` varchar(100) NOT NULL,
  `TIPO_RESERVA` varchar(100) NOT NULL,
  `OBSERVACOES` varchar(255) NOT NULL,
  `ID_USUARIO` int(6) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `reserva`
--

INSERT INTO `reserva` (`ID_RESERVA`, `NOME_CLIENTE`, `EMAIL_CLIENTE`, `QUANTIDADE_PESSOAS`, `DIA_RESERVA`, `HORA_RESERVA`, `AREA_RESTAURANTE`, `TIPO_RESERVA`, `OBSERVACOES`, `ID_USUARIO`) VALUES
(4, 'Breno', 'deoliveirarochabreno2@gmail.com', 2, '2024-11-28', '19:21:00', 'Externa', 'Especial', 'Pedido de Casamento', NULL),
(6, 'Breno', 'deoliveirarochabreno2@gmail.com', 1, '2024-11-22', '21:24:00', 'Externa', 'Normal', '', NULL),
(7, 'Breno', 'deoliveirarochabreno2@gmail.com', 12, '2024-11-21', '19:40:00', 'Interna', 'Normal', '', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `status_pedido`
--

CREATE TABLE `status_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `ID_USUARIO` int(6) UNSIGNED NOT NULL,
  `NOME_USUARIO` varchar(100) NOT NULL,
  `EMAIL_USUARIO` varchar(100) NOT NULL,
  `SENHA_USUARIO` varchar(255) NOT NULL,
  `DATA_NASC` date NOT NULL,
  `GENERO` varchar(100) NOT NULL,
  `ENDERECO` varchar(100) NOT NULL,
  `ESTADO` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`ID_USUARIO`, `NOME_USUARIO`, `EMAIL_USUARIO`, `SENHA_USUARIO`, `DATA_NASC`, `GENERO`, `ENDERECO`, `ESTADO`) VALUES
(1, 'BRENO DE OLIVEIRA ROCHA DE PAULA', 'deoliveirarochabreno2@gmail.com', '$2y$10$iP.7Ovyel.pyWX4U9XB6tOKBTGJ5XdxO//D6JYHLbZbwCRBdqOeru', '2024-10-02', 'Masculino', 'Rua José Cândido Capele,47-caçapava', 'SP');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `carrinho`
--
ALTER TABLE `carrinho`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`ID_RESERVA`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Índices de tabela `enderecos`
--
ALTER TABLE `enderecos`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `endereco_id` (`endereco_id`);

--
-- Índices de tabela `reserva`
--
ALTER TABLE `reserva`
  ADD PRIMARY KEY (`ID_RESERVA`),
  ADD KEY `ID_USUARIO` (`ID_USUARIO`);

--
-- Índices de tabela `status_pedido`
--
ALTER TABLE `status_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pedido_id` (`pedido_id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`ID_USUARIO`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `carrinho`
--
ALTER TABLE `carrinho`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `delivery`
--
ALTER TABLE `delivery`
  MODIFY `ID_RESERVA` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `enderecos`
--
ALTER TABLE `enderecos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT de tabela `reserva`
--
ALTER TABLE `reserva`
  MODIFY `ID_RESERVA` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `status_pedido`
--
ALTER TABLE `status_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `ID_USUARIO` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID_USUARIO`);

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`endereco_id`) REFERENCES `enderecos` (`id`);

--
-- Restrições para tabelas `reserva`
--
ALTER TABLE `reserva`
  ADD CONSTRAINT `reserva_ibfk_1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuario` (`ID_USUARIO`);

--
-- Restrições para tabelas `status_pedido`
--
ALTER TABLE `status_pedido`
  ADD CONSTRAINT `status_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
