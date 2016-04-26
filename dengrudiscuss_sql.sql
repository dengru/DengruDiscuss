-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 29, 2014 at 11:18 AM
-- Server version: 5.5.34-0ubuntu0.12.10.1
-- PHP Version: 5.4.6-1ubuntu1.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dengrudiscuss`
--

-- --------------------------------------------------------

--
-- Table structure for table `dd_categories`
--

CREATE TABLE IF NOT EXISTS `dd_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(20) NOT NULL,
  `cat_description` tinytext NOT NULL,
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `dd_posts`
--

CREATE TABLE IF NOT EXISTS `dd_posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_createdon` timestamp NULL DEFAULT NULL,
  `post_modifiedon` timestamp NULL DEFAULT NULL,
  `post_createdby` varchar(20) NOT NULL,
  `post_modifiedby` varchar(20) DEFAULT NULL,
  `thread_id` int(11) NOT NULL,
  `post_content` longtext NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `thread_id` (`thread_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

--
-- Table structure for table `dd_threads`
--

CREATE TABLE IF NOT EXISTS `dd_threads` (
  `thread_id` int(11) NOT NULL AUTO_INCREMENT,
  `thread_name` varchar(75) NOT NULL,
  `thread_createdon` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `thread_createdby` varchar(20) NOT NULL,
  `cat_id` int(11) NOT NULL,
  PRIMARY KEY (`thread_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Table structure for table `dd_users`
--

CREATE TABLE IF NOT EXISTS `dd_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `country` varchar(15) DEFAULT NULL,
  `role` enum('1','2') NOT NULL DEFAULT '2',
  `password` varchar(256) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
