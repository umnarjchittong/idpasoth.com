-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2021 at 03:24 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soth`
--

-- --------------------------------------------------------

--
-- Table structure for table `match-idpa`
--

CREATE TABLE `match-idpa` (
  `match_id` int(11) NOT NULL,
  `match_regist_datetime` datetime DEFAULT NULL,
  `match_name` varchar(120) NOT NULL,
  `match_location` varchar(80) DEFAULT NULL,
  `match_detail` text DEFAULT NULL,
  `match_level` varchar(10) NOT NULL DEFAULT 'TIER 1',
  `match_stages` int(11) DEFAULT NULL,
  `match_rounds` int(11) DEFAULT NULL,
  `match_begin` date DEFAULT NULL,
  `match_finish` date DEFAULT NULL,
  `match_md` varchar(30) DEFAULT NULL,
  `match_md_contact` varchar(60) DEFAULT NULL,
  `match_so_list` longtext DEFAULT NULL,
  `match_coordinator` int(11) DEFAULT NULL,
  `match_upload_file` varchar(50) DEFAULT NULL,
  `match_status` varchar(10) NOT NULL DEFAULT 'enable',
  `match_editor` varchar(30) DEFAULT NULL,
  `match_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `match-idpa`
--

INSERT INTO `match-idpa` (`match_id`, `match_regist_datetime`, `match_name`, `match_location`, `match_detail`, `match_level`, `match_stages`, `match_rounds`, `match_begin`, `match_finish`, `match_md`, `match_md_contact`, `match_so_list`, `match_coordinator`, `match_upload_file`, `match_status`, `match_editor`, `match_lastupdate`) VALUES
(1, '2020-08-20 14:30:59', 'IDPA Thailand - King of Low Light', 'สนาม 333 (รังสิต)', '', 'TIER 1', 8, 120, '2020-10-17', '2020-10-17', 'ก้องเกียรติ นาสิมมา', NULL, NULL, NULL, NULL, 'enable', 'Umnarj ', '2021-11-11 20:28:13'),
(2, '2020-08-24 10:37:01', 'R.A.D. FRIENDSHIP MATCH', 'สนาม 333 (รังสิต)', NULL, 'TIER 1', 9, NULL, '2019-10-10', '2019-10-10', 'ทรงศักดิ์ วงษ์สถาปนาเลิศ', NULL, NULL, NULL, NULL, 'enable', 'TOM', '2021-11-03 09:49:40'),
(3, '2020-08-24 11:02:07', 'GUN MEETIN DAY 2019', 'สนามยิงปืนตำรวจ', NULL, 'TIER 1', 8, NULL, '2019-09-21', '2019-09-22', 'ร.ต.ต.พัลลภ วิสิทธิ์', NULL, NULL, NULL, NULL, 'enable', 'TOM', '2021-11-03 09:49:40'),
(4, '2020-11-30 13:02:00', 'BANTAK IDPA', 'สนามยิงปืนบ้านตาก ,จังหวัดตาก', NULL, 'TIER 1', 8, 125, '2020-11-28', '2020-11-28', 'ก้องเกียรติ นาสิมมา', NULL, NULL, NULL, NULL, 'enable', 'TOM', '2021-11-03 09:49:40'),
(5, '2020-12-09 10:08:03', '333 IDPA Back to the future', '333 Shooting range rangsit phathumthani', NULL, 'TIER 1', 10, 157, '2020-12-06', '2020-12-06', 'Somchai Cherdchai', 'tingly10@yahoo.com', NULL, NULL, NULL, 'enable', 'TOM', '2021-11-03 09:49:40'),
(6, '2020-12-19 17:43:04', 'Gun Meeting Day 2020', 'สนามยิงปืนตำรวจ', NULL, 'TIER 1', 8, 127, '2020-12-19', '2020-12-19', 'ร.ต.ต.พัลลภ วิสิทธิ์', NULL, NULL, NULL, NULL, 'enable', 'TOM', '2021-11-03 09:49:40'),
(7, '2021-03-22 16:21:47', '333 IDPA 1/2021 The Killer', '333 Shooting Range Rangsit  PathumThani', NULL, 'TIER 1', 10, 171, '2021-03-21', '2021-03-21', 'Somchai Cherdchai TH967487', 'tingly10@yahoo.com', NULL, NULL, NULL, 'enable', 'TOM', '2021-11-03 09:49:40'),
(8, '2021-04-08 09:12:21', 'IDPA Handgun Challenge 2021 #1', NULL, NULL, 'TIER 1', 10, NULL, '2021-02-20', '2021-02-20', 'นายอิศรา อัศววงศ์ธาดา', NULL, NULL, NULL, NULL, 'enable', 'TOM', '2021-11-03 09:49:40');

-- --------------------------------------------------------

--
-- Table structure for table `on-duty`
--

CREATE TABLE `on-duty` (
  `on-duty_id` int(11) NOT NULL,
  `match_id` int(11) NOT NULL,
  `so_id` int(11) NOT NULL,
  `on-duty_priority` int(2) DEFAULT NULL,
  `on-duty_position` varchar(30) DEFAULT NULL,
  `on-duty_notes` text DEFAULT NULL,
  `on-duty_status` varchar(10) NOT NULL DEFAULT 'enable',
  `on-duty_editor` varchar(30) DEFAULT NULL,
  `on-duty_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `on-duty`
--

INSERT INTO `on-duty` (`on-duty_id`, `match_id`, `so_id`, `on-duty_priority`, `on-duty_position`, `on-duty_notes`, `on-duty_status`, `on-duty_editor`, `on-duty_lastupdate`) VALUES
(22, 2, 21, 1, 'MD', NULL, 'enable', 'TOM', '2021-11-04 09:58:09'),
(23, 2, 15, 2, 'CSO', NULL, 'enable', 'TOM', '2021-11-04 09:58:15'),
(24, 2, 37, 4, 'Chrono', NULL, 'enable', 'TOM', '2021-11-04 09:58:26'),
(25, 2, 22, 5, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-04 09:58:38'),
(26, 2, 4, 6, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-04 09:58:53'),
(27, 2, 52, 7, 'SO Stage #3', NULL, 'enable', 'TOM', '2021-11-04 10:00:27'),
(28, 2, 13, 11, 'SO Stage #7', NULL, 'enable', 'TOM', '2021-11-04 10:00:38'),
(29, 2, 25, 11, 'SO Stage #7', NULL, 'enable', 'TOM', '2021-11-04 10:00:51'),
(30, 2, 16, 12, 'SO Stage #8', NULL, 'enable', 'TOM', '2021-11-04 10:01:05'),
(31, 2, 5, 12, 'SO Stage #8', NULL, 'enable', 'TOM', '2021-11-04 10:01:19'),
(32, 2, 19, 13, 'SO Stage #9', NULL, 'enable', 'TOM', '2021-11-04 10:01:30'),
(33, 2, 42, 13, 'SO Stage #9', NULL, 'enable', 'TOM', '2021-11-04 10:01:59'),
(34, 2, 3, 3, 'STAT', NULL, 'enable', 'TOM', '2021-11-04 10:02:10'),
(35, 3, 21, 2, 'CSO', NULL, 'enable', 'TOM', '2021-11-04 13:33:48'),
(36, 3, 15, 2, 'CSO', NULL, 'enable', 'TOM', '2021-11-04 13:34:17'),
(37, 3, 3, 3, 'STAT', NULL, 'enable', 'TOM', '2021-11-04 13:34:03'),
(38, 3, 13, 5, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-04 13:34:26'),
(39, 3, 25, 5, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-04 13:34:38'),
(40, 3, 19, 6, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-04 13:34:45'),
(41, 3, 4, 7, 'SO Stage #3', NULL, 'enable', 'TOM', '2021-11-04 13:34:54'),
(42, 3, 22, 7, 'SO Stage #3', NULL, 'enable', 'TOM', '2021-11-04 13:35:02'),
(43, 3, 5, 8, 'SO Stage #4', NULL, 'enable', 'TOM', '2021-11-04 13:35:09'),
(44, 3, 42, 9, 'SO Stage #5', NULL, 'enable', 'TOM', '2021-11-04 13:35:18'),
(45, 3, 37, 9, 'SO Stage #5', NULL, 'enable', 'TOM', '2021-11-04 13:35:27'),
(46, 3, 26, 10, 'SO Stage #6', NULL, 'enable', 'TOM', '2021-11-04 13:35:34'),
(47, 3, 46, 10, 'SO Stage #6', NULL, 'enable', 'TOM', '2021-11-04 13:36:30'),
(48, 3, 52, 11, 'SO Stage #7', NULL, 'enable', 'TOM', '2021-11-04 13:35:47'),
(49, 3, 16, 12, 'SO Stage #8', NULL, 'enable', 'TOM', '2021-11-04 13:36:52'),
(50, 4, 34, 1, 'MD', NULL, 'enable', 'TOM', '2021-11-04 13:44:28'),
(51, 4, 50, 3, 'STAT', NULL, 'enable', 'TOM', '2021-11-04 13:44:38'),
(52, 4, 1, 5, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-04 13:44:54'),
(53, 4, 41, 6, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-04 13:45:15'),
(54, 4, 37, 7, 'SO Stage #3', NULL, 'enable', 'TOM', '2021-11-04 13:45:23'),
(55, 4, 46, 8, 'SO Stage #4', NULL, 'enable', 'TOM', '2021-11-04 13:45:51'),
(56, 4, 44, 9, 'SO Stage #5', NULL, 'enable', 'TOM', '2021-11-04 13:45:45'),
(57, 4, 3, 10, 'SO Stage #6', NULL, 'enable', 'TOM', '2021-11-04 13:46:03'),
(58, 4, 52, 11, 'SO Stage #7', NULL, 'enable', 'TOM', '2021-11-04 13:46:09'),
(59, 4, 4, 12, 'SO Stage #8', NULL, 'enable', 'TOM', '2021-11-04 13:46:17'),
(60, 5, 56, 1, 'MD', NULL, 'enable', 'TOM', '2021-11-04 13:49:07'),
(61, 5, 37, 3, 'STAT', NULL, 'enable', 'TOM', '2021-11-04 13:49:17'),
(62, 5, 45, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-04 13:50:40'),
(63, 5, 54, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-04 13:50:47'),
(64, 5, 29, 6, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-04 13:51:55'),
(65, 5, 61, 14, 'SO Stage #10', NULL, 'enable', 'TOM', '2021-11-04 13:52:05'),
(66, 5, 53, 9, 'SO Stage #5', NULL, 'enable', 'TOM', '2021-11-04 13:52:19'),
(67, 5, 15, 11, 'SO Stage #7', NULL, 'enable', 'TOM', '2021-11-04 13:52:29'),
(68, 5, 36, 5, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-04 13:52:40'),
(69, 5, 26, 10, 'SO Stage #6', NULL, 'enable', 'TOM', '2021-11-04 13:52:48'),
(70, 5, 46, 13, 'SO Stage #9', NULL, 'enable', 'TOM', '2021-11-04 13:52:58'),
(71, 5, 25, 14, 'SO Stage #10', NULL, 'enable', 'TOM', '2021-11-04 13:53:05'),
(72, 5, 34, 6, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-04 13:55:54'),
(73, 5, 11, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-04 13:56:48'),
(74, 5, 39, 9, 'SO Stage #5', NULL, 'enable', 'TOM', '2021-11-04 13:54:05'),
(75, 5, 13, 6, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-04 13:53:49'),
(76, 5, 18, 10, 'SO Stage #6', NULL, 'enable', 'TOM', '2021-11-04 13:54:15'),
(77, 5, 32, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-04 13:54:23'),
(78, 5, 1, 6, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-04 13:54:29'),
(79, 6, 21, 2, 'CSO', NULL, 'enable', 'TOM', '2021-11-05 12:31:39'),
(80, 6, 15, 2, 'CSO', NULL, 'enable', 'TOM', '2021-11-05 12:31:44'),
(81, 6, 22, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:31:49'),
(82, 6, 52, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:31:55'),
(83, 6, 19, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:00'),
(84, 6, 44, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:06'),
(85, 6, 3, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:12'),
(86, 6, 41, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:19'),
(87, 6, 42, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:26'),
(88, 6, 12, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:31'),
(89, 6, 11, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:38'),
(90, 6, 4, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:42'),
(91, 6, 54, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:49'),
(92, 6, 17, 3, 'STAT', NULL, 'enable', 'TOM', '2021-11-05 12:34:31'),
(93, 6, 5, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:32:59'),
(94, 6, 37, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:07'),
(95, 6, 53, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:16'),
(96, 6, 50, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:22'),
(97, 6, 61, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:29'),
(98, 6, 32, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:35'),
(99, 6, 45, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:42'),
(100, 6, 16, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:45'),
(101, 6, 13, 5, 'SO', NULL, 'enable', 'TOM', '2021-11-05 12:33:51'),
(102, 8, 21, 2, 'CSO', NULL, 'enable', 'TOM', '2021-11-05 12:36:09'),
(103, 8, 12, 6, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-05 12:36:34'),
(104, 8, 44, 6, 'SO Stage #1', NULL, 'enable', 'TOM', '2021-11-05 12:36:41'),
(105, 8, 13, 7, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-05 12:36:49'),
(106, 8, 19, 7, 'SO Stage #2', NULL, 'enable', 'TOM', '2021-11-05 12:36:55'),
(107, 8, 52, 8, 'SO Stage #3', NULL, 'enable', 'TOM', '2021-11-05 12:37:08'),
(108, 8, 32, 8, 'SO Stage #3', NULL, 'enable', 'TOM', '2021-11-05 12:37:18'),
(109, 8, 53, 9, 'SO Stage #4', NULL, 'enable', 'TOM', '2021-11-05 12:37:26'),
(110, 8, 42, 9, 'SO Stage #4', NULL, 'enable', 'TOM', '2021-11-05 12:37:34'),
(111, 8, 41, 10, 'SO Stage #5', NULL, 'enable', 'TOM', '2021-11-05 12:37:42'),
(112, 8, 9, 10, 'SO Stage #5', NULL, 'enable', 'TOM', '2021-11-05 12:37:49'),
(113, 8, 4, 11, 'SO Stage #6', NULL, 'enable', 'TOM', '2021-11-05 12:37:56'),
(114, 8, 58, 11, 'SO Stage #6', NULL, 'enable', 'TOM', '2021-11-05 12:38:01'),
(115, 8, 54, 12, 'SO Stage #7', NULL, 'enable', 'TOM', '2021-11-05 12:38:20'),
(116, 8, 25, 13, 'SO Stage #8', NULL, 'enable', 'TOM', '2021-11-05 12:38:28'),
(117, 8, 45, 13, 'SO Stage #8', NULL, 'enable', 'TOM', '2021-11-05 12:38:40'),
(118, 8, 22, 14, 'SO Stage #9', NULL, 'enable', 'TOM', '2021-11-05 12:38:50'),
(119, 8, 5, 14, 'SO Stage #9', NULL, 'enable', 'TOM', '2021-11-05 12:39:05'),
(120, 8, 11, 15, 'SO Stage #10', NULL, 'enable', 'TOM', '2021-11-05 12:39:47'),
(121, 8, 39, 15, 'SO Stage #10', NULL, 'enable', 'TOM', '2021-11-05 12:40:01'),
(122, 8, 17, 3, 'STAT', NULL, 'enable', 'TOM', '2021-11-05 12:40:09'),
(123, 8, 3, 3, 'STAT', NULL, 'enable', 'TOM', '2021-11-05 12:40:15'),
(130, 7, 45, 4, 'Chrono', NULL, 'enable', 'Umnarj ', '2021-11-11 10:34:17'),
(131, 7, 27, 4, 'Chrono', NULL, 'enable', 'Umnarj ', '2021-11-11 10:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `on-duty-position`
--

CREATE TABLE `on-duty-position` (
  `post_id` int(11) NOT NULL,
  `post_priority` int(11) NOT NULL,
  `post_title` varchar(15) NOT NULL,
  `post_status` varchar(10) NOT NULL DEFAULT 'enable',
  `post_editor` varchar(30) DEFAULT NULL,
  `post_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `on-duty-position`
--

INSERT INTO `on-duty-position` (`post_id`, `post_priority`, `post_title`, `post_status`, `post_editor`, `post_lastupdate`) VALUES
(1, 1, 'MD', 'enable', 'TOM', '2021-11-04 09:02:24'),
(2, 2, 'CSO', 'enable', 'TOM', '2021-11-04 09:02:24'),
(3, 3, 'STAT', 'enable', 'TOM', '2021-11-04 09:02:24'),
(4, 4, 'Chrono', 'enable', 'TOM', '2021-11-04 09:02:24'),
(5, 6, 'SO Stage #1', 'enable', 'TOM', '2021-11-04 09:02:24'),
(6, 7, 'SO Stage #2', 'enable', 'TOM', '2021-11-04 09:02:24'),
(7, 8, 'SO Stage #3', 'enable', 'TOM', '2021-11-04 09:02:24'),
(8, 9, 'SO Stage #4', 'enable', 'TOM', '2021-11-04 09:02:24'),
(9, 10, 'SO Stage #5', 'enable', 'TOM', '2021-11-04 09:02:24'),
(10, 11, 'SO Stage #6', 'enable', 'TOM', '2021-11-04 09:02:24'),
(11, 12, 'SO Stage #7', 'enable', 'TOM', '2021-11-04 09:02:24'),
(12, 13, 'SO Stage #8', 'enable', 'TOM', '2021-11-04 09:02:24'),
(13, 14, 'SO Stage #9', 'enable', 'TOM', '2021-11-04 09:02:24'),
(14, 15, 'SO Stage #10', 'enable', 'TOM', '2021-11-04 09:02:24'),
(15, 16, 'SO Stage #11', 'enable', 'TOM', '2021-11-04 09:02:24'),
(16, 16, 'SO Stage #12', 'enable', 'TOM', '2021-11-04 09:02:24'),
(17, 16, 'SO Stage #13', 'enable', 'TOM', '2021-11-04 09:02:24'),
(18, 16, 'SO Stage #14', 'enable', 'TOM', '2021-11-04 09:02:24'),
(19, 16, 'SO Stage #15', 'enable', 'TOM', '2021-11-04 09:02:24'),
(20, 5, 'SO', 'enable', NULL, '2021-11-04 13:50:20');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_id` int(11) NOT NULL,
  `setting_max_stage` int(11) DEFAULT NULL,
  `setting_db_name` varchar(16) DEFAULT NULL,
  `setting_debug_show` varchar(10) DEFAULT NULL,
  `setting_alert` varchar(10) DEFAULT NULL,
  `setting_meta_redirect` int(1) DEFAULT NULL,
  `setting_system_name` varchar(30) DEFAULT NULL,
  `setting_version` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_id`, `setting_max_stage`, `setting_db_name`, `setting_debug_show`, `setting_alert`, `setting_meta_redirect`, `setting_system_name`, `setting_version`) VALUES
(1, 10, 'soth', 'true', 'false', 3, 'SOTH MAIN DATABASE', '1');

-- --------------------------------------------------------

--
-- Table structure for table `so-member`
--

CREATE TABLE `so-member` (
  `so_id` int(11) NOT NULL,
  `so_idpa_id` varchar(10) DEFAULT NULL,
  `so_club` varchar(50) DEFAULT NULL,
  `so_firstname` varchar(30) NOT NULL,
  `so_lastname` varchar(30) NOT NULL,
  `so_firstname_en` varchar(30) DEFAULT NULL,
  `so_lastname_en` varchar(30) DEFAULT NULL,
  `so_nickname` varchar(20) NOT NULL,
  `so_citizen_id` varchar(13) NOT NULL,
  `so_dob` date DEFAULT NULL,
  `so_blood_type` varchar(3) DEFAULT NULL,
  `so_sex` varchar(10) DEFAULT NULL,
  `so_address` varchar(50) DEFAULT NULL,
  `so_subdistrict` varchar(30) DEFAULT NULL,
  `so_district` varchar(30) DEFAULT NULL,
  `so_province` varchar(30) DEFAULT NULL,
  `so_zipcode` varchar(5) DEFAULT NULL,
  `so_phone` varchar(30) DEFAULT NULL,
  `so_email` varchar(50) DEFAULT NULL,
  `so_line_id` varchar(30) DEFAULT NULL,
  `so_idpa_expire` date DEFAULT NULL,
  `so_license_expire` date DEFAULT NULL,
  `so_idpa_profile` varchar(30) DEFAULT NULL,
  `so_pwd` varchar(24) DEFAULT NULL,
  `so_auth_lv` int(1) NOT NULL DEFAULT 1 COMMENT '1 idpa member, 3 so member, 5 match director, 7 administrator, 9 developer',
  `so_avatar` varchar(50) DEFAULT 'img/person.png',
  `so_status` varchar(10) NOT NULL DEFAULT 'enable',
  `so_regis_datetime` datetime DEFAULT NULL,
  `so_editor` varchar(30) DEFAULT NULL,
  `so_lastupdate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `so-member`
--

INSERT INTO `so-member` (`so_id`, `so_idpa_id`, `so_club`, `so_firstname`, `so_lastname`, `so_firstname_en`, `so_lastname_en`, `so_nickname`, `so_citizen_id`, `so_dob`, `so_blood_type`, `so_sex`, `so_address`, `so_subdistrict`, `so_district`, `so_province`, `so_zipcode`, `so_phone`, `so_email`, `so_line_id`, `so_idpa_expire`, `so_license_expire`, `so_idpa_profile`, `so_pwd`, `so_auth_lv`, `so_avatar`, `so_status`, `so_regis_datetime`, `so_editor`, `so_lastupdate`) VALUES
(1, 'TH431698', 'IDPA THAILAND', 'ณฐพงศ ', 'สดสร้อย', 'SF1.Nutthapong ', 'Sodsoy', 'ต้อม', '1100500230525', '1987-11-09', 'B+', 'ชาย', '30/24 ถนนสายไหม58', 'แขวงสายไหม ', 'เขตสายไหม', 'กรุงเทพมหานคร', '10220', '0855626340', 'tomairborne47@gmail.com', 'tomairborne47', '2021-01-22', '2021-11-30', '', NULL, 3, 'img/person.png', 'enable', '2020-06-23 23:38:52', 'Umnarj ', '2021-11-11 18:44:27'),
(2, 'TH1014007', 'KKB Shooting Team', 'ธนกฤต ', 'รัตนรัตน์', 'Thanakrit ', 'Rattanarat', 'โจ้', '1100800145931', '1985-05-06', 'A-', 'ชาย', '27 Moo 8 Soi Rattanathibeth 22 ', 'Bangkasor', 'Muang', 'Nonthaburi', '11000', '0844559250', 'r.thanakrit@hotmail.com', 'jogiompe', '2024-01-03', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2021-11-02 14:19:55', NULL, '2021-11-02 15:57:43'),
(3, 'TH559691', 'Thai Police Shooting Club', 'นิษฐา ', 'ตุลวรรธนะ', 'Nittha ', 'Tulwatthana', 'น้อง', '1101200020151', '1984-06-27', 'O+', 'หญิง', '324 ถ.สุขสวัสดิ์', 'บางปะกอก', 'ราษฎร์บูรณะ', 'กรุงเทพมหานคร', '10140', '0989424564', 'lady_nong@hotmail.com', 'lady_nong', '2022-06-13', '2022-06-12', NULL, NULL, 3, 'img/person.png', 'enable', '2020-07-06 22:35:39', NULL, '2021-11-02 15:57:43'),
(4, 'TH1007300', '', 'พรเทพ ', 'น้ำทรัพย์', 'Paulthep ', 'Namsub', 'เอ็ม', '1101401568162', '1989-02-16', 'B-', 'ชาย', '385 ม.3', 'คูคต', 'ลำลูกกา', 'ปทุมธานี', '12130', '0831319899', 'paulthep1632@gmail.com', '', '2022-01-10', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 09:48:27', NULL, '2021-11-02 15:57:43'),
(5, 'TH1007192', 'Thai Police Shooting Club', 'อรรณพ ', 'แย้มพราย', 'Aunnop ', 'Yamprai', 'อัฐ', '1110300150978', '1995-08-24', 'O+', 'ชาย', '98/40 หมู่ 7 ถนนกิ่งแก้ว', 'บางพลีใหญ่', 'บางพลี', 'สมุทรปราการ', '10540', '+66930257768', 'aunnopmmc39@hotmail.com', 'aunyam39', '2020-09-25', '1995-09-25', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-22 13:38:41', NULL, '2021-11-02 15:57:43'),
(6, 'TH1008455', 'Defensive Shooting Club Thailand ', 'อิศรา ', 'โพธิ์ศรี', 'ISSARA ', 'PHOSRI', 'Arm', '1159900105190', '2531-02-06', 'O-', 'ชาย', '79/44 ', 'นวมินทร์86', 'คันนายาว', 'กทม', '10230', '0855185566', 'armissara.bkk@gmail.com', 'Fusiononestop ', '2024-04-25', '2021-12-15', NULL, NULL, 3, 'img/person.png', 'enable', '2020-12-24 00:45:24', NULL, '2021-11-02 15:57:43'),
(7, 'TH1008635', '', 'ปกรณ์ ', 'ทองนาท', 'Pakorn ', 'Thongnat', 'โบ้', '1200400035720', '2532-04-15', 'B+', 'ชาย', '29 ม.1', 'ห้วยใหญ่', 'บางละมุง', 'ชลบุรี', '20150', '0989329253', 'pakornthongnat@gmail.com', ' boboo69', '2022-01-24', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2021-11-02 14:20:36', NULL, '2021-11-02 15:57:43'),
(8, 'TH1013048', 'Ban Tak IDPA', 'สมพงษ์ ', 'วันคำ', 'Sompong ', 'Wankham', 'อิง', '1330500026781', '1987-10-25', 'O+', 'ชาย', '299 ม.6', 'ต.ไม้งาม', 'เมืองตาก', 'ตาก', '63000', '0811004130', 's.wankham@gmail.com', '0811004130', '2022-01-25', '2021-12-15', NULL, NULL, 3, 'img/person.png', 'enable', '2021-04-08 09:50:16', NULL, '2021-11-02 15:57:43'),
(9, 'TH1006046', 'Thai Police Shooting Club', 'ยศพร ', 'ดวงประจักษ์', 'Yossaporn ', 'Duangprachak', 'ยศ', '1429900088799', '1988-11-05', 'B-', 'ชาย', '248/120 แฟลตตำรวจกองปราบ โชคชัย 4', 'ลาดพร้าว', 'ลาดพร้าว', 'กรุงเทพมหานคร', '10240', '0908870202', 'momoro14@gmail.com', 'penguinz31', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 21:12:47', NULL, '2021-11-02 15:57:43'),
(10, 'TH1008789', '', 'กฤตวัฒน์ ', 'กมลจิตวารีย์', 'Kritawat ', 'Kaminjitvaree', 'อ๋อง', '1509901372546', '2536-12-13', 'O+', 'ชาย', '333 หมู่1 ถนนธัญบุรี-วังน้อย', 'คลองเจ็ด', 'คลองหลวง', 'ปทุมธานี', '12120', '0831541025', 'kritawatkamonjitvaree@gmail.com', 'Phot1993', '2023-09-01', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-12-21 10:27:01', NULL, '2021-11-02 15:57:43'),
(11, 'TH1001375', '', 'ภูริพัฒน์ ', 'พฤกษ์อำนวย', 'Phuriphat ', 'Pruekamnuai', 'เป๊ปซี่', '1710500127834', '1988-10-12', 'O-', 'ชาย', '783/23 happy condo ลาดพร้าว101', 'คลองเจ้าคุณสิงห์', 'บางกะปิ', 'กรุงเทพ', '10310', '0939395121​', 'phuriphat.th@gmail.com', 'pepsi.fc', '2021-07-01', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 15:40:27', NULL, '2021-11-02 15:57:43'),
(12, 'TH1010772', 'Thai Police Shooting Club', 'ยอดเพชร ', 'สิงหบุญพงศ์', 'Yordpetch ', 'Singhaboonpong', 'เพชร', '1800400199433', '1993-02-07', 'O+', 'ชาย', '296/534 ชั้น 41 โครงการ the issara ลาดพร้าว', 'จอมพล', 'จตุจักร', 'กรุงเทพมหานคร', '10900', '0639829265', 'Petch_si@outlook.com', 'Petch0807', '2023-08-10', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-20 14:48:03', NULL, '2021-11-02 15:57:43'),
(13, 'TH755280​', 'Thai Police Shooting Club', 'พงศ์​จิ​ระ​ ', 'แก้ว​ขาว​ใส​', 'Pongchira ', 'Kaewkaosai​', 'น๊อค​ / พงศ์​', '1809900119194', '1986-07-11', 'B-', 'ชาย', 'การกีฬา​แห่ง​ประเทศไ​ทย​ (ฝ่ายกีฬา​สถาน)​ 186 ถ.รา', 'หัวหมาก​', 'บางกะปิ​', 'กรุงเทพมหานคร', '10240', '0918859355​, 0988265925 ', 'pongchira.k@gmail.com', 'knockrt', '2022-05-22', '2020-07-12', NULL, NULL, 3, 'img/person.png', 'enable', '2020-07-06 22:42:23', NULL, '2021-11-02 15:57:43'),
(14, 'TH1001032', 'Thai Police Shooting Club', 'ทัศน์พล ', 'รุณแสง', 'Tassapol ', 'Roonsaeng', 'บิ๊ก', '1929900309251', '1992-02-29', 'A+', 'ชาย', '189 ม.5', 'ศาลายา', 'พุทธมณฑล', 'นครปฐม', '73170', '0921878884', 'season_schange@hotmail.com', 't.roonsaeng', '2020-11-22', '2020-07-12', NULL, NULL, 3, 'img/person.png', 'enable', NULL, NULL, '2021-11-02 15:57:43'),
(15, 'TH536250', 'Thai Police Shooting Club', 'วิจัย ', 'วะนะสนธิ์', 'Wijai ', 'Wanasonth', 'วจ', '3100200822580', '2510-07-02', 'B+', 'ชาย', '54/83 Mu2', 'ละหาร', 'บางบัวทอง', 'นนทบุรี', '11110', '0814210774', 'wijai7693@gmail.com', 'wijai7693', '2021-02-10', '2020-11-03', NULL, NULL, 7, 'img/person.png', 'enable', '2020-06-24 14:36:22', NULL, '2021-11-02 15:57:43'),
(16, 'TH1000214', 'Thai Police Shooting Club', 'กิตติเดช ', 'บางเทศธรรม', 'Mr.Kittidat ', 'Bangtessthum', 'เด่น', '3100203673456', '2515-09-15', 'O+', 'ชาย', '53 ซ.บางนาตราด12 ถ.บางนาตราด', 'บางนา', 'บางนา', 'กรุงเทพมหานคร', '10260', '0818072923', 'Design-D-Studio@hotmail.com', '0818072923', '2021-02-10', '2012-06-10', NULL, NULL, 3, 'img/person.png', 'enable', '2020-06-24 16:19:19', NULL, '2021-11-02 15:57:43'),
(17, 'TH658750', 'Thai-IDPA', 'กวีวงศ์ ', 'สุภาชวินสวัสดิ์', 'Kaveewong ', 'Supachavinswad', 'โอ', '3100400140393', '1979-10-31', 'AB+', 'ชาย', '9/22 ถนนธนิยะ ', 'สุรวงศ์', 'บางรัก', 'กรุงเทพมหานคร', '10500', '0816266409', 'kivee_r@hotmail.com', 'kavwong', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 17:47:57', NULL, '2021-11-02 15:57:43'),
(18, 'TH227755', '', 'อัศวิน ', 'สุขวัจน์', '', '', 'อัด', '3100501800742', '1965-10-28', '', 'ชาย', '31 ถ.กรุงเกษม', 'บางขุนพรหม', 'พระนคร', 'กรุงเทพมหานคร', '10200', '0868826166', 'aswin.s@eng.kmutnb.ac.th', '', '2021-10-22', '2022-08-22', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 08:43:59', NULL, '2021-11-02 15:57:43'),
(19, 'TH1000429', 'Thai Police Shooting Club', 'นิธิศ ', 'พงศ์ผาสุก', 'Nithit ', 'Phongphasuk', 'เค', '3100501855088', '2519-11-17', 'A+', 'ชาย', '1229 ซ.รามอินทรา67 ถ.รามอินทรา', 'ท่าแร้ง', 'บางเขน', 'กรุงเทพมหานคร', '10230', '0866689408', 'j_phong@hotmail.com', 'Tarnkay', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-07-03 10:30:23', NULL, '2021-11-02 15:57:43'),
(20, '', '', 'ทิพย์สุคนธ์ ', 'สุธรรมสมัย', 'Thipsukhol. ', 'Suthamsmai', 'ปุ้ม', '3100601854784', '1966-01-02', 'O+', 'หญิง', '271/25  หมู่6 ต.โสนลอย', 'ต.โสนลอย', 'บางบัวทอง', 'นนทบุรี', '11110', '0926240459', 'thipsukhol@gmail.com', 'piggy 9999', NULL, NULL, NULL, NULL, 1, 'img/person.png', 'enable', '2019-08-30 15:39:03', NULL, '2021-11-02 15:57:43'),
(21, 'TH1000215', 'Thai Police Shooting Club', 'ทรงศักดิ์ ', 'วงษ์สถาปนาเลิศ', 'Songsak ', 'Wongstapanalert', 'โหล', '3100601917557', '1979-10-26', 'O+', 'ชาย', '453 หมู่บ้านสินธร ถ.นวมินทร์', 'คลองจั่น', 'บางกะปิ', 'กรุงเทพมหานคร', '10240', '0819289827', 'w.songsak22@gmail.com', 'w.songsak1979', '2024-10-02', '2022-09-28', '', NULL, 7, 'img/person.png', 'enable', '2020-06-23 23:08:27', 'Songsak ', '2021-11-11 16:10:48'),
(22, 'TH1000216', 'Thai Police Shooting Club', 'รัชดา ', 'กลั่นฤทธิ์', 'Radchada ', 'Glanrith', 'กุน', '3101202098359', '2514-06-09', 'AB', 'หญิง', '127 พุทธมณฑล สาย2 ซอย7', 'บางแคเหนือ', 'บางแค', 'กรุงเทพมหานคร', '10160', '0815590211', 'gradchada@yahoo.com', 'kun-glanrith', '2021-10-02', '2020-11-03', NULL, NULL, 3, 'img/person.png', 'enable', '2020-06-30 14:08:02', NULL, '2021-11-02 15:57:43'),
(23, '', '', 'เบญจวรรณ ', 'เกตุพิชัย', 'Benjawan ', 'Ketpichai', 'วรรณ', '3101501485362', '1964-04-29', 'O-', 'หญิง', '97/95หมู่บ้านเฟื่องฟ้า11ซ.2เฟส7', 'ต.แพรกษา', 'เมือง', 'สมุทรปราการ', '10280', '0860730364', 'Ben0860730364@gmail.com', 'Benjwan', NULL, NULL, NULL, NULL, 1, 'img/person.png', 'enable', '2019-08-30 20:45:19', NULL, '2021-11-02 15:57:43'),
(24, 'TH188482', 'PPL', 'กฤตินันท์ ', 'ธนรักษ์', 'Krittinan ', 'Dhanaraksa', 'ตูน', '3101501547473', '1979-12-24', '', 'ชาย', '90 ซ. วัดหิรัญรูจี ถนน ประชาธิปก', 'หิรัญรูจี', 'ธนบุรี', 'กรุงเทพมหานคร', '10600', '0870649990', 'k.dhanaraksa@gmail.com', '', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 15:20:51', NULL, '2021-11-02 15:57:44'),
(25, 'TH718347', 'Mad Bulldog Shooting Club', 'พิสิษฐ์ ', 'วรรธนะทรงสิน', 'Pisit ', 'Wattanasasongsin', 'Jeep', '3101600728964', '2518-07-18', 'O+', 'ชาย', '997  ซ.อิสระภาพ33  ถ.อิสระภาพ ', 'วัดอรุณ', 'บางกอกใหญ่', 'กรุงเทพมหานคร', '10600', '0852268355', 'pisitjeep@gmail.com', 'dr.jeepkub', '2021-08-24', '2022-09-01', NULL, NULL, 3, 'img/person.png', 'enable', '2020-06-24 08:36:50', NULL, '2021-11-02 15:57:44'),
(26, 'TH744165', '1st Class IDPA', 'ฐาปกร ', 'ผลธรรมปาลิต', 'Thapakorn ', 'Pholdhampalit', 'เหน่ง (Neng)', '3101700395371', '2505-11-15', 'O+', 'ชาย', '79 หมู่บ้านพูนศิริ 2 ซอยสุคนธสวัสดิ์ 3(แนก 6) ถนนส', 'ลาดพร้าว', 'ลาดพร้าว', 'กรุงเทพมหานคร', '10230', '0815696080', 'thapakorn.241@gmail.com', 'thapakorn_241 หรือ tha_korn_24', '2023-02-14', '2022-06-14', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-21 08:22:45', NULL, '2021-11-02 15:57:44'),
(27, 'TH664887', 'PPL', 'กิตติวัจน์ ', 'บัวบาน', 'Kittiwat ', 'Buaban', 'โหน่ง', '3102002757091', '1978-09-11', 'O+', 'ชาย', '2360 หมู่บ้านพนักงานธนาคารทหารไทย ถนน กรุงเทพ- นนท', 'วงศ์สว่าง', 'บางซื่อ', 'กรุงเทพมหานคร', '10800', '0630959789', 'kittiwatx10@gmail.com', '0630959789', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 21:10:52', NULL, '2021-11-02 15:57:44'),
(28, 'TH729701', 'All Alpha', 'กฤษณะ ', 'ปูรานิธี', 'Krissana ', 'Puranitee', 'Tony Kriss', '3102100195330', '1980-09-21', 'A+', 'ชาย', '669 ม.4', 'อุทัย', 'อุทัย', 'พระนครศรีอยุธยา', '13210', '0863740999', 'k.smc.roj@gmail.com', 'tonykriss', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 17:52:20', NULL, '2021-11-02 15:57:44'),
(29, 'TH790857', 'WED Shooting Club', 'เกรียงศักดิ์ ', 'อัจฉริยยศ', 'Kriengsak ', 'Adchariyayot', 'เกรียง, กวาง', '3102100346133', '1977-06-04', 'A+', 'ชาย', '577/48 ลุมพินีสุขุมวิท77', 'สวนหลวง', 'สวนหลวง', 'กรุงเทพมหานคร', '10250', '0897744799', 'sai_0027@hotmail.com', 'fuji.is.fuji', '2022-02-06', '2022-11-22', NULL, NULL, 3, 'img/person.png', 'enable', '2021-04-08 13:30:27', NULL, '2021-11-02 15:57:44'),
(30, 'TH998572', 'All Alpha', 'ธนดี ', 'หงษ์รัตนอุทัย', 'Thanadee ', 'Hongratanauthai', 'Boat', '3102101391981', '1981-03-10', 'O-', 'ชาย', '84/76 ถ.นนทรี', 'แขวงช่องนนทรี', 'ยานนาวา', 'กรุงเทพมหานคร', '10120', '0815870839', 'babyboat@hotmail.com', 'bananaboat', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 15:27:25', NULL, '2021-11-02 15:57:44'),
(31, 'TH1006115', '', 'ธนพัฒน์ ', 'นิยมธรรมกิจ', 'Tanapat ', 'Niyomthamkit', 'เล็ก', '3102202041102', '1970-12-23', 'B+', 'ชาย', '39/121 ม.10  มบ.สิริกานต์', 'บางแม่นาง', 'บางใหญ่', 'นนทบุรี', '11140', '0970157497', 'lim4.ipsc@gmail.com', 'lim4.ipsc', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 15:26:02', NULL, '2021-11-02 15:57:44'),
(32, 'TH1005997', '', 'ณัฐกฤตา ', 'มากขึ้น', 'ณัฐกฤตา ', 'มากขึ้น', 'Natkeeta  Makkurn', '3110100338279', '1982-10-22', 'A+', 'หญิง', '58/1 ม.7', 'บางด้วน', 'เมืองสมุทรปราการ', 'สมุทรปราการ', '10270', '0917637624', 'Su_pranee2525@hotmail.com', '', '2021-08-09', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-12-07 18:57:03', NULL, '2021-11-02 15:57:44'),
(33, 'TH258802', 'IDPA Thailand', 'ศักดิ์ชัย ', 'นิยมนา', 'Sakchai ', 'Niyomna', 'ป้อม บางปลา', '3119900423805', '1968-03-01', 'B-', 'ชาย', '129/12 ม.1 ถ.เทพารักษ์ กม.21', 'บางเสาธง', 'บางเสาธง', 'สมุทรปราการ', '10570', '0613632594', 'sakchaisakchai98@gmail.com', 'p.mauto2555', '2022-09-28', '2022-09-28', NULL, NULL, 3, 'img/person.png', 'enable', '2021-11-02 14:18:35', NULL, '2021-11-02 15:57:44'),
(34, 'TH0006', 'IDPA THAILAND', 'ก้องเกียรติ ', 'นาสิมมา', 'Kongkiat ', 'Nasimma', 'ก้อง', '3120101111910', '1977-09-15', 'O+', 'ชาย', '8 ซ.ติวานนท์ 25 แยก 29 ถ.ติวานนท์', 'บางกระสอ', 'เมือง', 'นนทบุรี', '11000', '0656635364', 'nasimma@hotmail.com', 'Gong-addiction ', '2022-03-21', '2022-03-21', NULL, NULL, 7, 'img/person.png', 'enable', '2020-06-23 22:47:59', NULL, '2021-11-02 15:57:44'),
(35, '', '', 'อดิสรณ์ ', 'เที่ยงธรรม', 'Adisorn ', 'Tangtham', 'โอ', '3120600320310', '1973-01-23', '', 'ชาย', '271/25  หมู่ 6', 'โสนลอย', 'บางบัวทอง', 'นนทบุรี', '11110', '0938247800', 'tiangtham45@gmail.com', '', NULL, NULL, NULL, NULL, 1, 'img/person.png', 'enable', '2019-08-30 15:42:13', NULL, '2021-11-02 15:57:44'),
(36, 'TH1008727', '', 'พิชัยภัทร์ ', 'มหาวีระพงศา', 'Phichaipat ', 'Mahaweeraphongsa', 'Golf', '3120600650468', '1972-01-11', 'B+', 'ชาย', '29/138 เมืองทองธานี ถนน แจ้งวัฒนะ ', 'ตำบล บางพูด', 'อำเภอ ปากเกร็ด', 'นนทบุรี', '11120', '0819229252', 'phichaipatm@gmail.com', 'GFX', '2024-02-22', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2021-04-08 12:34:34', NULL, '2021-11-02 15:57:44'),
(37, 'TH981230', 'IDPA Asia', 'มนตรี ', 'ปานศิริ', 'Montree ', 'pansiri', 'เก๋', '3130600036395', '2521-08-28', 'O+', 'ชาย', '22/2 หมู่5 ', 'คลองเจ็ด', 'คลองหลวง', 'ปทุมธานี', '12120', '0892017865', 'montreemax9@hotmail.con', '0892017865', '2023-08-29', '2021-06-28', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-20 14:42:15', NULL, '2021-11-02 15:57:44'),
(38, 'TH924496 ', '', 'ภูวนัย ', 'ปานม่วง', '', '', 'หมีภู', '3130600512251', '2020-08-20', 'O+', 'ชาย', '42/9 หมู่ 6', 'คลองสี่', 'คลองหลวง', 'ปทุมธานี', '12120', '0979296169', 'poohkimber1911@gmail.com', 'Poohzzzzz ', '2020-11-18', '2022-06-13', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-21 11:44:31', NULL, '2021-11-02 15:57:44'),
(39, 'TH1000348', 'BULLETMASTER', 'ณัฏฐ์ ', 'นาคแก้ว', 'NAT ', 'NAKKAEW', 'ตั้ม', '3150100141297', '1977-06-06', 'O+', 'ชาย', '10/183', 'หนองค้างพลู', 'หนองแขม', 'กรุงเทพมหานคร', '10160', '0629477444', 'tum6620@hotmail.com', 'tum19112012', '2019-09-10', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 09:43:54', NULL, '2021-11-02 15:57:44'),
(40, 'TH823825', '', 'วิทยา ', 'สาณะเสน', 'Witthaya ', 'Sanasen', 'วิท', '3220400427462', '1970-08-30', 'O-', 'ชาย', '115/15 อาคารโมเดิร์นโฮมเพลส 4 room 451', 'ซ.อ่อนนุช 46 แขวงสวนหลวง', 'สวนหลวง', 'กรุงเทพมหานคร', '10250', '0813145107', 'witthayasa@srithepthai.com', '', '2021-02-03', '2022-06-18', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 14:09:44', NULL, '2021-11-02 15:57:44'),
(41, 'TH1006103', 'Thai Police Shooting Club', 'สมภพ ', 'ใบแบแน', 'Sompop ', 'Baibaenae', 'u-zoof', '3230100047605', '1981-02-19', 'B+', 'ชาย', '324 ถนนสุขสวัสดิ์ ', 'บางปะกอก', 'บางปะกอก', 'กรุงเทพมหานคร', '10140', '0896633993', 'sompopbaibaenae@gmail.com', 'u-zoof', '2020-07-13', '2020-07-12', NULL, NULL, 3, 'img/person.png', 'enable', '2020-07-06 22:52:44', NULL, '2021-11-02 15:57:44'),
(42, 'TH1006102', '', 'กฤตธนา ', 'คังคายะ', 'Kritthana ', 'Khangkhaya', 'กฤต', '3240400649848', '2521-03-22', 'AB+', 'ชาย', '429/20 เอื้ออาทร 9 กิโล อาคาร 25', 'สุรศักดิ์', 'ศรีราชา', 'ชลบุรี', '20110', '0645959597', 'prerakrit@hotmail.com', 'Kritthana 🇹🇭', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-21 13:27:19', NULL, '2021-11-02 15:57:44'),
(43, 'TH751702', '', 'ยุทธนา ', 'วีระธารานนท์', 'Yutthana ', 'weeratharanon', 'Eddy', '3300600013369', '1980-02-02', 'B+', 'ชาย', '799 หมู3', 'หนองบัวศาลา', 'เมือง', 'นครราชสีมา', '30000', '0817899365', 'yutthana@icon-engsolutions.com', 'M5341894', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 15:41:52', NULL, '2021-11-02 15:57:44'),
(44, 'TH1016103', 'Thai Police Shooting Club', 'ถวัลย์ ', 'ประเคนรี', 'Thawun ', 'Prekenree', 'ปล้ำ', '3340200048505', '2019-09-18', 'B+', 'ชาย', '17 ซ.เปรมฤทัย23/5', 'ท่าทราย', 'เมือง', 'นนทบุรี', '11000', '0867444177', 'thawun.tpsc@gmail.com', 'Thawun18', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 16:59:14', NULL, '2021-11-02 15:57:44'),
(45, 'TH1005656', 'KKB Shooting Club', 'กิตติกร ', 'ปานะวงศ์', 'Kittikorn ', 'Panawong', 'แคท (cat)', '3350800975041', '1980-12-17', 'O+', 'ชาย', '886/208 หมู่บ้าน PATIO ลาดกระบัง ซ.20 ถ.หลวงแพ่ง', 'ทับยาว', 'ลาดกระบัง', 'กรุงเทพมหานคร', '10520', '0813893128', 'cat101213@gmail.com', '3350800975041', '2021-08-21', '2020-10-14', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 12:46:22', NULL, '2021-11-02 15:57:44'),
(46, 'TH318253', '1st Class IDPA', 'ยศพล ', 'โคตธนู', 'Yodsapol ', 'Kotthanu', 'พล', '3401700132572', '1970-11-23', 'A+', 'ชาย', '33/130 ม.4', 'ลาดสวาย', 'ลำลูกกา', 'ปทุมธานี', '12150', '0818309573', 'supk_it@hotmail.com', 'Supk_it', '2020-07-12', '2022-05-08', NULL, NULL, 3, 'img/person.png', 'enable', '2020-06-24 13:24:02', NULL, '2021-11-02 15:57:44'),
(47, 'TH1006104', 'Thai Police Shooting Club', 'อรรถวิทย์ ', 'กันยา', 'Uttawit ', 'kunya', 'Pop', '3420100034838', '2523-07-20', 'B+', 'ชาย', '207/9 ซอยทหารอากาศ 4 ม.3 บ้านช้าง ', 'หมากแข้ง', 'เมือง', 'อุดรธานี', '41000', '0891200668', 'u_kunya@hotmail.com', 'kapolo56', '2020-07-13', '2020-07-12', NULL, NULL, 3, 'img/person.png', 'enable', '2020-06-28 20:20:02', NULL, '2021-11-02 15:57:44'),
(48, 'TH388588', 'Thai Police Shooting Club', 'ฉัตรชัย ', 'ภิญโญศรี', 'Chatchai ', 'pinyosri', 'Chat', '3451300198274', '1979-04-02', 'O+', 'ชาย', '22/45 หมู่บ้านรสริน 2', 'ดอนเมือง', 'ดอนเมือง', 'กรุงเทพมหานคร', '10210', '0803514564', 'chatpolish@gmail.com', 'Chatimmi', NULL, '2020-10-03', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 11:57:29', NULL, '2021-11-02 15:57:44'),
(49, 'TH1003337', 'Thai Police Shooting Club', 'พงษ์กานต์ ', 'จันทร์เงิน', 'Phongkan ', 'Channgoen', 'กานต์', '3500500354260', '1977-07-22', 'O+', 'ชาย', '32/1', 'ยางเนิ้ง', 'สารภี', 'เชียงใหม่', '50140', '0869143223', 'kan_rowaco@gotmail.com', 'channgoen', '2022-08-03', '2020-07-12', NULL, NULL, 3, 'img/person.png', 'enable', '2020-07-06 23:15:55', NULL, '2021-11-02 15:57:44'),
(50, 'TH1003336', 'Thai Police Shooting Club', 'อำนาจ ', 'ชิดทอง', 'Umnarj ', 'Chittong', 'ต้อม', '3500700238956', '1980-11-23', 'A+', 'ชาย', '39/3 หมู่4 ซอย10', 'แม่ปูคา', 'สันกำแพง', 'เชียงใหม่', '50130', '0866581883', 'tom.umnarj.soth@gmail.com', 'umnarjchittongaa', '2022-03-08', '2022-07-12', '', '231123', 9, 'img/person.png', 'enable', '2020-06-24 09:06:54', 'Umnarj ', '2021-11-11 16:53:22'),
(51, 'TH577942', 'IDPA Thailand Chiangrai', 'สถิต ', 'อุดมวัฒนศิริ', 'Sathit ', 'Udomwatanasiri', 'ที', '3579900038983', '2514-05-22', 'B+', 'ชาย', '192/165 หมู่ที่ 11 (หมู่บ้านรัตนบุรี) ', 'เวียงชัย', 'เวียงชัย', 'เชียงราย', '57210', '0947924566', 'sathit22en@gmail.com', 'sa_4566', '2020-12-18', '2020-11-06', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 08:57:58', NULL, '2021-11-02 15:57:44'),
(52, 'TH1000431', 'Thai Police Shooting Club', 'ปฐวี ', 'วาจาทะศิลป์', 'Patawee ', 'Wajatasilp', 'Win', '3600700333192', '1982-01-19', 'O+', 'ชาย', '98/1 ม.21', 'ตาคลี', 'ตาคลี', 'นครสวรรค์', '60140', '0923659712', 'muay1982@hotmail.com', '', '2021-01-27', '2020-03-11', NULL, NULL, 3, 'img/person.png', 'enable', '2020-07-06 22:11:57', NULL, '2021-11-02 15:57:44'),
(53, 'TH1005644', '', 'ณัฐ​ ', 'ปู่จ้าย', 'Nat​ ', 'Phujay', 'ณัฐ', '3620100608484', '1979-05-18', 'O+', 'ชาย', 'เลขที่​ 9/1​ ถ.สุข​สวัสดิ์​', 'ในคลองบาง​ปลากด​', 'พระสมุทรเจดีย์', 'สมุทรปราการ', '10290', '0815662374', 'nat180522@gmail.com', 'kaunchai01', '2020-06-20', '2021-07-07', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-20 18:55:36', NULL, '2021-11-02 15:57:44'),
(54, 'TH990818', 'KKB Shooting Club', 'สุรชัย ', 'ดวงชาทม', 'Surachai ', 'Duangchathom', 'โอ', '3630700027857', '1977-06-12', 'O+', 'ชาย', '18/8-9', 'บึงคิไห', 'ลำลูกกา', 'ปทุมธานี', '12150', '0836875550', 'bedbee2@gmail.com', 'Surachai5d ', '2020-10-14', '2020-10-14', NULL, NULL, 3, 'img/person.png', 'enable', '2020-08-24 12:29:17', NULL, '2021-11-02 15:57:44'),
(55, 'TH1013052', 'Ban Tak IDPA ', 'รุ่งโรจน์ ', 'ขะมันจา', 'ROONGROJ ', 'KAMANCHAR', 'เข้', '3660400014041', '1971-12-17', 'B+', 'ชาย', '30 หมู่11', 'แม่ท้อ', 'เมือง', 'ตาก', '63000', '0816806882', 'k.roongroj@gmail.com', 'hs6rxs', NULL, '2021-12-15', NULL, NULL, 3, 'img/person.png', 'enable', '2021-04-08 13:21:41', NULL, '2021-11-02 15:57:44'),
(56, 'TH967487', 'IDPA Asia', 'สมชาย ', 'เชิดฉาย', 'Somchai ', 'Cherdchai', 'Tingly', '3710101060783', '2019-08-27', 'O-', 'ชาย', '35/196 moo3', 'Klongsam', 'Klongluang', 'ปทุมธานี', '12120', '0809991047', 'tingly10@yahoo.com', 'tingly-army', NULL, NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2019-08-30 15:36:17', NULL, '2021-11-02 15:57:44'),
(57, 'TH1012434', '', 'ฐาปนนท์ ', 'เลาหพิสิฐพานิช', 'DHAPANON ', 'LAOHAPISITPANICH', 'ตุ้ย', '3710500065860', '1974-09-09', 'O+', 'ชาย', '51 หมู่ 6 ถ.ตลิ่งชัน-สุพรรณบุรี', 'เสาธงหิน', 'บางใหญ่', 'นนทบุรี', '11140', '0869907277', 'dhapanon_l@gmail.com', 'dltenterprise', '2024-05-02', '2021-12-15', NULL, NULL, 3, 'img/person.png', 'enable', '2021-04-09 14:15:55', NULL, '2021-11-02 15:57:44'),
(58, 'TH1006098', 'Thai Police Shooting Club', 'เจษฎา ', 'โสมนัส', 'Jessada ', 'Sommanus', 'เจษ', '3760500019809', '1983-10-11', 'B+', 'ชาย', '17/82 ถนนโชคชัย 4 ซอย 8 ', 'ลาดพร้าว', 'ลาดพร้าว', 'กรุงเทพมหานคร', '10230', '0851444054', 'jessyjopet@gmail.com', 'jessyjopet', '2022-07-13', '2020-07-12', NULL, NULL, 3, 'img/person.png', 'enable', '2020-06-24 13:21:03', NULL, '2021-11-02 15:57:45'),
(59, 'TH878690', 'WED', 'วิชญ์ธวัช ', 'ชมภูนุช', 'Witthawat ', 'Chompunuch', 'บอย', '3840100141177', '2522-04-14', 'B+', 'ชาย', '39/49 ม.6', 'บางคูวัด', 'เมือง', 'ปทุมธานี', '12000', '0646636545', 'cwitthawat@gmail.com', 'acons1', '2021-08-04', '2022-06-09', NULL, NULL, 3, 'img/person.png', 'enable', '2020-06-24 01:59:03', NULL, '2021-11-02 15:57:45'),
(60, 'TH1012505', 'Thai Police Shooting Club', 'กันยกร​ ', 'ลูกทอง', 'Kunyakorn​ ', '​Luktong​', 'หมิว', '3901200003051', '1980-07-21', 'A+', 'หญิง', '25/1  หมู่​ 1​', 'นาหม่อม', 'นาหม่อม', 'สงขลา', '90310', '0827951656​', 'kunyakorn_m@hotmail.com', '4167kunyakorn', '2021-12-10', '2021-12-15', NULL, NULL, 3, 'img/person.png', 'enable', '2021-04-05 12:38:15', NULL, '2021-11-02 15:57:45'),
(61, 'TH934901', 'WED Shooting Club', 'ธนทัศ ', 'แววเพ็ชร', 'Thanatuss ', 'Warwpeth', 'แนน', '3960100334934', '1978-09-18', 'AB+', 'ชาย', '321 ซ.รังสิต-นครนายก 22 ', 'ต.ประชาธิปัตย์.', 'อ. ธัญบุรี ', 'จ. ปทุมธานี', '12130', '061 795 9152', 'Thanatuss40@gmail.com', '061 795 9152', '2021-02-02', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2020-12-09 20:16:05', NULL, '2021-11-02 15:57:45'),
(62, 'TH1009027', '', 'ดำรงค์ ', 'สงค์ประเสริฐ', 'Dumrong ', 'Songprasert', 'rong', '5100599153423', '1964-12-07', 'O+', 'ชาย', '1092/1 Prajak Road', 'Muang', 'Muang', 'Nongkhai', '43000', '0815445929', 'DUMRONG.S@HOTMAIL.COM', '0815445929', '2022-11-02', '2021-02-17', NULL, NULL, 3, 'img/person.png', 'enable', '2021-04-08 14:52:22', NULL, '2021-11-02 15:57:45'),
(63, 'TH577942', 'IDPA Thailand Chiang-rai', 'สถิต ', 'อุดมวัฒนศิริ', 'Sathit ', 'Udomwatanasiri', 'ที', '3579900038983', '2514-05-22', 'B+', 'ชาย', '192/165 หมู่ที่ 11 หมู่บ้านรัตนบุรี', 'เวียงชัย', 'เวียงชัย', 'เชียงราย', '57210', '0947924566', 'sathit22en@gmail.com', 'SA_4566', '2022-02-18', NULL, NULL, NULL, 3, 'img/person.png', 'delete', '2021-11-02 14:47:04', NULL, '2021-11-02 15:57:45'),
(64, 'TH1013654', 'KKB SHOOTING CLUB THAILAND', 'กฤศชณยชญ์ ', 'อัคพราหมณ์', 'Kidchanayod ', 'Akkapram', 'เต้ ออน', '1130100001103', '1984-01-02', 'O+', 'ชาย', '54/20, หมู่ 3, บุราสิริ ราชพฤกษ์-345, ซอย 1/3, ถนน', 'คลองข่อย', 'ปากเกร็ด', 'นนทบุรี', '11120', '0825549666', 'Kidchanayod@hotmail.co.th', '0832559334', '2024-01-27', NULL, NULL, NULL, 3, 'img/person.png', 'enable', '2021-11-02 15:06:44', NULL, '2021-11-02 15:57:45'),
(66, 'TH1009415', 'Glockhub', 'อรรถวิศิษฐ์', 'หัสดินทร ณ อยุธยา', 'Autthavisit', 'Hatsadinthon na ayutthaya', 'Pub', '1100200657183', '1991-07-23', 'A+', 'หญิง', '27/231 หมู่บ้านเดอะสวีทการเด้นวิลล2', 'สามวาตะวันตก', 'คลองสามวา', 'กรุงเทพมหานคร', '10510', '0993698296', 'autthavisit@gmail.com', 'Xhhhdj', '2022-03-02', '2022-10-30', '', '', 3, 'img/person.png', 'enable', '2021-11-11 16:36:15', 'Umnarj ', '2021-11-11 16:36:15'),
(67, 'TH1016787', '', 'ณภัทร', 'ยามะณี', 'Napat', 'Yamanee', 'อาร์ม', '1529900465681', '1990-11-19', 'O+', 'ชาย', '39/35 อินทามาระ4 ถนนสุทธิสารวินิจฉัย ', 'สามเสนใน', 'พญาไทย', 'กรุงเทพ', '10400', '0827634688', 'cecop15@gmail.com', 'cecopp', '2021-09-28', '2024-09-28', '', '123456', 3, 'img/person.png', 'enable', '2021-11-11 16:40:28', 'Umnarj ', '2021-11-11 16:40:28');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_on_duty`
-- (See below for the actual view)
--
CREATE TABLE `v_on_duty` (
`on-duty_id` int(11)
,`match_id` int(11)
,`match_regist_datetime` datetime
,`match_name` varchar(120)
,`match_location` varchar(80)
,`match_detail` text
,`match_level` varchar(10)
,`match_stages` int(11)
,`match_rounds` int(11)
,`match_begin` date
,`match_finish` date
,`match_md` varchar(30)
,`match_md_contact` varchar(60)
,`match_so_list` longtext
,`match_status` varchar(10)
,`match_editor` varchar(30)
,`match_lastupdate` datetime
,`so_id` int(11)
,`so_idpa_id` varchar(10)
,`so_club` varchar(50)
,`so_firstname` varchar(30)
,`so_lastname` varchar(30)
,`so_firstname_en` varchar(30)
,`so_lastname_en` varchar(30)
,`so_nickname` varchar(20)
,`so_citizen_id` varchar(13)
,`so_dob` date
,`so_blood_type` varchar(3)
,`so_sex` varchar(10)
,`so_address` varchar(50)
,`so_subdistrict` varchar(30)
,`so_district` varchar(30)
,`so_province` varchar(30)
,`so_zipcode` varchar(5)
,`so_phone` varchar(30)
,`so_email` varchar(50)
,`so_line_id` varchar(30)
,`so_idpa_expire` date
,`so_license_expire` date
,`so_idpa_profile` varchar(30)
,`so_status` varchar(10)
,`so_regis_datetime` datetime
,`so_editor` varchar(30)
,`so_lastupdate` datetime
,`on-duty_priority` int(2)
,`on-duty_position` varchar(30)
,`on-duty_notes` text
,`on-duty_status` varchar(10)
,`on-duty_editor` varchar(30)
,`on-duty_lastupdate` datetime
);

-- --------------------------------------------------------

--
-- Structure for view `v_on_duty`
--
DROP TABLE IF EXISTS `v_on_duty`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_on_duty`  AS SELECT `on-duty`.`on-duty_id` AS `on-duty_id`, `match-idpa`.`match_id` AS `match_id`, `match-idpa`.`match_regist_datetime` AS `match_regist_datetime`, `match-idpa`.`match_name` AS `match_name`, `match-idpa`.`match_location` AS `match_location`, `match-idpa`.`match_detail` AS `match_detail`, `match-idpa`.`match_level` AS `match_level`, `match-idpa`.`match_stages` AS `match_stages`, `match-idpa`.`match_rounds` AS `match_rounds`, `match-idpa`.`match_begin` AS `match_begin`, `match-idpa`.`match_finish` AS `match_finish`, `match-idpa`.`match_md` AS `match_md`, `match-idpa`.`match_md_contact` AS `match_md_contact`, `match-idpa`.`match_so_list` AS `match_so_list`, `match-idpa`.`match_status` AS `match_status`, `match-idpa`.`match_editor` AS `match_editor`, `match-idpa`.`match_lastupdate` AS `match_lastupdate`, `so-member`.`so_id` AS `so_id`, `so-member`.`so_idpa_id` AS `so_idpa_id`, `so-member`.`so_club` AS `so_club`, `so-member`.`so_firstname` AS `so_firstname`, `so-member`.`so_lastname` AS `so_lastname`, `so-member`.`so_firstname_en` AS `so_firstname_en`, `so-member`.`so_lastname_en` AS `so_lastname_en`, `so-member`.`so_nickname` AS `so_nickname`, `so-member`.`so_citizen_id` AS `so_citizen_id`, `so-member`.`so_dob` AS `so_dob`, `so-member`.`so_blood_type` AS `so_blood_type`, `so-member`.`so_sex` AS `so_sex`, `so-member`.`so_address` AS `so_address`, `so-member`.`so_subdistrict` AS `so_subdistrict`, `so-member`.`so_district` AS `so_district`, `so-member`.`so_province` AS `so_province`, `so-member`.`so_zipcode` AS `so_zipcode`, `so-member`.`so_phone` AS `so_phone`, `so-member`.`so_email` AS `so_email`, `so-member`.`so_line_id` AS `so_line_id`, `so-member`.`so_idpa_expire` AS `so_idpa_expire`, `so-member`.`so_license_expire` AS `so_license_expire`, `so-member`.`so_idpa_profile` AS `so_idpa_profile`, `so-member`.`so_status` AS `so_status`, `so-member`.`so_regis_datetime` AS `so_regis_datetime`, `so-member`.`so_editor` AS `so_editor`, `so-member`.`so_lastupdate` AS `so_lastupdate`, `on-duty`.`on-duty_priority` AS `on-duty_priority`, `on-duty`.`on-duty_position` AS `on-duty_position`, `on-duty`.`on-duty_notes` AS `on-duty_notes`, `on-duty`.`on-duty_status` AS `on-duty_status`, `on-duty`.`on-duty_editor` AS `on-duty_editor`, `on-duty`.`on-duty_lastupdate` AS `on-duty_lastupdate` FROM ((`on-duty` left join `match-idpa` on(`on-duty`.`match_id` = `match-idpa`.`match_id`)) left join `so-member` on(`so-member`.`so_id` = `on-duty`.`so_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `match-idpa`
--
ALTER TABLE `match-idpa`
  ADD PRIMARY KEY (`match_id`);

--
-- Indexes for table `on-duty`
--
ALTER TABLE `on-duty`
  ADD PRIMARY KEY (`on-duty_id`);

--
-- Indexes for table `on-duty-position`
--
ALTER TABLE `on-duty-position`
  ADD PRIMARY KEY (`post_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`setting_id`);

--
-- Indexes for table `so-member`
--
ALTER TABLE `so-member`
  ADD PRIMARY KEY (`so_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `match-idpa`
--
ALTER TABLE `match-idpa`
  MODIFY `match_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `on-duty`
--
ALTER TABLE `on-duty`
  MODIFY `on-duty_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `on-duty-position`
--
ALTER TABLE `on-duty-position`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `so-member`
--
ALTER TABLE `so-member`
  MODIFY `so_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
