<?php
/**
 * Banner rotate
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Storm
 * @package    Storm_Banner
 * @copyright  Copyright (c) 2014 Storm
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Willian Cordeiro de Souza <williancordeirodesouza@gmail.com>
 */
$this->startSetup();
$this->run("
    SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
    SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
    SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

    -- -----------------------------------------------------
    -- Table `banner_group`
    -- -----------------------------------------------------
    DROP TABLE IF EXISTS {$this->getTable('banner/group')} ;
    CREATE TABLE IF NOT EXISTS {$this->getTable('banner/group')} (
      `id` INT NOT NULL AUTO_INCREMENT,
      `title` VARCHAR(50) NOT NULL,
      `code` VARCHAR(50) NOT NULL,
      `is_active` TINYINT(1) NOT NULL DEFAULT 1,
      PRIMARY KEY (`id`),
      UNIQUE INDEX `CODE_UNIQUE` (`code` ASC))
    ENGINE = InnoDB;

    -- -----------------------------------------------------
    -- Table `banner`
    -- -----------------------------------------------------
    DROP TABLE IF EXISTS {$this->getTable('banner/banner')} ;
    CREATE TABLE IF NOT EXISTS {$this->getTable('banner/banner')} (
      `id` INT NOT NULL AUTO_INCREMENT,
      `group_id` INT NOT NULL,
      `name` VARCHAR(50) NOT NULL,
      `image` VARCHAR(254) NOT NULL,
      `date_from` DATETIME NOT NULL,
      `date_to` DATETIME NULL,
      `is_active` TINYINT(1) NOT NULL,
      PRIMARY KEY (`id`),
      INDEX `FK_BANNER_GROUP_ID_IDX` (`group_id` ASC),
      CONSTRAINT `FK_BANNER_GROUP_ID`
        FOREIGN KEY (`group_id`)
        REFERENCES {$this->getTable('banner/group')} (`id`)
        ON DELETE CASCADE
        ON UPDATE CASCADE)
    ENGINE = InnoDB;

    SET SQL_MODE=@OLD_SQL_MODE;
    SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
    SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
");