-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.5.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4160
-- Date/time:                    2012-10-08 10:57:56
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for clanwar_data
CREATE DATABASE IF NOT EXISTS `clanwar_data` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `clanwar_data`;


-- Dumping structure for table clanwar_data.battle_log
CREATE TABLE IF NOT EXISTS `battle_log` (
  `player_name` varchar(25) NOT NULL,
  `clan_tag` varchar(10) NOT NULL,
  `team` int(10) NOT NULL,
  `match_time` int(10) NOT NULL,
  `match_type` int(5) NOT NULL,
  `name` varchar(25) NOT NULL,
  `alive` tinyint(1) NOT NULL,
  `frags` int(5) NOT NULL,
  `match_result` tinyint(1) NOT NULL,
  `map_location` varchar(50) NOT NULL,
  `match_location` varchar(50) NOT NULL,
  `last_update` int(10) NOT NULL,
  UNIQUE KEY `player_name` (`player_name`,`match_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table clanwar_data.battle_log: ~0 rows (approximately)
/*!40000 ALTER TABLE `battle_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `battle_log` ENABLE KEYS */;


-- Dumping structure for table clanwar_data.clan_data
CREATE TABLE IF NOT EXISTS `clan_data` (
  `clan_id` int(10) NOT NULL,
  `clan_tag` varchar(10) NOT NULL,
  `clan_name` varchar(50) NOT NULL,
  `clan_logo` blob NOT NULL,
  `owner` tinyint(1) NOT NULL,
  `ally` tinyint(1) NOT NULL,
  `last_update` int(10) NOT NULL,
  UNIQUE KEY `clan_id` (`clan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table clanwar_data.clan_data: ~1 rows (approximately)
/*!40000 ALTER TABLE `clan_data` DISABLE KEYS */;
INSERT INTO `clan_data` (`clan_id`, `clan_tag`, `clan_name`, `clan_logo`, `owner`, `ally`, `last_update`) VALUES
	(500000001, 'WG', 'Wargaming.net', '', 1, 0, 0);
/*!40000 ALTER TABLE `clan_data` ENABLE KEYS */;


-- Dumping structure for table clanwar_data.player_data
CREATE TABLE IF NOT EXISTS `player_data` (
  `player_id` int(10) NOT NULL,
  `player_name` varchar(25) NOT NULL,
  `clan_id` int(10) NOT NULL,
  `clan_tag` varchar(10) NOT NULL,
  `player_role` varchar(25) NOT NULL,
  `member_date` int(10) NOT NULL,
  `last_update` int(10) NOT NULL,
  `clan_history` text NOT NULL,
  `away_till` int(10) NOT NULL,
  UNIQUE KEY `player_id` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table clanwar_data.player_data: ~0 rows (approximately)
/*!40000 ALTER TABLE `player_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `player_data` ENABLE KEYS */;


-- Dumping structure for table clanwar_data.replay_data
CREATE TABLE IF NOT EXISTS `replay_data` (
  `filename` varchar(50) NOT NULL,
  `signature` int(10) NOT NULL,
  `match_type` int(10) NOT NULL,
  `match_time` int(10) NOT NULL,
  `match_map` varchar(50) NOT NULL,
  `match_location` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `match_blocks` tinyint(2) NOT NULL,
  `match_start_length` int(10) NOT NULL,
  `match_start_data` text NOT NULL,
  `match_end_length` int(10) NOT NULL,
  `match_end_data` text NOT NULL,
  `replay_file` mediumblob NOT NULL,
  `last_update` int(10) NOT NULL,
  UNIQUE KEY `match_time` (`match_time`,`match_map`,`match_location`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table clanwar_data.replay_data: ~0 rows (approximately)
/*!40000 ALTER TABLE `replay_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `replay_data` ENABLE KEYS */;


-- Dumping structure for table clanwar_data.tool_config
CREATE TABLE IF NOT EXISTS `tool_config` (
  `vehicle_class` varchar(25) NOT NULL,
  `vehicle_tier` tinyint(4) NOT NULL,
  `lock_time` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table clanwar_data.tool_config: ~38 rows (approximately)
/*!40000 ALTER TABLE `tool_config` DISABLE KEYS */;
INSERT INTO `tool_config` (`vehicle_class`, `vehicle_tier`, `lock_time`) VALUES
	('heavyTank', 10, 604800),
	('heavyTank', 9, 432000),
	('heavyTank', 8, 345600),
	('heavyTank', 7, 259200),
	('heavyTank', 6, 172800),
	('heavyTank', 5, 108000),
	('heavyTank', 4, 86400),
	('mediumTank', 10, 432000),
	('mediumTank', 9, 345600),
	('mediumTank', 8, 259200),
	('mediumTank', 7, 172800),
	('mediumTank', 6, 108000),
	('mediumTank', 5, 90000),
	('mediumTank', 4, 57600),
	('mediumTank', 3, 14400),
	('mediumTank', 2, 3600),
	('lightTank', 7, 57600),
	('lightTank', 6, 57600),
	('lightTank', 5, 57600),
	('lightTank', 4, 14400),
	('lightTank', 3, 7200),
	('lightTank', 2, 3600),
	('SPG', 8, 266400),
	('SPG', 7, 180000),
	('SPG', 6, 129600),
	('SPG', 5, 97200),
	('SPG', 4, 64800),
	('SPG', 3, 28800),
	('SPG', 2, 14400),
	('AT-SPG', 10, 432000),
	('AT-SPG', 9, 345600),
	('AT-SPG', 8, 259200),
	('AT-SPG', 7, 172800),
	('AT-SPG', 6, 108000),
	('AT-SPG', 5, 90000),
	('AT-SPG', 4, 57600),
	('AT-SPG', 3, 14400),
	('AT-SPG', 2, 3600);
/*!40000 ALTER TABLE `tool_config` ENABLE KEYS */;


-- Dumping structure for table clanwar_data.vehicle_data
CREATE TABLE IF NOT EXISTS `vehicle_data` (
  `player_id` int(10) NOT NULL,
  `player_name` varchar(25) NOT NULL,
  `vehicle_class` varchar(25) NOT NULL,
  `vehicle_tier` int(11) NOT NULL,
  `nation` varchar(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `localized_name` varchar(25) NOT NULL,
  `locked_on` int(10) NOT NULL,
  `last_update` int(10) NOT NULL,
  UNIQUE KEY `player_id` (`player_id`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table clanwar_data.vehicle_data: ~0 rows (approximately)
/*!40000 ALTER TABLE `vehicle_data` DISABLE KEYS */;
/*!40000 ALTER TABLE `vehicle_data` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
