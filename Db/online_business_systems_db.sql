-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2014 at 05:54 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `online_business_systems_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_cv`
--

CREATE TABLE IF NOT EXISTS `user_cv` (
  `username` varchar(20) NOT NULL,
  `cv_file_path` varchar(500) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_cv`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE IF NOT EXISTS `user_login` (
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(45) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_login`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_profile_details`
--

CREATE TABLE IF NOT EXISTS `user_profile_details` (
  `username` varchar(20) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `address_line1` varchar(60) NOT NULL,
  `country` varchar(30) NOT NULL,
  `email` varchar(45) NOT NULL,
  `address_line2` varchar(60) DEFAULT NULL,
  `picture_file_path` varchar(500) DEFAULT NULL,
  `contact_number` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_profile_details`
--


-- --------------------------------------------------------

--
-- Table structure for table `user_project`
--

CREATE TABLE IF NOT EXISTS `user_project` (
  `username` varchar(20) NOT NULL,
  `project_file_path` varchar(500) NOT NULL,
  `project_description` varchar(250) NOT NULL,
  `project_file_title` varchar(100) NOT NULL,
  PRIMARY KEY (`username`,`project_file_title`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_project`
--

