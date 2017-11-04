-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2015 at 12:24 PM
-- Server version: 5.5.41-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `final`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id_place` int(10) NOT NULL,
  `text` varchar(255) NOT NULL,
  `rate` int(10) NOT NULL DEFAULT '0',
  `id_comment` int(10) NOT NULL AUTO_INCREMENT,
  `id_user` int(10) NOT NULL,
  PRIMARY KEY (`id_comment`),
  UNIQUE KEY `id_comment` (`id_comment`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id_place`, `text`, `rate`, `id_comment`, `id_user`) VALUES
(3, 'Connecticut Hall is the Oldest Building at Yale', 2, 1, 1),
(1, 'According to one Simpsons episode, Mr. Burns is a member of Skull and Bones', -2, 2, 1),
(2, 'Famous Davenport College alumni:\n-George W. Bush\n-George H. W. Bush\n-Stephen A. Schwarzman', 2, 3, 1),
(4, 'One of the 23 complete Gutenberg Bibles is located at Beinecke Library', 0, 4, 1),
(3, 'Nowadays, the Yale Philosophy Department is located in the Connecticut Hall', 1, 5, 2),
(5, 'Once I stayed 20 minutes waiting for a spoon in Calhoun Dining Hall', -2, 6, 2),
(2, 'While the York Street faÃ§ade is gothic, the remainder of the college has been built in the red-brick Georgian style of the colonial era.', 0, 7, 3);

-- --------------------------------------------------------

--
-- Table structure for table `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id_place` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `latitude` decimal(7,4) NOT NULL,
  `longitude` decimal(7,4) NOT NULL,
  `id_user` int(10) NOT NULL,
  `number_facts` int(5) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_place`),
  UNIQUE KEY `id_place` (`id_place`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id_place`, `title`, `latitude`, `longitude`, `id_user`, `number_facts`) VALUES
(1, 'Skull and Bones', 41.3085, -72.9303, 1, 1),
(2, 'Davenport College', 41.3102, -72.9308, 1, 2),
(3, 'Connecticut Hall', 41.3082, -72.9288, 1, 2),
(4, 'Beinecke Library', 41.3116, -72.9274, 1, 1),
(5, 'Calhoun College', 41.3100, -72.9272, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `initialLat` decimal(7,4) NOT NULL DEFAULT '41.3088',
  `initialLong` decimal(7,4) NOT NULL DEFAULT '-72.9287',
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `id_user` (`id_user`),
  UNIQUE KEY `username` (`username`,`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `email`, `first_name`, `last_name`, `hash`, `id_user`, `initialLat`, `initialLong`) VALUES
('enrico', 'enrico.loffel@yale.edu', 'Enrico', 'Loffel', '$2y$10$deJf0B7H1WXr16Xr1eUpfO73dEB9VuElSOi1L1ESc1/lGW77ICNsu', 1, 41.3088, -72.9287),
('kimjongun', 'gmail@kju.com.kp', 'Kim', 'Jong Un', '$2y$10$Jj/Q99xMCSPhmNM9Zbisiea/DweJX71tCm1iPyFOfCsZKaPU.WMMO', 2, 39.0445, 125.7532),
('rickastley', 'rickastley@gmail.com', 'Rick', 'Astley', '$2y$10$gGT8PVF03BKFP87y2qmodON4i249K4Z0nYBduNEDi5JqvCXmPU9nC', 3, 41.3088, -72.9287);

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

CREATE TABLE IF NOT EXISTS `votes` (
  `id_comment` int(10) NOT NULL,
  `id_user` int(10) NOT NULL,
  `vote` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id_comment`, `id_user`, `vote`) VALUES
(4, 2, -1),
(3, 2, 1),
(1, 2, 1),
(2, 2, -1),
(6, 1, -1),
(5, 1, 1),
(1, 3, 1),
(6, 3, -1),
(4, 3, 1),
(3, 3, 1),
(2, 3, -1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
