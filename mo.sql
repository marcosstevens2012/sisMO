-- MySQL Script generated by MySQL Workbench
-- Thu Jan  4 23:48:27 2018
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`artefacto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`artefacto` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `descripcion` VARCHAR(45) NOT NULL,
  `estado` VARCHAR(45) NOT NULL,
  `stock` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`movimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`movimiento` (
  `id` INT NOT NULL,
  `usuario` VARCHAR(45) NULL,
  `fecha_hora` DATETIME NULL,
  `tipo` VARCHAR(45) NULL,
  `oberervaciones` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`estado` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`estado_artefacto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`estado_artefacto` (
  `estado_id` INT NOT NULL,
  `artefacto_id` INT NOT NULL,
  `fecha` DATE NULL,
  `hora` TIME NULL,
  `user` INT NULL,
  PRIMARY KEY (`estado_id`, `artefacto_id`),
  INDEX `fk_estado_has_artefacto_artefacto1_idx` (`artefacto_id` ASC),
  INDEX `fk_estado_has_artefacto_estado_idx` (`estado_id` ASC),
  CONSTRAINT `fk_estado_has_artefacto_estado`
    FOREIGN KEY (`estado_id`)
    REFERENCES `mydb`.`estado` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_estado_has_artefacto_artefacto1`
    FOREIGN KEY (`artefacto_id`)
    REFERENCES `mydb`.`artefacto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`list`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`list` (
  `id` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `user` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`detalle_list`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`detalle_list` (
  `id` INT NOT NULL,
  `list_id` INT NOT NULL,
  `tarea` VARCHAR(45) NULL,
  `estado` VARCHAR(2) NULL,
  `observaciones` VARCHAR(150) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_detalle_list_list1_idx` (`list_id` ASC),
  CONSTRAINT `fk_detalle_list_list1`
    FOREIGN KEY (`list_id`)
    REFERENCES `mydb`.`list` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`detalle_movimiento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`detalle_movimiento` (
  `id` INT NOT NULL,
  `movimiento_id` INT NOT NULL,
  `artefacto_id` INT NOT NULL,
  `cantidad` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_detalle_movimiento_movimiento1_idx` (`movimiento_id` ASC),
  INDEX `fk_detalle_movimiento_artefacto1_idx` (`artefacto_id` ASC),
  CONSTRAINT `fk_detalle_movimiento_movimiento1`
    FOREIGN KEY (`movimiento_id`)
    REFERENCES `mydb`.`movimiento` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_movimiento_artefacto1`
    FOREIGN KEY (`artefacto_id`)
    REFERENCES `mydb`.`artefacto` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
