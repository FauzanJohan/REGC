-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 20, 2024 at 04:29 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `realestate`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `AdminID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`AdminID`, `FirstName`, `LastName`, `Email`, `Phone`, `password`) VALUES
(1, 'Amri', 'Farhan', 'amrifarhan@gmail.com', '0125968237', '123'),
(2, 'Ammar', 'Nazhan', 'amnazhan@gmail.com', '0135739203', '123');

-- --------------------------------------------------------

--
-- Table structure for table `consultations`
--

CREATE TABLE `consultations` (
  `ConsultationID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `PropertyID` int(11) DEFAULT NULL,
  `ConsultationDate` date DEFAULT NULL,
  `Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `consultations`
--

INSERT INTO `consultations` (`ConsultationID`, `UserID`, `AdminID`, `PropertyID`, `ConsultationDate`, `Notes`) VALUES
(1, 2, 2, 4, '2024-02-27', 'About Fauzan house '),
(11, 1, 2, 5, '2024-01-29', 'Rumah Afiq'),
(13, 2, 2, 5, '2024-05-29', 'Rumah cantik'),
(14, 3, 2, 4, '2024-01-14', 'About rumah besar');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `PropertyID` int(11) NOT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `City` varchar(50) DEFAULT NULL,
  `State` varchar(50) DEFAULT NULL,
  `ZipCode` varchar(10) DEFAULT NULL,
  `PropertyType` varchar(50) DEFAULT NULL,
  `Bedrooms` int(11) DEFAULT NULL,
  `Bathrooms` int(11) DEFAULT NULL,
  `Price` decimal(18,2) DEFAULT NULL,
  `AdminID` int(11) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`PropertyID`, `Address`, `City`, `State`, `ZipCode`, `PropertyType`, `Bedrooms`, `Bathrooms`, `Price`, `AdminID`, `UserID`) VALUES
(4, 'No. 2, 1, Persiaran Tropicana Aman, Bandar Tropicana Aman, Telok Panglima Garang,', 'Kuala Lumpur', 'Selangor', '42425', 'Teres', 4, 5, 2500000.00, 1, NULL),
(5, '30, Jalan Putra Heights 7, Kampung Guar Nangka', 'Kuala Perlis', 'Perlis', '05200', 'Teres', 3, 2, 550000.00, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Phone` varchar(20) DEFAULT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `FirstName`, `LastName`, `Email`, `Phone`, `password`) VALUES
(1, 'Amira', 'Fariha', 'amira@gmail.com', '0129384765', '123'),
(2, 'Iffa', 'Raziah', 'iffaraziah@gmail.com', '0192873849', '123'),
(3, 'Afiq', 'Pojan', 'afiq@gmail.com', '0197634257', 'afiq123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `consultations`
--
ALTER TABLE `consultations`
  ADD PRIMARY KEY (`ConsultationID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `fk_consultations_properties` (`PropertyID`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`PropertyID`),
  ADD KEY `AdminID` (`AdminID`),
  ADD KEY `fk_user` (`UserID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `consultations`
--
ALTER TABLE `consultations`
  MODIFY `ConsultationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `PropertyID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `consultations`
--
ALTER TABLE `consultations`
  ADD CONSTRAINT `consultations_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `consultations_ibfk_3` FOREIGN KEY (`AdminID`) REFERENCES `admins` (`AdminID`),
  ADD CONSTRAINT `fk_consultations_properties` FOREIGN KEY (`PropertyID`) REFERENCES `properties` (`PropertyID`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`UserID`) REFERENCES `users` (`UserID`),
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`AdminID`) REFERENCES `admins` (`AdminID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
