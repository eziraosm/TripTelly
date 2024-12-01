-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 01, 2024 at 06:43 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adminName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adminFname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adminEmail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `adminPassword` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminName`, `adminFname`, `adminEmail`, `adminPassword`) VALUES
('187f865e92c96233', 'Erfa', 'Epa', 'erfa@gmail.com', '$2y$10$JeaHwp4rpKyE71gTjKWGSOCaMQsMRjWILjFUyTC2PCaB3jCtS4LyC'),
('524c84117063255f', 'Tiger Bray', 'Carol Huber', 'xonyfakaja@mailinator.com', '$2y$10$kSNjZolbgIUEUeO5lgEp5uPY7nwmnZPDzGkgRi.lcXUM346xpn/P6'),
('6a6400c0f678e99e', 'Ian Key', 'Yael Cooke', 'lemoba@mailinator.com', '$2y$10$0W7aql/I3iQLeQWpsISOe.UKK64cUVO3gv0hH.7ChRMqEU3H/mtOG'),
('6a7e4e764408f52f', 'Sam', 'Usamah', 'usamahsamah@gmail.com', '$2y$10$2G7pE40XTea/awPyeY5ztOKL6/EDrg8qaX0eyKWhkxwN5kEXHG8Yq'),
('877ca852fbbab4dc', 'Alea Webb', 'Callum Acosta', 'wovyd@mailinator.com', '$2y$10$FJdVBGBWFyy.y3G3jPOHFe.Ofsd3eFvoWhdcfwulm7Vld1gLleC36'),
('a8b69264b4fdb5cc', 'Ina Aguirre', 'Mannix Larsen', 'zesosybeb@mailinator.com', '$2y$10$eVwKhC3.51DVPmS4wHBLSO792PDsBfj1h.KOu0fNVNpvdCI7BNGEO'),
('a9e1da2425ad4d46', 'Lacota Hyde', 'Rae Mann', 'xigicice@mailinator.com', '$2y$10$qOk2bMRHtcZXj7pvsNRrTuJs.458h3sseweGmRgQI9q.i3og7HbTq'),
('c5bcd6582ba55069', 'Quynn Sykes', 'Jessamine Ellison', 'pycu@mailinator.com', '$2y$10$zz0ZzP2FYMF5kmy2aFTbt.sLnLty5tvvTQrFpKtSwSJceBRo.xNXS'),
('e1dbace618f25c7a', 'Malik Barrera', 'Ishmael Bates', 'puly@mailinator.com', '$2y$10$dca1ev65eBBzGBM9sawrgebXN0lgUsx6Tr1eBkeAuBXFVO06D6Zfi');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `userID` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `fromLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `destinationLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `departureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `member` int NOT NULL,
  `max_budget` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `fromLocation`, `destinationLocation`, `departureDate`, `returnDate`, `member`, `max_budget`) VALUES
('WMFLz0ZGQmx', '69e6a1311ecaca54', 'kedah', 'perak', '2024-11-21', '2024-11-23', 1, '500.00');

-- --------------------------------------------------------

--
-- Table structure for table `cart_attractions`
--

CREATE TABLE `cart_attractions` (
  `cartAttID` int NOT NULL,
  `cartID` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `attID` varchar(225) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'google places id',
  `attName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `attLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `attPrice` decimal(10,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_attractions`
--

INSERT INTO `cart_attractions` (`cartAttID`, `cartID`, `attID`, `attName`, `attLocation`, `attPrice`) VALUES
(23, 'WMFLz0ZGQmx', 'ChIJmxnqQILoyjERHBAJ7MAr7j8', 'Rumah Kediaman Almarhum Sultan Azlan Shah', 'No.37, Jalan Aman, Batu Gajah', '42.00'),
(24, 'WMFLz0ZGQmx', 'ChIJCyLxs5G8yjER8gxIqIg2N7k', 'Bandar Diraja Kuala Kangsar Monumen, ( Kuala Kangsar, Perak )', '156, Jalan Taiping, Kampung Talang Masjid, Kuala Kangsar', '153.00'),
(25, 'WMFLz0ZGQmx', 'ChIJ4arAFpWvyjERw67wE4yoCYk', 'Laman Budaya Taiping', '105, Jalan Ong Saik, Taiping', '84.00');

-- --------------------------------------------------------

--
-- Table structure for table `cart_hotel`
--

CREATE TABLE `cart_hotel` (
  `cartHotelID` int NOT NULL,
  `cartID` varchar(11) COLLATE utf8mb4_general_ci NOT NULL,
  `hotelID` varchar(255) COLLATE utf8mb4_general_ci NOT NULL COMMENT 'google places ID',
  `hotelName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hotelLocation` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `hotelPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_hotel`
--

INSERT INTO `cart_hotel` (`cartHotelID`, `cartID`, `hotelID`, `hotelName`, `hotelLocation`, `hotelPrice`) VALUES
(12, 'WMFLz0ZGQmx', 'ChIJyRwDyliuyjERc3IxrjHs5KM', 'Legend Inn hotel', '2, Jalan Long Jaafar, Taiping', '115.00');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int NOT NULL,
  `cartID` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `userID` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `hotelData` json DEFAULT NULL,
  `placeData` json DEFAULT NULL,
  `totalPrice` double(10,2) DEFAULT NULL,
  `fromLocation` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `destinationLocation` varchar(225) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `departureDate` date DEFAULT NULL,
  `returnDate` date DEFAULT NULL,
  `person` decimal(10,0) DEFAULT NULL,
  `max_budget` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`paymentID`, `cartID`, `userID`, `hotelData`, `placeData`, `totalPrice`, `fromLocation`, `destinationLocation`, `departureDate`, `returnDate`, `person`, `max_budget`) VALUES
(12, '3-KVVoxCo81', '69e6a1311ecaca54', '{\"cartID\": \"3-KVVoxCo81\", \"hotelID\": \"ChIJJ2V7SClPzDER779w0YaYOXU\", \"hotelName\": \"Royale Chulan Damansara\", \"hotelPrice\": \"103.00\", \"cartHotelID\": 19, \"hotelLocation\": \"2A, Jalan PJU 7/3, Mutiara Damansara, Petaling Jaya\"}', '[{\"attID\": \"ChIJvy1SAMZPzDERS6HN5ms9Xwo\", \"cartID\": \"3-KVVoxCo81\", \"attName\": \"Shawnalyzer Studio\", \"attPrice\": \"61.00\", \"cartAttID\": 56, \"attLocation\": \"15, Jalan Zuhrah U5/151, Taman Subang Murni, Shah Alam\"}, {\"attID\": \"ChIJJSAtCNNJzDERETbGF9iz7CI\", \"cartID\": \"3-KVVoxCo81\", \"attName\": \"Muzium Telekom\", \"attPrice\": \"79.00\", \"cartAttID\": 57, \"attLocation\": \"Jalan Raja Chulan, Kuala Lumpur\"}, {\"attID\": \"ChIJx2_KuMZJzDERboiFiS2RDyU\", \"cartID\": \"3-KVVoxCo81\", \"attName\": \"Muzium Etnologi Dunia Melayu\", \"attPrice\": \"79.00\", \"cartAttID\": 58, \"attLocation\": \"Jalan Damansara, Kuala Lumpur\"}, {\"attID\": \"ChIJwZUFgFs2zDERvM72M2ukZ1U\", \"cartID\": \"3-KVVoxCo81\", \"attName\": \"Art House Gallery Museum of Ethnic Arts\", \"attPrice\": \"78.00\", \"cartAttID\": 59, \"attLocation\": \"Lot 3.04 & 3.05, Level 2, Annexe Building, Central Market, 10,, Jalan Hang Kasturi, Kuala Lumpur\"}, {\"attID\": \"ChIJLTz0ccxJzDER0lOupg5YSmc\", \"cartID\": \"3-KVVoxCo81\", \"attName\": \"Galeri Ketua Polis Negara\", \"attPrice\": \"59.00\", \"cartAttID\": 61, \"attLocation\": \"Jalan Bukit Aman, Tasik Perdana, Kuala Lumpur\"}, {\"attID\": \"ChIJn7ct6mxIzDERAfOvaaTX5DM\", \"cartID\": \"3-KVVoxCo81\", \"attName\": \"National Art Gallery\", \"attPrice\": \"48.00\", \"cartAttID\": 62, \"attLocation\": \"Lembaga Pembangunan Seni Visual Negara, 2, Jalan Temerloh, off, Jalan Tun Razak, Kuala Lumpur\"}]', 507.00, 'kelantan', 'kuala lumpur', '2024-11-29', '2024-12-02', '1', '605.00'),
(13, 'l5JPqy3rJ9j', '69e6a1311ecaca54', '{\"cartID\": \"l5JPqy3rJ9j\", \"hotelID\": \"ChIJ7Z19qqnyyjERjI16PdKY99M\", \"hotelName\": \"Sunway Lost World Hotel\", \"hotelPrice\": \"125.00\", \"cartHotelID\": 11, \"hotelLocation\": \"1, Persiaran Lagun Sunway, Sunway City, Ipoh\"}', '[{\"attID\": \"ChIJ7ZsMJ4atyjERivUghzb_TYE\", \"cartID\": \"l5JPqy3rJ9j\", \"attName\": \"Matang Museum\", \"attPrice\": \"92.00\", \"cartAttID\": 18, \"attLocation\": \"Kampung Pekan Matang, Matang\"}, {\"attID\": \"ChIJyTplPviuyjERVvnvFM5JNp4\", \"cartID\": \"l5JPqy3rJ9j\", \"attName\": \"5D Art Paradise Taiping\", \"attPrice\": \"58.00\", \"cartAttID\": 19, \"attLocation\": \"25, Jalan Maharajalela, Taiping\"}, {\"attID\": \"ChIJRXTNZwi9yjERv6RpqHfW_SQ\", \"cartID\": \"l5JPqy3rJ9j\", \"attName\": \"Galeri Sultan Azlan Shah\", \"attPrice\": \"111.00\", \"cartAttID\": 20, \"attLocation\": \"Jalan Istana, Bukit Chandan, Kuala Kangsar\"}, {\"attID\": \"ChIJgaROuH3syjERv8PsY2-k-go\", \"cartID\": \"l5JPqy3rJ9j\", \"attName\": \"22 Hale Street Heritage Gallery\", \"attPrice\": \"147.00\", \"cartAttID\": 21, \"attLocation\": \"22, Jalan Tun Sambanthan, Ipoh\"}, {\"attID\": \"ChIJWyheJuNntTERMmFrMJWf5xU\", \"cartID\": \"l5JPqy3rJ9j\", \"attName\": \"Lenggong Archaeological Museum\", \"attPrice\": \"34.00\", \"cartAttID\": 22, \"attLocation\": \"Jabatan Warisan Negara Zon Tengah, Kota Tampan, Lenggong\"}]', 567.00, 'kedah', 'perak', '2024-11-21', '2024-11-23', '1', '500.00');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` varchar(225) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userFname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userEmail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `userPassword` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `username`, `userFname`, `userEmail`, `userPassword`) VALUES
('292d32c9dacb6f07', 'bixetujijo', 'Alexa Bass', 'lamyqego@mailinator.com', '$2y$10$91BSFS.V4a1AcyVe5.SLPuBtRo/e883gC4q7gjunFg4K8miRz/OEu'),
('3d143f5194b6292a', 'xuhigupor', 'Tatyana Meadows', 'lixuv@mailinator.com', '$2y$10$n.UgyBKZLqmog2KYHXfiGegr9llMunc5LO3FPAVPZPDll9rs.LLTu'),
('5af4645a36c1777a', 'focusot', 'Wylie Villarreal', 'vuvelar@mailinator.com', '$2y$10$rgDEptOne5Kzs7z3sikDseuN9aKykIFGWShsPMJKAD5OJKNt8Z3/O'),
('606a031bcf9b9189', 'zyfese', 'Kimberley David', 'qixyqa@mailinator.com', '$2y$10$p.pyV11u48Zo8Rb.7c6utOYibN./qLcDP0SErTImtCCfXGKaAX2Fq'),
('6083ef8352251f8e', 'gyzezox', 'Macaulay Richard', 'xuwilu@mailinator.com', '$2y$10$emBgYmeXrIf48WI8.GmtmunNYxbVpqcFJwjFqCK4aWIHJEm62Iffu'),
('632ba882362fd70a', 'vimep', 'Vance Lopez', 'wedip@mailinator.com', '$2y$10$whP2RfF/mzgmTVLdB9Hx6uwzykfnnnunwPnxydR3AT1fMY21kwby2'),
('69e6a1311ecaca54', 'Usamah', 'Mohamad Usamah Thani Che Arif', 'mohamadusamahthani@gmail.com', '$2y$10$aeNKSm.bQF4rjQppUHGMW.BLqFGAHxhHCkMLspy4cIVcznYH0pE3O'),
('6c0f1834877c342c', 'bometewe', 'Caleb Rowland', 'bevowo@mailinator.com', '$2y$10$xzTY9zoBjr3SLlGcSyHZrOdEyoj9x5udtJMFJ8TX4sm0evpP5ulOi'),
('8c515ad5bc828c08', 'Sam', 'UsamahThani', 'usamah@gmail.com', '$2y$10$JJudpbh3gtNiL0tcBKI5D.HMzndUW1e7PltoK/J8vjB3.VfUlFfmS'),
('b419549b1ea2e9e0', 'vyqureqa', 'Camille Morgan', 'xycidaheh@mailinator.com', '$2y$10$xPkZMbUdHwetXD7rglJ8jOehbWdJGEDfr6sZV84.7LTQ0UaiErKue'),
('cf8170e907a85071', 'Erfa', 'Erfa Customer', 'erfa@gmail.com', '$2y$10$Hwx/7FnI/1V9/9ZFzLZdaO4aPaf7Ap8imjKiU5Lxdt/ybxYtDpDza'),
('f103f3b68ee23036', 'qubovyr', 'Hector Ross', 'bevek@mailinator.com', '$2y$10$A5woI/fo6.ox61HWnTI2ru9O2hVhtDgy3sprO8sRJrqJdxD4Mo8JS');

-- --------------------------------------------------------

--
-- Table structure for table `user_engagement`
--

CREATE TABLE `user_engagement` (
  `id` int NOT NULL,
  `event_type` enum('visit','login') NOT NULL,
  `userId` varchar(255) DEFAULT NULL,
  `event_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_engagement`
--

INSERT INTO `user_engagement` (`id`, `event_type`, `userId`, `event_time`) VALUES
(1, 'visit', NULL, '2024-11-30 13:55:18'),
(2, 'login', '69e6a1311ecaca54', '2024-11-30 13:58:06'),
(3, 'visit', NULL, '2024-11-30 14:08:43'),
(4, 'login', '69e6a1311ecaca54', '2024-11-30 14:08:49'),
(5, 'visit', NULL, '2024-11-30 14:11:36'),
(6, 'login', '69e6a1311ecaca54', '2024-11-30 14:11:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

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
  ADD PRIMARY KEY (`cartAttID`) USING BTREE,
  ADD KEY `cartID` (`cartID`);

--
-- Indexes for table `cart_hotel`
--
ALTER TABLE `cart_hotel`
  ADD PRIMARY KEY (`cartHotelID`) USING BTREE,
  ADD KEY `cartID` (`cartID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- Indexes for table `user_engagement`
--
ALTER TABLE `user_engagement`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_attractions`
--
ALTER TABLE `cart_attractions`
  MODIFY `cartAttID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `cart_hotel`
--
ALTER TABLE `cart_hotel`
  MODIFY `cartHotelID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `user_engagement`
--
ALTER TABLE `user_engagement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
