-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2026 at 05:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market_analyst`
--

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `symbol` varchar(20) NOT NULL,
  `sector` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `symbol`, `sector`, `description`, `created_at`) VALUES
(1, 'Nepal Bank', 'NBL', 'Banking', 'Commercial banking company', '2026-08-13 09:51:12'),
(2, 'Nabil Bank', 'NABIL', 'Banking', 'Commercial bank providing financial services', '2026-08-13 09:51:12'),
(3, 'Nepal Telecom', 'NTC', 'Telecommunication', 'Telecommunication service provider', '2026-08-13 09:51:12'),
(4, 'Hydro Electricity Company', 'HEC', 'Hydropower', 'Hydropower and energy company', '2026-08-13 09:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `company_financials`
--

CREATE TABLE `company_financials` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `period` varchar(50) NOT NULL,
  `revenue` decimal(15,2) DEFAULT 0.00,
  `expenses` decimal(15,2) DEFAULT 0.00,
  `net_profit` decimal(15,2) DEFAULT 0.00,
  `net_loss` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_financials`
--

INSERT INTO `company_financials` (`id`, `company_id`, `period`, `revenue`, `expenses`, `net_profit`, `net_loss`) VALUES
(1, 1, 'Q1 2026', 5000000.00, 3500000.00, 1500000.00, 0.00),
(2, 2, 'Q1 2026', 7000000.00, 5000000.00, 2000000.00, 0.00),
(3, 3, 'Q1 2026', 9000000.00, 6000000.00, 3000000.00, 0.00),
(4, 4, 'Q1 2026', 4000000.00, 4500000.00, 0.00, 500000.00);

-- --------------------------------------------------------

--
-- Table structure for table `company_prices`
--

CREATE TABLE `company_prices` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `previous_price` decimal(10,2) DEFAULT NULL,
  `price_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_prices`
--

INSERT INTO `company_prices` (`id`, `company_id`, `price`, `previous_price`, `price_date`) VALUES
(1, 1, 450.00, 430.00, '2026-08-13'),
(2, 2, 520.00, 500.00, '2026-08-13'),
(3, 3, 980.00, 950.00, '2026-08-13'),
(4, 4, 350.00, 370.00, '2026-08-13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'samir', 'samir@test.com', '$2y$10$4smLptiYUXseIRiUgAGXYum3/PnrGecEHXDWcJNdJkTzRwMVm4R4e', '2026-08-13 15:25:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `symbol` (`symbol`);

--
-- Indexes for table `company_financials`
--
ALTER TABLE `company_financials`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `company_prices`
--
ALTER TABLE `company_prices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `company_id` (`company_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_financials`
--
ALTER TABLE `company_financials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `company_prices`
--
ALTER TABLE `company_prices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `company_financials`
--
ALTER TABLE `company_financials`
  ADD CONSTRAINT `company_financials_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);

--
-- Constraints for table `company_prices`
--
ALTER TABLE `company_prices`
  ADD CONSTRAINT `company_prices_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
