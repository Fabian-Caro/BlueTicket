-- MySQL Script generated by MySQL Workbench
-- Thu Nov 21 16:32:20 2024
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema blueTicketV2
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema blueTicketV2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `blueTicketV2` DEFAULT CHARACTER SET utf8 ;
USE `blueTicketV2` ;

-- -----------------------------------------------------
-- Table `blueTicketV2`.`Proveedor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Proveedor` (
  `idProveedor` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idProveedor`),
  UNIQUE INDEX `correo_UNIQUE` (`correo` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Categoria` (
  `idCategoria` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Artista`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Artista` (
  `idArtista` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idArtista`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Evento` (
  `idEvento` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `idProveedor` INT NOT NULL,
  `idCategoria` INT NOT NULL,
  `idArtista` INT NOT NULL,
  PRIMARY KEY (`idEvento`),
  INDEX `fk_Evento_Proveedor_idx` (`idProveedor` ASC) ,
  INDEX `fk_Evento_Categoria1_idx` (`idCategoria` ASC) ,
  INDEX `fk_Evento_Artista1_idx` (`idArtista` ASC) ,
  CONSTRAINT `fk_Evento_Proveedor`
    FOREIGN KEY (`idProveedor`)
    REFERENCES `blueTicketV2`.`Proveedor` (`idProveedor`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Evento_Categoria1`
    FOREIGN KEY (`idCategoria`)
    REFERENCES `blueTicketV2`.`Categoria` (`idCategoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Evento_Artista1`
    FOREIGN KEY (`idArtista`)
    REFERENCES `blueTicketV2`.`Artista` (`idArtista`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Cliente` (
  `idCliente` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `apellido` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `clave` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCliente`),
  UNIQUE INDEX `correo_UNIQUE` (`correo` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Factura`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Factura` (
  `idFactura` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `valor_subtotal` DOUBLE NOT NULL,
  `valor_total` DOUBLE NOT NULL,
  `idCliente` INT NOT NULL,
  PRIMARY KEY (`idFactura`),
  INDEX `fk_Factura_Cliente1_idx` (`idCliente` ASC) ,
  CONSTRAINT `fk_Factura_Cliente1`
    FOREIGN KEY (`idCliente`)
    REFERENCES `blueTicketV2`.`Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Ciudad`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Ciudad` (
  `idCiudad` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idCiudad`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Lugar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Lugar` (
  `idLugar` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `direccion` VARCHAR(45) NOT NULL,
  `idCiudad` INT NOT NULL,
  PRIMARY KEY (`idLugar`),
  INDEX `fk_Lugar_Ciudad1_idx` (`idCiudad` ASC) ,
  CONSTRAINT `fk_Lugar_Ciudad1`
    FOREIGN KEY (`idCiudad`)
    REFERENCES `blueTicketV2`.`Ciudad` (`idCiudad`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Detalle_evento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Detalle_evento` (
  `idDetalle` INT NOT NULL AUTO_INCREMENT,
  `fecha` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_final` TIME NOT NULL,
  `costo` DOUBLE NOT NULL,
  `aforo` INT NOT NULL,
  `idLugar` INT NOT NULL,
  `idEvento` INT NOT NULL,
  PRIMARY KEY (`idDetalle`),
  INDEX `fk_Lugar_Evento_Lugar1_idx` (`idLugar` ASC) ,
  INDEX `fk_Lugar_Evento_Evento1_idx` (`idEvento` ASC) ,
  CONSTRAINT `fk_Lugar_Evento_Lugar1`
    FOREIGN KEY (`idLugar`)
    REFERENCES `blueTicketV2`.`Lugar` (`idLugar`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Lugar_Evento_Evento1`
    FOREIGN KEY (`idEvento`)
    REFERENCES `blueTicketV2`.`Evento` (`idEvento`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Boleta`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Boleta` (
  `idBoleta` INT NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(45) NOT NULL,
  `idFactura` INT NOT NULL,
  `idDetalle` INT NOT NULL,
  PRIMARY KEY (`idBoleta`),
  INDEX `fk_Factura_Boleta_Boleta1_idx` (`idDetalle` ASC) ,
  INDEX `fk_Boleta_Factura1_idx` (`idFactura` ASC) ,
  CONSTRAINT `fk_Factura_Boleta_Boleta1`
    FOREIGN KEY (`idDetalle`)
    REFERENCES `blueTicketV2`.`Detalle_evento` (`idDetalle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Boleta_Factura1`
    FOREIGN KEY (`idFactura`)
    REFERENCES `blueTicketV2`.`Factura` (`idFactura`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blueTicketV2`.`Carro`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blueTicketV2`.`Carro` (
  `idCarro` INT NOT NULL AUTO_INCREMENT,
  `nombre_usuario` VARCHAR(45) NOT NULL,
  `idCliente` INT NOT NULL,
  `idDetalle` INT NOT NULL,
  INDEX `fk_Cliente_has_Detalle_evento_Detalle_evento1_idx` (`idDetalle` ASC) ,
  INDEX `fk_Cliente_has_Detalle_evento_Cliente1_idx` (`idCliente` ASC) ,
  PRIMARY KEY (`idCarro`),
  CONSTRAINT `fk_Cliente_has_Detalle_evento_Cliente1`
    FOREIGN KEY (`idCliente`)
    REFERENCES `blueTicketV2`.`Cliente` (`idCliente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Cliente_has_Detalle_evento_Detalle_evento1`
    FOREIGN KEY (`idDetalle`)
    REFERENCES `blueTicketV2`.`Detalle_evento` (`idDetalle`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
