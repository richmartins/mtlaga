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
-- Table `mtlaga_db`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mtlaga_db`.`users` (
  `id_user` INT NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(255) NOT NULL,
  `hash_password` VARCHAR(255) NOT NULL DEFAULT '',
  `salt_password` VARCHAR(255) NOT NULL,
  `admin` TINYINT(1) NOT NULL,
  `created_at` DATETIME NOT NULL,
  `confirmed` TINYINT(1) NOT NULL,
  `confirmed_at` DATETIME NULL,
  `confirmation_token` VARCHAR(255) NOT NULL,
  `remember` TINYINT(1) NOT NULL,
  `reset_password_token` VARCHAR(45) NULL,
  `reset_password_sent_at` DATETIME NULL,
  PRIMARY KEY (`id_user`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mtlaga_db`.`favorites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mtlaga_db`.`favorites` (
  `id_favorites` INT NOT NULL AUTO_INCREMENT,
  `itineraire` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_favorites`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mtlaga_db`.`rss`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mtlaga_db`.`rss` (
  `id_rss` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_rss`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mtlaga_db`.`users_has_favorites`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mtlaga_db`.`users_has_favorites` (
  `users_id_user` INT NOT NULL,
  `favorites_id_favorites` INT NOT NULL,
  PRIMARY KEY (`users_id_user`, `favorites_id_favorites`),
  INDEX `fk_users_has_favorites_favorites1_idx` (`favorites_id_favorites` ASC),
  INDEX `fk_users_has_favorites_users_idx` (`users_id_user` ASC),
  CONSTRAINT `fk_users_has_favorites_users`
    FOREIGN KEY (`users_id_user`)
    REFERENCES `mtlaga_db`.`users` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_has_favorites_favorites1`
    FOREIGN KEY (`favorites_id_favorites`)
    REFERENCES `mtlaga_db`.`favorites` (`id_favorites`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Create DB user
-- -----------------------------------------------------
CREATE USER IF NOT EXISTS 'mtlaga_user'@'localhost' IDENTIFIED BY '7x+d4XV9Hc/K$M+t8q5';
GRANT ALL PRIVILEGES ON mtlaga_db . * TO 'mtlaga_user'@'localhost';
FLUSH PRIVILEGES;

-- -----------------------------------------------------
-- Create test users into table users
-- -----------------------------------------------------
INSERT INTO mtlaga_db.users (email, hash_password, salt_password, admin, created_at, confirmed, confirmed_at, confirmation_token, remember)
VALUES ('plop@plop.com', '18496197305510DF22AF763507C99219EA08E08414383AE1ABF1CB156D961A03', 'KK2CYdZaBL', 0, '2019-02-14 17:42', 1, '2019-02-14 17:45', 'djtph9fvns4erv4bqgc7', 0);

INSERT INTO mtlaga_db.users (email, hash_password, salt_password, admin, created_at, confirmed, confirmed_at, confirmation_token, remember)
VALUES ('toto@toto.com', '31F7A65E315586AC198BD798B6629CE4903D0899476D5741A9F32E2E521B6A66', '8EHq3XsBTa', 0, '2019-01-12 09:13', 1, '2019-01-12 09:23', 'fujnbefa38vne9br4wmp', 1);

INSERT INTO mtlaga_db.users (email, hash_password, salt_password, admin, created_at, confirmed, confirmed_at, confirmation_token, remember)
VALUES ('tutu@tutu.com', 'EB0295D98F37AE9E95102AFAE792D540137BE2DEDF6C4B00570AB1D1F355D033', 'F9jvC94FdR', 0, '2018-09-01 11:12', 1, '2018-09-01 11:13', 'xpwmgkm4uz5hdsx2ufz9', 0);

INSERT INTO mtlaga_db.users (email, hash_password, salt_password, admin, created_at, confirmed, confirmed_at, confirmation_token, remember)
VALUES ('john@doe.com', 'C2713B62C903791BDEFC5A6A99DF04D4330DE491BBC7A0CA6A5007337E4A6028', 'D3gg4FkzbT', 0, '2018-12-12 21:37', 1, '2018-12-12 21:37', 'wkw2k7y288gtkzxsx2xb', 1);

INSERT INTO mtlaga_db.users (email, hash_password, salt_password, admin, created_at, confirmed, confirmed_at, confirmation_token, remember)
VALUES ('coco@coco.com', '4F682B71153FFA91E608445D7EA1257E2076D0D95EAB6336CD1AA94B49680F11', 'T38XwrEfMF', 0, '2019-01-30 06:54', 1, '2019-01-30 07:00', 'u8fc9zz3hfyznq48wkdm', 0);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

