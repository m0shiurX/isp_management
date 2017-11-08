-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2017 at 09:21 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kp_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `billings`
--

CREATE TABLE `billings` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `bill_id` varchar(255) NOT NULL,
  `bill_month` varchar(255) NOT NULL,
  `Discount` int(11) NOT NULL DEFAULT '0',
  `bill_amount` int(11) NOT NULL,
  `paid_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_collection`
--

CREATE TABLE `cash_collection` (
  `id` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` bigint(20) NOT NULL,
  `payee` varchar(255) NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cash_expanse`
--

CREATE TABLE `cash_expanse` (
  `id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `amount` bigint(20) NOT NULL,
  `purpose` text NOT NULL,
  `remarks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `nid` varchar(16) NOT NULL,
  `address` text,
  `conn_location` text NOT NULL,
  `email` varchar(30) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `conn_type` varchar(10) NOT NULL,
  `package_id` int(10) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `dropped` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kp_category`
--

CREATE TABLE `kp_category` (
  `cat_id` int(3) NOT NULL,
  `cat_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Category name for products table, parents to products';

--
-- Dumping data for table `kp_category`
--

INSERT INTO `kp_category` (`cat_id`, `cat_name`) VALUES
(2, 'MC'),
(1, 'Onu');

-- --------------------------------------------------------

--
-- Table structure for table `kp_products`
--

CREATE TABLE `kp_products` (
  `pro_id` int(3) NOT NULL COMMENT 'Product identity no',
  `pro_name` varchar(40) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Product name',
  `pro_unit` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'Product unit',
  `pro_category` varchar(20) CHARACTER SET utf16 COLLATE utf16_unicode_ci NOT NULL COMMENT 'Product category: Child of kp_category table',
  `pro_details` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Product details',
  `pro_dropped` int(1) NOT NULL DEFAULT '0' COMMENT 'If a product is dropped or not'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Table for individuals products';

-- --------------------------------------------------------

--
-- Table structure for table `kp_user`
--

CREATE TABLE `kp_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `user_pwd` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `full_name` text COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `contact` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci,
  `c_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `authentication` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kp_user`
--

INSERT INTO `kp_user` (`user_id`, `user_name`, `user_pwd`, `full_name`, `email`, `contact`, `address`, `c_date`, `authentication`) VALUES
(32, 'moshiur', '$2y$10$Xk8TYun1Crr0gIS960sSCeh7rfXfQfK2VJ3rJ7SThN/6cehlop35O', 'Moshiur Rahman', 'unimrgm@gmail.com', '01719454658', 'Bogra', '2017-10-21 20:39:51', 0),
(33, 'misu', '$2y$10$xuIQ8LSURAJbGj8dD8Wr9.0PzbPq2qUvaLjmSwMh/5xEY.SHeKYnS', 'Mushfiqur Rahman', 'misu@gmail.com', '01719454658', 'Bogra', '2017-10-22 07:29:55', 0),
(34, 'admin', '$2y$10$51/xhfZqmMt6pr9HhXfZB.Punql5srC5vXtOEradf0Cs5Dg/FzHYy', 'Mr Admin', 'admin@netwaybd.com', '051-56565', 'Netway', '2017-10-23 15:28:31', 0);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `fee` bigint(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `packages`
--

INSERT INTO `packages` (`id`, `name`, `fee`, `created_at`) VALUES
(1, '2 Mbps', 800, '2017-10-30 19:22:42'),
(2, '5 Mbps', 2000, '2017-11-01 07:21:18'),
(3, '3 Mbps ', 1200, '2017-11-01 07:21:53');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) NOT NULL,
  `customer_id` int(10) NOT NULL,
  `r_month` varchar(255) NOT NULL,
  `amount` int(10) NOT NULL,
  `g_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `p_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `paid` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `cdate` datetime DEFAULT CURRENT_TIMESTAMP,
  `provider` varchar(50) NOT NULL,
  `remarks` text NOT NULL,
  `recipient` varchar(50) NOT NULL,
  `type` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billings`
--
ALTER TABLE `billings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_collection`
--
ALTER TABLE `cash_collection`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_expanse`
--
ALTER TABLE `cash_expanse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nid` (`nid`);

--
-- Indexes for table `kp_category`
--
ALTER TABLE `kp_category`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `cat_name` (`cat_name`);

--
-- Indexes for table `kp_products`
--
ALTER TABLE `kp_products`
  ADD PRIMARY KEY (`pro_id`),
  ADD UNIQUE KEY `pro_name` (`pro_name`),
  ADD KEY `pro_category` (`pro_category`);

--
-- Indexes for table `kp_user`
--
ALTER TABLE `kp_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billings`
--
ALTER TABLE `billings`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cash_collection`
--
ALTER TABLE `cash_collection`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `cash_expanse`
--
ALTER TABLE `cash_expanse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `kp_category`
--
ALTER TABLE `kp_category`
  MODIFY `cat_id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `kp_products`
--
ALTER TABLE `kp_products`
  MODIFY `pro_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Product identity no';
--
-- AUTO_INCREMENT for table `kp_user`
--
ALTER TABLE `kp_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
