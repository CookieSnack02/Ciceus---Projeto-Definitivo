-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- O script nao cria nem escolhe o banco: importe-o com o banco
-- ja selecionado (no phpMyAdmin da hospedagem, clique no banco
-- antes de "Importar"). Na hospedagem compartilhada o usuario
-- nao tem permissao para CREATE SCHEMA.
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `ciceus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ciceus` (
  `idCiceus` INT NOT NULL AUTO_INCREMENT,
  `nmUsuario` VARCHAR(255) NOT NULL,
  `emailUsuario` VARCHAR(255) NOT NULL,
  `senhaUsuario` VARCHAR(255) NOT NULL,
  `telefoneUsuario` VARCHAR(45) NOT NULL,
  `sxUsuario` CHAR(1) NULL,
  `dtNasUsuario` DATE NULL,
  `dtCriacaoUsuario` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCiceus`),
  UNIQUE INDEX `emailUsuario_UNIQUE` (`emailUsuario` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `pasta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `pasta` (
  `codPasta` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nmPasta` VARCHAR(255) NOT NULL,
  `corPasta` CHAR(7) NULL,
  `dtCriacaoPasta` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ciceus_idCiceus` INT NOT NULL,
  INDEX `fk_pasta_ciceus1_idx` (`ciceus_idCiceus` ASC),
  PRIMARY KEY (`codPasta`),
  CONSTRAINT `fk_pasta_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `ciceus` (`idCiceus`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nota`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nota` (
  `idNotas` INT NOT NULL AUTO_INCREMENT,
  `tituloNotas` VARCHAR(45) NULL,
  `conteudoNotas` MEDIUMTEXT NULL, -- MEDIUMTEXT (16 MB): imagens coladas no editor vem embutidas no HTML
  `ciceus_idCiceus` INT NOT NULL,
  `dtCriacaoNota` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idNotas`),
  INDEX `fk_nota_ciceus1_idx` (`ciceus_idCiceus` ASC),
  CONSTRAINT `fk_nota_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `ciceus` (`idCiceus`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quadro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quadro` (
  `idQuadro` INT NOT NULL AUTO_INCREMENT,
  `quadro` VARCHAR(255) NOT NULL,
  `ciceus_idCiceus` INT NOT NULL,
  INDEX `fk_quadro_ciceus1_idx` (`ciceus_idCiceus` ASC),
  PRIMARY KEY (`idQuadro`),
  CONSTRAINT `fk_quadro_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `ciceus` (`idCiceus`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `questao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `questao` (
  `idQuestao` INT NOT NULL AUTO_INCREMENT,
  `tpQuestao` ENUM('objetiva', 'discursiva') NULL,
  `enunciadoQuestao` TEXT NULL,
  `dtCriacaoQuestao` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `pasta_codPasta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idQuestao`),
  INDEX `fk_questao_pasta1_idx` (`pasta_codPasta` ASC),
  CONSTRAINT `fk_questao_pasta1`
    FOREIGN KEY (`pasta_codPasta`)
    REFERENCES `pasta` (`codPasta`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gabarito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `gabarito` (
  `idGabarito` INT NOT NULL AUTO_INCREMENT,
  `explicacaoGabarito` TEXT NULL,
  `respostaGabarito` TEXT NULL,
  `questao_idQuestao` INT NOT NULL,
  PRIMARY KEY (`idGabarito`),
  INDEX `fk_gabarito_questao1_idx` (`questao_idQuestao` ASC),
  CONSTRAINT `fk_gabarito_questao1`
    FOREIGN KEY (`questao_idQuestao`)
    REFERENCES `questao` (`idQuestao`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `timer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `timer` (
  `idTimer` INT NOT NULL AUTO_INCREMENT,
  `tempo` TIME NULL,
  `ciceus_idCiceus` INT NOT NULL,
  PRIMARY KEY (`idTimer`),
  INDEX `fk_timer_ciceus1_idx` (`ciceus_idCiceus` ASC),
  CONSTRAINT `fk_timer_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `ciceus` (`idCiceus`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `resposta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `resposta` (
  `idResposta` INT NOT NULL AUTO_INCREMENT,
  `dtResposta` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `alternativaResposta` VARCHAR(45) NULL,
  `discursivaResposta` TEXT NULL,
  `questao_idQuestao` INT NOT NULL,
  `ciceus_idCiceus` INT NOT NULL,
  PRIMARY KEY (`idResposta`),
  INDEX `fk_resposta_questao1_idx` (`questao_idQuestao` ASC),
  INDEX `fk_resposta_ciceus1_idx` (`ciceus_idCiceus` ASC),
  CONSTRAINT `fk_resposta_questao1`
    FOREIGN KEY (`questao_idQuestao`)
    REFERENCES `questao` (`idQuestao`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resposta_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `ciceus` (`idCiceus`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `quadro_has_pasta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `quadro_has_pasta` (
  `quadro_idQuadro` INT NOT NULL,
  `pasta_codPasta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`quadro_idQuadro`, `pasta_codPasta`),
  INDEX `fk_quadro_has_pasta_pasta1_idx` (`pasta_codPasta` ASC),
  INDEX `fk_quadro_has_pasta_quadro1_idx` (`quadro_idQuadro` ASC),
  CONSTRAINT `fk_quadro_has_pasta_quadro1`
    FOREIGN KEY (`quadro_idQuadro`)
    REFERENCES `quadro` (`idQuadro`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quadro_has_pasta_pasta1`
    FOREIGN KEY (`pasta_codPasta`)
    REFERENCES `pasta` (`codPasta`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `nota_has_pasta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `nota_has_pasta` (
  `nota_idNotas` INT NOT NULL,
  `pasta_codPasta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`nota_idNotas`, `pasta_codPasta`),
  INDEX `fk_nota_has_pasta_pasta1_idx` (`pasta_codPasta` ASC),
  INDEX `fk_nota_has_pasta_nota1_idx` (`nota_idNotas` ASC),
  CONSTRAINT `fk_nota_has_pasta_nota1`
    FOREIGN KEY (`nota_idNotas`)
    REFERENCES `nota` (`idNotas`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_has_pasta_pasta1`
    FOREIGN KEY (`pasta_codPasta`)
    REFERENCES `pasta` (`codPasta`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cartao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cartao` (
  `idCartao` INT NOT NULL AUTO_INCREMENT,
  `frenteCartao` TEXT NOT NULL,
  `versoCartao` TEXT NOT NULL,
  `ciceus_idCiceus` INT NOT NULL,
  `dtCriacaoCartao` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `dtUltimaRevisao` DATE NULL,
  `dtProximaRevisao` DATE NULL,
  `dificuldadeUltima` ENUM('errei', 'dificil', 'bom', 'facil') NULL,
  `intervaloCartao` INT UNSIGNED NOT NULL DEFAULT 0,
  `facilidadeCartao` SMALLINT UNSIGNED NOT NULL DEFAULT 2500,
  `repeticoesCartao` INT UNSIGNED NOT NULL DEFAULT 0,
  `lapsosCartao` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`idCartao`),
  INDEX `idx_cartao_revisao` (`ciceus_idCiceus` ASC, `dtProximaRevisao` ASC),
  CONSTRAINT `fk_cartao_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `ciceus` (`idCiceus`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cartao_has_pasta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cartao_has_pasta` (
  `cartao_idCartao` INT NOT NULL,
  `pasta_codPasta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`cartao_idCartao`, `pasta_codPasta`),
  INDEX `fk_cartao_has_pasta_pasta1_idx` (`pasta_codPasta` ASC),
  INDEX `fk_cartao_has_pasta_cartao1_idx` (`cartao_idCartao` ASC),
  CONSTRAINT `fk_cartao_has_pasta_cartao1`
    FOREIGN KEY (`cartao_idCartao`)
    REFERENCES `cartao` (`idCartao`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_cartao_has_pasta_pasta1`
    FOREIGN KEY (`pasta_codPasta`)
    REFERENCES `pasta` (`codPasta`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cartao_historico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cartao_historico` (
  `idCartaoH` INT NOT NULL AUTO_INCREMENT,
  `dtRevisao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dificuldadeRevisao` ENUM('errei', 'dificil', 'bom', 'facil') NOT NULL,
  `intervaloAnterior` INT UNSIGNED NOT NULL,
  `intervaloNovo` INT UNSIGNED NOT NULL,
  `facilidadeNova` SMALLINT UNSIGNED NOT NULL,
  `cartao_idCartao` INT NOT NULL,
  PRIMARY KEY (`idCartaoH`),
  INDEX `fk_cartao_historico_cartao1_idx` (`cartao_idCartao` ASC),
  CONSTRAINT `fk_cartao_historico_cartao1`
    FOREIGN KEY (`cartao_idCartao`)
    REFERENCES `cartao` (`idCartao`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
