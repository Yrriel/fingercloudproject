-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 14, 2024 at 03:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projectfingerprint`
--
CREATE DATABASE IF NOT EXISTS `projectfingerprint` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `projectfingerprint`;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `optionesp32` varchar(250) NOT NULL,
  `id` int(11) NOT NULL,
  `fingerprint_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`optionesp32`, `id`, `fingerprint_id`) VALUES
('1', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tablelistauditlogs`
--

CREATE TABLE `tablelistauditlogs` (
  `UID` varchar(50) NOT NULL,
  `ESP32SerialNumber` varchar(250) NOT NULL,
  `DATE` datetime NOT NULL,
  `TYPE` varchar(250) NOT NULL,
  `DESCRIPTION` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tablelistfingerprintenrolled`
--

CREATE TABLE `tablelistfingerprintenrolled` (
  `UID` varchar(50) NOT NULL,
  `ESP32SerialNumber` varchar(50) NOT NULL,
  `indexFingerprint` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablelistfingerprintenrolled`
--

INSERT INTO `tablelistfingerprintenrolled` (`UID`, `ESP32SerialNumber`, `indexFingerprint`, `name`) VALUES
('0608', '0914', '1', 'TakkiYukki'),
('', 'SN-679D163B', '', ''),
('', 'SN-2B24615A', '', ''),
('', 'SN-0C1BBD25', '', ''),
('', 'SN-7CD40879', '', ''),
('', 'SN-46D1F354', '', ''),
('', 'SN-B75FDE1B', '', ''),
('', 'SN-D769BFA0', '', ''),
('', 'SN-9618A514', '', ''),
('', 'SN-F4B4C91E', '', ''),
('', 'SN-45C02252', '', ''),
('', 'SN-B57CB94E', '', ''),
('', 'SN-B288C4C0', '', ''),
('', 'SN-24A07ABA', '', ''),
('', 'SN-12078DFE', '', ''),
('', 'SN-56B7AE6E', '', ''),
('', 'SN-C3241568', '', ''),
('', 'SN-4B31CABE', '', ''),
('', 'SN-90B9F302', '', ''),
('', 'SN-6587AB39', '', ''),
('', 'SN-885B7762', '', ''),
('', 'SN-DDD3F4D8', '', ''),
('', 'SN-B98FAC00', '', ''),
('', 'SN-7132C8E3', '', ''),
('', 'SN-7132C8E3', '1', ''),
('', 'SN-7132C8E3', '1', ''),
('', 'SN-0260810D', '', ''),
('', 'SN-0260810D', '1', ''),
('SET', 'SN-6623DBB1', '', ''),
('[value-1]', '[value-2]', '[value-3]', ''),
('', 'SN-88E40973', '', ''),
('', 'SN-88E40973', '1', ''),
('[value-1]', '[value-2]', '[value-3]', ''),
('[value-1]', '[value-2]', '[value-3]', ''),
('[value-1]', '[value-2]', '[value-3]', ''),
('[value-1]', '[value-2]', '[value-3]', ''),
('SET', 'SN-88E40973', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tablelistowner`
--

CREATE TABLE `tablelistowner` (
  `UID` varchar(50) NOT NULL,
  `ESP32SerialNumber` varchar(50) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `loginattempts` int(3) NOT NULL DEFAULT 0,
  `suspendedtimeleft` datetime NOT NULL,
  `suspended_count` int(3) NOT NULL DEFAULT 0,
  `locked_account` varchar(5) NOT NULL DEFAULT 'FALSE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tablelistowner`
--

INSERT INTO `tablelistowner` (`UID`, `ESP32SerialNumber`, `email`, `password`, `firstName`, `lastName`, `loginattempts`, `suspendedtimeleft`, `suspended_count`, `locked_account`) VALUES
('0608', '0914', 'm70455067@gmail.com', '123123', 'Takii', 'Yukki', 0, '0000-00-00 00:00:00', 0, 'FALSE'),
('SN-7C2E35AA', '', 'xejoto1983@bawsny.com', '123123', '', '', 0, '0000-00-00 00:00:00', 0, 'FALSE'),
('SN-A287973F', '', '', '', '', '', 0, '0000-00-00 00:00:00', 0, 'FALSE'),
('not set', 'SN-88E40973', 'duck@duck.com', '123123123', '', '', 0, '0000-00-00 00:00:00', 0, 'FALSE');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
