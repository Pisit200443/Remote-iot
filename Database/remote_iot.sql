-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2024 at 11:37 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `remote_iot`
--

-- --------------------------------------------------------

--
-- Table structure for table `device`
--

CREATE TABLE `device` (
  `device_id` int(11) NOT NULL,
  `device_name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `installation_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `device`
--

INSERT INTO `device` (`device_id`, `device_name`, `location`, `description`, `installation_date`, `user_id`) VALUES
(7, 'HightSolutionDemo', 'HightSolution', '', '2024-02-13 05:18:04', 15),
(17, 'TheFinality', 'Salaya', '', '2024-02-21 03:13:01', 15),
(20, 'ProjectTest', 'HightSolution', '', '2024-02-21 03:12:12', 15),
(22, 'TestSystem', 'Salaya', '', '2024-02-15 02:33:31', 15);

-- --------------------------------------------------------

--
-- Table structure for table `real_time`
--

CREATE TABLE `real_time` (
  `value_id` int(11) NOT NULL,
  `value` varchar(255) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `real_time`
--

INSERT INTO `real_time` (`value_id`, `value`, `create_at`, `status`, `device_id`) VALUES
(1, 'power', '2024-03-04 02:31:28', '0', 7);

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `sd_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `value` varchar(255) NOT NULL,
  `status` enum('1','0') NOT NULL DEFAULT '1',
  `device_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`sd_id`, `date_time`, `value`, `status`, `device_id`) VALUES
(1, '2023-12-27 11:00:00', 'power', '0', 7),
(3, '2023-12-27 15:31:00', 'power', '0', 7),
(4, '2023-12-27 05:05:00', 'power', '0', 7),
(5, '2023-12-27 04:06:00', 'power', '0', 7),
(26, '2023-12-01 12:12:00', 'home', '0', 7),
(27, '2023-12-01 21:00:00', 'power', '0', 7),
(28, '2023-12-01 21:00:00', 'home', '0', 7),
(29, '2023-12-01 21:00:00', 'power', '0', 7),
(30, '2023-12-01 21:00:00', 'power', '0', 7),
(31, '2023-12-01 21:00:00', 'power', '0', 7),
(32, '2024-01-01 21:00:00', 'power', '0', 7),
(33, '2024-01-01 20:08:00', 'power', '0', 7),
(34, '2024-01-01 13:01:00', 'power', '0', 7),
(35, '2024-01-01 05:30:00', 'home', '0', 7),
(36, '2024-01-14 01:43:00', 'home', '0', 7),
(37, '2024-01-02 18:53:00', 'power', '0', 7),
(38, '2024-01-14 18:54:00', 'power', '0', 7),
(40, '2024-01-10 01:00:00', 'power', '0', 7),
(41, '2024-01-10 13:00:00', 'power', '0', 7),
(42, '2024-01-10 13:10:00', 'power', '0', 7),
(43, '2024-01-10 21:26:00', 'power', '0', 7),
(45, '2024-01-11 23:55:00', 'power', '0', 7),
(46, '2024-01-11 13:20:00', 'power', '0', 7),
(48, '2024-01-11 16:20:00', 'power', '0', 7),
(50, '2024-01-12 16:20:00', 'power', '0', 7),
(51, '2024-01-15 22:50:00', 'power', '0', 7),
(65, '2024-01-16 17:37:00', 'power', '0', 7),
(66, '2024-01-17 09:26:00', 'home', '0', 7),
(67, '2024-01-17 09:36:00', 'home', '0', 7),
(68, '2024-01-17 10:09:00', 'power', '0', 7),
(69, '2024-01-17 10:25:00', 'power', '0', 7),
(70, '2024-01-17 11:05:00', 'home', '0', 7),
(71, '2024-01-19 14:10:00', 'power', '0', 7),
(72, '2024-01-19 17:27:00', 'power', '0', 7),
(73, '2024-01-20 17:35:00', 'power', '0', 7),
(74, '2024-01-20 17:37:00', 'home', '0', 7),
(75, '2024-01-20 18:00:00', 'power', '0', 7),
(76, '2024-01-20 22:20:00', 'power', '0', 7),
(77, '2024-01-20 20:22:00', 'home', '0', 7),
(78, '2024-01-23 08:30:00', 'power', '0', 7),
(79, '2024-01-22 09:00:00', 'power', '0', 7),
(80, '2024-01-22 10:50:00', 'power', '0', 7),
(81, '2024-01-22 11:15:00', 'power', '0', 7),
(82, '2024-01-22 11:25:00', 'power', '0', 7),
(83, '2024-01-30 17:39:00', 'power', '0', 7),
(84, '2024-02-27 18:00:00', 'power', '0', 7);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `phone_number` varchar(12) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `firstname`, `lastname`, `username`, `password`, `status`, `phone_number`, `create_at`) VALUES
(5, 'pisit', 'suwichai', 'pisit.200443', '$2y$10$q2d/9UnRRHqO6JY8s2WIz.GuWPJRW5TrC6X/sZuWggUCOBl4yRmYC', 'admin', '0859903171', '2024-02-21 04:21:51'),
(15, 'Mongkon', 'SkinDog', 'SkinDog1234', '$2y$10$t4hdHyRuiugIQDfVJNbSRu1zS0fp6r/Hlg/i/e..fwjO6K/dzudXO', 'user', '081-234-5678', '2024-02-12 06:44:11'),
(16, 'Pisit', 'Suwichai', 'pisit.1234', '$2y$10$FsZ21JayIfZOgZsTIXfrM.XM.vvmL9Pc1bHOwyp/2xDdUus7u2vM2', 'user', '062-865-6486', '2024-02-14 03:32:20'),
(17, 'Nongchay', 'NongNong', 'Nongchay', '$2y$10$sdeUg1PBGEbJpDVnqCK1Ru48cdSwLRMx6mYEjPKd6MQTWG5VhvtyS', 'user', '062-865-6487', '2024-02-15 03:01:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`device_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `real_time`
--
ALTER TABLE `real_time`
  ADD PRIMARY KEY (`value_id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`sd_id`),
  ADD KEY `device_id` (`device_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `device`
--
ALTER TABLE `device`
  MODIFY `device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `real_time`
--
ALTER TABLE `real_time`
  MODIFY `value_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `sd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `device_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `real_time`
--
ALTER TABLE `real_time`
  ADD CONSTRAINT `real_time_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `device` (`device_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`device_id`) REFERENCES `device` (`device_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
