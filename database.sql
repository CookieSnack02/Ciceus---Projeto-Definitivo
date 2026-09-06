-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`ciceus`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`ciceus` (
  `idCiceus` INT NOT NULL AUTO_INCREMENT,
  `nmUsuario` VARCHAR(255) NOT NULL,
  `emailUsuario` VARCHAR(255) NOT NULL,
  `senhaUsuario` VARCHAR(255) NOT NULL,
  `telefoneUsuario` VARCHAR(45) NOT NULL,
  `sxUsuario` CHAR(1) NULL,
  `dtNasUsuario` DATE NULL,
  `dtCriacaoUsuario` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idCiceus`),
  UNIQUE INDEX `idCiceus_UNIQUE` (`idCiceus` ASC) VISIBLE,
  UNIQUE INDEX `emailUsuario_UNIQUE` (`emailUsuario` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`pasta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`pasta` (
  `codPasta` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nmPasta` VARCHAR(255) NOT NULL,
  `corPasta` CHAR(7) NULL,
  `dtCriacaoPasta` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ciceus_idCiceus` INT NOT NULL,
  INDEX `fk_pasta_ciceus1_idx` (`ciceus_idCiceus` ASC) VISIBLE,
  PRIMARY KEY (`codPasta`),
  CONSTRAINT `fk_pasta_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `mydb`.`ciceus` (`idCiceus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`nota`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`nota` (
  `idNotas` INT NOT NULL AUTO_INCREMENT,
  `tituloNotas` VARCHAR(45) NULL,
  `conteudoNotas` TEXT NULL,
  `ciceus_idCiceus` INT NOT NULL,
  PRIMARY KEY (`idNotas`),
  INDEX `fk_nota_ciceus1_idx` (`ciceus_idCiceus` ASC) VISIBLE,
  CONSTRAINT `fk_nota_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `mydb`.`ciceus` (`idCiceus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`quadro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`quadro` (
  `idQuadro` INT NOT NULL AUTO_INCREMENT,
  `quadro` VARCHAR(255) NOT NULL,
  `ciceus_idCiceus` INT NOT NULL,
  INDEX `fk_quadro_ciceus1_idx` (`ciceus_idCiceus` ASC) VISIBLE,
  PRIMARY KEY (`idQuadro`),
  CONSTRAINT `fk_quadro_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `mydb`.`ciceus` (`idCiceus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`questao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`questao` (
  `idQuestao` INT NOT NULL AUTO_INCREMENT,
  `tpQuestao` ENUM('objetiva', 'discursiva') NULL,
  `enunciadoQuestao` TEXT NULL,
  `dtCriacaoQuestao` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `pasta_codPasta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`idQuestao`),
  INDEX `fk_questao_pasta1_idx` (`pasta_codPasta` ASC) VISIBLE,
  CONSTRAINT `fk_questao_pasta1`
    FOREIGN KEY (`pasta_codPasta`)
    REFERENCES `mydb`.`pasta` (`codPasta`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`gabarito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`gabarito` (
  `idGabarito` INT NOT NULL AUTO_INCREMENT,
  `explicacaoGabarito` TEXT NULL,
  `respostaGabarito` TEXT NULL,
  `questao_idQuestao` INT NOT NULL,
  PRIMARY KEY (`idGabarito`),
  INDEX `fk_gabarito_questao1_idx` (`questao_idQuestao` ASC) VISIBLE,
  CONSTRAINT `fk_gabarito_questao1`
    FOREIGN KEY (`questao_idQuestao`)
    REFERENCES `mydb`.`questao` (`idQuestao`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`timer`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`timer` (
  `idTimer` INT NOT NULL AUTO_INCREMENT,
  `tempo` TIME NULL,
  `ciceus_idCiceus` INT NOT NULL,
  PRIMARY KEY (`idTimer`),
  INDEX `fk_timer_ciceus1_idx` (`ciceus_idCiceus` ASC) VISIBLE,
  CONSTRAINT `fk_timer_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `mydb`.`ciceus` (`idCiceus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`resposta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`resposta` (
  `idResposta` INT NOT NULL AUTO_INCREMENT,
  `dtResposta` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `alternativaResposta` VARCHAR(45) NULL,
  `discursivaResposta` TEXT NULL,
  `questao_idQuestao` INT NOT NULL,
  `ciceus_idCiceus` INT NOT NULL,
  PRIMARY KEY (`idResposta`),
  INDEX `fk_resposta_questao1_idx` (`questao_idQuestao` ASC) VISIBLE,
  INDEX `fk_resposta_ciceus1_idx` (`ciceus_idCiceus` ASC) VISIBLE,
  CONSTRAINT `fk_resposta_questao1`
    FOREIGN KEY (`questao_idQuestao`)
    REFERENCES `mydb`.`questao` (`idQuestao`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_resposta_ciceus1`
    FOREIGN KEY (`ciceus_idCiceus`)
    REFERENCES `mydb`.`ciceus` (`idCiceus`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`quadro_has_pasta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`quadro_has_pasta` (
  `quadro_idQuadro` INT NOT NULL,
  `pasta_codPasta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`quadro_idQuadro`, `pasta_codPasta`),
  INDEX `fk_quadro_has_pasta_pasta1_idx` (`pasta_codPasta` ASC) VISIBLE,
  INDEX `fk_quadro_has_pasta_quadro1_idx` (`quadro_idQuadro` ASC) VISIBLE,
  CONSTRAINT `fk_quadro_has_pasta_quadro1`
    FOREIGN KEY (`quadro_idQuadro`)
    REFERENCES `mydb`.`quadro` (`idQuadro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_quadro_has_pasta_pasta1`
    FOREIGN KEY (`pasta_codPasta`)
    REFERENCES `mydb`.`pasta` (`codPasta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`nota_has_pasta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`nota_has_pasta` (
  `nota_idNotas` INT NOT NULL,
  `pasta_codPasta` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`nota_idNotas`, `pasta_codPasta`),
  INDEX `fk_nota_has_pasta_pasta1_idx` (`pasta_codPasta` ASC) VISIBLE,
  INDEX `fk_nota_has_pasta_nota1_idx` (`nota_idNotas` ASC) VISIBLE,
  CONSTRAINT `fk_nota_has_pasta_nota1`
    FOREIGN KEY (`nota_idNotas`)
    REFERENCES `mydb`.`nota` (`idNotas`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_nota_has_pasta_pasta1`
    FOREIGN KEY (`pasta_codPasta`)
    REFERENCES `mydb`.`pasta` (`codPasta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
