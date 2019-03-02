-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2018 at 06:40 AM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project-2`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_info`
--

CREATE TABLE `group_info` (
  `GroupId` int(11) NOT NULL,
  `PackageId` int(11) NOT NULL,
  `GroupSize` int(11) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_info`
--

INSERT INTO `group_info` (`GroupId`, `PackageId`, `GroupSize`, `Date`) VALUES
(1, 3, 1, '2018-12-06'),
(2, 1, 2, '2018-12-12'),
(3, 5, 1, '2018-12-12'),
(4, 3, 2, '2018-12-13'),
(5, 2, 2, '2018-12-25'),
(6, 1, 1, '2018-12-28'),
(7, 1, 2018, '0000-00-00'),
(8, 2, 2018, '0000-00-00'),
(9, 1, 2018, '0000-00-00'),
(10, 2, 2018, '0000-00-00'),
(11, 2, 2018, '0000-00-00'),
(12, 1, 2018, '0000-00-00'),
(13, 3, 1, '2018-12-06'),
(14, 1, 2, '2018-12-12'),
(15, 5, 1, '2018-12-12'),
(16, 3, 2, '2018-12-13'),
(17, 2, 2, '2018-12-25'),
(18, 1, 1, '2018-12-28');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `RegistrationId` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Address` varchar(30) NOT NULL,
  `Date` varchar(10) NOT NULL,
  `Email` varchar(20) NOT NULL,
  `PackageId` int(11) NOT NULL,
  `GroupId` int(11) DEFAULT NULL,
  `Password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`RegistrationId`, `Name`, `Address`, `Date`, `Email`, `PackageId`, `GroupId`, `Password`) VALUES
(1, 'Admin', 'Admin', '', 'admin@travelplan.com', 1, NULL, 'admin'),
(1917, 'Jack', 'jack\'s Adress', '2018-12-13', 'jack@gmail.com', 3, NULL, ''),
(2784, 'Jack', 'jack\'s Adress', '2018-12-13', 'jack@gmail.com', 3, NULL, 'test'),
(3289, 'Humberto Luiz Rovina', 'R. Vergínio Flaiban', '2018-12-12', 'test@gmail.com', 1, NULL, ''),
(3374, 'Jone', 'jone\'s Adress', '2018-12-12', 'jone@yahoo.ca', 5, NULL, 'test'),
(4697, 'Jack', 'abjckj', '2018-12-12', 'jone@yahoo.ca', 1, NULL, 'test'),
(6245, 'Jasleen', 'abjckj', '2018-12-28', '34@gmail.com', 1, 3, 'hjk'),
(6834, 'Jasleen', '34565fgyrhgfd', '2018-12-25', 'abc@gmail.com', 2, NULL, 'jas'),
(6937, 'Alex', 'gfkljg', '2018-12-25', '123jas@gmail.com', 2, NULL, 'test'),
(8548, 'maria', 'maria\'s address', '2018-12-06', 'test@gmail.com', 3, NULL, 'test');

-- --------------------------------------------------------

--
-- Table structure for table `vacationplan`
--

CREATE TABLE `vacationplan` (
  `PackageId` int(11) NOT NULL,
  `PackageName` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `vacationplan`
--

INSERT INTO `vacationplan` (`PackageId`, `PackageName`) VALUES
(1, 'Montreal'),
(2, 'Thousand Island'),
(3, 'Wonderland'),
(4, 'CN Tower'),
(5, 'Vancouver');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `group_info`
--
ALTER TABLE `group_info`
  ADD PRIMARY KEY (`GroupId`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`RegistrationId`),
  ADD UNIQUE KEY `RegistrationId` (`RegistrationId`),
  ADD KEY `packageid_fk` (`PackageId`);

--
-- Indexes for table `vacationplan`
--
ALTER TABLE `vacationplan`
  ADD PRIMARY KEY (`PackageId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_info`
--
ALTER TABLE `group_info`
  MODIFY `GroupId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `vacationplan`
--
ALTER TABLE `vacationplan`
  MODIFY `PackageId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `packageid_fk` FOREIGN KEY (`PackageId`) REFERENCES `vacationplan` (`PackageId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
