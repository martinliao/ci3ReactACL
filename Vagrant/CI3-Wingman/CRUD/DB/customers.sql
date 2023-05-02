-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2020 at 11:23 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ci3`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `id` bigint(20) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `vehicles` text NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `servername` varchar(100) DEFAULT NULL,
  `communication` text NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT 'A' COMMENT 'A= Active D= Deactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`id`, `fullname`, `email`, `phone`, `vehicles`, `username`, `servername`, `communication`, `address`, `created_at`, `updated_at`, `status`) VALUES
(9, 'DEEPAK SHARMA (NOIDA)', '', '+91 8527318181', 'UP-16 BT-9827\r\nUP-23 T-2973\r\nUP-23 T-7323\r\n', NULL, NULL, 'NIL', 'C- 102 Omicron 2nd Greater Noida', '2020-04-16 09:29:18', '2020-04-13 06:30:55', 'A'),
(10, 'SURENDRA KHALSA', '', '+91 9412273108', 'UP-81 AF-4013\r\nUP-81 AB-9420\r\nUP-87 9143\r\nUP-81 BT-5488\r\nUP-81 BT-5388\r\nUP-81 AV-4099\r\nUP-81 BP-1313\r\nUP-81 0013\r\nUP-81 CT-3820\r\nUP-81 CT-2537\r\nUP-13 T-2537\r\nUP-81 CT-1300\r\nUP-81 BT-5234\r\nUP-81 BT-5389\r\nUP-81 BJ-0013\r\nUP-81 BT-4496\r\nUP-81 CT-1313\r\n', NULL, NULL, 'NIL', 'ALIGARH', '2020-04-13 06:45:44', '2020-04-13 06:32:19', 'A');

-- --------------------------------------------------------

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
