-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 19, 2013 at 09:47 AM
-- Server version: 5.1.50
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `onlinestore`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_product`
--

CREATE TABLE IF NOT EXISTS `cart_product` (
  `CustomerId` bigint(20) unsigned NOT NULL,
  `ProductId` bigint(20) unsigned NOT NULL,
  `Quantity` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`CustomerId`,`ProductId`),
  KEY `productsid` (`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cart_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CategoryID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(10) DEFAULT NULL,
  `Description` varchar(50) DEFAULT NULL,
  `ParentCatId` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`CategoryID`),
  UNIQUE KEY `CategoryID` (`CategoryID`),
  KEY `ParentCatId` (`ParentCatId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `Name`, `Description`, `ParentCatId`) VALUES
(1, '所有分类', '所有分类', 0),
(2, '美容护肤', '各类美容美发护肤和化妆用品', 1),
(3, '服装鞋帽', '各类服装，鞋帽', 1),
(4, '男装', '男装', 3),
(5, '女装', '女装', 3),
(6, '童装', '童装', 3),
(7, '外套', '外套', 4),
(8, '西装', '西装', 4),
(9, '女士秋装', '女士秋装', 5),
(10, '职业套装', '职业套装', 5),
(11, '裙装', '裙装', 5),
(12, '香水', '香水', 2),
(13, '护肤品', '护肤品', 2),
(14, '化妆品', '', 2);

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `ProductID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `OrderID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Content` varchar(100) DEFAULT NULL,
  `CommentTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Rating` enum('0','1','2','3','4','5') DEFAULT NULL,
  PRIMARY KEY (`ProductID`,`OrderID`),
  KEY `orders` (`OrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--


-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `CustomerID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Email` varchar(100) DEFAULT NULL,
  `TEL` varchar(20) DEFAULT NULL,
  `Name` varchar(30) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Password` char(32) DEFAULT NULL,
  `Mobile` varchar(20) DEFAULT NULL,
  `Approved` tinyint(1) DEFAULT NULL,
  `date_added` bigint(20) DEFAULT NULL,
  `date_modified` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`CustomerID`),
  UNIQUE KEY `CustomerID` (`CustomerID`),
  UNIQUE KEY `Email` (`Email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `Email`, `TEL`, `Name`, `Address`, `Password`, `Mobile`, `Approved`, `date_added`, `date_modified`) VALUES
(42, 'qq@qq.com', '111', 'qq', 'SDadd', '099b3b060154898840f0ebdfb46ec78f', '', NULL, 1370746893, NULL),
(43, 'w@w.w', '123', 'wq', '222', 'ad57484016654da87125db86f4227ea3', 'ww', NULL, 1371005271, 1371005298);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `OrderID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `CustomerID` bigint(20) unsigned DEFAULT NULL,
  `OrderTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `OrderStatus` tinyint(4) DEFAULT NULL,
  `PaymentMethod` tinyint(4) DEFAULT NULL,
  `ShippingMethod` tinyint(4) DEFAULT NULL,
  `ShippingAddress` varchar(100) DEFAULT NULL,
  `ReceiverTel` varchar(20) DEFAULT NULL,
  `ReceiverName` varchar(15) DEFAULT NULL,
  `AdminComment` varchar(50) DEFAULT NULL,
  `CustomerComment` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`OrderID`),
  UNIQUE KEY `OrderID` (`OrderID`),
  KEY `customerid` (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `orders`
--


-- --------------------------------------------------------

--
-- Table structure for table `order_product`
--

CREATE TABLE IF NOT EXISTS `order_product` (
  `OrderId` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ProductId` bigint(20) unsigned NOT NULL DEFAULT '0',
  `Quantity` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`OrderId`,`ProductId`),
  KEY `OrderId` (`OrderId`),
  KEY `ProductId` (`ProductId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `order_product`
--


-- --------------------------------------------------------

--
-- Table structure for table `payment_method`
--

CREATE TABLE IF NOT EXISTS `payment_method` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `payment_method`
--

INSERT INTO `payment_method` (`id`, `name`, `availability`) VALUES
(1, 'Ö§¸¶±¦', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `ProductID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) NOT NULL,
  `Price` decimal(7,2) NOT NULL,
  `Spec` varchar(20) DEFAULT NULL,
  `Manufacturer` varchar(20) DEFAULT NULL,
  `Category` bigint(20) unsigned DEFAULT NULL,
  `Image` varchar(100) DEFAULT NULL,
  `Description` varchar(5000) DEFAULT NULL,
  `QuantitySold` int(10) unsigned DEFAULT NULL,
  `QuantityInStock` int(10) unsigned DEFAULT NULL,
  `Promoted` tinyint(1) DEFAULT '0',
  `Date_Added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ProductID`),
  UNIQUE KEY `ProductID` (`ProductID`),
  KEY `category` (`Category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `Name`, `Price`, `Spec`, `Manufacturer`, `Category`, `Image`, `Description`, `QuantitySold`, `QuantityInStock`, `Promoted`, `Date_Added`) VALUES
(4, 'product1', '800.00', NULL, NULL, 2, '1.jpg', '880ml', 8, 3, 1, '2013-05-11 10:29:04'),
(5, 'product2', '128.00', NULL, NULL, 9, '2.jpg', '?', 7, 5, 1, '2013-05-11 10:29:04'),
(6, 'product3', '98.00', NULL, NULL, 9, '3.jpg', '', 2, NULL, 1, '2013-05-11 10:29:04'),
(7, 'product4', '899.00', NULL, NULL, 7, '4.jpg', '?', 6, 3, 1, '2013-05-11 10:29:04'),
(8, 'product5', '1280.00', NULL, NULL, 7, '5.jpg', '', 16, 2, 1, '2013-05-11 10:29:04'),
(9, 'product6', '1280.00', NULL, NULL, 8, '6.jpg', 'Men?', 22, 2, 0, '2013-05-11 10:29:04'),
(10, 'product7', '1280.00', NULL, NULL, 8, '7.jpg', 'Super?', 11, 2, 0, '2013-05-11 10:29:04'),
(11, 'product8', '0.00', NULL, NULL, 10, '8.jpg', NULL, 11, NULL, 0, '2013-05-11 10:29:04'),
(12, 'product9', '0.00', NULL, NULL, 10, '9.jpg', NULL, 5, NULL, 0, '2013-05-11 10:29:04'),
(13, 'product10', '0.00', NULL, NULL, 11, '10.jpg', NULL, 6, NULL, 0, '2013-05-11 10:29:04'),
(14, 'product11', '0.00', NULL, NULL, 2, '11.jpg', NULL, 1, NULL, 0, '2013-05-11 10:29:04'),
(15, 'product12', '0.00', NULL, NULL, 12, '12.jpg', NULL, 2, NULL, 0, '2013-05-11 10:29:04'),
(16, 'product13', '0.00', NULL, NULL, 13, '13.jpg', NULL, 1, NULL, 0, '2013-05-11 10:29:04'),
(17, 'product14', '680.00', NULL, NULL, 12, '14.jpg', '211 - Flower Collection 50ml\r\n\r\nThe amazing sweet aroma of flowers, Sambucus your heart beat faster.\r\nThe aroma is an invitation to joy and happiness. It''s up to you who you invite.', 0, NULL, 0, '2013-05-11 10:29:04'),
(18, 'product15', '320.00', NULL, NULL, 12, '15.jpg', 'FL06 - 2nd Skin Foundation SAND BEIGE\r\n\r\nWhen designing the SECOND SKIN FOUNDATION we have a process of micronization of pigments used, that is their recitals satisfactory fragmentation.\r\nMicronized pigments blend perfectly with the skin.\r\n \r\n\r\n    30ml\r\n\r\n', 1, NULL, 0, '2013-05-11 10:29:04'),
(19, 'product16', '680.00', NULL, NULL, 12, '16.jpg', 'The Home Perfume is essentially a fragrant oil bottled in an attractive bottle. The scent is spread by a number olieabsoberende sticks that are put in the bottle. The sticks take the oil and distribute an attractive smell, 40ml', 4, NULL, 0, '2013-05-11 10:29:04'),
(20, 'product17', '320.00', NULL, NULL, 12, '17.jpg', 'C001 - Eyeshadows CHOCOLATE MOUSSE\r\n\r\nWarm, appetizing chocolate colors underline the depth of the gaze.\r\n\r\n    10 gram\r\n\r\n', 7, NULL, 0, '2013-05-11 10:29:04'),
(21, 'product18', '1200.00', NULL, NULL, 12, '18.jpg', 'Luxury Collection Men FM 300\r\n\r\n    FM 300 A light, dynamic composition in which notes of grapefruit, lemon and bergamot are combined with lavender and cedar\r\n\r\n', 6, NULL, 0, '2013-05-11 10:29:04'),
(22, 'product19', '88.00', NULL, NULL, 12, '19.jpg', 'Luxury Collection 198\r\n\r\nAn extravagant combination of tobacco leaves, bergamot, fern, jasmine and patchouli.\r\n', 0, NULL, 0, '2013-05-11 10:29:04'),
(23, 'product20', '288.00', NULL, NULL, 12, '20.jpg', 'Lotion SPF30 100ml \r\n \r\nB02 FM\r\n\r\n    Suitable for use by people with mild to very light skin and skin that is sensitive to the Sun\r\n    The lotion contains no fragrances or dyes, hypoallergenic mineral an innovative combination of filters (including titanium dioxide) with a stable chemical complex of photo filters provides an effective protection against UVA and UVB rays.\r\n    An extract of golden algae (Laminaria ochroleuca) was used as a unique immune filter.\r\n    It protects the skin from within (DNA), it strengthens the natural zonafweersysteem.\r\n    It will also protect against photo-allergies and soothes the redness of the skin caused by excessive UV rays.\r\n    Vitamin E softens and moisturizes the skin and protects cells against free radicals.\r\n    Waterproof (also protects your skin while bathing).\r\n    A soft, creamy texture for easy application.\r\n', 8, NULL, 0, '2013-05-11 10:29:04'),
(24, 'testproduct21', '0.00', NULL, NULL, 2, '1163_list_1284678384572.jpg', '蓝色衬衣', 0, NULL, 0, '2013-06-12 10:55:02');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE IF NOT EXISTS `shipping_method` (
  `id` tinyint(1) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `availability` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`id`, `name`, `availability`) VALUES
(1, 'EMS¿ìµÝ', 1),
(2, 'ÆÕÍ¨ÓÊ¼Ä', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_product`
--
ALTER TABLE `cart_product`
  ADD CONSTRAINT `customer` FOREIGN KEY (`CustomerId`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `productsid` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `orders` FOREIGN KEY (`OrderID`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `product` FOREIGN KEY (`ProductID`) REFERENCES `product` (`ProductID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `customerid` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`);

--
-- Constraints for table `order_product`
--
ALTER TABLE `order_product`
  ADD CONSTRAINT `OrderId` FOREIGN KEY (`OrderId`) REFERENCES `orders` (`OrderID`),
  ADD CONSTRAINT `ProductId` FOREIGN KEY (`ProductId`) REFERENCES `product` (`ProductID`);
