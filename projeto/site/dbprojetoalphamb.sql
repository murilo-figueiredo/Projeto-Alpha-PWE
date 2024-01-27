-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 12-Jun-2023 às 01:38
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `dbprojetoalphamb`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

DROP TABLE IF EXISTS `tb_cliente`;
CREATE TABLE IF NOT EXISTS `tb_cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(60) NOT NULL,
  `end_cliente` varchar(120) NOT NULL,
  `email_cliente` varchar(35) NOT NULL,
  `senha_cliente` varchar(20) NOT NULL,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `email_cliente` (`email_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_cliente`
--

INSERT INTO `tb_cliente` (`id_cliente`, `nome_cliente`, `end_cliente`, `email_cliente`, `senha_cliente`) VALUES
(1, 'Murilo Rodrigues', 'Rua 14', 'murilor.figueiredo@gmail.com', 'senha12345'),
(2, 'Bianca Santos', 'Rua 21', 'anneg2821@gmail.com', 'teste123');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_pedido`
--

DROP TABLE IF EXISTS `tb_pedido`;
CREATE TABLE IF NOT EXISTS `tb_pedido` (
  `id_pedido` int NOT NULL AUTO_INCREMENT,
  `dta_pedido` datetime NOT NULL,
  `valor_pedido` decimal(7,2) NOT NULL,
  `status_pedido` varchar(40) NOT NULL,
  `comentario_pedido` text,
  `id_prod` int NOT NULL,
  `id_cliente` int NOT NULL,
  PRIMARY KEY (`id_pedido`),
  KEY `id_prod` (`id_prod`),
  KEY `id_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_pedido`
--

INSERT INTO `tb_pedido` (`id_pedido`, `dta_pedido`, `valor_pedido`, `status_pedido`, `comentario_pedido`, `id_prod`, `id_cliente`) VALUES
(1, '2023-06-11 22:18:58', '5500.00', 'Encomendado', 'Não estarei em casa no momento da entrega', 1, 2),
(2, '2023-06-11 22:20:43', '1.50', 'Encomendado', 'Estou ansioso para usar minha nova caneta', 2, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

DROP TABLE IF EXISTS `tb_produto`;
CREATE TABLE IF NOT EXISTS `tb_produto` (
  `id_prod` int NOT NULL AUTO_INCREMENT,
  `nome_prod` varchar(40) NOT NULL,
  `valor_prod` decimal(6,2) NOT NULL,
  `desc_prod` text NOT NULL,
  PRIMARY KEY (`id_prod`),
  UNIQUE KEY `nome_prod` (`nome_prod`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_prod`, `nome_prod`, `valor_prod`, `desc_prod`) VALUES
(1, 'Caneta Dourada', '5500.00', 'Caneta azul normal, mas cara porque é dourada.'),
(2, 'Caneta Comum', '1.50', 'Caneta azul normal, barata porque é normal.');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `tb_pedido`
--
ALTER TABLE `tb_pedido`
  ADD CONSTRAINT `tb_pedido_ibfk_1` FOREIGN KEY (`id_prod`) REFERENCES `tb_produto` (`id_prod`),
  ADD CONSTRAINT `tb_pedido_ibfk_2` FOREIGN KEY (`id_cliente`) REFERENCES `tb_cliente` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
