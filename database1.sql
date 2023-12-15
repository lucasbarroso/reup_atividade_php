-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 23-Jul-2023 às 21:58
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
-- Banco de dados: `database1`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `filhos`
--

DROP TABLE IF EXISTS `filhos`;
CREATE TABLE IF NOT EXISTS `filhos` (
  `pessoas_id` int DEFAULT NULL,
  `nome` varchar(45) NOT NULL,
  `idade` int DEFAULT NULL,
  KEY `pessoas_id` (`pessoas_id`)
) 

--
-- Extraindo dados da tabela `filhos`
--

INSERT INTO `filhos` (`pessoas_id`, `nome`, `idade`) VALUES
(1, 'Pedro', 5),
(1, 'Ana', 8),
(2, 'Luiza', 3),
(3, 'Mariana', 10);

-- --------------------------------------------------------

--
-- Estrutura da tabela `pessoas`
--

DROP TABLE IF EXISTS `pessoas`;
CREATE TABLE IF NOT EXISTS `pessoas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `idade` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Extraindo dados da tabela `pessoas`
--

INSERT INTO pessoas (id, nome, idade) VALUES
(1, 'João', 30),
(2, 'Maria', 25),
(3, 'Carlos', 40),
(5, 'João Almeida', 31),
(6, 'João Bosco', 30),
(7, 'João Vitor', 32),
(8, 'João iweohqh', 36),
(9, 'João asijdp', 35);

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `filhos`
--
ALTER TABLE `filhos`
  ADD CONSTRAINT `filhos_ibfk_1` FOREIGN KEY (`pessoas_id`) REFERENCES `pessoas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
