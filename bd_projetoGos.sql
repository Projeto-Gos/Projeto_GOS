CREATE TABLE `tb_user` (
  `id_user` int NOT NULL AUTO_INCREMENT,
  `foto_user` varchar(150) NOT NULL,
  `nome_user` varchar(80) NOT NULL,
  `email_user` varchar(100) NOT NULL,
  `senha_user` varchar(255) NOT NULL,  -- Aumentado para suporte a hashes de senha mais longos
  PRIMARY KEY (`id_user`),
  UNIQUE (`email_user`)  -- Garante que o e-mail seja único
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Criação da tabela fisico
CREATE TABLE `tb_fisico` (
  `id_fisico` int NOT NULL AUTO_INCREMENT,
  `nome_fidico` varchar(100) NOT NULL,
  `email_fisico` varchar(100) NOT NULL,
  `telefone_fisico` varchar(15) DEFAULT NULL,
  `cpf_fisico` char(11) NOT NULL,
  PRIMARY KEY (`id_fisico`),
  UNIQUE KEY `email` (`email_fisico`),
  UNIQUE KEY `cpf` (`cpf_fisico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criação da tabela juridico
CREATE TABLE `tb_juridico` (
  `id_juridico` int NOT NULL AUTO_INCREMENT,
  `nome_juridico` varchar(100) NOT NULL,
  `email_juridico` varchar(100) NOT NULL,
  `cnpj_juridico` char(14) NOT NULL,
  `telefone_juridico` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id_juridico`),
  UNIQUE KEY `email` (`email_juridico`),
  UNIQUE KEY `cnpj` (`cnpj_juridico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criação da tabela servico
CREATE TABLE `tb_servico` (
  `id_servico` int NOT NULL AUTO_INCREMENT,
  `nome_servico` varchar(255) NOT NULL,
  `preco_servico` decimal(10,2) NOT NULL,
  `custo_servico` decimal(10,2) NOT NULL,
  `informacao_servico` text,
  PRIMARY KEY (`id_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criação da tabela equipamentos
CREATE TABLE `tb_equipamentos` (
  `id_equipa` int NOT NULL AUTO_INCREMENT,
  `nome_equipa` varchar(255) NOT NULL,
  `modelo_equipa` varchar(100) DEFAULT NULL,
  `marca_equipa` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_equipa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Criação da tabela cliente
CREATE TABLE `tb_cliente` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `fk_id_fisico` int NOT NULL,
  `fk_id_juridico` int NOT NULL,
  `fk_id_servico` int NOT NULL,
  PRIMARY KEY (`id_cliente`),
  KEY `fk_fisico_idx` (`fk_id_fisico`),
  KEY `fk_juridico_idx` (`fk_id_juridico`),
  KEY `fk_servico_idx` (`fk_id_servico`),
  CONSTRAINT `fk_fisico` FOREIGN KEY (`fk_id_fisico`) REFERENCES `tb_fisico` (`id_fisico`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_juridico` FOREIGN KEY (`fk_id_juridico`) REFERENCES `tb_juridico` (`id_juridico`),
  CONSTRAINT `fk_servico` FOREIGN KEY (`fk_id_servico`) REFERENCES `tb_servico` (`id_servico`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;