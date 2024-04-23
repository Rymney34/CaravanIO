-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 20, 2024 at 01:07 AM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assignment`
--

-- --------------------------------------------------------

--
-- Table structure for table `listinginput`
--

CREATE TABLE `listinginput` (
  `id` int(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `price` bigint(20) NOT NULL,
  `description` varchar(200) NOT NULL,
  `contact` varchar(250) NOT NULL,
  `qty` int(250) NOT NULL,
  `location` varchar(250) NOT NULL,
  `image` blob NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `listinginput`
--

INSERT INTO `listinginput` (`id`, `title`, `price`, `description`, `contact`, `qty`, `location`, `image`, `user_id`) VALUES
(82, 'caravan', 100, 'Best for this price', '0786543435', 1, 'Cardiff', 0x6361726176616e332e6a706567, 30),
(83, 'caravan2', 1000, 'Best for the holidays', '078976546789', 9, 'London', 0x6361726176616e322e6a706567, 30),
(84, 'Meces', 50, 'In good condition!', '079876545789', 5, 'Newport', 0x4361726176616e312e6a706567, 30),
(87, 'VW', 40, 'Best for the couple', '0789656e457', 2, 'Cardiff', 0x6361726176616e332e6a706567, 30),
(86, 'Aidi', 99, 'Nice for big family', '076576890', 2, 'Cardiff', 0x315f6e76394b593659712d793065586c4f4c474f425870512e6a7067, 30),
(85, 'Pege', 67, 'Nice for long runs', '07896545789', 1, 'Cardiff', 0x3230383133393130352d63616d70696e672d6f6e2d6e61747572652d62656163682d6361726176616e2d72656372656174696f6e616c2d76656869636c652d61742d73756e726973652d6f6e2d6d65646974657272616e65616e2d636f6173742d696e2d737061696e2e6a7067, 30);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `listinginput`
--
ALTER TABLE `listinginput`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `EMAIL` (`email`),
  ADD UNIQUE KEY `USERNAME` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `listinginput`
--
ALTER TABLE `listinginput`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
