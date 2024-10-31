-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 18, 2024 at 02:24 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dborders`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` text,
  `address` text,
  `contact` text,
  `username` text,
  `password` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `fullname`, `address`, `contact`, `username`, `password`) VALUES
(1, 'Graeme Jairus Sta. Iness', 'Ibabao, Cuenca, Batangass', '092174531181111', 'gia', '123'),
(2, 'Aeron Mark', 'Laiya', '019192912', 'aeron', '123'),
(3, 'vincent', 'vincent@gmail.com', '', 'vincent', '123'),
(4, 'reign', 'reign@gmail.com', '', 'reign', '123'),
(5, 'art', 'art@gmail.com', '', 'art', '123'),
(6, 'admin', 'admin', 'admin', 'admin', 'admin'),
(7, 'asdadadad', 'adadsdada', '12333', 'qwerty', '123'),
(8, 'try', 'try lang', '0921212', 'try', '1234'),
(9, '', '', '', 'zeke', '123'),
(10, 'TRY LANG123', 'adasdadadadad', '09121212', 'trylang ', '123'),
(11, '1', '1', '1', '1', '1'),
(12, 'sdadadasd', 'adadad', '1231231231', 'ada', '123');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL DEFAULT '0',
  `itemid` int(11) NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `cart`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Dining'),
(2, 'Living');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` text,
  `description` text,
  `price` float NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `categoryid` int(11) NOT NULL DEFAULT '0',
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  `img` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `itemname`, `description`, `price`, `quantity`, `categoryid`, `deleted`, `img`) VALUES
(21, 'headset2', 'adadadad', 500, 1, 1, b'0', 'images/headset.png'),
(16, 'chair', 'addada', 111, 6, 1, b'0', 'images/amber-marcel-i-chair_1_1.png'),
(17, 'charger', 'adadadad', 100, 6, 2, b'0', 'images/charger.webp'),
(18, 'keyboard', 'adasdad', 12, 9, 1, b'0', 'images/keyboard.png'),
(19, 'logo', 'adadadad', 1, 10, 1, b'0', 'images/logo1.png'),
(20, 'headset', 'adadadad', 1, 7, 1, b'0', 'images/headset.png');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL DEFAULT '0',
  `subtotal` float NOT NULL DEFAULT '0',
  `fee` float NOT NULL DEFAULT '0',
  `totalamount` float NOT NULL DEFAULT '0',
  `status` text,
  `orderdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `clientid`, `subtotal`, `fee`, `totalamount`, `status`, `orderdate`) VALUES
(1, 1, 223, 100, 323, 'Completed', '2024-06-17 18:28:39');

-- --------------------------------------------------------

--
-- Table structure for table `transactions_items`
--

CREATE TABLE IF NOT EXISTS `transactions_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transactionid` int(11) NOT NULL DEFAULT '0',
  `itemid` int(11) NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `transactions_items`
--

