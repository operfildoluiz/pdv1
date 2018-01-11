SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
CREATE DATABASE IF NOT EXISTS `pdv1` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `pdv1`;

CREATE TABLE `item_pedido` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `produto_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `quantidade` decimal(10,2) NOT NULL,
  `precoUnitario` decimal(10,2) NOT NULL,
  `percentualDesconto` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `pedido_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `pedido` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `cliente_id` char(36) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '(DC2Type:uuid)',
  `numero` int(11) NOT NULL,
  `emissao` date NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `pessoa` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dataNascimento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `produto` (
  `id` char(36) COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:uuid)',
  `codigo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nome` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `precoUnitario` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


ALTER TABLE `item_pedido`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_42156301BF396750` (`id`),
  ADD KEY `IDX_42156301105CFD56` (`produto_id`),
  ADD KEY `IDX_421563014854653A` (`pedido_id`);

ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_C4EC16CEBF396750` (`id`),
  ADD KEY `IDX_C4EC16CEDE734E51` (`cliente_id`),
  ADD KEY `numero` (`numero`);

ALTER TABLE `pessoa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1CDFAB82BF396750` (`id`),
  ADD UNIQUE KEY `UNIQ_1CDFAB8254BD530C` (`nome`);

ALTER TABLE `produto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_5CAC49D7BF396750` (`id`),
  ADD UNIQUE KEY `UNIQ_5CAC49D720332D99` (`codigo`),
  ADD UNIQUE KEY `UNIQ_5CAC49D754BD530C` (`nome`);


ALTER TABLE `pedido`
  MODIFY `numero` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

ALTER TABLE `item_pedido`
  ADD CONSTRAINT `FK_42156301105CFD56` FOREIGN KEY (`produto_id`) REFERENCES `produto` (`id`),
  ADD CONSTRAINT `FK_421563014854653A` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE CASCADE;

ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_C4EC16CEDE734E51` FOREIGN KEY (`cliente_id`) REFERENCES `pessoa` (`id`);
