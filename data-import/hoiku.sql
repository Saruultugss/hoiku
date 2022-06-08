-- MySQL Script generated by MySQL Workbench
-- Wed Jun  8 12:50:33 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema kindergarden
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `kindergarden` ;

-- -----------------------------------------------------
-- Schema kindergarden
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `kindergarden` DEFAULT CHARACTER SET utf8 ;
USE `kindergarden` ;

-- -----------------------------------------------------
-- Table `kindergarden`.`facility`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `kindergarden`.`facility` ;

CREATE TABLE IF NOT EXISTS `kindergarden`.`facility` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `corporate_id` INT UNSIGNED NOT NULL,
  `facility_type` VARCHAR(45) NULL,
  `facility_name` VARCHAR(200) NULL,
  `facility_name_hiragana` VARCHAR(200) NULL,
  `facility_id` VARCHAR(13) NULL,
  `postal_code` VARCHAR(7) NULL,
  `address_prefecture` VARCHAR(45) NULL,
  `address_district` VARCHAR(45) NULL,
  `address_street` VARCHAR(45) NULL,
  `address_building` VARCHAR(45) NULL,
  `licensed_date` DATE NULL,
  `opening_date` DATE NULL,
  `phone` VARCHAR(45) NULL,
  `hoikushi_fulltime` INT(2) NULL,
  `hoikushi_parttime` INT(2) NULL,
  `hoikushi_working_hour` INT(2) NULL,
  `hoikushi_avg_exp_fulltime` INT(2) NULL,
  `hoikushi_avg_exp_parttime` INT(2) NULL,
  `assistant_fulltime` INT(2) NULL,
  `assistant_parttime` INT(2) NULL,
  `assistant_working_hour` INT(2) NULL,
  `assistant_avg_exp_fulltime` INT(2) NULL,
  `assistant_avg_exp_parttime` INT(2) NULL,
  `kyouyu_fulltime` INT(2) NULL,
  `kyouyu_parttime` INT(2) NULL,
  `kyouyu_working_hour` INT(2) NULL,
  `kyouyu_avg_exp_fulltime` INT(2) NULL,
  `kyouyu_avg_exp_parttime` INT(2) NULL,
  `kateiteki_fulltime` INT(2) NULL,
  `kateiteki_parttime` INT(2) NULL,
  `kateiteki_working_hour` INT(2) NULL,
  `kateiteki_avg_exp_fulltime` INT(2) NULL,
  `kateiteki_avg_exp_parttime` INT(2) NULL,
  `total_fulltime` INT(2) NULL,
  `total_parttime` INT(2) NULL,
  `child_for_each_teacher` INT(2) NULL,
  `certification` VARCHAR(500) NULL,
  `certification_other` VARCHAR(500) NULL,
  `business_day` VARCHAR(45) NULL,
  `weekday_opening_time` TIME NULL,
  `weekday_closing_time` TIME NULL,
  `weekend_opening_time` TIME NULL,
  `weekend_closing_time` TIME NULL,
  `holiday_opening_time` TIME NULL,
  `holiday_closing_time` TIME NULL,
  `quota_0` INT(2) NULL,
  `quota_1` INT(2) NULL,
  `quota_2` INT(2) NULL,
  `quota_3` INT(2) NULL,
  `quota_4` INT(2) NULL,
  `quota_5` INT(2) NULL,
  `quota_total` INT(2) NULL,
  `operation_method` TEXT NULL,
  `hoiku_naiyou` TEXT NULL,
  `kyuushoku` TEXT NULL,
  `kyuushoku_day` VARCHAR(45) NULL,
  `disabled_child_receiving` BIT NULL,
  `temporary_caring` BIT NULL,
  `sick_child_receiving` BIT NULL,
  `tetuduki` TEXT NULL,
  `tetuduki_other` TEXT NULL,
  `claim_window` TEXT NULL,
  `compensation` TEXT NULL,
  `tokushoku` TEXT NULL,
  `jippi_choushuu` BIT NULL,
  `jippi_riyuu` TEXT NULL,
  `jippi_amount` INT NULL,
  `facilitycol` VARCHAR(45) NULL,
  INDEX `fk_kindergarden_corporate_idx` (`corporate_id` ASC) VISIBLE,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `facility_name_UNIQUE` (`facility_name` ASC) VISIBLE,
  CONSTRAINT `fk_kindergarden_corporate`
    FOREIGN KEY (`corporate_id`)
    REFERENCES `kindergarden`.`corporate` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
