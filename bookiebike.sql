-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2024 at 05:26 AM
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
-- Database: `bookiebike`
--

-- --------------------------------------------------------

--
-- Table structure for table `bikes`
--

CREATE TABLE `bikes` (
  `bike_id` int(11) NOT NULL,
  `bike_location` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `is_available` enum('Yes','No') NOT NULL,
  `bike_detail` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bikes`
--

INSERT INTO `bikes` (`bike_id`, `bike_location`, `image_url`, `is_available`, `bike_detail`) VALUES
(6, 'Inasis MAS', 'image_1.jpg', 'Yes', 'Good condition'),
(7, 'Pejabat Inasis TM', 'image_2.jpg', 'Yes', 'All black\r\nIn good condition'),
(8, 'Pejabat Inasis Bank SME', 'image_3.jpg', 'Yes', 'Light blue tube\r\nBlack Seat'),
(9, 'Vmall', 'image_4.jpg', 'Yes', 'Brown Tyres\r\nAll black tube\r\nGood condition'),
(10, 'Pejabat Inasis Bank Rakyat', 'image_5.jpg', 'Yes', 'LECTRIC\r\nTwo seats'),
(11, 'Pejabat Inasis MISC & BSN', 'image_6.jpg', 'Yes', 'Basket provided\r\nGood condition'),
(12, 'Inasis MAS', '', 'Yes', 'Great Cycle 2600 Blue tube'),
(13, 'UPC Kachi', 'image_8.jpg', 'Yes', 'Jazz Ashoka\r\nOrange'),
(14, 'Tempat Letak Kereta Inasis TM', 'image_9.jpg', 'Yes', 'Hercules bike\r\nBlack and Yellow'),
(16, 'Kafe Inasis YAB & Muamalat', 'image_4.jpg', 'No', 'Bad condition, need to fix it'),
(17, 'Uinn', 'image_11.jpg', 'Yes', 'Basket provided, Two Seats, QCShuang');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `matric_number` int(6) DEFAULT NULL,
  `bike_id` int(11) DEFAULT NULL,
  `booking_time` datetime NOT NULL,
  `bike_location` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `matric_number`, `bike_id`, `booking_time`, `bike_location`) VALUES
(13, 289785, 11, '2024-01-18 10:00:00', 'Inasis MAS'),
(14, 289785, 6, '2024-01-18 08:30:00', 'Kafe Inasis Petronas'),
(17, 276818, 12, '2024-01-11 18:00:00', 'Inasis MAS'),
(19, 276818, 6, '2024-01-18 12:00:00', 'Kafe Inasis Petronas'),
(40, 289785, 6, '2024-03-12 17:47:00', 'Inasis MAS');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `matric_number` int(6) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contact_number` int(12) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `user_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`matric_number`, `username`, `password`, `contact_number`, `name`, `user_type`) VALUES
(130123, 'admin', '$2y$10$nCzcZOAUM.jY8khj4RgF4.65MbdO6mF4IDj0M9oFwSPIXQBYt6IBm', 123456789, 'Koh Qian Wen', 'admin'),
(276818, 'atik', '$2y$10$v.wn94XCDb7DsF4Xk8XMCeA7QhrJEGPHDTWYA4/Kfq7rxrsAODiJ.', 194190391, 'atikah kamal', 'user'),
(279838, 'student', '$2y$10$SwZgSjlLeVvJoFPGLuuwG.ZDyXv1r42YC6jAa035Aot.5DdGbqgAa', 123456000, 'atikah kamal', 'user'),
(289785, 'wxwx', '$2y$10$EV2biyEnRZ10ThBXNmVqB.xOmdZTSetrKMdka2L/EzyogYYduQiV2', 123456780, 'Kohqw', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bikes`
--
ALTER TABLE `bikes`
  ADD PRIMARY KEY (`bike_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `bike_id` (`bike_id`),
  ADD KEY `matric_number_2` (`matric_number`) USING BTREE,
  ADD KEY `matric_number` (`matric_number`,`bike_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`matric_number`),
  ADD UNIQUE KEY `contact_number` (`contact_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bikes`
--
ALTER TABLE `bikes`
  MODIFY `bike_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`matric_number`) REFERENCES `users` (`matric_number`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`bike_id`) REFERENCES `bikes` (`bike_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
