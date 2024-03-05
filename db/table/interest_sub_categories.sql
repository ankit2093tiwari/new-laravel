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
-- Table structure for table `interest_sub_categories`
--

CREATE TABLE `interest_sub_categories` (
  `id` int(11) NOT NULL,
  `child_id` int(11) DEFAULT NULL,
  `interest_categories_id` int(11) DEFAULT NULL,
  `interest_sub_category` varchar(255) DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `interest_sub_categories`
--

INSERT INTO `interest_sub_categories` (`id`, `child_id`, `interest_categories_id`, `interest_sub_category`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 132, 1, 'Cricket', 1, NULL, '2023-06-06 10:36:30', '2023-06-06 10:36:30'),
(2, 132, 1, 'FootBall', 1, NULL, '2023-06-06 10:36:30', '2023-06-06 10:36:30'),
(3, 132, 1, 'VollyBall', 1, NULL, '2023-06-06 10:36:30', '2023-06-06 10:36:30'),
(4, 132, 2, 'First Travelling', 1, NULL, '2023-06-06 10:37:37', '2023-06-06 10:37:37'),
(5, 132, 2, 'Second Travelling', 1, NULL, '2023-06-06 10:37:37', '2023-06-06 10:37:37'),
(6, 132, 2, 'Third Travelling', 1, NULL, '2023-06-06 10:37:37', '2023-06-06 10:37:37'),
(7, 132, 3, 'Hip Hop', 1, NULL, '2023-06-06 10:38:50', '2023-06-06 10:38:50'),
(8, 132, 3, 'Classic', 1, NULL, '2023-06-06 10:38:50', '2023-06-06 10:38:50'),
(9, 132, 3, 'Bharat Natyam', 1, NULL, '2023-06-06 10:38:50', '2023-06-06 10:38:50'),
(10, 97, 4, 'First Cricket', 1, NULL, '2023-06-06 10:36:30', '2023-06-06 10:36:30'),
(11, 97, 4, 'First FootBall', 1, NULL, '2023-06-06 10:36:30', '2023-06-06 10:36:30'),
(12, 97, 4, 'First VollyBall', 1, NULL, '2023-06-06 10:36:30', '2023-06-06 10:36:30'),
(13, 97, 5, '4 Travelling', 1, NULL, '2023-06-06 10:37:37', '2023-06-06 10:37:37'),
(14, 97, 5, '5 Travelling', 1, NULL, '2023-06-06 10:37:37', '2023-06-06 10:37:37'),
(15, 97, 5, '6 Travelling', 1, NULL, '2023-06-06 10:37:37', '2023-06-06 10:37:37'),
(16, 97, 6, 'First Hip Hop', 1, NULL, '2023-06-06 10:38:50', '2023-06-06 10:38:50'),
(17, 97, 6, 'First Classic', 1, NULL, '2023-06-06 10:38:50', '2023-06-06 10:38:50'),
(18, 97, 6, 'First Bharat Natyam', 1, NULL, '2023-06-06 10:38:50', '2023-06-06 10:38:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `interest_sub_categories`
--
ALTER TABLE `interest_sub_categories`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `interest_sub_categories`
--
ALTER TABLE `interest_sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
