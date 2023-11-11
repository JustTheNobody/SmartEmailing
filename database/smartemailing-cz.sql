-- Adminer 4.8.1 MySQL 10.5.13-MariaDB dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `days`;
CREATE TABLE `days` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `day_of_week` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `day_of_week` (`day_of_week`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `days` (`id`, `day_of_week`) VALUES
(5,	'Friday'),
(1,	'Monday'),
(6,	'Saturday'),
(7,	'Sunday'),
(4,	'Thursday'),
(2,	'Tuesday'),
(3,	'Wednesday');

DROP TABLE IF EXISTS `pid_day_time_slots`;
CREATE TABLE `pid_day_time_slots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid_sale_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `day_id` bigint(20) unsigned NOT NULL,
  `pid_time_slot_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid_sale_id_day_id_pid_time_slot_id` (`pid_sale_id`,`day_id`,`pid_time_slot_id`),
  KEY `pid_day_time_slots_day_id_foreign` (`day_id`),
  KEY `pid_day_time_slots_pid_time_slot_id_foreign` (`pid_time_slot_id`),
  KEY `pid_sale_id` (`pid_sale_id`),
  CONSTRAINT `pid_day_time_slots_day_id_foreign` FOREIGN KEY (`day_id`) REFERENCES `days` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pid_day_time_slots_pid_time_slot_id_foreign` FOREIGN KEY (`pid_time_slot_id`) REFERENCES `pid_time_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pid_pay_methods`;
CREATE TABLE `pid_pay_methods` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  UNIQUE KEY `pid_pay_methods_id_unique` (`id`),
  KEY `pid_pay_methods_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pid_sales`;
CREATE TABLE `pid_sales` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pid_type_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remarks` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double(10,6) NOT NULL,
  `lon` double(10,6) NOT NULL,
  `pid_service_id` bigint(20) NOT NULL,
  `pid_pay_method_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `type_id` (`pid_type_id`),
  KEY `pay_method_id` (`pid_pay_method_id`),
  KEY `pid_service_id` (`pid_service_id`),
  KEY `name` (`name`),
  CONSTRAINT `pid_sales_ibfk_1` FOREIGN KEY (`pid_type_id`) REFERENCES `pid_types` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `pid_sales_ibfk_2` FOREIGN KEY (`pid_pay_method_id`) REFERENCES `pid_pay_methods` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `pid_sales_ibfk_3` FOREIGN KEY (`pid_service_id`) REFERENCES `pid_services` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pid_services`;
CREATE TABLE `pid_services` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pid_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pid_services_id_index` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pid_time_slots`;
CREATE TABLE `pid_time_slots` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `start_time_end_time` (`start_time`,`end_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `pid_types`;
CREATE TABLE `pid_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2023-11-11 11:15:15
