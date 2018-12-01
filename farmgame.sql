-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2018 at 08:34 PM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farmgame`
--

-- --------------------------------------------------------

--
-- Table structure for table `died_object`
--

CREATE TABLE `died_object` (
  `id` int(11) NOT NULL,
  `game_id` varchar(255) NOT NULL,
  `farm_object_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `farmobjects`
--

CREATE TABLE `farmobjects` (
  `id` int(11) NOT NULL,
  `head_name` varchar(255) NOT NULL,
  `type` enum('farmer','cow','bunny') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `farmobjects`
--

INSERT INTO `farmobjects` (`id`, `head_name`, `type`) VALUES
(1, 'Farmer', 'farmer'),
(2, 'Cow 1', 'cow'),
(3, 'Cow 2', 'cow'),
(4, 'Bunny 1', 'bunny'),
(5, 'Bunny 2', 'bunny'),
(6, 'Bunny 3', 'bunny'),
(7, 'Bunny 4', 'bunny');

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `id` int(11) NOT NULL,
  `farm_object_id` int(11) NOT NULL COMMENT 'farm objects id',
  `game_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `died_object`
--
ALTER TABLE `died_object`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `game_id` (`game_id`,`farm_object_id`),
  ADD KEY `fk_fo_do_id` (`farm_object_id`);

--
-- Indexes for table `farmobjects`
--
ALTER TABLE `farmobjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fo_id` (`farm_object_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `died_object`
--
ALTER TABLE `died_object`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `farmobjects`
--
ALTER TABLE `farmobjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `died_object`
--
ALTER TABLE `died_object`
  ADD CONSTRAINT `fk_fo_do_id` FOREIGN KEY (`farm_object_id`) REFERENCES `farmobjects` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `fk_fo_id` FOREIGN KEY (`farm_object_id`) REFERENCES `farmobjects` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
