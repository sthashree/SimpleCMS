-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 08, 2010 at 03:14 PM
-- Server version: 5.1.36
-- PHP Version: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db_construction`
--
CREATE DATABASE `db_construction` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `db_construction`;

-- --------------------------------------------------------

--
-- Table structure for table `con_actual_item_cost`
--

CREATE TABLE IF NOT EXISTS `con_actual_item_cost` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `parent_id` int(255) NOT NULL,
  `comp` varchar(255) NOT NULL,
  `month` int(255) NOT NULL,
  `amount` double NOT NULL,
  `project_id` int(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=233 ;

--
-- Dumping data for table `con_actual_item_cost`
--

INSERT INTO `con_actual_item_cost` (`id`, `parent_id`, `comp`, `month`, `amount`, `project_id`) VALUES
(175, 8, 'gyyyy', 2, 4000, 1),
(176, 8, 'gyyyy', 3, 10000, 1),
(177, 8, 'gyyyy', 4, 8000, 1),
(178, 8, 'gyyyy', 5, 9000, 1),
(179, 9, 'ram', 2, 6700, 1),
(180, 9, 'ram', 3, 67, 1),
(181, 9, 'ram', 4, 67, 1),
(182, 9, 'ram', 5, 89, 1),
(183, 9, 'test', 2, 4000, 1),
(184, 9, 'test', 3, 3000, 1),
(185, 9, 'test', 4, 6000, 1),
(186, 1, 'cds', 2, 231, 1),
(187, 1, 'cds', 3, 899, 1),
(188, 1, 'cds', 4, 90, 1),
(189, 1, 'cds', 5, 90, 1),
(215, 7, 'teisokhu', 8, 23000, 7),
(216, 7, 'teisokhu', 9, 1200, 7),
(217, 7, 'teisokhu', 10, 780000, 7),
(218, 7, 'tongkachu', 8, 6000000, 7),
(219, 7, 'tongkachu', 9, 1200000, 7),
(220, 8, 'tempura', 8, 67000, 7),
(221, 8, 'tempura', 9, 90000, 7),
(222, 7, 'teisokhu', 8, 23000, 7),
(223, 7, 'teisokhu', 9, 1200, 7),
(224, 7, 'teisokhu', 10, 780000, 7),
(225, 7, 'tongkachu', 8, 6000000, 7),
(226, 7, 'tongkachu', 9, 1200000, 7),
(227, 8, 'tempura', 8, 67000, 7),
(228, 8, 'tempura', 9, 90000, 7),
(229, 9, '', 8, 12000, 7),
(230, 1, 'hongachu', 8, 12000, 7),
(231, 1, 'hongachu', 9, 89900, 7),
(232, 1, 'hongachu', 10, 8000, 7);

-- --------------------------------------------------------

--
-- Table structure for table `con_actual_material_heading`
--

CREATE TABLE IF NOT EXISTS `con_actual_material_heading` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `parent_id` int(100) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `companies` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=45 ;

--
-- Dumping data for table `con_actual_material_heading`
--

INSERT INTO `con_actual_material_heading` (`id`, `title`, `parent_id`, `level`, `companies`, `updated_date`) VALUES
(41, 'Gakkuso', 0, 0, '', '2010-08-05 23:23:19'),
(42, 'hello', 0, 0, '', '2010-08-05 23:23:19');

-- --------------------------------------------------------

--
-- Table structure for table `con_additional_cost`
--

CREATE TABLE IF NOT EXISTS `con_additional_cost` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `project_id` int(100) NOT NULL,
  `title` varchar(255) NOT NULL,
  `additional_amount` double NOT NULL,
  `tax` int(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `con_additional_cost`
--

INSERT INTO `con_additional_cost` (`id`, `project_id`, `title`, `additional_amount`, `tax`, `updated_date`) VALUES
(11, 1, '', 0, 0, '2010-08-05 22:16:25'),
(2, 2, '', 0, 0, '2010-08-02 15:06:13'),
(4, 3, '', 0, 0, '2010-08-04 20:05:57'),
(5, 4, '', 0, 0, '2010-08-05 12:15:18'),
(6, 5, '', 0, 0, '2010-08-05 12:17:33'),
(7, 6, '', 0, 0, '2010-08-05 15:48:31'),
(12, 7, '', 0, 0, '2010-08-07 15:09:58'),
(19, 8, '', 0, 0, '2010-08-08 15:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `con_address`
--

CREATE TABLE IF NOT EXISTS `con_address` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `parent_id` int(100) NOT NULL,
  `label` int(100) NOT NULL,
  `published` tinyint(100) NOT NULL,
  `updated_date` date NOT NULL,
  `alias` varchar(255) CHARACTER SET utf8 NOT NULL,
  `description` text CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=36 ;

--
-- Dumping data for table `con_address`
--

INSERT INTO `con_address` (`id`, `name`, `parent_id`, `label`, `published`, `updated_date`, `alias`, `description`) VALUES
(12, 'vbjxb', 2, 2, 1, '2010-07-19', 'vbjxb', 'BVCDMXDVCX'),
(35, '開軍２丁目地内', 34, 2, 1, '2010-08-08', '開軍２丁目地内', ''),
(34, '稚内', 1, 1, 0, '2010-08-08', '稚内', ''),
(13, 'hbkjcd', 0, 2, 1, '2010-07-19', 'hbkjcd', 'vdfvdvd'),
(14, 'vcxvcxvxcvcx', 7, 2, 1, '2010-07-19', 'vcxvcxvxcvcx', 'vcx'),
(16, 'y65464564564564', 0, 2, 1, '2010-07-19', 'y65464564564564', 'vcxvxcvcx'),
(1, '北海道', 0, 0, 0, '2010-08-08', '圗海道', ''),
(32, '東京', 0, 0, 0, '2010-08-08', '東京', ''),
(26, 'testy', 0, 2, 1, '2010-07-19', 'testy', 'fsdfsdfsd'),
(27, 'fdsfsdfsdfsd', 0, 2, 1, '2010-07-19', 'fdsfsdfsdfsd', 'fsdfds'),
(28, 'postal56vvvvv', 24, 2, 1, '2010-07-19', 'postal56vvvvv', 'xcvxcvcx'),
(29, 'vdsfsdf', 23, 2, 1, '2010-07-19', 'vdsfsdf', 'fdsfsdfsd'),
(33, '青森', 0, 0, 0, '2010-08-08', '青森', ''),
(2, '稚内', 0, 1, 0, '2010-08-08', '稚内', '');

-- --------------------------------------------------------

--
-- Table structure for table `con_costs`
--

CREATE TABLE IF NOT EXISTS `con_costs` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `project_id` int(100) NOT NULL,
  `tender_subtotal` int(100) NOT NULL,
  `additional_subtotal` int(100) NOT NULL,
  `subtotal` int(100) NOT NULL,
  `subtotal_tax` int(100) NOT NULL,
  `item_total` int(255) NOT NULL,
  `total_tax` int(255) NOT NULL,
  `actual` tinyint(10) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `con_costs`
--

INSERT INTO `con_costs` (`id`, `project_id`, `tender_subtotal`, `additional_subtotal`, `subtotal`, `subtotal_tax`, `item_total`, `total_tax`, `actual`, `modified_date`) VALUES
(19, 8, 11760000, 0, 11200000, 0, 3199100, 0, 0, '2010-08-08 15:55:12');

-- --------------------------------------------------------

--
-- Table structure for table `con_item_cost`
--

CREATE TABLE IF NOT EXISTS `con_item_cost` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `project_id` int(100) NOT NULL,
  `item_id` int(100) NOT NULL,
  `item_company` int(100) NOT NULL,
  `item_amount` double NOT NULL,
  `item_purchase_date` date NOT NULL,
  `actual` tinyint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98 ;

--
-- Dumping data for table `con_item_cost`
--

INSERT INTO `con_item_cost` (`id`, `project_id`, `item_id`, `item_company`, `item_amount`, `item_purchase_date`, `actual`) VALUES
(97, 8, 0, 0, 0, '0000-00-00', 0),
(96, 8, 0, 0, 0, '0000-00-00', 0),
(95, 8, 65, 0, 1500000, '0000-00-00', 0),
(94, 8, 0, 0, 0, '0000-00-00', 0),
(93, 8, 41, 0, 20000, '0000-00-00', 0),
(92, 8, 40, 2, 400000, '0000-00-00', 0),
(91, 8, 38, 1, 80000, '0000-00-00', 0),
(90, 8, 0, 0, 0, '0000-00-00', 0),
(89, 8, 55, 0, 238000, '0000-00-00', 0),
(88, 8, 37, 2, 926900, '0000-00-00', 0),
(87, 8, 39, 1, 34200, '0000-00-00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `con_material_heading`
--

CREATE TABLE IF NOT EXISTS `con_material_heading` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `parent_id` int(100) NOT NULL,
  `level` int(11) NOT NULL DEFAULT '0',
  `companies` varchar(255) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `con_material_heading`
--

INSERT INTO `con_material_heading` (`id`, `title`, `parent_id`, `level`, `companies`, `updated_date`) VALUES
(60, '保温', 1, 1, 'モリ,安藤,星', '2010-08-08 15:20:44'),
(8, '機器類', 0, 0, '', '2010-07-19 18:18:31'),
(9, '材料費', 0, 0, '', '2010-07-19 18:18:31'),
(59, 'バルブ類', 9, 1, '三立,工機,太平洋', '2010-08-08 15:20:44'),
(56, '衛星器具', 8, 1, '', '2010-08-08 15:03:42'),
(42, '水道', 1, 1, '三立,工機,太平洋', '2010-08-08 08:54:05'),
(41, '官・　手', 9, 1, '三立,工機,太平洋', '2010-08-08 08:46:05'),
(1, '外注費', 100, 0, '', '2010-08-07 14:38:11'),
(40, '官', 9, 1, '三立,工機,太平洋', '2010-07-19 19:46:24'),
(39, 'ポンプ類', 8, 1, '三立,工機,太平洋', '2010-07-19 19:46:12'),
(38, '支持・金物', 9, 1, '三立,工機,太平洋', '2010-07-19 18:26:32'),
(37, '冷房', 8, 1, '三立,工機,太平洋', '2010-07-19 18:26:32'),
(57, '排水金物', 8, 1, '三立,工機,太平洋', '2010-08-08 15:03:42'),
(58, '労務費', 0, 0, '', '2010-08-08 15:03:42'),
(54, '仮説費', 0, 0, '', '2010-08-08 14:58:45'),
(55, '喚気送風機', 8, 1, '三立,工機,太平洋', '2010-08-08 15:03:42'),
(53, '経費', 0, 0, '', '2010-08-08 14:56:42'),
(61, 'プレハブ', 54, 1, '', '2010-08-08 15:20:44'),
(62, '自社', 53, 1, '', '2010-08-08 15:20:44'),
(63, '消耗・雑材', 9, 1, '三立,工機,太平洋', '2010-08-08 15:46:26'),
(64, 'ダクト', 1, 1, '', '2010-08-08 15:46:26'),
(65, '自社', 58, 1, '', '2010-08-08 15:54:23'),
(66, '外注', 58, 1, '', '2010-08-08 15:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `con_production_company`
--

CREATE TABLE IF NOT EXISTS `con_production_company` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `item_id` int(100) NOT NULL,
  `company` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `con_production_company`
--


-- --------------------------------------------------------

--
-- Table structure for table `con_project`
--

CREATE TABLE IF NOT EXISTS `con_project` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location_id` int(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `contract_date` varchar(255) NOT NULL,
  `project_code` varchar(255) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `project_amount` double NOT NULL,
  `tax` double NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `incharge` varchar(255) NOT NULL,
  `incharge_post` varchar(255) NOT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `success` tinyint(10) NOT NULL DEFAULT '0',
  `type_id` tinyint(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `con_project`
--

INSERT INTO `con_project` (`id`, `name`, `location_id`, `street`, `owner`, `contract_date`, `project_code`, `start_time`, `end_time`, `project_amount`, `tax`, `contact_person`, `incharge`, `incharge_post`, `invoice_no`, `success`, `type_id`) VALUES
(8, '稚内港港港環境設備', 12, 'this is test', '', '2010/06/25', 'No 30', '2010/07/02', '2010/12/25', 11200000, 560000, '', '', '', '10KK006', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `con_total_cost`
--

CREATE TABLE IF NOT EXISTS `con_total_cost` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `project_id` int(100) NOT NULL,
  `project_cost` double NOT NULL,
  `actual` tinyint(10) NOT NULL,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `con_total_cost`
--


-- --------------------------------------------------------

--
-- Table structure for table `con_users`
--

CREATE TABLE IF NOT EXISTS `con_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `middlename` varchar(255) CHARACTER SET utf8 NOT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(45) DEFAULT NULL,
  `enabled` tinyint(4) DEFAULT '0',
  `date_joined` date DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_id` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `published` tinyint(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_type` (`user_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `con_users`
--

INSERT INTO `con_users` (`id`, `firstname`, `middlename`, `lastname`, `email`, `phone`, `mobile`, `address`, `file`, `photo`, `username`, `password`, `enabled`, `date_joined`, `modified_date`, `user_id`, `user_type`, `published`) VALUES
(15, 'shree', 'krishna', 'shrestha', '', NULL, NULL, NULL, NULL, NULL, 'admin', '21232f297a57a5a743894a0e4a801fc3', 0, NULL, '2010-07-18 07:47:49', NULL, 1, 0);
