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
  `eventID` int(6) NOT NULL AUTO_INCREMENT,
  `startTime` time DEFAULT NULL,
  `endTime` time DEFAULT NULL,
  `location` varchar(500) NOT NULL,
  `userID` int(6) NOT NULL,
  `total_votes` int(6) NOT NULL, 
  `event_name` varchar(500) NOT NULL,
  CONSTRAINT checkTime CHECK (`endTime` > `startTime`), 
  PRIMARY KEY (`eventID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--
INSERT INTO `event` (`eventID`, `startTime`, `endTime`, `location`, `userID`, `total_votes`, `event_name`) VALUES
(200000, '10:00:00', '14:00:00', "Newcomb", 300000, 1, "Free Meal"),
(200001, '09:30:00', '10:30:00', "Maury Hall", 300000, 2, "Free Ice Cream"),
(200002, '13:00:00', '16:00:00', "The Lawn", 300000, 3, "Snacks with Headshot Purchase"),
(200003, '12:30:00', '18:30:00', "Rotunda", 300001, -1, "Take a Pic, Get a Fish Stick"),
(200004, '11:00:00', '12:00:00', "Chemistry Building", 300001, -2, "Discounted Fries"),
(200005, '18:30:00', '21:30:00', "Old Cabell Hall", 300001, -9, "Tunes and Spoons: Free Soup!"),
(200006, '08:00:00', '10:00:00', "Nau", 300002, 0, "Fresh Beets"),
(200007, '12:00:00', '22:00:00', "Brought to you!", 300002, 0, "Free Delivery with a Large Pizza"),
(200008, '13:00:00', '14:00:00', "Gilmer Hall", 300002, 0, "Free Bagel"),
(200009, '10:30:00', '12:30:00', "Rice Hall", 300003, 1, "Cream Cheese Taste Testing"),
(200010, '10:30:00', '14:30:00', "Rice Hall", 300003, 1, "$2 Pizza Slices"),
(200011, '08:30:00', '11:30:00', "At Bodos", 300003, 1, "Get a Dozen for $2");
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
(100003, "Bodo's Bagels", 'bodos@gmail.com'),
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
(200000, '2020-07-10'),
(200001, '2020-06-05'),
(200003, '2020-12-15'),
(200004, '2020-05-02'),
(200006, '2020-08-17'),
(200008, '2020-05-27'),
(200010, '2020-06-09');

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
(200002, 'monthly'),
(200005, 'daily'),
(200007, 'daily'),
(200009, 'weekly'),
(200011, 'weekly');

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
(200002, 'Friday'),
(200002, 'Monday'),
(200002, 'Wednesday'),
(200009, 'Thursday'),
(200009, 'Tuesday'),
(200009, 'Friday'),
(200011, 'Tuesday'),
(200011, 'Monday');

-- --------------------------------------------------------

--
-- Table structure for table `registered_user`
--

CREATE TABLE `registered_user` (
  `userID` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `password` varchar(64) NOT NULL,
  PRIMARY KEY (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `registered_user`
--

INSERT INTO `registered_user` (`userID`, `name`, `password`) VALUES
(300000, 'Abby', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8'),
(300001, 'Bob', '3d8bb29caec77d2eaf1d357c63d77d989c0391c53215bb881742b13aff93cc7d'),
(300002, 'Claire', '11da47786653a4b96846b95bc67f74c260e904e40b8d5c03ea0648b6f99d9379'),
(300003, 'Dan', '0f78d023a91e09c0e598b5b4e03767c4b5db232e31fac8c6a9b1bf87a4afb0ce'),
(300004, 'Charlie', 'c2532f1a059c00e42ae966223024be933d2813a39b6820b78b74da84f9a4b96f'),
(300005, 'Alice', 'f3071140b8a7bfb8d94cd0d04d50b0056e7f727f0e295572331b0f50b03b640b'),
(300006, 'Samy', 'c66c2be7d968fd62e63874fc64179cc558e038a8314ddd735c45a91ff35913bd'),
(300007, 'Kylie', '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225'),
(300008, 'Josh', 'd74ff0ee8da3b9806b18c877dbf29bbde50b5bd8e4dad7a3a725000feb82e8f1'),
(300009, 'Lauren', '04995257f6d6379791e7754c0c358bda2bf7c0917fb3d60f4eebacfc8f2c9b8e'),
(300010, 'Admin', '3b612c75a7b5048a435fb6ec81e52ff92d6d795a8b5a9c17070f6a63c97a53b2');

-- Abby : password
-- Bob : 123thisismypassword
-- Claire : 12345:-)
-- Dan : Dan300003
-- Charlie : char 345
-- Alice : AisForAlice
-- Samy : SamIAm
-- Kylie : 123456789
-- Josh : pass
-- Lauren : thisissafe
-- Admin : Admin123

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
(200002, 100001),
(200003, 100001),
(200004, 100001),
(200005, 100002),
(200006, 100002),
(200007, 100004),
(200008, 100003),
(200009, 100003),
(200010, 100004),
(200011, 100003);

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
(200067, 300001, 1, 0),
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
(200012, 300001, 1, 0),
(200005, 300004, 0, 1),
(200005, 300005, 0, 1),
(200005, 300006, 0, 1),
(200005, 300007, 0, 1),
(200005, 300008, 0, 1),
(200005, 300009, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
/*
ALTER TABLE `event`
  ADD PRIMARY KEY (`eventID`);
  */

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
/*
ALTER TABLE `registered_user`
  ADD PRIMARY KEY (`userID`);
  */

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

-- Trigger

DELIMITER $$
CREATE TRIGGER voteTriggerInsert
AFTER INSERT ON votes 
FOR EACH ROW
  BEGIN
    DELETE FROM event WHERE total_votes <= -9;
  END
$$
DELIMITER ;

DELIMITER $$
CREATE TRIGGER voteTriggerUpdate
AFTER UPDATE ON votes 
FOR EACH ROW
  BEGIN
    DELETE FROM event WHERE total_votes <= -9;
  END
$$
DELIMITER ;

/*
DELIMITER $$
CREATE TRIGGER voteTriggerInsert
AFTER INSERT ON votes 
FOR EACH ROW
  BEGIN
    DELETE FROM one_time_event WHERE (SELECT eventID FROM event WHERE total_votes <= -10) = one_time_event.eventID;
    DELETE FROM recurring_event WHERE (SELECT eventID FROM event WHERE total_votes <= -10) = recurring_event.eventID;
    DELETE FROM recurring_event_days_occurring WHERE (SELECT eventID FROM event WHERE total_votes <= -10) = recurring_event_days_occurring.eventID;
    DELETE FROM votes WHERE (SELECT eventID FROM event WHERE total_votes <= -10)= votes.eventID;
    DELETE FROM sponsors WHERE (SELECT eventID FROM event WHERE total_votes <= -10)= sponsors.eventID;
    DELETE FROM event WHERE event.total_votes <= -10;
  END
$$
DELIMITER ;
*/