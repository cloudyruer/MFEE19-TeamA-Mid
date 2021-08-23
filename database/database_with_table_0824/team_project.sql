-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2021-08-24 00:06:17
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
-- 資料表結構 `account_address`
--

CREATE TABLE `account_address` (
  `id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `consignee` varchar(255) NOT NULL,
  `mobile` varchar(255) NOT NULL,
  `post_code` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `account_address`
--

INSERT INTO `account_address` (`id`, `members_id`, `consignee`, `mobile`, `post_code`, `address`) VALUES
(1, 1, '陳緯霖', '0912345678', '116', '台北市'),
(2, 2, '黃彥銘', '0912345678', '116', '新北市'),
(3, 3, '周育弘', '0912345678', '116', '桃園市'),
(4, 4, '李紫蓉', '0912345678', '116', '新竹市'),
(5, 5, '劉明鑫', '0912345678', '116', '台中市'),
(6, 6, '廖采揚', '0912345678', '116', '高雄市'),
(8, 7, 'pikachu', '0988345678', '242', '屏東縣');

-- --------------------------------------------------------

--
-- 資料表結構 `account_ranking`
--

CREATE TABLE `account_ranking` (
  `id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `orders_amount` int(11) NOT NULL,
  `ranking` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `account_ranking`
--

INSERT INTO `account_ranking` (`id`, `members_id`, `orders_amount`, `ranking`) VALUES
(1, 1, 1000, 2),
(2, 2, 2694, 3),
(3, 3, 850, 1),
(4, 4, 2230, 3),
(5, 5, 2240, 3),
(6, 6, 820, 1),
(7, 7, 3300, 4);

-- --------------------------------------------------------

--
-- 資料表結構 `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `nick_name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL,
  `last_modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `blog`
--

INSERT INTO `blog` (`id`, `author`, `nick_name`, `title`, `content`, `created_at`, `last_modified`) VALUES
(1, '林漢娜', 'Hana', '穿過就回不去！五雙超強『回購款神鞋』，快來看看你鞋櫃那雙上榜沒？', '大家會不會跟編輯一樣，有囤貨的習慣呢？許多東西只要好用、好穿，一定會一次再多買個幾雙或是幾份，以免之後買不到的時候很慌張，而鞋子雖然不能囤貨，不過總會有幾雙超百搭的款式，讓人穿爛之後還想繼續買，因為就是沒有鞋款可以取代它呀！今天編輯就要來盤點五雙回購款神鞋，大家也可以看看自己鞋櫃裡的那雙是否上榜啦！\r\nConverse 1970\r\n看到這雙上榜大家應該一點都不意外吧？經典的1970到底誰不會再回購啦！編輯自己光是黑色款，鞋櫃裡就有兩雙，因為穿爛了還捨不得丟啊（笑）百搭的1970不管是什麼顏色都非常百搭，而且不侷限穿搭的風格，就算穿正裝還是好Fashion啦～如果還沒入手這雙的你，編輯真的是要打屁股啦！\r\nVans Old School\r\n雖然這雙真的是紅了好長一段時間，但是大家對於這雙的愛好度可是一點也沒有少吧？只要稍微率性一點、有個性的妹子應該人腳一雙吧！編輯自己也是這雙的中毒者，黑色的款式完全不用怕髒，而且平底的設計又非常舒適好走，一點也不用怕走久了之後腳會酸的問題，側邊的logo經典又不會太繁複，實搭程度絕對可以對得上回購款神鞋這個名字！', '2021-08-15 09:42:48', '2021-08-15 09:42:48'),
(2, '李梓軒', 'Abi', '最佛心『球鞋系列』懶人包！50+款式、20+穿搭技巧，連代購推薦也都有！', '各位水水們，球鞋這東西是不是真的每出一季新款，就很容易燒到大家體無完膚？但是太多款式到底該買哪一雙？自己用google搜尋又很麻煩，常常搜尋完又忘記！沒關係，今天這個困擾就讓穿搭編來解決！精心整理了所以妳們愛的球鞋懶人包，款式、穿搭技巧、代購推薦通通有，趕快看下去！\r\n球鞋推薦篇一：\r\n身為時尚又潮流的水水們，球鞋一定是穿搭必備的單品！了解時下球鞋趨勢，更是時髦水水們必須知道的事情！如果要問妳們2021年最韓球鞋是什麼，你知道會是哪些款式進入排行榜嗎？不知道的話也沒關係，穿搭編幫你們找到了專業人士來解答「2021年五雙韓妞都在穿的球鞋」，想知道有哪五雙快看下去！\r\n\r\n各位水水們，球鞋這東西是不是真的每出一季新款，就很容易燒到大家體無完膚？但是太多款式到底該買哪一雙？自己用google搜尋又很麻煩，常常搜尋完又忘記！沒關係，今天這個困擾就讓穿搭編來解決！精心整理了所以妳們愛的球鞋懶人包，款式、穿搭技巧、代購推薦通通有，趕快看下去！\r\n還只會穿Converse？2021最省預算的「Vans穿搭範本」，12套搭配公式教給你！\r\n球鞋推薦篇一：\r\n身為時尚又潮流的水水們，球鞋一定是穿搭必備的單品！了解時下球鞋趨勢，更是時髦水水們必須知道的事情！如果要問妳們2021年最韓球鞋是什麼，你知道會是哪些款式進入排行榜嗎？不知道的話也沒關係，穿搭編幫你們找到了專業人士來解答「2021年五雙韓妞都在穿的球鞋」，想知道有哪五雙快看下去！\r\n歐膩們都在穿！2021韓妞最愛的球鞋排行榜TOP 5，現在入手還來得及！\r\n球鞋推薦篇二：\r\n女孩們真的鞋櫃無時無刻都少一雙鞋呀！除了帆布鞋、馬丁、襪靴，球鞋更是百百種，今天想走復古還是時髦感，要挑哪雙好煩惱～穿搭編都聽到大家的心聲了，今天就要在這裡跟妳們分享「2021超時髦的15款球鞋穿搭」，無論走什麼風格，都能找到命定款，快接著看下去吧！', '2021-08-15 09:49:04', '2021-08-15 09:49:04');

-- --------------------------------------------------------

--
-- 資料表結構 `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'NIKE'),
(2, 'PUMA'),
(3, 'New Balance'),
(4, 'Arc\'teryx'),
(5, 'SALOMON'),
(6, 'adidas');

-- --------------------------------------------------------

--
-- 資料表結構 `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `parents_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `categories`
--

INSERT INTO `categories` (`id`, `name`, `parents_id`) VALUES
(1, '男鞋', 0),
(2, '女鞋', 0),
(3, '其他商品', 0),
(4, '慢跑鞋', 1),
(5, '球類運動鞋', 1),
(6, '休閒鞋', 1),
(7, '登山鞋', 1),
(8, '靴子', 1),
(9, '慢跑鞋', 2),
(10, '球類運動鞋', 2),
(11, '休閒鞋', 2),
(12, '登山鞋', 2),
(13, '靴子', 2),
(14, '背包', 3),
(15, '帽子', 3);

-- --------------------------------------------------------

--
-- 資料表結構 `geo_info`
--

CREATE TABLE `geo_info` (
  `id` int(11) NOT NULL COMMENT 'auto',
  `members_id` int(11) NOT NULL COMMENT 'foreign',
  `lat` decimal(8,6) NOT NULL COMMENT '##.######(緯度)',
  `lng` decimal(9,6) NOT NULL COMMENT '###.######(經度)',
  `city` varchar(255) NOT NULL,
  `locality` varchar(255) NOT NULL,
  `activity_type` varchar(255) NOT NULL,
  `activity_detail` varchar(255) NOT NULL,
  `start_time` datetime DEFAULT NULL COMMENT '大專新增或等有空',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'auto',
  `changed_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'auto',
  `valid` int(11) NOT NULL DEFAULT 1 COMMENT '1=有效;0=無效(auto default)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 資料表結構 `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `products_sid` int(11) NOT NULL,
  `fileName` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `images`
--

INSERT INTO `images` (`id`, `products_sid`, `fileName`) VALUES
(1, 1, 'nike01pink (1).jpeg'),
(2, 1, 'nike01pink (1).png'),
(3, 1, 'nike01pink (3).png'),
(4, 1, 'nike01pink (4).png'),
(5, 1, 'nike01pink (5).png'),
(6, 2, 'nike01gray (1).jpeg'),
(7, 2, 'nike01gray(2).png'),
(8, 2, 'nike01gray(3).png'),
(9, 2, 'nike01gray(4).png'),
(10, 2, 'nike01gray(5).png'),
(11, 3, 'nike01white(1).png'),
(12, 3, 'nike01white(2).png'),
(13, 3, 'nike01white(3).png'),
(14, 3, 'nike01white(4).png'),
(15, 3, 'nike01white(5).png'),
(16, 4, 'nb01orange (1).jpg'),
(17, 4, 'nb01orange (2).jpg'),
(18, 4, 'nb01orange (3).jpg'),
(19, 4, 'nb01orange (4).jpg'),
(20, 4, 'nb01orange (5).jpg'),
(21, 5, 'nb01black (1).jpg'),
(22, 5, 'nb01black (2).jpg'),
(23, 5, 'nb01black (3).jpg'),
(24, 5, 'nb01black (4).jpg'),
(25, 5, 'nb01black (5).jpg'),
(26, 6, 'nb01red (1).jpg'),
(27, 6, 'nb01red (2).jpg'),
(28, 6, 'nb01red (3).jpg'),
(29, 6, 'nb01red (4).jpg'),
(30, 6, 'nb01red (5).jpg'),
(37, 43, 'DSCN3669.JPG.jpg'),
(42, 50, 'pexels-mnz-1598505.jpg.jpg'),
(44, 52, 'pexels-ketut-subiyanto-4719839.jpg.jpg');

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

-- --------------------------------------------------------

--
-- 資料表結構 `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `members_id` int(11) NOT NULL,
  `order_date` date NOT NULL,
  `amount` int(11) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 傾印資料表的資料 `orders`
--

INSERT INTO `orders` (`id`, `members_id`, `order_date`, `amount`, `status`) VALUES
(1, 1, '2021-08-10', 1000, '運送中'),
(2, 2, '2021-08-10', 2694, '運送中'),
(3, 3, '2021-02-10', 850, '已完成'),
(4, 4, '2021-03-10', 2230, '代付款'),
(5, 5, '2021-07-10', 2240, '已完成'),
(6, 6, '2021-06-10', 820, '待付款'),
(7, 7, '2021-09-10', 3300, '運送中');

-- --------------------------------------------------------

--
-- 資料表結構 `orders_detail`
--

CREATE TABLE `orders_detail` (
  `id` int(11) NOT NULL,
  `orders_id` int(11) NOT NULL,
  `product_id(連結商品列表)` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `orders_detail`
--

INSERT INTO `orders_detail` (`id`, `orders_id`, `product_id(連結商品列表)`, `price`, `quantity`) VALUES
(1, 1, 2, 200, 2),
(2, 1, 3, 300, 2),
(3, 2, 15, 399, 3),
(4, 2, 9, 300, 1),
(5, 2, 15, 399, 3),
(6, 3, 19, 200, 2),
(7, 3, 18, 450, 1),
(8, 4, 12, 230, 4),
(9, 4, 8, 320, 3),
(10, 4, 4, 350, 1),
(11, 5, 11, 560, 4),
(12, 6, 12, 100, 1),
(13, 6, 15, 120, 6),
(14, 7, 2, 500, 3),
(15, 7, 5, 600, 3);

-- --------------------------------------------------------

--
-- 資料表結構 `order_details`
--

CREATE TABLE `order_details` (
  `sid` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `product_id` int(11) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `order_details`
--

INSERT INTO `order_details` (`sid`, `order_id`, `user_id`, `user_name`, `product_id`, `unit_price`, `quantity`, `sub_total`) VALUES
(38, 61, 5, 'Liu Ming-Xin', 11, 1880, 1, 1880),
(39, 61, 5, 'Liu Ming-Xin', 13, 1600, 1, 1600);

-- --------------------------------------------------------

--
-- 資料表結構 `order_list`
--

CREATE TABLE `order_list` (
  `sid` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_price` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `user_name` varchar(255) NOT NULL,
  `user_phone` varchar(255) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `pickup_way` varchar(255) NOT NULL,
  `pickup_store` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `order_list`
--

INSERT INTO `order_list` (`sid`, `user_id`, `total_price`, `order_status`, `user_name`, `user_phone`, `user_email`, `user_address`, `pickup_way`, `pickup_store`, `created_at`) VALUES
(61, 5, 3780, '等待結帳', 'Liu Ming-Xin', '0912123123', 'smallstars10@gmail.com', 'ulitsa Institutskaya, 4, Kiev', '7-11門市取貨', '板仁門市', '2021-08-23 21:20:44');

-- --------------------------------------------------------

--
-- 資料表結構 `products`
--

CREATE TABLE `products` (
  `sid` int(11) NOT NULL,
  `categories_id` int(11) NOT NULL,
  `categories_parents_id` int(11) NOT NULL,
  `brands_id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `number` varchar(255) CHARACTER SET utf8 NOT NULL,
  `price` int(11) NOT NULL,
  `sale` int(11) NOT NULL,
  `detail` varchar(255) CHARACTER SET utf8 NOT NULL,
  `origin` varchar(255) NOT NULL,
  `launched` tinyint(1) NOT NULL,
  `created_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `products`
--

INSERT INTO `products` (`sid`, `categories_id`, `categories_parents_id`, `brands_id`, `name`, `number`, `price`, `sale`, `detail`, `origin`, `launched`, `created_time`) VALUES
(1, 2, 10, 1, 'NIKE Jordan Delta 2', 'nike01pink\r\n', 4500, 4500, 'Jordan Delta 2 在你喜愛的耐久性、舒適度和 Jordan 核心概念等特色上，增添全新大膽元素。我們延續 Delta 的一貫理念，改版設計線條，並去除部分元素。第二代鞋款同樣混搭了各式具支撐力與太空概念的衝突材質，結合不同紋理與大量縫線，打造既經典又新奇的造型。\r\n', '越南\r\n', 1, '2021-08-14 10:00:32'),
(2, 2, 10, 1, 'NIKE Jordan Delta 2', 'nike01gray\n', 4500, 4500, 'Jordan Delta 2 在你喜愛的耐久性、舒適度和 Jordan 核心概念等特色上，增添全新大膽元素。我們延續 Delta 的一貫理念，改版設計線條，並去除部分元素。第二代鞋款同樣混搭了各式具支撐力與太空概念的衝突材質，結合不同紋理與大量縫線，打造既經典又新奇的造型。\r\n', '越南\r\n', 1, '2021-08-14 10:00:32'),
(3, 2, 10, 1, 'NIKE Jordan Delta 2', 'nike01white', 4500, 4500, 'Jordan Delta 2 在你喜愛的耐久性、舒適度和 Jordan 核心概念等特色上，增添全新大膽元素。我們延續 Delta 的一貫理念，改版設計線條，並去除部分元素。第二代鞋款同樣混搭了各式具支撐力與太空概念的衝突材質，結合不同紋理與大量縫線，打造既經典又新奇的造型。\r\n', '越南\r\n', 1, '2021-08-14 10:00:32'),
(4, 2, 10, 3, 'New Balance Fresh Foam X Vongo v5\r\n', 'nb01orange\r\n', 4780, 4780, '我們的 Fresh Foam X Vongo v5 女式跑鞋旨在將支撐性和柔軟性完美融合。Vongo 採用 Fresh Foam 中底和內側立柱，每一步都保持穩定性。\r\n', '中國', 1, '2021-08-14 16:11:20'),
(5, 2, 10, 3, 'New Balance Fresh Foam X Vongo v5\r\n', 'nb01black', 4780, 4780, '我們的 Fresh Foam X Vongo v5 女式跑鞋旨在將支撐性和柔軟性完美融合。Vongo 採用 Fresh Foam 中底和內側立柱，每一步都保持穩定性。\r\n', '中國', 1, '2021-08-14 16:11:20'),
(6, 2, 10, 3, 'New Balance Fresh Foam X Vongo v5\r\n', 'nb01red', 4780, 4780, '我們的 Fresh Foam X Vongo v5 女式跑鞋旨在將支撐性和柔軟性完美融合。Vongo 採用 Fresh Foam 中底和內側立柱，每一步都保持穩定性。\r\n', '中國', 1, '2021-08-14 16:11:20'),
(43, 3, 15, 2, 'fakefake123', 'noname12', 2330, 2330, 'qwfjqwpojfpowjgpjgpjgwp', '台灣', 1, '2021-08-19 13:13:33'),
(50, 1, 6, 1, 'imagetest', 'noname04', 2330, 2330, 'dgsdsgsd', '台灣', 1, '2021-08-19 15:10:33'),
(52, 1, 5, 6, 'OKder', 'noname10', 2330, 2330, '這是一雙籃球鞋', '台灣', 1, '2021-08-21 11:06:10');

-- --------------------------------------------------------

--
-- 資料表結構 `product_list`
--

CREATE TABLE `product_list` (
  `sid` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_brand` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `product_img` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `product_list`
--

INSERT INTO `product_list` (`sid`, `category_id`, `product_name`, `product_brand`, `product_price`, `stock`, `product_img`) VALUES
(1, 1, 'NIKE Jordan Delta 2', 'NIKE', 3000, 200, 'nike01purple'),
(2, 2, 'Fresh Foam X Vongo v5', 'NewBalance', 4000, 300, 'newbalance01blue'),
(3, 3, 'PUMA Velocity Nitro Wn', 'PUMA', 5000, 400, 'puma01black'),
(4, 4, 'PUMA Velocity Nitro Wn', 'PUMA', 5000, 10, 'puma02white'),
(5, 5, 'Nike Air Zoom Vomero', 'NIKE', 4700, 22, 'Nike Air Zoom Vomero'),
(6, 6, 'Nike Air Max Bolt', 'NIKE', 2980, 50, 'Nike Air Max Bolt'),
(7, 7, 'Nike Space Hippie 04', 'NIKE', 3150, 40, 'Nike Space Hippie 04'),
(8, 8, 'Nike Asuna Print', 'NIKE', 1600, 30, 'Nike Asuna Print'),
(9, 9, 'Nike Court Royale 2', 'NIKE', 1680, 47, 'Nike Court Royale 2'),
(10, 10, 'Nike SB Zoom Blazer 中筒 Premium', 'NIKE', 3600, 55, 'Nike SB Zoom Blazer 中筒 Premium'),
(11, 11, 'Nike SB Chron 2 Slip', 'NIKE', 1880, 33, 'Nike SB Chron 2 Slip'),
(12, 12, 'Nike Air Force 1 低筒 Unlocked', 'NIKE', 5200, 0, 'Nike Air Force 1 低筒 Unlocked'),
(13, 13, 'Nike Asuna', 'NIKE', 1600, 1, 'Nike Asuna');

-- --------------------------------------------------------

--
-- 資料表結構 `product_spec`
--

CREATE TABLE `product_spec` (
  `sid` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_size` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `product_spec`
--

INSERT INTO `product_spec` (`sid`, `category_id`, `product_id`, `product_size`) VALUES
(1, 1, 1, 23),
(2, 1, 2, 24),
(3, 1, 3, 24),
(4, 1, 4, 25),
(5, 1, 5, 25),
(6, 2, 6, 23),
(7, 2, 7, 24),
(8, 2, 8, 24),
(9, 2, 9, 25),
(10, 2, 10, 25),
(11, 3, 11, 23),
(12, 3, 12, 24),
(13, 3, 13, 24),
(14, 3, 14, 25),
(15, 3, 15, 25),
(16, 4, 16, 23),
(17, 4, 17, 24),
(18, 4, 18, 24),
(19, 4, 19, 25),
(20, 4, 20, 25);

-- --------------------------------------------------------

--
-- 資料表結構 `sportsgame`
--

CREATE TABLE `sportsgame` (
  `sid` int(11) NOT NULL,
  `gameName` int(11) NOT NULL COMMENT '賽事名稱',
  `gameStatus` varchar(255) DEFAULT NULL COMMENT '賽事階段',
  `gameTime` date NOT NULL COMMENT '比賽時間',
  `gameStadium` int(11) DEFAULT NULL COMMENT '比賽場地',
  `player1` varchar(255) DEFAULT NULL COMMENT '對手1',
  `player2` varchar(255) DEFAULT NULL COMMENT '對手2',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `sportsgame`
--

INSERT INTO `sportsgame` (`sid`, `gameName`, `gameStatus`, `gameTime`, `gameStadium`, `player1`, `player2`, `created_at`) VALUES
(1, 2, '上半季例行賽', '2021-08-16', 1, '中信兄弟', '統一獅', '2021-08-15 20:37:27'),
(2, 2, '下半季例行賽', '2021-08-18', 1, '統一獅', '兄弟象', '2021-08-17 16:54:04'),
(4, 2, '上半季例行賽', '2021-08-05', 1, '兄弟', '統一獅1', '2021-08-17 22:01:02'),
(6, 2, '上半季例行賽', '2021-08-05', 1, '兄弟', '兄弟', '2021-08-17 22:03:01'),
(7, 7, '高中十六強例行賽', '2021-08-18', 2, '松山高中', '南山高中', '2021-08-17 22:14:19'),
(8, 15, '蛙式', '2021-08-19', 3, '菲爾普斯', '鈴木一朗', '2021-08-18 21:42:09'),
(9, 21, 'WWE巡迴賽', '2021-08-19', 3, '超人', '蝙蝠俠', '2021-08-18 21:43:30'),
(10, 15, '蛙式', '2021-08-20', 3, '兄弟', '統一獅1', '2021-08-18 21:44:17'),
(11, 2, '總冠軍戰', '2021-08-09', 1, '太空人', '洋基', '2021-08-18 22:03:22'),
(12, 6, '黑豹旗總決賽', '2021-08-19', 1, '兄弟', '兄弟', '2021-08-18 22:05:38'),
(13, 2, '上半季例行賽', '2021-08-17', 1, '兄弟', '兄弟', '2021-08-18 22:38:11'),
(15, 4, '熱身賽', '2021-09-10', 1, '國王', '湖人', '2021-08-19 14:09:22'),
(16, 4, '總冠軍戰', '2021-08-10', 8, '湖人', '籃網', '2021-08-20 23:11:58');

-- --------------------------------------------------------

--
-- 資料表結構 `sportstype`
--

CREATE TABLE `sportstype` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL COMMENT '賽事類別名稱',
  `rank` int(11) NOT NULL COMMENT '類別階層',
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `sportstype`
--

INSERT INTO `sportstype` (`sid`, `name`, `rank`, `created_at`) VALUES
(1, '棒球', 0, '2021-08-15 20:35:57'),
(2, '中華職棒', 1, '2021-08-15 20:35:57'),
(3, '籃球', 0, '2021-08-16 21:00:10'),
(4, 'NBA', 3, '2021-08-16 21:00:10'),
(5, 'SBL', 3, '2021-08-16 21:43:55'),
(6, '黑豹旗', 1, '2021-08-16 21:43:55'),
(7, 'HBL', 3, '2021-08-16 21:47:27'),
(8, 'P+', 3, '2021-08-16 21:47:27'),
(9, '長青盃', 3, '2021-08-16 21:47:54'),
(10, '街頭3對3', 3, '2021-08-16 21:47:54'),
(11, 'ABL', 3, '2021-08-16 21:48:15'),
(13, '游泳', 0, '2021-08-16 23:26:00'),
(15, '十二公尺', 13, '2021-08-17 10:09:50'),
(16, 'MLB', 1, '2021-08-17 10:10:23'),
(18, '摔角', 0, '2021-08-17 15:22:07'),
(19, '海碩盃12', 4, '2021-08-17 15:23:05'),
(20, '大樹盃', 4, '2021-08-17 15:27:44'),
(21, 'WWE', 18, '2021-08-17 16:00:07'),
(22, 'WWC', 18, '2021-08-18 22:39:45'),
(23, 'WWA', 18, '2021-08-18 22:39:53'),
(24, 'WWG', 18, '2021-08-18 22:40:06'),
(25, 'WWR', 18, '2021-08-18 22:40:18'),
(26, 'WWW', 18, '2021-08-18 22:40:32');

-- --------------------------------------------------------

--
-- 資料表結構 `stadium`
--

CREATE TABLE `stadium` (
  `sid` int(11) NOT NULL,
  `gymName` varchar(255) NOT NULL COMMENT '場館名稱',
  `city` varchar(255) DEFAULT NULL COMMENT '城市',
  `area` varchar(255) DEFAULT NULL COMMENT '行政區',
  `address` varchar(255) DEFAULT NULL COMMENT '地址',
  `gymKind` int(11) NOT NULL DEFAULT 1 COMMENT '設施類型',
  `inAndout` varchar(255) DEFAULT NULL COMMENT '室內外',
  `lat` varchar(255) NOT NULL COMMENT '緯度',
  `lng` varchar(255) NOT NULL COMMENT '經度',
  `photo` varchar(255) DEFAULT NULL COMMENT '照片',
  `phone` varchar(255) DEFAULT NULL COMMENT '電話',
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '建立時間'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `stadium`
--

INSERT INTO `stadium` (`sid`, `gymName`, `city`, `area`, `address`, `gymKind`, `inAndout`, `lat`, `lng`, `photo`, `phone`, `created_at`) VALUES
(1, '天母棒球場', '台北市', '士林區', '忠誠路二段77號', 2, '室外', '25.11439823009718', '121.5326674079359', NULL, '+886228735688', '2021-08-15 20:45:29'),
(3, '新莊高中游泳池', '新北市', '新莊區', '景平路50號', 5, NULL, '1231231', '123123123', NULL, NULL, '2021-08-20 15:42:32'),
(8, '中和高中籃球場', '新北市', '220', '景德街28號', 9, '室外', '1231', '12312', './imgs/下載.jpeg', '+886986761963', '2021-08-20 17:54:52'),
(9, '臺北小巨蛋', '臺北市', '105', '南京東路四段2號', 9, '室內', '25.0513881', '121.5486215', './imgs/1024x768.jpeg', '123123123', '2021-08-21 00:51:36');

-- --------------------------------------------------------

--
-- 資料表結構 `stadiumtype`
--

CREATE TABLE `stadiumtype` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `rank` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `stadiumtype`
--

INSERT INTO `stadiumtype` (`sid`, `name`, `rank`, `created_at`) VALUES
(1, '球類運動設施', 0, '2021-08-15 21:15:01'),
(2, '棒球場', 1, '2021-08-15 21:15:01'),
(3, '水上運動設施', 0, '2021-08-19 00:05:19'),
(5, '游泳池', 3, '2021-08-19 13:33:10'),
(6, '高爾夫球場', 1, '2021-08-19 23:20:24'),
(7, '壘球場', 1, '2021-08-19 23:20:31'),
(8, '足球場', 1, '2021-08-19 23:21:13'),
(9, '籃球場', 1, '2021-08-19 23:21:28'),
(11, '羽球場', 1, '2021-08-19 23:22:04');

-- --------------------------------------------------------

--
-- 資料表結構 `stock`
--

CREATE TABLE `stock` (
  `id` int(11) NOT NULL,
  `products_id` int(11) NOT NULL,
  `size` varchar(255) CHARACTER SET utf8 NOT NULL,
  `stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `stock`
--

INSERT INTO `stock` (`id`, `products_id`, `size`, `stock`) VALUES
(1, 1, '22.5', 50),
(2, 1, '23', 50),
(3, 1, '23.5', 10),
(4, 1, '24', 20),
(5, 1, '24.5', 50),
(6, 1, '25', 50),
(7, 1, '25.5', 50),
(8, 2, '22.5', 50),
(9, 2, '23', 20),
(10, 2, '23.5', 50),
(11, 2, '24', 50),
(12, 2, '24.5', 50),
(13, 2, '25', 50),
(14, 2, '25.5', 50),
(15, 3, '22.5', 50),
(16, 3, '23', 30),
(17, 3, '23.5', 50),
(18, 3, '24', 50),
(19, 3, '24.5', 50),
(20, 3, '25', 50),
(21, 3, '25.5', 50),
(22, 4, '22.5', 50),
(23, 4, '23', 40),
(24, 4, '23.5', 50),
(25, 4, '24', 50),
(26, 4, '24.5', 50),
(27, 4, '25', 50),
(28, 4, '25.5', 50),
(29, 5, '22.5', 50),
(30, 5, '23', 20),
(31, 5, '23.5', 50),
(32, 5, '24', 50),
(33, 5, '24.5', 50),
(34, 5, '25', 50),
(35, 5, '25.5', 50),
(36, 6, '22.5', 50),
(37, 6, '23', 30),
(38, 6, '23.5', 50),
(39, 6, '24', 50),
(40, 6, '24.5', 50),
(41, 6, '25', 50),
(42, 6, '25.5', 50),
(60, 50, '26.5', 59),
(66, 50, '26.5', 59),
(67, 50, '26.5', 59),
(68, 50, '26.5', 59),
(69, 50, '26.5', 59),
(79, 43, '28', 52),
(80, 50, '26.5', 59),
(81, 43, '29', 30),
(83, 52, '26.5', 51);

-- --------------------------------------------------------

--
-- 資料表結構 `store`
--

CREATE TABLE `store` (
  `sid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parents_id` varchar(255) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 傾印資料表的資料 `store`
--

INSERT INTO `store` (`sid`, `name`, `parents_id`) VALUES
(1, '宅配到府', '0'),
(2, '7-11門市取貨', '0'),
(3, '家裡', '宅配到府'),
(4, '板仁門市', '7-11門市取貨'),
(5, '仁金門市', '7-11門市取貨'),
(6, '學央門市', '7-11門市取貨'),
(7, '竹盈門市', '7-11門市取貨'),
(8, '景旭門市', '7-11門市取貨');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `account_address`
--
ALTER TABLE `account_address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_id` (`members_id`);

--
-- 資料表索引 `account_ranking`
--
ALTER TABLE `account_ranking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_id` (`members_id`);

--
-- 資料表索引 `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `geo_info`
--
ALTER TABLE `geo_info`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_id` (`members_id`);

--
-- 資料表索引 `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_sid` (`products_sid`);

--
-- 資料表索引 `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `account` (`account`);

--
-- 資料表索引 `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `members_id` (`members_id`);

--
-- 資料表索引 `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_id` (`orders_id`);

--
-- 資料表索引 `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `order_list`
--
ALTER TABLE `order_list`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`sid`),
  ADD KEY `brands_id` (`brands_id`);

--
-- 資料表索引 `product_list`
--
ALTER TABLE `product_list`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `product_spec`
--
ALTER TABLE `product_spec`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `sportsgame`
--
ALTER TABLE `sportsgame`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `sportstype`
--
ALTER TABLE `sportstype`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `stadium`
--
ALTER TABLE `stadium`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `stadiumtype`
--
ALTER TABLE `stadiumtype`
  ADD PRIMARY KEY (`sid`);

--
-- 資料表索引 `stock`
--
ALTER TABLE `stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_sid` (`products_id`) USING BTREE;

--
-- 資料表索引 `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`sid`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `account_address`
--
ALTER TABLE `account_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `account_ranking`
--
ALTER TABLE `account_ranking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `geo_info`
--
ALTER TABLE `geo_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'auto';

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `order_details`
--
ALTER TABLE `order_details`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `order_list`
--
ALTER TABLE `order_list`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `products`
--
ALTER TABLE `products`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_list`
--
ALTER TABLE `product_list`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `product_spec`
--
ALTER TABLE `product_spec`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sportsgame`
--
ALTER TABLE `sportsgame`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `sportstype`
--
ALTER TABLE `sportstype`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `stadium`
--
ALTER TABLE `stadium`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `stadiumtype`
--
ALTER TABLE `stadiumtype`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `stock`
--
ALTER TABLE `stock`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `store`
--
ALTER TABLE `store`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `account_address`
--
ALTER TABLE `account_address`
  ADD CONSTRAINT `account_address_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`id`);

--
-- 資料表的限制式 `account_ranking`
--
ALTER TABLE `account_ranking`
  ADD CONSTRAINT `account_ranking_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`id`);

--
-- 資料表的限制式 `geo_info`
--
ALTER TABLE `geo_info`
  ADD CONSTRAINT `geo_info_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`id`);

--
-- 資料表的限制式 `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`products_sid`) REFERENCES `products` (`sid`);

--
-- 資料表的限制式 `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`members_id`) REFERENCES `members` (`id`);

--
-- 資料表的限制式 `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD CONSTRAINT `orders_detail_ibfk_1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`);

--
-- 資料表的限制式 `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brands_id`) REFERENCES `brands` (`id`);

--
-- 資料表的限制式 `stock`
--
ALTER TABLE `stock`
  ADD CONSTRAINT `stock_ibfk_1` FOREIGN KEY (`products_id`) REFERENCES `products` (`sid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
