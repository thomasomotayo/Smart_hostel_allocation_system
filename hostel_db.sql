-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2026 at 04:02 PM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hostel_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`, `full_name`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'System Administrator');

-- --------------------------------------------------------

--
-- Table structure for table `allocations`
--

CREATE TABLE `allocations` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `allocation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `allocations`
--

INSERT INTO `allocations` (`id`, `student_id`, `room_id`, `allocation_date`, `status`) VALUES
(1, 1, 1, '2026-07-03 11:48:16', 'active'),
(2, 2, 1, '2026-07-03 13:15:10', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `token` varchar(64) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `student_id`, `token`, `expires_at`, `used`) VALUES
(1, 1, '5a99d8aa9c99928fe4179768fb662471f4c42f867641beef2d219740de8d6ccf', '2026-07-03 16:51:08', 0),
(2, 1, '21a58b7bd69eb6c9944b6657ce96f514e38056d8eb231609c49a274530c74fb6', '2026-07-03 16:52:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(11) NOT NULL,
  `room_number` varchar(10) NOT NULL,
  `floor` int(11) NOT NULL,
  `capacity` int(11) DEFAULT 4,
  `occupied` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `room_number`, `floor`, `capacity`, `occupied`) VALUES
(1, '101', 1, 4, 2),
(2, '102', 1, 4, 0),
(3, '103', 1, 4, 0),
(4, '104', 1, 4, 0),
(5, '105', 1, 4, 0),
(6, '106', 1, 4, 0),
(7, '107', 1, 4, 0),
(8, '108', 1, 4, 0),
(9, '201', 2, 4, 0),
(10, '202', 2, 4, 0),
(11, '203', 2, 4, 0),
(12, '204', 2, 4, 0),
(13, '205', 2, 4, 0),
(14, '206', 2, 4, 0),
(15, '207', 2, 4, 0),
(16, '208', 2, 4, 0),
(17, '301', 3, 4, 0),
(18, '302', 3, 4, 0),
(19, '303', 3, 4, 0),
(20, '304', 3, 4, 0),
(21, '305', 3, 4, 0),
(22, '306', 3, 4, 0),
(23, '307', 3, 4, 0),
(24, '308', 3, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `payment_status` enum('pending','verified') DEFAULT 'pending',
  `payment_ref` varchar(255) DEFAULT NULL,
  `payment_proof` varchar(255) DEFAULT NULL,
  `payment_method` enum('receipt','online') DEFAULT 'receipt',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `full_name`, `email`, `phone`, `password`, `payment_status`, `payment_ref`, `payment_proof`, `payment_method`, `created_at`) VALUES
(1, 'COS/024/001', 'Thomas Racheal', 'thomasomotayo@gmail.com', '+2348137219798', '$2y$10$X39x/whKuJljGqaVvIY4jO.jwF8bSbnT68zNRvN1hIVoyTd9vOxrS', 'verified', '002115', 'uploads/1783077667_1.jpg', 'receipt', '2026-07-03 11:17:42'),
(2, 'COS/024/003', 'Ajayi Samuel', 'john@gmail.com', '+2348077654345', '$2y$10$5Wd/rSrhsBm7yjT6GpFK1eTN8biygC7spbg5WkkGD4otsKLNfbWoC', 'verified', 'HOSTEL-1783084378-2', NULL, 'online', '2026-07-03 12:24:25');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `reference` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` enum('pending','success','failed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `student_id`, `reference`, `amount`, `status`, `created_at`) VALUES
(1, 2, 'HOSTEL-1783081496-2', '5000000.00', 'pending', '2026-07-03 12:24:56'),
(2, 2, 'HOSTEL-1783081535-2', '5000000.00', 'pending', '2026-07-03 12:25:35'),
(3, 2, 'HOSTEL-1783081857-2', '5000000.00', 'pending', '2026-07-03 12:30:57'),
(4, 2, 'HOSTEL-1783082236-2', '5000000.00', 'pending', '2026-07-03 12:37:16'),
(5, 2, 'HOSTEL-1783082407-2', '5000000.00', 'pending', '2026-07-03 12:40:07'),
(6, 2, 'HOSTEL-1783082423-2', '5000000.00', 'pending', '2026-07-03 12:40:23'),
(7, 2, 'HOSTEL-1783082513-2', '5000000.00', 'pending', '2026-07-03 12:41:53'),
(8, 2, 'HOSTEL-1783082975-2', '5000000.00', 'pending', '2026-07-03 12:49:35'),
(9, 2, 'HOSTEL-1783083838-2', '5000000.00', 'pending', '2026-07-03 13:03:58'),
(10, 2, 'HOSTEL-1783083931-2', '5000000.00', 'pending', '2026-07-03 13:05:31'),
(11, 2, 'HOSTEL-1783084019-2', '5000000.00', 'pending', '2026-07-03 13:06:59'),
(12, 2, 'HOSTEL-1783084283-2', '5000000.00', 'pending', '2026-07-03 13:11:23'),
(13, 2, 'HOSTEL-1783084378-2', '5000000.00', 'success', '2026-07-03 13:12:58');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `allocations`
--
ALTER TABLE `allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `room_id` (`room_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `room_number` (`room_number`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `allocations`
--
ALTER TABLE `allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `allocations`
--
ALTER TABLE `allocations`
  ADD CONSTRAINT `allocations_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `allocations_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
