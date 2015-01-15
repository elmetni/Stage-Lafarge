-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- المزود: localhost
-- أنشئ في: 17 سبتمبر 2012 الساعة 08:54
-- إصدارة المزود: 5.5.24-log
-- PHP إصدارة: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- قاعدة البيانات: `intervention`
--

-- --------------------------------------------------------

--
-- بنية الجدول `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id_item` int(11) NOT NULL AUTO_INCREMENT,
  `name_item` varchar(255) NOT NULL,
  `image_item` text NOT NULL,
  `quantity_item` int(11) NOT NULL,
  `description` text NOT NULL,
  `time_item` datetime NOT NULL,
  `type_item` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id_item`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

-- --------------------------------------------------------

--
-- بنية الجدول `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id_message` int(11) NOT NULL AUTO_INCREMENT,
  `id_sender` int(11) NOT NULL,
  `id_reciever` int(11) NOT NULL,
  `value_message` text NOT NULL,
  `title_message` varchar(255) NOT NULL,
  `time_message` datetime NOT NULL,
  `statue_message` varchar(255) NOT NULL,
  `repeat_title` varchar(255) NOT NULL,
  PRIMARY KEY (`id_message`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- بنية الجدول `read_message`
--

CREATE TABLE IF NOT EXISTS `read_message` (
  `id_read` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_message` int(11) NOT NULL,
  PRIMARY KEY (`id_read`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- بنية الجدول `request`
--

CREATE TABLE IF NOT EXISTS `request` (
  `id_request` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantity_request` int(11) NOT NULL,
  `time_request` datetime NOT NULL,
  `statue_request` varchar(255) NOT NULL,
  `comment_request` text NOT NULL,
  `time_answer` datetime NOT NULL,
  `detail_answer` text NOT NULL,
  `statue_sender` varchar(255) NOT NULL,
  PRIMARY KEY (`id_request`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=51 ;

-- --------------------------------------------------------

--
-- بنية الجدول `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type_account` varchar(255) NOT NULL,
  `statue_account` varchar(255) NOT NULL,
  `picture_user` text NOT NULL,
  `nm` varchar(255) NOT NULL,
  `fonction` varchar(255) NOT NULL,
  `departement` varchar(255) NOT NULL,
  `first` varchar(255) NOT NULL,
  `last` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- إرجاع أو استيراد بيانات الجدول `user`
--

INSERT INTO `user` (`id_user`, `login`, `password`, `type_account`, `statue_account`, `picture_user`, `nm`, `fonction`, `departement`, `first`, `last`, `telephone`, `email`) VALUES
(8, 'hamza', '12345678', 'administrator', 'enable', 'user/hamza_elmetni_2012_09_17_08_54_L774FE5.png', 'L774FE5', 'eleve ingenieur', 'informatique', 'hamza', 'elmetni', '0626814298', 'elmetni.hamza@gmail.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
