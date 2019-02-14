-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mtlaga_db
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mtlaga_db
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mtlaga_db` DEFAULT CHARACTER SET utf8 ;
USE `mtlaga_db` ;

-- -----------------------------------------------------
-- Table `mtlaga_db`.`favorites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mtlaga_db`.`favorites` (
  `id_favorites` INT NOT NULL,
  `itineraire` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_favorites`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mtlaga_db`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mtlaga_db`.`users` (
  `id_user` INT NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `salt_password` VARCHAR(255) NOT NULL,
  `admin` TINYINT(1) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `confirmed` TINYINT(1) NOT NULL,
  `confirmed_at` DATETIME NOT NULL,
  `confirmation_token` VARCHAR(255) NOT NULL,
  `confirmation_token_sent_at` DATETIME NOT NULL,
  `remember` TINYINT(1) NOT NULL,
  `reset_password_token` VARCHAR(45) NULL,
  `reset_password_sent_at` DATETIME NULL,
  `favorites_id` INT NOT NULL,
  PRIMARY KEY (`id_user`, `favorites_id`),
  INDEX `fk_tb_user_tb_favorites_idx` (`favorites_id` ASC),
  CONSTRAINT `fk_tb_user_tb_favorites`
    FOREIGN KEY (`favorites_id`)
    REFERENCES `mtlaga_db`.`favorites` (`id_favorites`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mtlaga_db`.`rss`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mtlaga_db`.`rss` (
  `id_rss` INT NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_rss`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
