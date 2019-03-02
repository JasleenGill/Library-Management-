-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 04, 2018 at 05:29 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `project2`
--

-- --------------------------------------------------------

--
-- Table structure for table `group`
--

CREATE TABLE `group` (
  `Group-Id` int(11) NOT NULL,
  `Size` int(11) NOT NULL,
  `GroupFormed` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(0, 'Admin', 'Admin', '', 'admin@travelplan.com', 1, NULL, 'admin'),
(1917, 'Jack', 'jack\'s Adress', '2018-12-13', 'jack@gmail.com', 3, NULL, ''),
(2784, 'Jack', 'jack\'s Adress', '2018-12-13', 'jack@gmail.com', 3, NULL, 'test'),
(3289, 'Humberto Luiz Rovina', 'R. Vergínio Flaiban', '2018-12-12', 'test@gmail.com', 1, NULL, ''),
(3374, 'Jone', 'jone\'s Adress', '2018-12-12', 'jone@yahoo.ca', 5, NULL, 'test'),
(4697, 'Jone', 'jone\'s Adress', '2018-12-12', 'jone@yahoo.ca', 5, NULL, 'test'),
(6245, 'Jack Daniels', 'jack\'s Adressd', '2018-12-05', 'test@gmail.com', 3, NULL, 'test'),
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
-- Indexes for table `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`Group-Id`);

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
-- AUTO_INCREMENT for table `group`
--
ALTER TABLE `group`
  MODIFY `Group-Id` int(11) NOT NULL AUTO_INCREMENT;

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
