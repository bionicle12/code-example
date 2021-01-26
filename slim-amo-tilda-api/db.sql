-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               10.3.22-MariaDB-log - mariadb.org binary distribution
-- Операционная система:         Win64
-- HeidiSQL Версия:              11.0.0.5958
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица project_db.breeds
DROP TABLE IF EXISTS `breeds`;
CREATE TABLE IF NOT EXISTS `breeds` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `type` varchar(3) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.carts
DROP TABLE IF EXISTS `carts`;
CREATE TABLE IF NOT EXISTS `carts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.contacts
DROP TABLE IF EXISTS `contacts`;
CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `company` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `dogs` smallint(5) unsigned DEFAULT NULL,
  `tests` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `phone` (`phone`),
  KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.discount_cards
DROP TABLE IF EXISTS `discount_cards`;
CREATE TABLE IF NOT EXISTS `discount_cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `discount` varchar(10) DEFAULT NULL,
  `dogs` smallint(5) unsigned DEFAULT NULL,
  `tests` smallint(5) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.genetic_prices
DROP TABLE IF EXISTS `genetic_prices`;
CREATE TABLE IF NOT EXISTS `genetic_prices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `count` tinyint(3) unsigned DEFAULT NULL,
  `price` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `cart` mediumtext DEFAULT NULL,
  `img_url` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.prices
DROP TABLE IF EXISTS `prices`;
CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `price` mediumint(8) unsigned DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `position` tinyint(3) unsigned DEFAULT NULL,
  `type` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.products
DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `sku` varchar(50) DEFAULT NULL,
  `name` varchar(150) DEFAULT NULL,
  `name_latin` varchar(150) DEFAULT NULL,
  `group` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `breed_dogs` mediumtext DEFAULT NULL,
  `breed_cats` mediumtext DEFAULT NULL,
  `price` mediumint(8) unsigned DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.promocodes
DROP TABLE IF EXISTS `promocodes`;
CREATE TABLE IF NOT EXISTS `promocodes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `crm_id` int(11) unsigned DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `discount` varchar(50) DEFAULT NULL,
  `used` mediumint(8) unsigned DEFAULT NULL,
  `limit` mediumint(8) unsigned DEFAULT NULL,
  `expired` date DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.stuff
DROP TABLE IF EXISTS `stuff`;
CREATE TABLE IF NOT EXISTS `stuff` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `stuff_name` varchar(50) DEFAULT NULL,
  `stuff_details` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

-- Дамп структуры для таблица project_db.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

-- Экспортируемые данные не выделены.

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
