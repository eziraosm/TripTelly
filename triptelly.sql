-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for triptelly
DROP DATABASE IF EXISTS `triptelly`;
CREATE DATABASE IF NOT EXISTS `triptelly` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `triptelly`;

-- Dumping structure for table triptelly.cart
DROP TABLE IF EXISTS `cart`;
CREATE TABLE IF NOT EXISTS `cart` (
  `cartID` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `userID` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `fromLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `destinationLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `departureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `member` int NOT NULL,
  `max_budget` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`cartID`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table triptelly.cart: ~3 rows (approximately)
DELETE FROM `cart`;
INSERT INTO `cart` (`cartID`, `userID`, `fromLocation`, `destinationLocation`, `departureDate`, `returnDate`, `member`, `max_budget`) VALUES
	('7VDmfLDYtkE', '69e6a1311ecaca54', 'kedah', 'putrajaya', '2024-11-20', '2024-11-23', 1, 500.00),
	('AfW0kIq6PJh', '69e6a1311ecaca54', 'kedah', 'putrajaya', '2024-11-20', '2024-11-23', 1, 500.00),
	('yyQ69MOD1Jg', '69e6a1311ecaca54', 'kedah', 'putrajaya', '2024-11-20', '2024-11-23', 1, 500.00);

-- Dumping structure for table triptelly.cart_attractions
DROP TABLE IF EXISTS `cart_attractions`;
CREATE TABLE IF NOT EXISTS `cart_attractions` (
  `cartAttID` int NOT NULL AUTO_INCREMENT,
  `cartID` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `attID` varchar(225) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'google places id',
  `attName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `attLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `attPrice` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`cartAttID`) USING BTREE,
  KEY `cartID` (`cartID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table triptelly.cart_attractions: ~3 rows (approximately)
DELETE FROM `cart_attractions`;
INSERT INTO `cart_attractions` (`cartAttID`, `cartID`, `attID`, `attName`, `attLocation`, `attPrice`) VALUES
	(1, '7VDmfLDYtkE', 'ChIJ2yat5MVJzDERUIHFb1rkGGw', 'Planetarium Negara', '53, Jalan Perdana, Kuala Lumpur', 31.00),
	(2, '7VDmfLDYtkE', 'ChIJJSAtCNNJzDERETbGF9iz7CI', 'Muzium Telekom', 'Jalan Raja Chulan, Kuala Lumpur', 11.00),
	(3, '7VDmfLDYtkE', 'ChIJn7ct6mxIzDERAfOvaaTX5DM', 'National Art Gallery', 'Lembaga Pembangunan Seni Visual Negara, 2, Jalan Temerloh, off, Jalan Tun Razak, Kuala Lumpur', 48.00);

-- Dumping structure for table triptelly.cart_hotel
DROP TABLE IF EXISTS `cart_hotel`;
CREATE TABLE IF NOT EXISTS `cart_hotel` (
  `cartHotelID` int NOT NULL AUTO_INCREMENT,
  `cartID` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `hotelID` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'google places ID',
  `hotelName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hotelLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hotelPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`cartHotelID`) USING BTREE,
  KEY `cartID` (`cartID`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table triptelly.cart_hotel: ~1 rows (approximately)
DELETE FROM `cart_hotel`;
INSERT INTO `cart_hotel` (`cartHotelID`, `cartID`, `hotelID`, `hotelName`, `hotelLocation`, `hotelPrice`) VALUES
	(3, 'AfW0kIq6PJh', 'ChIJJ2V7SClPzDER779w0YaYOXU', 'Royale Chulan Damansara', '2A, Jalan PJU 7/3, Mutiara Damansara, Petaling Jaya', 102.00);

-- Dumping structure for table triptelly.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `userID` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userFname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userEmail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userPassword` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `userEmail` (`userEmail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table triptelly.user: ~1 rows (approximately)
DELETE FROM `user`;
INSERT INTO `user` (`userID`, `username`, `userFname`, `userEmail`, `userPassword`) VALUES
	('69e6a1311ecaca54', 'Usamah', 'Mohamad Usamah Thani Che Arif', 'mohamadusamahthani@gmail.com', '$2y$10$aeNKSm.bQF4rjQppUHGMW.BLqFGAHxhHCkMLspy4cIVcznYH0pE3O'),
	('8c515ad5bc828c08', 'Sam', 'UsamahThani', 'usamah@gmail.com', '$2y$10$JJudpbh3gtNiL0tcBKI5D.HMzndUW1e7PltoK/J8vjB3.VfUlFfmS');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
