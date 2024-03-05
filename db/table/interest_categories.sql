-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2023 at 01:44 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `diligentdollar`
--

-- --------------------------------------------------------

--
-- Table structure for table `interest_categories`
--

CREATE TABLE `interest_categories` (
  `id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `color` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interest_categories`
--

INSERT INTO `interest_categories` (`id`, `child_id`, `name`, `color`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 132, 'Sports', 'Red', 'Frist desc', 1, NULL, '2023-06-06 10:31:30', '2023-06-06 10:31:30'),
(2, 132, 'Travelling', 'Red', 'Second desc', 1, NULL, '2023-06-06 10:32:21', '2023-06-06 10:32:21'),
(3, 132, 'Dance', 'Red', 'Second desc', 1, NULL, '2023-06-06 10:32:33', '2023-06-06 10:32:33'),
(4, 97, 'Sports', 'Red', 'Frist des', 1, NULL, '2023-06-06 10:33:27', '2023-06-06 10:33:27'),
(5, 97, 'Travelling', 'Red', 'Frist des', 1, NULL, '2023-06-06 10:33:46', '2023-06-06 10:33:46'),
(6, 97, 'Dance', 'Red', 'Frist des', 1, NULL, '2023-06-06 10:33:55', '2023-06-06 10:33:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `interest_categories`
--
ALTER TABLE `interest_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `interest_categories`
--
ALTER TABLE `interest_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
