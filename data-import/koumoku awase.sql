-- MySQL Script generated by MySQL Workbench
-- Wed Jun  8 12:50:33 2022
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

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
239  `assistant_fulltime` INT(2) NULL,
240  `assistant_parttime` INT(2) NULL,
241  `assistant_working_hour` INT(2) NULL,
242  `assistant_avg_exp_fulltime` INT(2) NULL,
243  `assistant_avg_exp_parttime` INT(2) NULL,
244  `kyouyu_fulltime` INT(2) NULL,
245  `kyouyu_parttime` INT(2) NULL,
246  `kyouyu_working_hour` INT(2) NULL,
247  `kyouyu_avg_exp_fulltime` INT(2) NULL,
248  `kyouyu_avg_exp_parttime` INT(2) NULL,
249  `kateiteki_fulltime` INT(2) NULL,
250  `kateiteki_parttime` INT(2) NULL,
251  `kateiteki_working_hour` INT(2) NULL,
252  `kateiteki_avg_exp_fulltime` INT(2) NULL,
253  `kateiteki_avg_exp_parttime` INT(2) NULL,
254  `total_fulltime` INT(2) NULL,
255  `total_parttime` INT(2) NULL,
256  `child_for_each_teacher` INT(2) NULL,
257  `certification` VARCHAR(500) NULL,
258  `certification_other` VARCHAR(500) NULL,
259  `business_day` VARCHAR(45) NULL,
260  `weekday_opening_time` TIME NULL,
261  `weekday_closing_time` TIME NULL,
262  `weekend_opening_time` TIME NULL,
263  `weekend_closing_time` TIME NULL,
264  `holiday_opening_time` TIME NULL,
265  `holiday_closing_time` TIME NULL,
280  `quota_0` INT(2) NULL,
283  `quota_1` INT(2) NULL,
286  `quota_2` INT(2) NULL,
289  `quota_3` INT(2) NULL,
292  `quota_4` INT(2) NULL,
295  `quota_5` INT(2) NULL,
298  `quota_total` INT(2) NULL,
302  `operation_method` TEXT NULL,
303  `hoiku_naiyou` TEXT NULL,
304  `kyuushoku` TEXT NULL,
305  `kyuushoku_day` VARCHAR(45) NULL,
306  `disabled_child_receiving` BIT NULL,
307  `temporary_caring` BIT NULL,
308  `sick_child_receiving` BIT NULL,
309  `tetuduki` TEXT NULL,
311  `tetuduki_other` TEXT NULL,
312  `claim_window` TEXT NULL,
313  `compensation` TEXT NULL,
314  `tokushoku` TEXT NULL,
315  `jippi_choushuu` BIT NULL,
316  `jippi_riyuu` TEXT NULL,
317  `jippi_amount` INT NULL,
  `facilitycol` VARCHAR(45) NULL,
  INDEX `fk_kindergarden_corporate_idx` (`corporate_id` ASC),
  PRIMARY KEY (`id`),
  UNIQUE INDEX `facility_name_UNIQUE` (`facility_name` ASC),
  CONSTRAINT `fk_kindergarden_corporate`
    FOREIGN KEY (`corporate_id`)
    REFERENCES `kindergarden`.`corporate` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
