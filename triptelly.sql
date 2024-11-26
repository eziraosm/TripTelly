-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2024 at 03:48 PM
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
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` varchar(255) NOT NULL,
  `adminName` varchar(255) NOT NULL,
  `adminFname` varchar(255) NOT NULL,
  `adminEmail` varchar(255) NOT NULL,
  `adminPassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `adminName`, `adminFname`, `adminEmail`, `adminPassword`) VALUES
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
  `cartID` varchar(11) NOT NULL,
  `userID` varchar(225) NOT NULL,
  `fromLocation` varchar(255) NOT NULL,
  `destinationLocation` varchar(255) NOT NULL,
  `departureDate` date NOT NULL,
  `returnDate` date NOT NULL,
  `member` int(11) NOT NULL,
  `max_budget` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartID`, `userID`, `fromLocation`, `destinationLocation`, `departureDate`, `returnDate`, `member`, `max_budget`) VALUES
('l5JPqy3rJ9j', '69e6a1311ecaca54', 'kedah', 'perak', '2024-11-21', '2024-11-23', 1, 500.00);

-- --------------------------------------------------------

--
-- Table structure for table `cart_attractions`
--

CREATE TABLE `cart_attractions` (
  `cartAttID` int(11) NOT NULL,
  `cartID` varchar(11) NOT NULL,
  `attID` varchar(225) NOT NULL COMMENT 'google places id',
  `attName` varchar(255) NOT NULL,
  `attLocation` varchar(255) NOT NULL,
  `attPrice` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_attractions`
--

INSERT INTO `cart_attractions` (`cartAttID`, `cartID`, `attID`, `attName`, `attLocation`, `attPrice`) VALUES
(18, 'l5JPqy3rJ9j', 'ChIJ7ZsMJ4atyjERivUghzb_TYE', 'Matang Museum', 'Kampung Pekan Matang, Matang', 92.00),
(19, 'l5JPqy3rJ9j', 'ChIJyTplPviuyjERVvnvFM5JNp4', '5D Art Paradise Taiping', '25, Jalan Maharajalela, Taiping', 58.00),
(20, 'l5JPqy3rJ9j', 'ChIJRXTNZwi9yjERv6RpqHfW_SQ', 'Galeri Sultan Azlan Shah', 'Jalan Istana, Bukit Chandan, Kuala Kangsar', 111.00),
(21, 'l5JPqy3rJ9j', 'ChIJgaROuH3syjERv8PsY2-k-go', '22 Hale Street Heritage Gallery', '22, Jalan Tun Sambanthan, Ipoh', 147.00),
(22, 'l5JPqy3rJ9j', 'ChIJWyheJuNntTERMmFrMJWf5xU', 'Lenggong Archaeological Museum', 'Jabatan Warisan Negara Zon Tengah, Kota Tampan, Lenggong', 34.00);

-- --------------------------------------------------------

--
-- Table structure for table `cart_hotel`
--

CREATE TABLE `cart_hotel` (
  `cartHotelID` int(11) NOT NULL,
  `cartID` varchar(11) NOT NULL,
  `hotelID` varchar(255) NOT NULL COMMENT 'google places ID',
  `hotelName` varchar(255) NOT NULL,
  `hotelLocation` varchar(255) NOT NULL,
  `hotelPrice` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart_hotel`
--

INSERT INTO `cart_hotel` (`cartHotelID`, `cartID`, `hotelID`, `hotelName`, `hotelLocation`, `hotelPrice`) VALUES
(11, 'l5JPqy3rJ9j', 'ChIJ7Z19qqnyyjERjI16PdKY99M', 'Sunway Lost World Hotel', '1, Persiaran Lagun Sunway, Sunway City, Ipoh', 125.00);

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
('f103f3b68ee23036', 'qubovyr', 'Hector Ross', 'bevek@mailinator.com', '$2y$10$A5woI/fo6.ox61HWnTI2ru9O2hVhtDgy3sprO8sRJrqJdxD4Mo8JS');

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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userEmail` (`userEmail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_attractions`
--
ALTER TABLE `cart_attractions`
  MODIFY `cartAttID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `cart_hotel`
--
ALTER TABLE `cart_hotel`
  MODIFY `cartHotelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
