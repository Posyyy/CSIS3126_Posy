-- phpMyAdmin SQL Dump
-- version 5.1.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 20, 2025 at 01:36 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_queue`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `log_id` int(11) NOT NULL,
  `admin_username` varchar(100) DEFAULT NULL,
  `action` text,
  `log_time` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`log_id`, `admin_username`, `action`, `log_time`) VALUES
(1, 'Unknown', 'Updated table ID 1 to status \'Available\'', '2025-04-19 20:57:47');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `name`, `phone_number`, `email`) VALUES
(1, 'Alice Johnson', '5551234567', 'alice@example.com'),
(2, 'Bob Smith', '5552345678', 'bob@example.com'),
(3, 'Charlie Brown', '5553456789', 'charlie@example.com'),
(4, 'David Lee', '5554567890', 'david@example.com'),
(5, 'Emma Davis', '5555678901', 'emma@example.com'),
(6, 'Frank Wilson', '5556789012', 'frank@example.com'),
(7, 'Grace Hall', '5557890123', 'grace@example.com'),
(8, 'Henry Adams', '5558901234', 'henry@example.com'),
(9, 'Isabella White', '5559012345', 'isabella@example.com'),
(10, 'Jack Martin', '5550123456', 'jack@example.com'),
(13, 'Evan Posy', '4011111111', 'totaldrama@yuo.moc'),
(14, 'Evan Posy', '430123984', 'ev@example.com');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `reservation_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `party_size` int(11) NOT NULL,
  `reservation_time` datetime NOT NULL,
  `status` enum('confirmed','cancelled','completed') DEFAULT 'confirmed',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE `restaurant` (
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `max_capacity` int(11) NOT NULL DEFAULT '250'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `restaurant`
--

INSERT INTO `restaurant` (`restaurant_id`, `name`, `location`, `phone_number`, `max_capacity`) VALUES
(1, 'Dunder Mifflin ', 'Scranton, PA', '555-123-4567', 250),
(5, 'Test Restaurant', '123 Main St', NULL, 100);

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `role` enum('manager','host','server') NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(20) NOT NULL,
  `shift_start` time DEFAULT NULL,
  `shift_end` time DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `restaurant_id`, `name`, `role`, `email`, `password`, `phone_number`, `shift_start`, `shift_end`, `created_at`) VALUES
(3, 5, 'John Doe', 'manager', 'john@example.com', 'admin123', '123-456-7890', '08:00:00', '16:00:00', '2025-03-26 00:53:31'),
(4, 5, 'Jane Smith', 'host', 'jane@example.com', 'hostpass456', '987-654-3210', '10:00:00', '18:00:00', '2025-03-26 00:53:31'),
(15, 1, 'Michael Scott', 'manager', 'michael@restaurant.com', 'michael789', '5550001111', NULL, NULL, '2025-03-26 19:46:20'),
(16, 1, 'Pam Beesly', 'host', 'pam@restaurant.com', 'pam1234', '5550002222', NULL, NULL, '2025-03-26 19:46:20'),
(17, 1, 'Jim Halpert', 'server', 'jim@restaurant.com', 'jim5678', '5550003333', NULL, NULL, '2025-03-26 19:46:20'),
(18, 1, 'Dwight Schrute', 'server', 'dwight@restaurant.com', 'dwight9999', '5550004444', NULL, NULL, '2025-03-26 19:46:20');

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `table_id` int(11) NOT NULL,
  `table_number` int(11) NOT NULL,
  `capacity` int(11) NOT NULL,
  `status` enum('available','occupied','reserved') DEFAULT 'available',
  `estimated_wait_time` int(11) DEFAULT NULL,
  `restaurant_id` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`table_id`, `table_number`, `capacity`, `status`, `estimated_wait_time`, `restaurant_id`) VALUES
(1, 1, 2, 'available', NULL, 1),
(2, 2, 2, 'occupied', NULL, 1),
(3, 3, 4, 'available', NULL, 1),
(4, 4, 4, 'available', NULL, 1),
(5, 5, 2, 'available', NULL, 1),
(6, 6, 4, 'available', NULL, 1),
(7, 7, 4, 'available', NULL, 1),
(8, 8, 6, 'available', NULL, 1),
(9, 9, 2, 'available', NULL, 1),
(10, 10, 4, 'available', NULL, 1),
(11, 11, 6, 'available', NULL, 1),
(12, 12, 2, 'available', NULL, 1),
(13, 13, 2, 'available', NULL, 1),
(14, 14, 4, 'available', NULL, 1),
(15, 15, 6, 'available', NULL, 1),
(16, 16, 6, 'available', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `waitlist`
--

CREATE TABLE `waitlist` (
  `waitlist_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `restaurant_id` int(11) NOT NULL DEFAULT '1',
  `party_size` int(11) NOT NULL,
  `status` enum('waiting','seated','removed') DEFAULT NULL,
  `estimated_wait_time` int(11) DEFAULT NULL,
  `waitlist_type` enum('walk-in','reservation') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `arrival_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `reservation_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `waitlist`
--

INSERT INTO `waitlist` (`waitlist_id`, `customer_id`, `restaurant_id`, `party_size`, `status`, `estimated_wait_time`, `waitlist_type`, `created_at`, `arrival_time`, `reservation_time`) VALUES
(45, 1, 1, 4, 'waiting', NULL, 'walk-in', '2025-03-26 16:30:00', '2025-03-26 16:30:00', NULL),
(46, 2, 1, 2, 'waiting', NULL, 'reservation', '2025-03-26 17:00:00', '2025-03-27 22:50:00', '19:00:00'),
(47, 3, 1, 5, 'seated', NULL, 'walk-in', '2025-03-26 17:15:00', '2025-03-26 17:15:00', NULL),
(48, 4, 1, 3, 'waiting', NULL, 'reservation', '2025-03-26 17:45:00', '2025-03-28 00:15:00', '20:30:00'),
(49, 5, 1, 6, 'seated', NULL, 'walk-in', '2025-03-26 18:00:00', '2025-03-26 18:00:00', NULL),
(50, 6, 1, 2, 'waiting', NULL, 'reservation', '2025-03-26 18:30:00', '2025-03-28 21:50:00', '18:00:00'),
(51, 7, 1, 4, 'waiting', NULL, 'walk-in', '2025-03-26 19:00:00', '2025-03-26 19:00:00', NULL),
(52, 8, 1, 3, 'waiting', NULL, 'reservation', '2025-03-26 19:30:00', '2025-03-29 23:30:00', '19:45:00'),
(53, 9, 1, 5, 'seated', NULL, 'walk-in', '2025-03-26 20:00:00', '2025-03-26 20:00:00', NULL),
(54, 10, 1, 2, 'waiting', NULL, 'walk-in', '2025-03-26 20:30:00', '2025-03-26 20:30:00', NULL),
(65, 13, 1, 5, 'waiting', NULL, 'reservation', '2025-03-27 19:59:44', '2025-03-27 19:59:44', '17:02:00'),
(66, 14, 1, 16, 'waiting', NULL, 'walk-in', '2025-04-01 13:49:47', '2025-04-01 13:49:47', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD PRIMARY KEY (`restaurant_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `restaurant_id` (`restaurant_id`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`table_id`);

--
-- Indexes for table `waitlist`
--
ALTER TABLE `waitlist`
  ADD PRIMARY KEY (`waitlist_id`),
  ADD KEY `idx_customer_id` (`customer_id`),
  ADD KEY `idx_restaurant_id` (`restaurant_id`),
  ADD KEY `idx_status` (`status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `restaurant`
--
ALTER TABLE `restaurant`
  MODIFY `restaurant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `table_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `waitlist`
--
ALTER TABLE `waitlist`
  MODIFY `waitlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_ibfk_1` FOREIGN KEY (`restaurant_id`) REFERENCES `restaurant` (`restaurant_id`) ON DELETE CASCADE;

--
-- Constraints for table `waitlist`
--
ALTER TABLE `waitlist`
  ADD CONSTRAINT `waitlist_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`customer_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
