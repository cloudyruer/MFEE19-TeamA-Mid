-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-08-13 23:30:56
-- 伺服器版本： 10.4.20-MariaDB
-- PHP 版本： 7.4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫: `team_project`
--
CREATE DATABASE IF NOT EXISTS `team_project` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `team_project`;

-- --------------------------------------------------------

--
-- 資料表結構 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `account` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT '',
  `mobile` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `nickname` varchar(255) NOT NULL,
  `create_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `members`
--

INSERT INTO `members` (`id`, `account`, `password`, `email`, `avatar`, `mobile`, `address`, `birthday`, `nickname`, `create_at`) VALUES
(1, 'emma', '$2y$10$pC96RzqUO3uvh16bPuhVF.go3wYTCW9dJ4mGP4n7qzn2NzL4orvtm', 'emma@emma.com', '', NULL, 'password:001(NULL)', NULL, 'EMMA', '2021-08-08 22:19:18'),
(2, 'tommy', '$2y$10$wJUS/FgZAN5UTyVNZu1b0eOrrTYyWbUGGpIkXJ01cSaz1DwNxgGSi', 'tommy@tommy.com', '', NULL, 'password:002(NULL)', NULL, 'TOMMY', '2021-08-09 22:20:15'),
(3, 'joey', '$2y$10$cgwAexTbJFAw3povztTSmeWKRHuFoTN6DZiD3bLXORwq7Nt/N8bJO', 'joey@joey.com', '', NULL, 'password:004(NULL)', NULL, 'JOEY', '2021-08-10 22:23:57'),
(4, 'li', '$2y$10$.khoshs..4.c2ErMmVKLyuDvQuzBpN3AvaE5u9tg21G1SA2sHOFGW', 'li@li.com', '', NULL, 'password:009(NULL)', NULL, 'LI', '2021-08-11 22:23:57'),
(5, 'henry', '$2y$10$qA5cLE73LkaZy5XVFlMUpOjhQaghnFiAaW29wQQCv67pZMGZDdMj2', 'henry@henry.com', '', NULL, 'password:019(NULL)', NULL, 'HENRY', '2021-08-12 22:23:57'),
(6, 'leo', '$2y$10$Im251ewHZ0m5i/I.FqU/duJBwylEQEdhCMz6wBLBC0bQF8QRZc7We', 'leo@leo.com', '', NULL, 'password:033(NULL)', NULL, 'LEO', '2021-08-13 22:23:57'),
(7, 'pikachu', '$2y$10$4MHdK9/HNTasXOuJAaodrejXCWnra4OUsuY0egw.Je1A..7A.COA2', 'pika@pika.com', 'de879ff42791bdc32631fac784f698ab43e7adb6.jpg', NULL, NULL, NULL, '很秋', '2021-08-13 23:01:29');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
