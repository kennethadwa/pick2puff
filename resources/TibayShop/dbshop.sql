-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2024 at 12:57 AM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dbshop`
--

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `cart`
--


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`) VALUES
(1, 'Clothes'),
(2, 'Electrical');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`id`, `fullname`) VALUES
(2, 'Harold Inacay');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemname` text,
  `categoryid` int(11) NOT NULL DEFAULT '0',
  `description` text,
  `price` float NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `img` text,
  `deleted` bit(1) NOT NULL DEFAULT b'0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `itemname`, `categoryid`, `description`, `price`, `quantity`, `img`, `deleted`) VALUES
(1, 'Socket', 2, 'Sinaksakan', 150, 0, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRwHciOE1qf0VtY6zNtv1yUBGeOAbJMdjDe7Q&s', b'0'),
(2, 'Nike TShirt', 1, 'Anti Nude', 50, 4, 'https://dynamic.zacdn.com/dVku9nBXV-K7_A8DfoDUz58Us4I=/filters:quality(70):format(webp)/https://static-ph.zacdn.com/p/nike-2849-8020503-1.jpg', b'0'),
(3, 'Sando', 1, 'Pambanas', 20, 50, 'https://media.karousell.com/media/photos/products/2023/6/11/mens_singlet_1686476227_60612953_progressive.jpg', b'0'),
(4, 'Short', 1, 'Sleeveless', 60, 1, 'https://media.karousell.com/media/photos/products/2023/9/11/vintage_flame_short_rare_ltd_i_1694394909_5fc2a364_progressive.jpg', b'0'),
(5, 'Extension', 2, 'sinaksakan ng marami', 150, 1, 'https://down-ph.img.susercontent.com/file/75d1f491caae19d41d24180862cf2021', b'0');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL DEFAULT '0',
  `subtotal` float NOT NULL DEFAULT '0',
  `fee` float NOT NULL DEFAULT '0',
  `total` float NOT NULL DEFAULT '0',
  `status` text,
  `orderdate` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `clientid`, `subtotal`, `fee`, `total`, `status`, `orderdate`) VALUES
(1, 2, 200, 100, 300, 'Pending', '2024-06-08 08:57:05');
