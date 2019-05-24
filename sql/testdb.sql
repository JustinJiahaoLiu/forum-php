-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 24, 2019 at 01:11 AM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `forums`
--

DROP TABLE IF EXISTS `forums`;
CREATE TABLE IF NOT EXISTS `forums` (
  `forum_id` int(11) NOT NULL,
  `forum_name` varchar(100) NOT NULL,
  `forum_Description` varchar(255) DEFAULT NULL,
  `forum_image` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`forum_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forums`
--

INSERT INTO `forums` (`forum_id`, `forum_name`, `forum_Description`, `forum_image`) VALUES
(1, 'Final Fantacy XIV', 'Your time has come', 'images/ff14_ico.png'),
(2, 'Guild Wars 2', 'Go to Tyria, be a Tyrian', 'images/gw2_ico.png'),
(3, 'World of Warcraft', 'Just play it!', 'images/wow_ico.png');

-- --------------------------------------------------------

--
-- Table structure for table `forum_posts`
--

DROP TABLE IF EXISTS `forum_posts`;
CREATE TABLE IF NOT EXISTS `forum_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_id` int(11) NOT NULL,
  `post_text` text,
  `post_create_time` datetime DEFAULT NULL,
  `post_owner` varchar(150) DEFAULT NULL,
  `forum_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_posts`
--

INSERT INTO `forum_posts` (`post_id`, `topic_id`, `post_text`, `post_create_time`, `post_owner`, `forum_id`) VALUES
(1, 1, 'This is a test', '2019-03-29 10:39:42', 'test@test.com', 1),
(2, 2, 'This is a test', '2019-03-29 10:40:50', 'test@test.com', 2),
(3, 3, 'This is a test2', '2019-03-29 10:41:50', 'test2@test.com', 3),
(4, 3, 'This an reply testing', '2019-03-29 11:54:02', 'test_rely@test.com', 3),
(5, 4, 'Testing Testing', '2019-04-12 21:29:59', 'FF14-fan@gmail.com', 1),
(6, 5, 'Now what?', '2019-05-03 11:36:21', 'long@abc.com', 1),
(7, 5, 'This is not cool', '2019-05-03 12:45:51', 'troll_1@abc.com', 1),
(8, 5, 'This is really bad', '2019-05-03 12:49:06', 'troll_2@cba.com', 1),
(9, 5, 'This is a trolling train', '2019-05-03 12:51:18', 'troll_3@ccc.com', 1),
(10, 6, 'We finally have season 5 online', '2019-05-17 10:33:52', 'GW2_fan@ab.com', 2),
(11, 6, 'What the heck is season 5?', '2019-05-17 10:35:06', 'troll_NO1@trolling.com', 2),
(12, 7, 'Testing', '2019-05-23 16:41:32', 'troll@gmail.com', 1),
(13, 1, 'Testing', '2019-05-23 16:41:53', 'asdfa@a.c', 1),
(14, 5, 'testing', '2019-05-24 09:56:02', 'testing@a.c', 1);

-- --------------------------------------------------------

--
-- Table structure for table `forum_topics`
--

DROP TABLE IF EXISTS `forum_topics`;
CREATE TABLE IF NOT EXISTS `forum_topics` (
  `topic_id` int(11) NOT NULL AUTO_INCREMENT,
  `topic_title` varchar(150) DEFAULT NULL,
  `topic_create_time` datetime DEFAULT NULL,
  `topic_owner` varchar(150) DEFAULT NULL,
  `forum_id` int(11) NOT NULL,
  PRIMARY KEY (`topic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `forum_topics`
--

INSERT INTO `forum_topics` (`topic_id`, `topic_title`, `topic_create_time`, `topic_owner`, `forum_id`) VALUES
(1, 'Test1', '2019-03-29 10:41:50', 'test1@test.com', 1),
(2, 'Test2', '2019-03-29 10:41:50', 'test22@test.com', 2),
(3, 'Test test2', '2019-03-29 10:41:50', 'test2@test.com', 3),
(4, 'FF14 Forum Testing', '2019-04-12 21:29:59', 'FF14-fan@gmail.com', 1),
(5, 'This is a testing for a very loooooooooooooooooooooooooooooooooooooooooong title', '2019-05-03 11:36:21', 'long@abc.com', 1),
(6, 'This is a really good day today', '2019-05-17 10:33:52', 'GW2_fan@ab.com', 2),
(7, 'Testing', '2019-05-23 16:41:32', 'troll@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `store_categories`
--

DROP TABLE IF EXISTS `store_categories`;
CREATE TABLE IF NOT EXISTS `store_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_title` varchar(50) DEFAULT NULL,
  `cat_desc` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cat_title` (`cat_title`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_categories`
--

INSERT INTO `store_categories` (`id`, `cat_title`, `cat_desc`) VALUES
(1, 'Hats', 'Funky hats in all shapes and sizes!'),
(2, 'Shirts', 'From t-shirts to\r\nsweatshirts to polo shirts and beyond.'),
(3, 'Books', 'Paperback, hardback,\r\nbooks for school or play.');

-- --------------------------------------------------------

--
-- Table structure for table `store_items`
--

DROP TABLE IF EXISTS `store_items`;
CREATE TABLE IF NOT EXISTS `store_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) NOT NULL,
  `item_title` varchar(75) DEFAULT NULL,
  `item_price` float(8,2) DEFAULT NULL,
  `item_desc` text,
  `item_image` varchar(50) DEFAULT NULL,
  `item_stock` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_items`
--

INSERT INTO `store_items` (`id`, `cat_id`, `item_title`, `item_price`, `item_desc`, `item_image`, `item_stock`) VALUES
(1, 1, 'Baseball Hat', 12.00, 'Fancy, low-profile baseball hat.', 'images/baseballhat.gif', 92),
(2, 1, 'Cowboy Hat', 52.00, '10 gallon variety', 'images/cowboyhat.gif', 97),
(3, 1, 'Top Hat', 102.00, 'Good for costumes.', 'images/tophat.gif', 99),
(4, 2, 'Short-Sleeved T-Shirt', 12.00, '100% cotton, pre-shrunk.', 'images/sstshirt.gif', 94),
(5, 2, 'Long-Sleeved T-Shirt', 15.00, 'Just like the short-sleeved shirt, with longer sleeves.', 'images/lstshirt.gif', 97),
(6, 2, 'Sweatshirt', 22.00, 'Heavy and warm.', 'images/sweatshirt.gif', 99),
(7, 3, 'Jane\'s Self-Help Book', 12.00, 'Jane gives advice.', 'images/selfhelpbook.gif', 99),
(8, 3, 'Generic Academic Book', 35.00, 'Some required reading for school, will put you to sleep.', 'images/boringbook.gif', 98),
(9, 3, 'Chicago Manual of Style', 9.99, 'Good for copywriters.', 'images/chicagostyle.gif', 99);

-- --------------------------------------------------------

--
-- Table structure for table `store_item_color`
--

DROP TABLE IF EXISTS `store_item_color`;
CREATE TABLE IF NOT EXISTS `store_item_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `item_color` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_item_color`
--

INSERT INTO `store_item_color` (`id`, `item_id`, `item_color`) VALUES
(1, 1, 'red'),
(2, 1, 'black'),
(3, 1, 'blue');

-- --------------------------------------------------------

--
-- Table structure for table `store_item_size`
--

DROP TABLE IF EXISTS `store_item_size`;
CREATE TABLE IF NOT EXISTS `store_item_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `item_size` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_item_size`
--

INSERT INTO `store_item_size` (`id`, `item_id`, `item_size`) VALUES
(1, 1, 'One Size Fits All'),
(2, 2, 'One Size Fits All'),
(3, 3, 'One Size Fits All'),
(4, 4, 'S'),
(5, 4, 'M'),
(6, 4, 'L'),
(7, 4, 'XL');

-- --------------------------------------------------------

--
-- Table structure for table `store_orders`
--

DROP TABLE IF EXISTS `store_orders`;
CREATE TABLE IF NOT EXISTS `store_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_date` datetime DEFAULT NULL,
  `order_name` varchar(100) DEFAULT NULL,
  `order_address` varchar(255) DEFAULT NULL,
  `order_city` varchar(50) DEFAULT NULL,
  `order_state` char(3) DEFAULT NULL,
  `order_zip` varchar(4) DEFAULT NULL,
  `order_tel` varchar(25) DEFAULT NULL,
  `order_email` varchar(100) DEFAULT NULL,
  `item_total` float(6,2) DEFAULT NULL,
  `shipping_total` float(6,2) DEFAULT NULL,
  `authorization` varchar(50) DEFAULT NULL,
  `status` enum('processed','pending') DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_orders`
--

INSERT INTO `store_orders` (`id`, `order_date`, `order_name`, `order_address`, `order_city`, `order_state`, `order_zip`, `order_tel`, `order_email`, `item_total`, `shipping_total`, `authorization`, `status`) VALUES
(1, '2019-05-17 14:04:55', 'justin', '123 Pitt Street', 'Sydney', 'SA', '2000', '0400000000', 'justin.liu@gmailcom', 36.00, NULL, NULL, NULL),
(2, '2019-05-17 14:15:25', 'justin', '123 Pitt Street', 'Sydney', 'SA', '2000', '0400000000', 'justin.liu@gmailcom', 36.00, NULL, NULL, NULL),
(3, '2019-05-17 14:34:08', 'justin', '123 Pitt Street', 'Sydney', 'SA', '2000', '0400000000', 'justin.liu@gmailcom', 36.00, NULL, NULL, NULL),
(4, '2019-05-17 14:41:55', 'joe', '222 Kent Str.', 'Sydney', 'NS', '2000', '040000000', 'joedoe@abc.com', 36.00, NULL, NULL, NULL),
(6, '2019-05-17 14:48:04', 'Jane', '333 York Str', 'Sydney', 'NS', '2000', '0404001001', 'jane@a.c', 74.00, NULL, NULL, NULL),
(7, '2019-05-23 16:40:55', 'jjksalsdf', 'jkljkladf', 'jkljkladf', 'jk', '2222', '000000000', 'adfda@a.c', 9.99, NULL, NULL, NULL),
(8, '2019-05-24 09:59:01', 'justin', '123 Pitt ST.', 'Sydney', 'NS', '2000', '040000000', 'justin.liu@gmail.com', 47.00, NULL, NULL, NULL),
(9, '2019-05-24 10:43:26', 'testing', 'testing', 'Sydney', 'NSW', '2001', '0400000000', 'testing@test.com', 15.00, NULL, NULL, NULL),
(10, '2019-05-24 10:46:13', 'testing', 'testing', 'Sydney', 'NSW', '2001', '0400000000', 'testing@test.com', 15.00, NULL, NULL, NULL),
(11, '2019-05-24 10:49:22', 'justin liu', '123 York Street', 'Sydney', 'NSW', '2000', '0400000001', 'justin.liu@gmail.com', 262.00, NULL, NULL, NULL),
(12, '2019-05-24 11:08:58', 'justin', 'jkjljkad', 'jklj', 'nsw', '2000', '034000', 'jk@a.c', 36.00, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `store_orders_items`
--

DROP TABLE IF EXISTS `store_orders_items`;
CREATE TABLE IF NOT EXISTS `store_orders_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) DEFAULT NULL,
  `sel_item_id` int(11) DEFAULT NULL,
  `sel_item_qty` smallint(6) DEFAULT NULL,
  `sel_item_size` varchar(25) DEFAULT NULL,
  `sel_item_color` varchar(25) DEFAULT NULL,
  `sel_item_price` float(6,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store_orders_items`
--

INSERT INTO `store_orders_items` (`id`, `order_id`, `sel_item_id`, `sel_item_qty`, `sel_item_size`, `sel_item_color`, `sel_item_price`) VALUES
(1, 3, 14, 3, 'L', '', 12.00),
(2, 4, 14, 3, 'L', '', 12.00),
(3, 5, 15, 1, 'One Size Fits All', '', 102.00),
(4, 5, 16, 1, 'S', '', 12.00),
(5, 6, 17, 1, '', '', 35.00),
(6, 6, 18, 1, '', '', 15.00),
(7, 6, 19, 1, 'One Size Fits All', 'black', 12.00),
(8, 6, 20, 1, 'M', '', 12.00),
(9, 7, 21, 1, '', '', 9.99),
(10, 8, 25, 1, '', '', 35.00),
(11, 8, 26, 1, 'L', '', 12.00),
(12, 10, 5, 1, '', '', 15.00),
(13, 11, 2, 2, 'One Size Fits All', '', 52.00),
(14, 11, 5, 1, '', '', 15.00),
(15, 11, 4, 5, 'L', '', 12.00),
(16, 11, 8, 1, '', '', 35.00),
(17, 11, 1, 4, 'One Size Fits All', 'blue', 12.00),
(18, 12, 1, 3, 'One Size Fits All', 'blue', 12.00);

-- --------------------------------------------------------

--
-- Table structure for table `store_shoppertrack`
--

DROP TABLE IF EXISTS `store_shoppertrack`;
CREATE TABLE IF NOT EXISTS `store_shoppertrack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(32) DEFAULT NULL,
  `sel_item_id` int(11) DEFAULT NULL,
  `sel_item_qty` smallint(6) DEFAULT NULL,
  `sel_item_size` varchar(25) DEFAULT NULL,
  `sel_item_color` varchar(25) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
