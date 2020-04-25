-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 24, 2020 at 06:02 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_deals`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `eventID` int(6) NOT NULL,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `location` varchar(500) NOT NULL,
  `userID` int(6) NOT NULL,
  `total_votes` int(6) NOT NULL, 
  `event_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`eventID`, `startTime`, `endTime`, `location`, `userID`, `total_votes`, `event_name`) VALUES
(200067, '10:00:00', '12:00:00', 'max\'s house', 300000, 0, "free pizza");

-- --------------------------------------------------------

--
-- Table structure for table `host`
--

CREATE TABLE `host` (
  `hostID` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `host`
--

INSERT INTO `host` (`hostID`, `name`, `email`) VALUES
(100000, 'Student Council', NULL),
(100001, 'Photography Club', 'photography@virginia.edu'),
(100002, 'Music Club', NULL),
(100003, 'Bodo\'s Bagels', 'bodos@gmail.com'),
(100004, 'Mellow Mushroom Pizza', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `one_time_event`
--

CREATE TABLE `one_time_event` (
  `eventID` int(6) NOT NULL,
  `exact_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `one_time_event`
--

INSERT INTO `one_time_event` (`eventID`, `exact_date`) VALUES
(200067, '2020-10-10');

-- --------------------------------------------------------

--
-- Table structure for table `organization`
--

CREATE TABLE `organization` (
  `hostID` int(6) NOT NULL,
  `description` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `organization`
--

INSERT INTO `organization` (`hostID`, `description`) VALUES
(100000, 'Led by John Doe, the student council president'),
(100001, ''),
(100002, 'Organized by Professor Smith');

-- --------------------------------------------------------

--
-- Table structure for table `recurring_event`
--

CREATE TABLE `recurring_event` (
  `eventID` int(6) NOT NULL,
  `timing` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recurring_event`
--

INSERT INTO `recurring_event` (`eventID`, `timing`) VALUES
(200005, 'daily'),
(200006, 'weekly'),
(200007, 'monthly'),
(200008, 'daily'),
(200009, 'weekly'),
(200012, 'weekly'),
(200063, 'weekly');

-- --------------------------------------------------------

--
-- Table structure for table `recurring_event_days_occurring`
--

CREATE TABLE `recurring_event_days_occurring` (
  `eventID` int(6) NOT NULL,
  `day` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `recurring_event_days_occurring`
--

INSERT INTO `recurring_event_days_occurring` (`eventID`, `day`) VALUES
(200006, 'Friday'),
(200006, 'Monday'),
(200006, 'Wednesday'),
(200007, 'Thursday'),
(200007, 'Tuesday'),
(200009, 'Friday'),
(200012, 'Tuesday'),
(200063, 'Monday');

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `userID` int(6) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`userID`, `name`, `password`) VALUES
(300000, 'Abby', 'password'),
(300001, 'Bob', '123thisismypassword'),
(300002, 'Claire', '12345:-)'),
(300003, 'Dan', 'Dan300003');

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `hostID` int(6) NOT NULL,
  `address_number` int(20) DEFAULT NULL,
  `address_street` varchar(50) DEFAULT NULL,
  `address_zipcode` int(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`hostID`, `address_number`, `address_street`, `address_zipcode`) VALUES
(100003, 1609, 'University Avenue', 22903),
(100004, 1321, 'W Main Street', 22903);

-- --------------------------------------------------------

--
-- Table structure for table `restaurant_city`
--

CREATE TABLE `restaurant_city` (
  `address_zipcode` int(5) NOT NULL,
  `address_city` varchar(50) NOT NULL,
  `address_state` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `restaurant_city`
--

INSERT INTO `restaurant_city` (`address_zipcode`, `address_city`, `address_state`) VALUES
(22903, 'Charlottesville', 'VA');

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `eventID` int(6) NOT NULL,
  `hostID` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`eventID`, `hostID`) VALUES
(200000, 100000),
(200001, 100000),
(200002, 100000),
(200003, 100001),
(200004, 100001),
(200005, 100001),
(200006, 100002),
(200007, 100002),
(200008, 100002),
(200009, 100002),
(200010, 100003),
(200011, 100004),
(200012, 100003);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE `votes` (
  `eventID` int(6) NOT NULL,
  `userID` int(6) NOT NULL,
  `upvote` tinyint(1) NOT NULL,
  `downvote` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`eventID`, `userID`, `upvote`, `downvote`) VALUES
(200000, 300001, 1, 0),
(200001, 300001, 1, 0),
(200001, 300002, 1, 0),
(200002, 300001, 1, 0),
(200002, 300002, 1, 0),
(200002, 300003, 1, 0),
(200003, 300000, 0, 1),
(200004, 300000, 0, 1),
(200004, 300002, 0, 1),
(200005, 300000, 0, 1),
(200005, 300002, 0, 1),
(200005, 300003, 0, 1),
(200009, 300000, 1, 0),
(200011, 300001, 1, 0),
(200012, 300001, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `host`
--
ALTER TABLE `host`
  ADD PRIMARY KEY (`hostID`);

--
-- Indexes for table `one_time_event`
--
ALTER TABLE `one_time_event`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `organization`
--
ALTER TABLE `organization`
  ADD PRIMARY KEY (`hostID`);

--
-- Indexes for table `recurring_event`
--
ALTER TABLE `recurring_event`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `recurring_event_days_occurring`
--
ALTER TABLE `recurring_event_days_occurring`
  ADD PRIMARY KEY (`eventID`,`day`);

--
-- Indexes for table `registered_user`
--
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`hostID`);

--
-- Indexes for table `restaurant_city`
--
ALTER TABLE `restaurant_city`
  ADD PRIMARY KEY (`address_zipcode`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`eventID`);

--
-- Indexes for table `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`eventID`,`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `eventID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200068;

--
-- AUTO_INCREMENT for table `host`
--
ALTER TABLE `host`
  MODIFY `hostID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100005;

--
-- AUTO_INCREMENT for table `registered_user`
--
ALTER TABLE `registered_user`
  MODIFY `userID` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300004;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
