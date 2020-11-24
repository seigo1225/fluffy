-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2020 年 11 月 19 日 09:25
-- サーバのバージョン： 5.7.26
-- PHP のバージョン: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `fluffy`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `massage` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `post_time` datetime DEFAULT NULL,
  `edit_time` datetime NOT NULL DEFAULT '1000-10-10 10:10:10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `post`
--

INSERT INTO `post` (`id`, `user_id`, `user_name`, `massage`, `image`, `post_time`, `edit_time`) VALUES
(69, 3, 'セイゴ', 'fluffyはじめました！', NULL, '2020-11-12 15:35:01', '1000-10-10 10:10:10'),
(70, 3, 'セイゴ', '', 'img/1605162917_95573f01ef459a46e96eb16420fdd7f832988fde.jpg', '2020-11-12 15:35:17', '1000-10-10 10:10:10'),
(71, 3, 'セイゴ', 'aaaa', NULL, '2020-11-19 13:30:48', '1000-10-10 10:10:10'),
(74, 4, 'たなか', 'test', NULL, '2020-11-19 18:17:55', '1000-10-10 10:10:10');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `user_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `icon` varchar(255) DEFAULT 'img/肉球のアイコン.png',
  `biography` varchar(255) DEFAULT NULL,
  `role` int(1) NOT NULL COMMENT '0:ゲスト 1:一般ユーザー 2:管理者',
  `regist_time` datetime DEFAULT NULL,
  `edit_time` datetime NOT NULL DEFAULT '1000-10-10 10:10:10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `user_id`, `user_name`, `email`, `password`, `icon`, `biography`, `role`, `regist_time`, `edit_time`) VALUES
(1, 'guest', 'ゲスト', 'guset01@mail.com', '0000', 'img/chacha.jpeg', 'お試し中！', 0, '2020-08-14 14:32:43', '2020-09-03 09:51:44'),
(2, 'admin00', '管理者', 'admin@mail.com', 'admin', '', '管理者', 2, '2020-08-14 16:18:08', '2020-08-14 16:18:08'),
(3, 'seigo', 'セイゴ', 'seigo@test.jp', '0000', 'img/1605151341_1ff31bfbe7bf390cfc1e0771353db787db35e530.jpg', 'aaaa', 1, '2020-08-14 08:38:15', '2020-11-12 12:22:21'),
(4, 'tanaka', 'たなか', 'aaaaa', '0000', 'img/肉球のアイコン.png', '動物大好き', 1, '2020-09-12 18:11:33', '2020-11-19 09:17:07');

-- --------------------------------------------------------

--
-- テーブルの構造 `user_post`
--

CREATE TABLE `user_post` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `user_post`
--

INSERT INTO `user_post` (`user_id`, `post_id`, `created`) VALUES
(3, 69, '2020-11-12 15:35:01'),
(3, 70, '2020-11-12 15:35:17'),
(3, 71, '2020-11-19 13:30:48'),
(4, 57, '2020-11-08 16:51:42'),
(4, 65, '2020-11-12 13:47:43'),
(4, 66, '2020-11-12 13:47:48'),
(4, 74, '2020-11-19 18:17:55'),
(7, 67, '2020-11-12 13:55:37');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `user_post`
--
ALTER TABLE `user_post`
  ADD PRIMARY KEY (`user_id`,`post_id`,`created`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- テーブルのAUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
