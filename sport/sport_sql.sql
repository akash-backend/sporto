-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 03, 2019 at 06:12 AM
-- Server version: 5.6.41-84.1
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ctinf0eg_sport`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `percent` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `company`, `email`, `password`, `city`, `percent`) VALUES
(1, '', '', 'admin@admin.com', 'e10adc3949ba59abbe56e057f20f883e', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `user_from` int(11) DEFAULT NULL,
  `user_to` int(11) DEFAULT NULL,
  `message` text COLLATE utf8mb4_bin,
  `created_at` datetime DEFAULT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`id`, `user_from`, `user_to`, `message`, `created_at`, `group_id`) VALUES
(1, 1, 2, '\"Hi\"', '2018-09-17 13:09:31', 0),
(2, 1, 2, '\"Reply me on this user\"', '2018-09-17 13:09:52', 0),
(3, 1, 2, '\"Rply\"', '2018-09-17 13:10:52', 0),
(4, 2, 1, '\"Hii\"', '2018-09-17 13:10:57', 0),
(5, 1, 2, '\"Create event\"', '2018-09-17 13:11:14', 0),
(6, 2, 1, '\"Ok\"', '2018-09-17 13:11:25', 0),
(7, 3, 1, '\"Ho\"', '2018-09-17 13:12:24', 0),
(8, 2, 1, '\"Event created\"', '2018-09-17 13:12:26', 0),
(9, 1, 2, '\"Hii\"', '2018-09-17 13:12:36', 0),
(10, 2, 1, '\"Event created\"', '2018-09-17 13:12:49', 0),
(11, 1, 3, '\"Hello\"', '2018-09-17 13:13:27', 0),
(12, 3, 1, '\"Hi\"', '2018-09-17 13:13:39', 0),
(13, 3, 1, '\"Hii\"', '2018-09-17 13:13:53', 0),
(14, 1, 3, '\"Hui\"', '2018-09-17 13:13:59', 0),
(15, 1, 3, '\"Wassup\"', '2018-09-17 13:15:16', 0),
(16, 1, 3, '\"Hahejj\"', '2018-09-17 13:15:31', 0),
(17, 3, 1, '\"Harjrwjutw\"', '2018-09-17 13:15:36', 0),
(18, 3, 1, '\"Sjrtjeei\"', '2018-09-17 13:15:58', 0),
(19, 1, 3, '\"Hddudisi\"', '2018-09-17 13:23:34', 0),
(20, 6, 3, '\"Hi\"', '2018-09-17 13:45:11', 0),
(21, 3, 6, '\"Hi\"', '2018-09-17 13:45:45', 0),
(22, 6, 3, '\"Hddjdidi\"', '2018-09-17 13:46:12', 0),
(23, 3, 6, '\"Hello\"', '2018-09-17 13:46:26', 0),
(24, 6, 3, '\"Bio\"', '2018-09-17 13:46:51', 0),
(25, 3, 6, '\"New text\"', '2018-09-17 13:47:32', 0),
(26, 4, 6, '\"Rgdtdsfgfd\"', '2018-09-17 13:52:31', 0),
(27, 6, 5, '\"Hh\"', '2018-09-17 13:54:19', 0),
(28, 6, 5, '\"GUI\"', '2018-09-17 13:55:15', 0),
(29, 5, 6, '\"Fg\"', '2018-09-17 13:55:25', 0),
(30, 6, 5, '\"Hi\"', '2018-09-17 13:57:02', 0),
(31, 4, 5, '\"Hii\"', '2018-09-17 13:58:08', 0),
(32, 4, 6, '\"Gjgh\"', '2018-09-17 13:58:17', 0),
(33, 4, 5, '\"Fghfhfghfgh\"', '2018-09-17 14:00:56', 0),
(34, 4, 5, '\"hiiiiee\"', '2018-09-17 14:01:52', 0),
(35, 3, 6, '\"Hi\"', '2018-09-27 09:36:18', 0),
(36, 4, 1, '\"Hi\"', '2018-10-17 14:11:40', 0),
(37, 4, 1, '\"Hello\"', '2018-10-17 14:12:40', 0),
(38, 4, 1, '\"Reply sir\"', '2018-10-17 14:12:59', 0),
(39, 4, 1, '\"\\ud83d\\ude09\"', '2018-10-17 14:13:45', 0),
(40, 4, 1, '\"\\ud83d\\ude33\"', '2018-10-17 14:14:10', 0),
(41, 4, 1, '\"777\"', '2018-10-17 14:14:20', 0),
(42, 3, 4, '\"Hii\"', '2018-11-15 11:55:45', 0),
(43, 4, 8, '\"Hi\"', '2018-12-06 10:47:31', 0),
(44, 9, 3, '\"Hio\"', '2018-12-06 13:29:02', 0),
(45, 9, 3, '\"Sir\"', '2018-12-06 13:29:12', 0),
(46, 8, 10, '\"Hej\"', '2018-12-06 17:22:13', 0),
(47, 10, 8, '\"Jeg\"', '2018-12-06 17:22:28', 0),
(48, 10, 8, '\"Hej\"', '2018-12-06 17:26:28', 0),
(49, 3, 8, '\"Hi\"', '2018-12-07 08:04:31', 0),
(50, 8, 11, '\"Herhjemme\"', '2018-12-09 13:07:52', 0),
(51, 11, 8, '\"Ohhh hallo my fruens\"', '2018-12-09 13:08:09', 0);

-- --------------------------------------------------------

--
-- Table structure for table `join_event_tbl`
--

CREATE TABLE `join_event_tbl` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `join_id` int(11) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = pending,1 = accept,2 = reject'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `join_event_tbl`
--

INSERT INTO `join_event_tbl` (`id`, `user_id`, `event_id`, `join_id`, `status`) VALUES
(1, 1, 1, 3, 1),
(2, 2, 2, 5, 0),
(3, 11, 14, 8, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification_tbl`
--

CREATE TABLE `notification_tbl` (
  `id` int(11) NOT NULL,
  `message` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_send_from` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `type` varchar(255) NOT NULL COMMENT '1-join,2-follow',
  `event_id` int(11) NOT NULL,
  `unique_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `notification_tbl`
--

INSERT INTO `notification_tbl` (`id`, `message`, `user_id`, `user_send_from`, `date`, `type`, `event_id`, `unique_id`) VALUES
(1, 'Started Following You', 2, 1, '2018-09-17 13:09:24', 'Following', 0, 0),
(2, 'Sent You a Message', 2, 1, '2018-09-17 13:09:31', 'Message', 0, 0),
(3, 'Sent You a Message', 2, 1, '2018-09-17 13:09:52', 'Message', 0, 0),
(4, 'Sent You a Message', 2, 1, '2018-09-17 13:10:52', 'Message', 0, 0),
(5, 'Sent You a Message', 1, 2, '2018-09-17 13:10:58', 'Message', 0, 0),
(6, 'Sent You a Message', 2, 1, '2018-09-17 13:11:14', 'Message', 0, 0),
(7, 'Sent You a Message', 1, 2, '2018-09-17 13:11:25', 'Message', 0, 0),
(9, 'Now Joinee of Event', 3, 1, '2018-09-17 13:11:37', 'Event', 1, 0),
(10, 'Sent You a Message', 1, 3, '2018-09-17 13:12:24', 'Message', 0, 0),
(11, 'Sent You a Message', 1, 2, '2018-09-17 13:12:27', 'Message', 0, 0),
(12, 'Sent You a Message', 2, 1, '2018-09-17 13:12:36', 'Message', 0, 0),
(13, 'Sent You a Message', 1, 2, '2018-09-17 13:12:49', 'Message', 0, 0),
(14, 'Sent You a Message', 3, 1, '2018-09-17 13:13:27', 'Message', 0, 0),
(15, 'Sent You a Message', 1, 3, '2018-09-17 13:13:39', 'Message', 0, 0),
(16, 'Sent You a Message', 1, 3, '2018-09-17 13:13:53', 'Message', 0, 0),
(17, 'Sent You a Message', 3, 1, '2018-09-17 13:13:59', 'Message', 0, 0),
(18, 'Sent You a Message', 3, 1, '2018-09-17 13:15:16', 'Message', 0, 0),
(19, 'Sent You a Message', 3, 1, '2018-09-17 13:15:31', 'Message', 0, 0),
(20, 'Sent You a Message', 1, 3, '2018-09-17 13:15:37', 'Message', 0, 0),
(21, 'Sent You a Message', 1, 3, '2018-09-17 13:15:58', 'Message', 0, 0),
(22, 'Has to you Invited Event', 1, 2, '2018-09-17 13:22:23', 'Invite', 1, 0),
(23, 'Sent You a Message', 3, 1, '2018-09-17 13:23:34', 'Message', 0, 0),
(24, 'Started Following You', 3, 1, '2018-09-17 13:23:40', 'Following', 0, 0),
(25, 'Started Following You', 2, 4, '2018-09-17 13:38:15', 'Following', 0, 0),
(26, 'Has to you Invited Event', 4, 2, '2018-09-17 13:39:15', 'Invite', 3, 0),
(27, 'Started Following You', 5, 4, '2018-09-17 13:42:59', 'Following', 0, 0),
(28, 'Has to you Invited Event', 4, 5, '2018-09-17 13:43:35', 'Invite', 3, 0),
(29, 'Started Following You', 3, 6, '2018-09-17 13:44:50', 'Following', 0, 0),
(30, 'Sent You a Message', 3, 6, '2018-09-17 13:45:11', 'Message', 0, 0),
(31, 'Unfollowed You', 3, 6, '2018-09-17 13:45:27', 'Unfollowed', 0, 0),
(32, 'Started Following You', 3, 6, '2018-09-17 13:45:36', 'Following', 0, 0),
(33, 'Sent You a Message', 6, 3, '2018-09-17 13:45:46', 'Message', 0, 0),
(34, 'Sent You a Message', 3, 6, '2018-09-17 13:46:12', 'Message', 0, 0),
(35, 'Sent You a Message', 6, 3, '2018-09-17 13:46:26', 'Message', 0, 0),
(36, 'Sent You a Message', 3, 6, '2018-09-17 13:46:51', 'Message', 0, 0),
(37, 'Sent You a Message', 6, 3, '2018-09-17 13:47:32', 'Message', 0, 0),
(38, 'Wants to Join Your Event', 2, 5, '2018-09-17 13:47:59', 'Join', 2, 2),
(39, 'Has to you Invited Event', 4, 2, '2018-09-17 13:49:47', 'Invite', 3, 0),
(40, 'Has to you Invited Event', 4, 5, '2018-09-17 13:50:25', 'Invite', 3, 0),
(41, 'Started Following You', 6, 4, '2018-09-17 13:51:23', 'Following', 0, 0),
(42, 'Has to you Invited Event', 4, 6, '2018-09-17 13:51:31', 'Invite', 3, 0),
(43, 'Has to you Invited Event', 4, 6, '2018-09-17 13:52:22', 'Invite', 3, 0),
(44, 'Sent You a Message', 6, 4, '2018-09-17 13:52:31', 'Message', 0, 0),
(45, 'Started Following You', 6, 5, '2018-09-17 13:53:03', 'Following', 0, 0),
(46, 'Started Following You', 5, 6, '2018-09-17 13:54:06', 'Following', 0, 0),
(47, 'Sent You a Message', 5, 6, '2018-09-17 13:54:19', 'Message', 0, 0),
(48, 'Sent You a Message', 5, 6, '2018-09-17 13:55:15', 'Message', 0, 0),
(49, 'Sent You a Message', 6, 5, '2018-09-17 13:55:25', 'Message', 0, 0),
(50, 'Sent You a Message', 5, 6, '2018-09-17 13:57:02', 'Message', 0, 0),
(51, 'Has to you Invited Event', 4, 5, '2018-09-17 13:57:43', 'Invite', 3, 0),
(52, 'Has to you Invited Event', 4, 6, '2018-09-17 13:57:50', 'Invite', 3, 0),
(53, 'Sent You a Message', 5, 4, '2018-09-17 13:58:09', 'Message', 0, 0),
(54, 'Sent You a Message', 6, 4, '2018-09-17 13:58:17', 'Message', 0, 0),
(55, 'Unfollowed You', 5, 4, '2018-09-17 13:59:27', 'Unfollowed', 0, 0),
(56, 'Sent You a Message', 5, 4, '2018-09-17 14:00:56', 'Message', 0, 0),
(57, 'Sent You a Message', 5, 4, '2018-09-17 14:01:53', 'Message', 0, 0),
(58, 'Has to you Invited Event', 6, 3, '2018-09-17 14:08:41', 'Invite', 4, 0),
(59, 'Has to you Invited Event', 6, 3, '2018-09-17 14:09:12', 'Invite', 4, 0),
(60, 'Has to you Invited Event', 5, 6, '2018-09-17 14:17:00', 'Invite', 5, 0),
(61, 'Has to you Invited Event', 3, 6, '2018-09-17 14:17:34', 'Invite', 5, 0),
(62, 'Has to you Invited Event', 3, 6, '2018-09-17 14:17:54', 'Invite', 4, 0),
(63, 'Has to you Invited Event', 6, 5, '2018-09-17 14:18:55', 'Invite', 5, 0),
(64, 'Has to you Invited Event', 6, 5, '2018-09-17 14:19:20', 'Invite', 5, 0),
(65, 'Has to you Invited Event', 1, 5, '2018-09-17 14:19:27', 'Invite', 5, 0),
(66, 'Has to you Invited Event', 3, 5, '2018-09-17 14:19:28', 'Invite', 5, 0),
(67, 'Has to you Invited Event', 6, 5, '2018-09-17 14:20:59', 'Invite', 6, 0),
(68, 'Started Following You', 1, 5, '2018-09-17 14:21:08', 'Following', 0, 0),
(69, 'Has to you Invited Event', 1, 5, '2018-09-17 14:21:17', 'Invite', 6, 0),
(70, 'Has to you Invited Event', 1, 4, '2018-09-18 13:44:20', 'Invite', 5, 0),
(71, 'Has to you Invited Event', 2, 4, '2018-09-18 13:44:20', 'Invite', 5, 0),
(72, 'Has to you Invited Event', 3, 4, '2018-09-18 13:44:21', 'Invite', 5, 0),
(73, 'Has to you Invited Event', 5, 4, '2018-09-18 13:44:21', 'Invite', 5, 0),
(74, 'Has to you Invited Event', 6, 4, '2018-09-18 13:44:21', 'Invite', 5, 0),
(75, 'Sent You a Message', 6, 3, '2018-09-27 09:36:18', 'Message', 0, 0),
(76, 'Has to you Invited Event', 2, 3, '2018-09-27 09:36:46', 'Invite', 5, 0),
(77, 'Has to you Invited Event', 6, 1, '2018-10-09 18:39:06', 'Invite', 5, 0),
(78, 'Has to you Invited Event', 6, 1, '2018-10-09 18:39:14', 'Invite', 5, 0),
(79, 'Sent You a Message', 1, 4, '2018-10-17 14:11:40', 'Message', 0, 0),
(80, 'Sent You a Message', 1, 4, '2018-10-17 14:12:40', 'Message', 0, 0),
(81, 'Sent You a Message', 1, 4, '2018-10-17 14:12:59', 'Message', 0, 0),
(82, 'Sent You a Message', 1, 4, '2018-10-17 14:13:45', 'Message', 0, 0),
(83, 'Sent You a Message', 1, 4, '2018-10-17 14:14:10', 'Message', 0, 0),
(84, 'Sent You a Message', 1, 4, '2018-10-17 14:14:20', 'Message', 0, 0),
(85, 'Started Following You', 4, 3, '2018-11-15 11:55:24', 'Following', 0, 0),
(86, 'Sent You a Message', 4, 3, '2018-11-15 11:55:45', 'Message', 0, 0),
(87, 'Has to you Invited Event', 1, 3, '2018-11-15 11:56:03', 'Invite', 5, 0),
(88, 'Has to you Invited Event', 8, 3, '2018-11-15 11:56:09', 'Invite', 5, 0),
(89, 'Has to you Invited Event', 1, 8, '2018-11-29 11:04:31', 'Invite', 5, 0),
(90, 'Started Following You', 9, 8, '2018-12-04 16:36:30', 'Following', 0, 0),
(91, 'Has to you Invited Event', 2, 4, '2018-12-05 11:17:29', 'Invite', 5, 0),
(92, 'Unfollowed You', 2, 4, '2018-12-06 07:39:08', 'Unfollowed', 0, 0),
(93, 'Started Following You', 1, 4, '2018-12-06 07:39:25', 'Following', 0, 0),
(94, 'Started Following You', 8, 4, '2018-12-06 07:39:54', 'Following', 0, 0),
(95, 'Unfollowed You', 1, 4, '2018-12-06 07:40:31', 'Unfollowed', 0, 0),
(96, 'Has to you Invited Event', 8, 4, '2018-12-06 10:47:18', 'Invite', 5, 0),
(97, 'Sent You a Message', 8, 4, '2018-12-06 10:47:31', 'Message', 0, 0),
(98, 'Has to you Invited Event', 1, 9, '2018-12-06 13:28:45', 'Invite', 5, 0),
(99, 'Has to you Invited Event', 3, 9, '2018-12-06 13:28:45', 'Invite', 5, 0),
(100, 'Has to you Invited Event', 8, 9, '2018-12-06 13:28:45', 'Invite', 5, 0),
(101, 'Sent You a Message', 3, 9, '2018-12-06 13:29:02', 'Message', 0, 0),
(102, 'Sent You a Message', 3, 9, '2018-12-06 13:29:12', 'Message', 0, 0),
(103, 'Started Following You', 3, 9, '2018-12-06 13:29:17', 'Following', 0, 0),
(104, 'Started Following You', 10, 8, '2018-12-06 17:22:00', 'Following', 0, 0),
(105, 'Sent You a Message', 10, 8, '2018-12-06 17:22:13', 'Message', 0, 0),
(106, 'Sent You a Message', 8, 10, '2018-12-06 17:22:28', 'Message', 0, 0),
(107, 'Has to you Invited Event', 10, 8, '2018-12-06 17:23:06', 'Invite', 12, 0),
(108, 'Has to you Invited Event', 10, 8, '2018-12-06 17:23:18', 'Invite', 12, 0),
(109, 'Started Following You', 8, 10, '2018-12-06 17:24:49', 'Following', 0, 0),
(110, 'Has to you Invited Event', 8, 10, '2018-12-06 17:25:35', 'Invite', 13, 0),
(111, 'Sent You a Message', 8, 10, '2018-12-06 17:26:28', 'Message', 0, 0),
(112, 'Started Following You', 3, 2, '2018-12-07 08:02:40', 'Following', 0, 0),
(113, 'Started Following You', 8, 3, '2018-12-07 08:04:22', 'Following', 0, 0),
(114, 'Sent You a Message', 8, 3, '2018-12-07 08:04:31', 'Message', 0, 0),
(115, 'Started Following You', 3, 4, '2018-12-07 08:04:56', 'Following', 0, 0),
(117, 'Now Joinee of Event', 8, 11, '2018-12-09 13:07:30', 'Event', 14, 0),
(118, 'Sent You a Message', 11, 8, '2018-12-09 13:07:52', 'Message', 0, 0),
(119, 'Sent You a Message', 8, 11, '2018-12-09 13:08:09', 'Message', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sport_event`
--

CREATE TABLE `sport_event` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `game_id` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `event_time` datetime NOT NULL,
  `event_duration` int(11) NOT NULL,
  `event_participant_no` int(11) NOT NULL,
  `event_description` text NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `event_address` varchar(255) NOT NULL,
  `event_user_type` int(11) NOT NULL COMMENT '1-admin,2-user',
  `join_user` varchar(255) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `link` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '	0 = not block, 1 = block'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sport_event`
--

INSERT INTO `sport_event` (`id`, `title`, `game_id`, `price`, `event_time`, `event_duration`, `event_participant_no`, `event_description`, `latitude`, `longitude`, `event_address`, `event_user_type`, `join_user`, `event_image`, `user_id`, `link`, `status`) VALUES
(1, 'Makshi', 8, 0, '2018-09-20 16:38:48', 1, 3, 'Baraj', '23.2349886443194', '76.1361125484109', 'Kapeli, Madhya Pradesh, India', 2, '1,3', '', 1, '', 0),
(2, 'Testing 123', 4, 0, '2018-09-17 17:40:34', 3, 14, 'Testing only', '22.6965850977853', '75.864269323647', 'Laxmi apartment, 138/47, New Agrawal nagar, Behind INOX cinema, Sapna Sangeeta Rd, bhwarkua, Indore, Madhya Pradesh 452001, India', 2, '2', '', 2, '', 0),
(3, 'New', 8, 0, '2018-09-18 17:08:41', 1, 3, 'Fdsfdsg gdfgdf', '22.5434942508245', '75.9889900311828', 'Indore, Madhya Pradesh, India', 2, '4', '', 4, '', 0),
(4, 'Dodo do', 7, 0, '2018-09-19 17:23:35', 2, 3, 'Bhaskar', '22.9870637295094', '76.0846811905503', 'Unnamed Road, Kshipra, Madhya Pradesh 453771, India', 2, '6', '', 6, '', 0),
(5, 'game test admin', 9, 2000, '2019-07-11 09:25:00', 8, 15, ' fgdsgdgdfgdfgdfg', '22.7190596', '75.88171609999995', '7, Kanchan Baug, Kanchan Baug, Indore, Madhya Pradesh 452001, India', 1, '', '7ba90387bac83e96498e5c57c8d8d855.jpg', 0, 'https://google.co.in', 0),
(6, 'New', 4, 0, '2018-09-19 17:50:41', 1, 3, 'Gary', '22.9396525075199', '76.1490880697966', 'Unnamed Road, Napakhedi, Madhya Pradesh 455223, India', 2, '5', '', 5, '', 0),
(7, 'New creative event', 4, 0, '2018-09-27 13:08:39', 1, 3, 'Hqey bhar Jew ', '52.1528883323426', '17.9107366874814', 'Zieleniew 15, 99-107 Zieleniew, Poland', 2, '3', '', 3, '', 0),
(8, 'Footbaa', 10, 0, '2018-12-07 16:53:49', 2, 5, 'Please Come in my event ', '38.5703458537592', '78.4900714829564', 'Aqcha, Afghanistan', 2, '4', '', 4, '', 0),
(9, 'Hej', 4, 0, '2018-12-04 17:31:56', 2, 10, 'Jek', '55.4042485791939', '10.4017205536366', 'Kochsgade 44, 5000 Odense, Danmark', 2, '8', '', 8, '', 0),
(10, 'Hej', 4, 0, '2018-12-05 18:14:25', 1, 5, 'Jek', '55.4037949392099', '10.397516861558', 'Kochsgade 16B, 5000 Odense, Danmark', 2, '8', '', 8, '', 0),
(11, 'Hej', 4, 0, '2018-12-05 20:25:53', 2, 5, 'Hej', '55.4037115587386', '10.3975741937757', 'Kochsgade 16, 5000 Odense, Danmark', 2, '8', '', 8, '', 0),
(12, 'Hey ', 4, 0, '2018-12-06 17:24:51', 3, 10, 'Hej', '55.4037330701556', '10.3973991796374', 'Kochsgade 16B, 5000 Odense, Danmark', 2, '8', '', 8, '', 0),
(13, 'Hej', 4, 0, '2018-12-06 17:30:18', 2, 6, 'NFL', '55.4037427788443', '10.3974715992808', 'Kochsgade 16B, 5000 Odense, Danmark', 2, '10', '', 10, '', 0),
(14, 'Bh\n', 2, 0, '2018-12-10 13:30:35', 1, 4, 'Grcfgggff', '55.7961695778576', '9.64243680238724', 'Lindvedvej 27, 8723 Løsning, Danmark', 2, '11,8', '', 11, '', 0),
(15, 'Test', 3, 0, '2018-12-10 19:09:58', 1, 3, 'Dhdjf', '23.8963590617468', '75.990404561162', 'Unnamed Road, Madhya Pradesh 465447, India', 2, '3', '', 3, '', 0),
(16, 'Hyggebold på multibanen v. Chang', 4, 0, '2018-12-18 15:00:53', 1, 8, 'Klar på noget hyggebold? Både drenge og piger på alle niveauer er velkomne. Lad os trille noget bold og spille noget kamp! Jeg tager bold med!', '55.4039243879948', '10.3971309587359', 'Kochsgade 16, 5000 Odense, Danmark', 2, '8', '', 8, '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sport_game`
--

CREATE TABLE `sport_game` (
  `id` int(11) NOT NULL,
  `game_name` varchar(225) NOT NULL,
  `game_image` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '	0 = not block, 1 = block'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sport_game`
--

INSERT INTO `sport_game` (`id`, `game_name`, `game_image`, `status`) VALUES
(1, 'e-sport', '5eb6912c1b3f6d1063f328e2ec1eeed8.png', 0),
(2, 'badminton', '558b197e0450ae0acae24fae97e30cb2.png', 0),
(3, 'løb', 'd5aab1c34159a1594d9681f6346dd011.png', 0),
(4, 'fodbold', '0fb0b888a2f5f84dafefe6d365c99137.png', 0),
(5, 'cykling', 'dba3111d42b41fa81f263fd63aba6c3d.png', 0),
(7, 'Basketball', '880a80bed53f06d88da5b4ba6052c4bf.png', 0),
(8, 'Golf', '74153be88ca41305aba05737f4d12fcd.png', 0),
(9, 'Tennis', '750ff8622efc4688ee8fa350b11c4879.png', 0),
(10, 'andet', '85a57c88b3110404d3f07b0110141224.png', 0),
(11, 'fitness', '5404bada101d0f2b8ae82762582f0ff8.png', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `user_dob` date NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `image` varchar(128) NOT NULL,
  `social` int(11) NOT NULL,
  `ios_token` varchar(256) NOT NULL,
  `android_token` varchar(256) NOT NULL,
  `created_at` datetime NOT NULL,
  `user_latitude` varchar(255) NOT NULL,
  `user_longitude` varchar(255) NOT NULL,
  `user_game_id` int(11) NOT NULL,
  `user_event` varchar(255) NOT NULL,
  `user_info` varchar(255) NOT NULL,
  `status` int(11) NOT NULL COMMENT '0 = not block, 1 = block'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `email`, `user_dob`, `user_address`, `image`, `social`, `ios_token`, `android_token`, `created_at`, `user_latitude`, `user_longitude`, `user_game_id`, `user_event`, `user_info`, `status`) VALUES
(1, 'Gaurang Bhatore', 'bhatoregaurang@gmail.com', '1997-04-09', '', 'a221d90f1f92ec344b1837b49d61d08c.jpg', 1, '24dc8a7179c901dc34219749531d4612934e46076a007bcf86cf1e0d614538a6', '', '2018-09-17 13:06:36', '22.7233574470281', '75.8869079214909', 0, '1', '', 0),
(2, 'Honey Maheshwari', 'maheshwarihoney@ymail.com', '1997-04-09', '', '3780417061537182508.png', 1, '5dd7a330f463a393f3f9dc557b2458d70b77c23b8c91d779fabbb82ba154376f', '', '2018-09-17 13:08:29', '22.684567035197', '75.8721746318749', 0, '2', '', 0),
(3, 'Devendra Dharwar', 'devendra1891@gmail.com', '1997-04-09', '', 'c962c6b65f6d124ba16130e7bd7ea3f7.jpg', 1, 'd5bf1a2ee81145b2085818f8357a529cc1b412c1749a6bf7d60762797488e98c', '', '2018-09-17 13:11:13', '22.723389823524', '75.8866621806845', 0, '1,7,15', '', 0),
(4, 'Nidhi Patni', 'nids.patni1992@gmail.com', '1997-04-09', '', '19356090831537184264.png', 1, 'NODEVICETOKEN', '', '2018-09-17 13:37:45', '22.719568', '75.857727', 0, '3', '', 0),
(5, 'Altab Patel', '', '1997-04-09', '', '2176198861537184562.png', 1, '539f3cf3934f3b9e54c63bd92479013eda7f531d6186f8525c702d447c26cdf5', '', '2018-09-17 13:42:42', '22.7232807376673', '75.8868076858676', 0, '6', '', 0),
(6, 'Rakesh', 'rakeshyadav709@gmail.com', '1976-04-09', 'Agra Bombay Rd, South Tukoganj, Indore, Madhya Pradesh 452001, India', 'b4569a466489ee417d217dca5f987912.jpg', 1, '2294c49994080ce982c5789218475cf969077e1061f65d4f73779a4cd87e1639', '', '2018-09-17 13:43:07', '22.7231380928456', '75.8866737500166', 10, '4', '', 0),
(7, 'Fly Flyerson', 'flyflyerson@gmail.com', '1997-04-09', '', '3146897321537320048.png', 1, 'f252990c23f55419ab70bcc1c8ea7e8766f16cad0dccb0cf87c645b06f276dcb', '', '2018-09-19 03:20:49', '0.0', '0.0', 0, '', '', 0),
(8, 'Patrick Pelle', 'p.p.r@live.dk', '1995-01-16', 'Odense C', '4b6e7e910e11b9dd09c7c86a98737529.jpg', 1, '33a3d7b9afb9cc29790215dd6b645b5c1a252d2f8b373ed7bc3e3673ef9fbf3d', '', '2018-09-19 10:23:47', '55.4050878156493', '10.4023714922465', 0, '12,14,16', 'Jeg spiller til dagligt Serie 1 i Chang, Odense. ', 0),
(9, 'Sneha Mishra', 'sneha.vidya29@gmail.com', '1997-04-09', '', '7283921011544099039.png', 1, '1b20f5ae7295737e5f8fd1d34409c0c8bdbaa91d9d1296cf635195785ffbf4fe', '', '2018-12-06 13:23:59', '0.0', '0.0', 0, '', '', 0),
(10, 'Rebecka Wilkens', 'rebeckawilkens@hotmail.com', '1997-04-09', '', '10903130031544113299.png', 1, '4ae5500155935002035f6f7a2b24306a9ddd5af06be074a0f58a6e51a7b921ea', '', '2018-12-06 17:21:39', '55.4034311324874', '10.4002114757992', 0, '13', '', 0),
(11, 'Hans Ravn', 'hansravn11@hotmail.com', '1997-04-09', '', '20235070661544357113.png', 1, '6036828fed505424196cc8c13c840d394f3599dbd9f4fca886ea23ec8b15e7ba', '', '2018-12-09 13:05:13', '55.7970834849922', '9.64506670833532', 0, '14', '', 0),
(12, 'Michael Helming Johansson', 'michael.johansson13@gmail.com', '1997-04-09', '', '13511519531545066763.png', 1, 'f252990c23f55419ab70bcc1c8ea7e8766f16cad0dccb0cf87c645b06f276dcb', '', '2018-12-17 18:12:44', '55.3942640545363', '10.4054629895933', 0, '', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_block`
--

CREATE TABLE `user_block` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `block_uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_block`
--

INSERT INTO `user_block` (`id`, `user_id`, `block_uid`) VALUES
(5, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_following`
--

CREATE TABLE `user_following` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `following_id` int(11) NOT NULL,
  `date_follow` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_following`
--

INSERT INTO `user_following` (`id`, `user_id`, `following_id`, `date_follow`) VALUES
(2, 1, 2, '2018-09-17 13:09:24'),
(3, 1, 3, '2018-09-17 13:23:40'),
(7, 6, 3, '2018-09-17 13:45:36'),
(8, 4, 6, '2018-09-17 13:51:23'),
(9, 5, 6, '2018-09-17 13:53:03'),
(10, 6, 5, '2018-09-17 13:54:06'),
(11, 5, 1, '2018-09-17 14:21:08'),
(12, 3, 4, '2018-11-15 11:55:24'),
(13, 8, 9, '2018-12-04 16:36:30'),
(15, 4, 8, '2018-12-06 07:39:54'),
(16, 9, 3, '2018-12-06 13:29:17'),
(17, 8, 10, '2018-12-06 17:22:00'),
(18, 10, 8, '2018-12-06 17:24:49'),
(19, 2, 3, '2018-12-07 08:02:40'),
(20, 3, 8, '2018-12-07 08:04:22'),
(21, 4, 3, '2018-12-07 08:04:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `join_event_tbl`
--
ALTER TABLE `join_event_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_tbl`
--
ALTER TABLE `notification_tbl`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sport_event`
--
ALTER TABLE `sport_event`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sport_game`
--
ALTER TABLE `sport_game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_block`
--
ALTER TABLE `user_block`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_following`
--
ALTER TABLE `user_following`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `join_event_tbl`
--
ALTER TABLE `join_event_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification_tbl`
--
ALTER TABLE `notification_tbl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `sport_event`
--
ALTER TABLE `sport_event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `sport_game`
--
ALTER TABLE `sport_game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_block`
--
ALTER TABLE `user_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_following`
--
ALTER TABLE `user_following`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
