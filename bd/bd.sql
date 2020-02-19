
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema telemetriabd
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema telemetriabd
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `telemetriabd` DEFAULT CHARACTER SET utf8 ;
USE `telemetriabd` ;

-- -----------------------------------------------------
-- Table `telemetriabd`.`master`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `telemetriabd`.`master` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `tentativa` INT NOT NULL,
  `tempo` TIME NOT NULL,
  `setor` INT NOT NULL,
  `velocidadeDesejada` INT NOT NULL,
  `velocidadeMotorEsquerdo` INT NOT NULL,
  `velocidadeMotorDireito` INT NOT NULL,
  `p` FLOAT NOT NULL,
  `d` FLOAT NOT NULL,
  `i` FLOAT NOT NULL,
  `erro` FLOAT NOT NULL,
  `erroAcumulado` FLOAT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

select * from master;


SELECT MAX(tentativa) FROM master;
DELETE FROM master WHERE id IS NOT NULL;

UPDATE master SET tentativa = 1;


