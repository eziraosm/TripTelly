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

-- Dumping data for table triptelly.cart: ~1 rows (approximately)
DELETE FROM `cart`;
INSERT INTO `cart` (`cartID`, `userID`, `fromLocation`, `destinationLocation`, `departureDate`, `returnDate`, `member`, `budget`) VALUES
	('uNXD14XnUG8', '69e6a1311ecaca54', 'kelantan', 'kuala lumpur', '2024-11-19', '2024-11-22', 1, 0.00);

-- Dumping data for table triptelly.cart_attractions: ~4 rows (approximately)
DELETE FROM `cart_attractions`;
INSERT INTO `cart_attractions` (`cartID`, `attID`, `attName`, `attLocation`, `attPrice`) VALUES
	('uNXD14XnUG8', 'ChIJ5Yo1z7lJzDERjQ0Y3YzFkVA', 'Orang Asli Crafts Museum', 'Orang Asli Crafts Museum, Jabatan Muzium Malaysia, Jalan Damansara, 50566 Kuala Lumpur', 25.00),
	('uNXD14XnUG8', 'ChIJnWvAPjFIzDERoFfk1RGfzqc', 'Bank Negara Malaysia Museum and Art Gallery', 'Sasana Kijang, 2, Jalan Dato Onn, Kuala Lumpur', 66.00),
	('uNXD14XnUG8', 'ChIJt2_hksNJzDERE4oP7192_Pc', 'Wei-Ling Gallery', '8, Jalan Scott, Brickfields, Kuala Lumpur', 76.00),
	('uNXD14XnUG8', 'ChIJYUOG73hSzDER-iJYkiuMqNE', 'Yayasan Restu', '2A, Persiaran Damai, Seksyen 10, Shah Alam', 193.00);

-- Dumping data for table triptelly.cart_hotel: ~1 rows (approximately)
DELETE FROM `cart_hotel`;
INSERT INTO `cart_hotel` (`cartID`, `hotelID`, `hotelName`, `hotelLocation`, `hotelPrice`) VALUES
	('uNXD14XnUG8', 'ChIJ3aAABGRMzDERSZKnRep_6ZM', 'Holiday Villa Hotel & Conference Centre Subang', '9, Jalan SS 12/1, Ss 12, Subang Jaya', 111.00);

-- Dumping data for table triptelly.user: ~1 rows (approximately)
DELETE FROM `user`;
INSERT INTO `user` (`userID`, `username`, `userFname`, `userEmail`, `userPassword`) VALUES
	('69e6a1311ecaca54', 'Usamah', 'Mohamad Usamah Thani Che Arif', 'mohamadusamahthani@gmail.com', '$2y$10$aeNKSm.bQF4rjQppUHGMW.BLqFGAHxhHCkMLspy4cIVcznYH0pE3O');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
