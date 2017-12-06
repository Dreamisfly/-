-- phpMyAdmin SQL Dump
-- http://www.phpmyadmin.net
--
-- 生成日期: 2013 年 10 月 19 日 19:54

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `PDqnCKpUpgeUoTKdoOau`
--

-- --------------------------------------------------------

--
-- 表的结构 `tbl_music`
--

CREATE TABLE IF NOT EXISTS `tbl_music` (
  `music_id` int(11) NOT NULL,
  `music_name` varchar(40) NOT NULL,
  `music_singer` varchar(40) NOT NULL,
  `music_lrc` text NOT NULL,
  PRIMARY KEY (`music_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `tbl_music`
--

INSERT INTO `tbl_music` (`music_id`, `music_name`, `music_singer`, `music_lrc`) VALUES
(10001, 'Far Away From Home', 'Groove Coverage', 'far away from home'),
(10002, 'The Dawn', 'Dreamtale', 'the dawn'),
(20002, '董小姐', '宋冬野', '董小姐'),
(20001, '左边', '杨丞琳', '左边');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
