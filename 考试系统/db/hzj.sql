-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017 年 05 月 24 日 00:28
-- 服务器版本: 5.5.24-log
-- PHP 版本: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `huzejun`
--
CREATE DATABASE `huzejun` DEFAULT CHARACTER SET gbk COLLATE gbk_chinese_ci;
USE `huzejun`;

-- --------------------------------------------------------

--
-- 表的结构 `answer_paper`
--

CREATE TABLE IF NOT EXISTS `answer_paper` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `studentid` varchar(8) NOT NULL COMMENT '学号',
  `paper_id` int(10) unsigned NOT NULL COMMENT '试卷号',
  `select_question_id` int(10) unsigned NOT NULL COMMENT '题号',
  `answer` varchar(100) DEFAULT NULL COMMENT '选择状态',
  `memo` varchar(32) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `INDEX_QUESTION_ID` (`select_question_id`) USING BTREE,
  KEY `INDEX_PAPER_ID` (`paper_id`),
  KEY `INDEX_S_ID` (`studentid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=190 ;

--
-- 转存表中的数据 `answer_paper`
--

INSERT INTO `answer_paper` (`id`, `studentid`, `paper_id`, `select_question_id`, `answer`, `memo`) VALUES
(188, '07160801', 20, 12, 'a:3:{i:45;i:1;i:46;i:1;i:48;i:1;}', NULL),
(189, '07160801', 20, 13, 'a:3:{i:49;i:1;i:50;i:1;i:51;i:1;}', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `paper`
--

CREATE TABLE IF NOT EXISTS `paper` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(100) NOT NULL COMMENT '试卷名',
  `subject` varchar(50) NOT NULL COMMENT '科目',
  `total` int(11) NOT NULL COMMENT '总题量',
  `content` text NOT NULL COMMENT '内容',
  `memo` varchar(50) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- 转存表中的数据 `paper`
--

INSERT INTO `paper` (`id`, `name`, `subject`, `total`, `content`, `memo`) VALUES
(20, '2016-2017-2 php期末考试卷', 'php', 2, '12,13', '');

-- --------------------------------------------------------

--
-- 表的结构 `score`
--

CREATE TABLE IF NOT EXISTS `score` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `studentId` varchar(8) CHARACTER SET utf8 NOT NULL,
  `test_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `subject` varchar(50) CHARACTER SET utf8 NOT NULL,
  `paper_id` int(10) unsigned NOT NULL COMMENT '试卷id',
  `mark` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index3_student_id` (`studentId`),
  KEY `index4_paper_id` (`paper_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=gbk AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `score`
--

INSERT INTO `score` (`id`, `studentId`, `test_name`, `subject`, `paper_id`, `mark`) VALUES
(13, '07160801', '2016-2017-2 php期末考试卷', 'php', 20, 0);

-- --------------------------------------------------------

--
-- 表的结构 `select_item`
--

CREATE TABLE IF NOT EXISTS `select_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `select_question_id` int(10) unsigned NOT NULL COMMENT '选择题号',
  `isanswer` tinyint(1) NOT NULL COMMENT '是否答案',
  `content` varchar(100) NOT NULL COMMENT '选项',
  `memo` varchar(32) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `INDEX_QUESTION_ID` (`select_question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=gbk AUTO_INCREMENT=53 ;

--
-- 转存表中的数据 `select_item`
--

INSERT INTO `select_item` (`id`, `select_question_id`, `isanswer`, `content`, `memo`) VALUES
(45, 12, 1, '数组包括一维数组和多维数组', NULL),
(46, 12, 1, '数组包括数值数组和关联数组', NULL),
(47, 12, 0, '数值数组一下标为数字，最小下标为1', NULL),
(48, 12, 1, '关联数组的可以用foreach进行遍历', NULL),
(49, 13, 1, 'for循环', NULL),
(50, 13, 1, 'while循环', NULL),
(51, 13, 1, 'foreach循环', NULL),
(52, 13, 0, 'switch循环', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `select_question`
--

CREATE TABLE IF NOT EXISTS `select_question` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `subject` varchar(50) NOT NULL COMMENT '科目',
  `type` varchar(4) NOT NULL COMMENT '单多',
  `title` varchar(200) NOT NULL COMMENT '题目',
  `memo` varchar(50) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `select_question`
--

INSERT INTO `select_question` (`id`, `subject`, `type`, `title`, `memo`) VALUES
(12, 'php', '多', '有关数组说法中正确的是：', NULL),
(13, 'php', '多', '循环种类包括哪些？', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `studentId` varchar(8) NOT NULL,
  `name` varchar(20) NOT NULL,
  `className` varchar(20) NOT NULL,
  `birthday` date NOT NULL,
  `sex` char(1) NOT NULL DEFAULT '男',
  `nation` varchar(10) NOT NULL,
  `password` varchar(40) DEFAULT NULL COMMENT '密码',
  PRIMARY KEY (`id`),
  UNIQUE KEY `INDEX_STUDENT_ID` (`studentId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- 转存表中的数据 `student`
--

INSERT INTO `student` (`id`, `studentId`, `name`, `className`, `birthday`, `sex`, `nation`, `password`) VALUES
(1, '07160801', '张三', '软件1608', '2000-01-01', '男', '汉族', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(3, '07160802', '无奇不有', '软件班', '2013-04-22', '男', '汉族', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(6, '07160606', '四四', '软件1606', '1996-12-31', '女', '高山族', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(7, '07160699', '张张张张', '软件1606', '1999-09-09', '男', '汉', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(8, '07160698', '出现了', '软件1606', '1998-09-09', '女', '回', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(9, '07160697', '耍花枪', '软件1606', '1997-04-04', '男', '汉', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(10, '07160696', '于在古', '软件1606', '1666-06-06', '男', '汉', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(11, '07160695', '逻辑思维', '软件1606', '1999-09-09', '女', '汉', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(12, '07160694', '丌苦', '软件1606', '1999-09-09', '女', '汉', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8'),
(13, '07160693', '徐城枯', '软件1606', '1999-09-09', '男', '汉', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8');

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL,
  `password` varchar(48) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `status`) VALUES
(1, 'a', '86f7e437faa5a7fce15d1ddcb9eaeaea377667b8', 0),
(2, 'rrr', '8578173555a47d4ea49e697badfda270dee0858f', 1);

--
-- 限制导出的表
--

--
-- 限制表 `answer_paper`
--
ALTER TABLE `answer_paper`
  ADD CONSTRAINT `answer_paper_ibfk_1` FOREIGN KEY (`select_question_id`) REFERENCES `select_question` (`id`),
  ADD CONSTRAINT `answer_paper_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`id`),
  ADD CONSTRAINT `answer_paper_ibfk_3` FOREIGN KEY (`studentid`) REFERENCES `student` (`studentId`);

--
-- 限制表 `score`
--
ALTER TABLE `score`
  ADD CONSTRAINT `score_ibfk_1` FOREIGN KEY (`studentId`) REFERENCES `student` (`studentId`),
  ADD CONSTRAINT `score_ibfk_2` FOREIGN KEY (`paper_id`) REFERENCES `paper` (`id`);

--
-- 限制表 `select_item`
--
ALTER TABLE `select_item`
  ADD CONSTRAINT `select_item_ibfk_1` FOREIGN KEY (`select_question_id`) REFERENCES `select_question` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
