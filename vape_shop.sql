-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 08:31 AM
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
-- Database: `vape_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `fullname` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `account_type` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `fullname`, `address`, `contact`, `email`, `password`, `token`, `account_type`) VALUES
(1, 'Graeme Jairus Sta. Iness', 'Ibabao, Cuenca, Batangass', '092174531181111', 'hehehe', '123', NULL, NULL),
(2, 'Aeron Mark', 'Laiya', '019192912', 'aeron', '123', NULL, NULL),
(3, 'vincent', 'vincent@gmail.com', '', 'vincent', '123', NULL, NULL),
(4, 'reign', 'reign@gmail.com', '', 'reign', '123', NULL, NULL),
(5, 'art', 'art@gmail.com', '', 'art', '123', NULL, NULL),
(6, 'admin', 'admin', 'admin', 'admin', 'admin', NULL, 1),
(7, 'asdadadad', 'adadsdada', '12333', 'qwerty', '123', NULL, NULL),
(8, 'try', 'try lang', '0921212', 'try', '1234', NULL, NULL),
(9, '', '', '', 'zeke', '123', NULL, NULL),
(10, 'Jerome Almocera', 'Balintawak, Lipa City', '09123456789', 'jerome123@gmail.com', '12345678', NULL, 2),
(11, '1', '1', '1', '1', '1', NULL, NULL),
(12, 'sdadadasd', 'adadad', '1231231231', 'ada', '123', NULL, NULL),
(15, 'Adam Jacob Bautista', '4217-Example Street, Mataas na Kahoy, Lipa City', '09123456789', 'adambautista@gmail.com', '12345678', NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL DEFAULT 0,
  `itemid` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `clientid`, `itemid`, `quantity`, `price`) VALUES
(18, 1, 17, 1, 100),
(19, 1, 27, 1, 343),
(37, 10, 28, 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Flava'),
(2, 'GeeKVape'),
(4, 'Aqua'),
(5, 'RELX'),
(6, 'SMOK');

-- --------------------------------------------------------

--
-- Table structure for table `chatbot`
--

CREATE TABLE `chatbot` (
  `id` int(11) NOT NULL,
  `queries` varchar(500) NOT NULL,
  `replies` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chatbot`
--

INSERT INTO `chatbot` (`id`, `queries`, `replies`) VALUES
(1, 'hi|hello|hey|yow', 'Hello! do you have any questions?');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `itemname` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `categoryid` int(11) NOT NULL DEFAULT 0,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `img` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `itemname`, `description`, `price`, `quantity`, `categoryid`, `deleted`, `img`) VALUES
(33, 'FLAVA GEEKBAR 10K WITH LANYARD', 'Tax included. Shipping calculated at checkout.', 450, 55, 1, b'0', 'images/GEEKFLAVE_480x.webp'),
(32, 'FLAVA HYPERBAR XTRE 10000', 'Tax included. Shipping calculated at checkout.', 500, 150, 1, b'0', 'images/ph-11134207-7r98v-lqiz70tl3h6j54_480x.webp'),
(31, 'FLAVA ROMIO V2 9500 ( PINK SHIROTA )', 'Tax included. Shipping calculated at checkout.', 450, 100, 1, b'0', 'images/NIMMcopy_480x.webp'),
(30, 'FLAVA OXBAR MAZE PRO', 'Tax included. Shipping calculated at checkout.', 450, 100, 1, b'0', 'images/mazepro_480x.webp'),
(29, 'FLAVA BLACK OXBAR BATTERY', 'Tax included. Shipping calculated at checkout.', 250, 50, 1, b'0', 'images/black-oxbar-battery.webp'),
(34, 'FLAVA MOSMO 7000 PUFFS', 'Tax included. Shipping calculated at checkout.', 450, 67, 1, b'0', 'images/mosmo1_480x.webp'),
(35, 'FLAVA OXBAR G9500 PRO', 'Tax included. Shipping calculated at checkout.', 460, 78, 1, b'0', 'images/oxbarpro_480x.webp'),
(36, 'FLAVA ARTERY ABAR 6500', 'Tax included. Shipping calculated at checkout.', 450, 499, 1, b'0', 'images/abartemplate_480x.webp'),
(37, 'FLAVA AE BAR 8500/9000 PUFFS', 'Tax included. Shipping calculated at checkout.', 390, 88, 1, b'0', 'images/AEBARTEMPcopy_480x.webp'),
(38, 'FLAVA FRIOBAR 9500', 'Tax included. Shipping calculated at checkout.', 450, 99, 1, b'0', 'images/FRIOBAR_480x.webp'),
(39, 'RELX INFINITY POD MENTHOL PLUS SINGLE POD', 'Tax included. Shipping calculated at checkout.', 200, 150, 5, b'0', 'images/relx_pods_1200x1200.webp'),
(40, 'RELX POD PRO - ZESTY SPARKLE', 'Tax included. Shipping calculated at checkout.', 200, 50, 5, b'0', 'images/Qjc2tZ3qvk8mxGPn7oy3bP_watermark_400.jpg'),
(41, 'RELX ESSENTIAL DEV - NEON PURPLE', 'Tax included. Shipping calculated at checkout.', 899, 260, 5, b'0', 'images/NtZjDPRCMjkfq8fuhbbYWo_watermark_400.jpg'),
(42, 'RELX INFINITY 2 DEV - OBSIDIAN BLACK', 'Tax included. Shipping calculated at checkout.', 1169, 150, 5, b'0', 'images/RelxInfinity2Device-ObsidianBlack.webp'),
(43, 'RELX ESSENTIAL DEV - BLUE', 'Tax included. Shipping calculated at checkout.', 799, 150, 5, b'0', 'images/LhLXD6fWvVhDtZmw4ZXeb2_watermark_400.jpg'),
(44, 'RELX POD PRO - WHITE FREEZE', 'Tax included. Shipping calculated at checkout.', 200, 200, 5, b'0', 'images/images.jfif'),
(45, 'RELX INFINITY POD - GARDENS HEART SINGLE POD', 'Tax included. Shipping calculated at checkout.', 200, 50, 5, b'0', 'images/relx-infinity-pro-single-pod-gardens-heart-699861.webp'),
(46, 'RELX INFINITY POD TANGY PURPLE SINGLE POD', 'Tax included. Shipping calculated at checkout.', 200, 299, 5, b'0', 'images/K7cSSGqVbEj6zL9TQLVdCM_watermark_400.jpg'),
(47, 'SMOK PRO POD GT  KIT 22W VAPE', 'Tax included. Shipping calculated at checkout.', 1100, 23, 6, b'0', 'images/20240325-173414-scaled.jpg'),
(48, 'SMOK NORD GT 80W', 'Tax included. Shipping calculated at checkout.', 1700, 399, 6, b'0', 'images/images (1).jfif'),
(49, 'SMOK MAVIC 9000', 'Tax included. Shipping calculated at checkout.', 299, 150, 6, b'0', 'images/7ff01ee2d054fb014299b432526e982a.jpg_720x720q80.jpg'),
(50, 'SMOK NOVO 4', 'Tax included. Shipping calculated at checkout.', 568, 120, 6, b'0', 'images/SMOK-004-1-600x600.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `clientid` int(11) NOT NULL DEFAULT 0,
  `subtotal` float NOT NULL DEFAULT 0,
  `fee` float NOT NULL DEFAULT 0,
  `totalamount` float NOT NULL DEFAULT 0,
  `status` text DEFAULT NULL,
  `orderdate` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `clientid`, `subtotal`, `fee`, `totalamount`, `status`, `orderdate`) VALUES
(1, 1, 223, 100, 323, 'Completed', '2024-06-17 18:28:39'),
(2, 13, 550, 100, 650, 'Completed', '2024-10-30 15:27:00'),
(3, 13, 1100, 100, 1200, 'Paid', '2024-10-30 15:33:50'),
(4, 13, 2750, 100, 2850, '', '2024-10-30 15:36:45'),
(5, 13, 550, 100, 650, 'completed', '2024-10-30 15:38:47'),
(6, 13, 550, 100, 650, 'completed', '2024-10-30 15:41:21'),
(7, 13, 550, 100, 650, 'completed', '2024-10-30 19:57:24'),
(8, 13, 550, 100, 650, 'completed', '2024-10-30 19:58:44'),
(9, 13, 550, 100, 650, 'completed', '2024-10-30 19:59:24'),
(10, 13, 550, 100, 650, 'completed', '2024-10-30 21:48:14'),
(11, 13, 550, 100, 650, 'completed', '2024-10-30 21:49:10'),
(12, 13, 550, 100, 650, 'Canceled', '2024-10-30 22:09:55'),
(13, 13, 1100, 100, 1200, 'Canceled', '2024-10-30 22:28:53'),
(14, 13, 550, 100, 650, 'Completed', '2024-10-31 00:28:10'),
(15, 13, 1100, 100, 1200, 'Completed', '2024-10-31 02:14:27');

-- --------------------------------------------------------

--
-- Table structure for table `transactions_items`
--

CREATE TABLE `transactions_items` (
  `id` int(11) NOT NULL,
  `transactionid` int(11) NOT NULL DEFAULT 0,
  `itemid` int(11) NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `transactions_items`
--

INSERT INTO `transactions_items` (`id`, `transactionid`, `itemid`, `price`, `quantity`) VALUES
(1, 12, 28, 550, 1),
(2, 13, 28, 550, 2),
(3, 14, 28, 550, 1),
(4, 15, 28, 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_itemid` (`itemid`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chatbot`
--
ALTER TABLE `chatbot`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_client_id` (`clientid`);

--
-- Indexes for table `transactions_items`
--
ALTER TABLE `transactions_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_itemid` (`itemid`),
  ADD KEY `fk_transactionid` (`transactionid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `chatbot`
--
ALTER TABLE `chatbot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `transactions_items`
--
ALTER TABLE `transactions_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
