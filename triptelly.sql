-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 05:40 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `triptelly`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` varchar(11) NOT NULL,
  `userID` varchar(225) NOT NULL,
  `fromLocation` varchar(255) NOT NULL,
  `destinationLocation` varchar(255) NOT NULL,
  `departureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `member` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `fromLocation`, `destinationLocation`, `departureDate`, `returnDate`, `member`) VALUES
('aNO5CIHsy3H', '69e6a1311ecaca54', 'kedah', 'kuala lumpur', '2011-10-08', '1977-04-25', 3);

-- --------------------------------------------------------

--
-- Table structure for table `cart_attractions`
--

CREATE TABLE `cart_attractions` (
  `cartID` varchar(11) NOT NULL,
  `attID` varchar(225) NOT NULL COMMENT 'google places id',
  `attName` varchar(255) NOT NULL,
  `attLocation` varchar(255) NOT NULL,
  `attPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_attractions`
--

INSERT INTO `cart_attractions` (`cartID`, `attID`, `attName`, `attLocation`, `attPrice`) VALUES
('aNO5CIHsy3H', 'ChIJ9_6dH8dJzDERC7k4SHbqU3o', 'The National Museum of Malaysia', 'Department of Museum, Jalan Damansara, Tasik Perdana, Kuala Lumpur', 67),
('aNO5CIHsy3H', 'ChIJqaULqPxSzDERn8ySiuUKEmw', 'Trick Art Museum @ i-City', 'i-Gallery, Jalan Multimedia 7/Ah, I-city, Shah Alam', 100),
('aNO5CIHsy3H', 'ChIJvy1SAMZPzDERS6HN5ms9Xwo', 'Shawnalyzer Studio', '15, Jalan Zuhrah U5/151, Taman Subang Murni, Shah Alam', 9);

-- --------------------------------------------------------

--
-- Table structure for table `cart_hotel`
--

CREATE TABLE `cart_hotel` (
  `cartID` varchar(11) NOT NULL,
  `hotelID` varchar(255) NOT NULL COMMENT 'google places ID',
  `hotelName` varchar(255) NOT NULL,
  `hotelLocation` varchar(255) NOT NULL,
  `hotelPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_hotel`
--

INSERT INTO `cart_hotel` (`cartID`, `hotelID`, `hotelName`, `hotelLocation`, `hotelPrice`) VALUES
('aNO5CIHsy3H', 'ChIJNySdvdFJzDERZLNbuoRR-DQ', 'Impiana KLCC Hotel', 'Impiana KLCC Hotel, 13, Jalan Pinang, Kuala Lumpur', 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` varchar(225) NOT NULL,
  `username` varchar(255) NOT NULL,
  `userFname` varchar(255) NOT NULL,
  `userEmail` varchar(255) NOT NULL,
  `userPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `userFname`, `userEmail`, `userPassword`) VALUES
('69e6a1311ecaca54', 'Usamah', 'Mohamad Usamah Thani Che Arif', 'mohamadusamahthani@gmail.com', '$2y$10$aeNKSm.bQF4rjQppUHGMW.BLqFGAHxhHCkMLspy4cIVcznYH0pE3O');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `cart_attractions`
--
ALTER TABLE `cart_attractions`
  ADD PRIMARY KEY (`attID`),
  ADD KEY `cartID` (`cartID`);

--
-- Indexes for table `cart_hotel`
--
ALTER TABLE `cart_hotel`
  ADD PRIMARY KEY (`hotelID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
