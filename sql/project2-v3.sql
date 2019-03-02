-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 09, 2018 at 06:09 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `project2`
--

-- --------------------------------------------------------

--
-- Table structure for table `group_info`
--

CREATE TABLE `group_info` (
  `GroupId` int(11) NOT NULL,
  `PackageId` int(11) NOT NULL,
  `GroupSize` int(11) NOT NULL,
  `Date` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_info`
--

INSERT INTO `group_info` (`GroupId`, `PackageId`, `GroupSize`, `Date`) VALUES
(2041, 1, 2, '2018-12-12'),
(3164, 3, 1, '2018-12-06'),
(5256, 5, 1, '2018-12-12'),
(5966, 2, 3, '2018-12-25'),
(7062, 3, 2, '2018-12-13');

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
(1917, 'Mike', 'jack\'s Adress', '2018-12-13', 'mike@gmail.com', 3, 7062, 'test'),
(2784, 'Josh', 'jack\'s Adress', '2018-12-13', 'joshKK@gmail.com', 1, 7060, 'test'),
(3289, 'Humberto Luiz Rovina', 'R. Vergínio Flaiban', '2018-12-12', 'test@gmail.com', 1, 2041, 'test'),
(3374, 'Jone', 'jone\'s Adress', '2018-12-12', 'jone@yahoo.ca', 5, 5256, 'test'),
(4697, 'Jack', 'abjckj', '2018-12-12', 'jone@yahoo.ca', 1, 2041, 'test'),
(5931, 'Jackson', 'jackson\'s Adress', '2018-12-20', 'jackson@gmail.com', 4, NULL, 'test'),
(6245, 'Maria', 'abjckj', '2018-12-28', '34@gmail.com', 1, 3, 'hjk'),
(6834, 'Jasleen', '34565fgyrhgfd', '2018-12-25', 'abc@gmail.com', 2, 5966, 'jas'),
(6937, 'Alex', 'gfkljg', '2018-12-25', '123jas@gmail.com', 2, 5966, 'test'),
(7679, 'Michael', 'michael\'s house', '2019-01-17', 'michael@gmail.com', 4, NULL, 'test'),
(8473, 'Roberto', 'roberto\'s home', '2018-12-25', 'roberto@gmail.com', 2, 5966, 'test'),
(8548, 'Jason', 'maria\'s address', '2018-12-06', 'test@gmail.com', 3, 3164, 'test');

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
