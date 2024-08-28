-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 06, 2024 at 12:05 PM
-- Server version: 10.6.18-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `etctra_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendence`
--

CREATE TABLE `attendence` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `attendence` tinyint(4) NOT NULL DEFAULT 0,
  `user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendence`
--

INSERT INTO `attendence` (`id`, `course_id`, `class_id`, `teacher_id`, `attendence`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 94, 110, 15, 0, 3, '2023-04-17 12:57:16', '2023-01-28 07:21:33');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `image` text DEFAULT NULL,
  `title` text DEFAULT NULL,
  `subtitle` text DEFAULT NULL,
  `btn_link` text DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `section` varchar(255) NOT NULL DEFAULT 'home-main',
  `banner_text` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `banners`
--

INSERT INTO `banners` (`id`, `image`, `title`, `subtitle`, `btn_link`, `start_date`, `end_date`, `section`, `banner_text`, `created_at`, `updated_at`) VALUES
(8, 'banners1694414382.jpg', NULL, NULL, NULL, '2023-09-11', '2025-01-01', 'home-main', 'Connecting teachers with students ............. all over the world !!!', '2023-09-11 06:39:42', '2023-09-22 05:45:29'),
(9, 'banners1694414757.jpg', NULL, NULL, NULL, '2023-09-11', '2024-09-11', 'home-main', 'Fun hobby courses ............. for everyone in the family !!!', '2023-09-11 06:45:57', '2023-09-22 05:00:14'),
(10, 'banners1694415035.jpg', NULL, NULL, NULL, '2023-09-11', '2025-01-01', 'home-main', 'Busy during weekdays?  ....... join our weekend classes !!!', '2023-09-11 06:50:35', '2023-09-22 05:46:48'),
(11, 'banners1694415088.jpg', NULL, NULL, NULL, '2023-09-11', '2025-01-01', 'home-main', 'Choose your class timing ............ as per your\'s and the baby\'s convenience !!!', '2023-09-11 06:51:28', '2023-09-22 05:48:02'),
(12, 'banners1694415135.jpg', NULL, NULL, NULL, '2023-09-11', '2024-09-11', 'home-main', 'If you have knowledge, let others light their candles in it !!!', '2023-09-11 06:52:15', '2023-09-21 11:42:06'),
(13, 'banners1694415169.jpg', NULL, NULL, NULL, '2023-09-11', '2024-09-11', 'home-main', 'It\'s cool to have hobbies .......... be a student forever !!!', '2023-09-11 06:52:49', '2023-09-20 12:06:03'),
(14, 'banners1694415248.jpg', NULL, NULL, NULL, '2023-09-11', '2024-09-11', 'home-main', 'Anyone who stops learning is old ............ keep learning, stay young !!!', '2023-09-11 06:54:08', '2023-09-20 12:04:54');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `icon` text DEFAULT NULL,
  `parent` int(11) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `indexing` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `short_description`, `icon`, `parent`, `order`, `indexing`, `created_at`, `updated_at`) VALUES
(24, 'Creative art', NULL, 'icon/icon1711792043.jpg', NULL, 5, 5, '2022-11-25 10:25:55', '2024-03-30 09:47:23'),
(25, 'Languages', NULL, 'icon/icon1711791825.jpg', NULL, 4, 4, '2022-11-25 10:28:55', '2024-03-30 09:43:45'),
(26, 'Fitness', NULL, 'icon/icon1711791761.jpg', NULL, 3, 3, '2022-11-25 10:31:45', '2024-03-30 09:42:41'),
(27, 'Fine arts', NULL, 'icon/icon1711791562.jpg', NULL, 0, 2, '2022-11-25 10:33:48', '2024-03-30 09:39:22'),
(39, 'Singing', NULL, 'icon/icon1711794752.jpg', 175, 1, 1, '2023-01-31 12:37:06', '2024-03-30 10:32:32'),
(41, 'Hindustani classical', NULL, 'icon/icon1714360584.png', 39, 0, NULL, '2023-03-25 03:46:54', '2024-04-29 03:16:24'),
(44, 'Western', NULL, 'icon/icon1712344015.jpg', 39, 0, NULL, '2023-03-25 04:36:05', '2024-04-05 19:06:55'),
(45, 'Bollywood songs', NULL, 'icon/icon1712344090.jpg', 39, 0, NULL, '2023-03-25 04:37:27', '2024-04-05 19:08:10'),
(47, 'Carnatic classical', NULL, 'icon/icon1711794924.jpg', 39, 0, NULL, '2023-03-25 04:37:27', '2024-03-30 10:35:24'),
(48, 'Painting', NULL, 'icon/icon1716196364.png', 27, 1, 2, '2023-03-25 05:03:39', '2024-05-20 09:12:44'),
(49, 'Handwriting & Calligraphy', NULL, 'icon/icon1711793978.jpg', 27, 2, 3, '2023-03-25 05:04:42', '2024-03-30 10:19:38'),
(50, 'Exercise', NULL, 'icon/icon1711793912.jpg', 26, 1, NULL, '2023-03-29 05:24:50', '2024-03-30 10:18:32'),
(51, 'Indian languages', NULL, 'icon/icon1714361072.png', 25, 2, 2, '2023-05-02 12:48:12', '2024-04-29 03:24:32'),
(52, 'Kathak', NULL, 'icon/icon1714354694.png', 188, 0, 1, '2023-05-22 06:42:49', '2024-04-29 01:38:14'),
(53, 'Bharatanatyam', NULL, 'icon/icon1694757117.jpg', 11, 0, 2, '2023-05-22 06:47:05', '2023-09-18 05:37:25'),
(54, 'Bollywood', NULL, 'icon/icon1711795117.jpg', 188, 0, 3, '2023-05-22 06:49:53', '2024-03-30 10:38:37'),
(55, 'Fusion', NULL, 'icon/icon1711795176.jpg', 188, 0, 4, '2023-05-22 06:52:51', '2024-03-30 10:39:36'),
(56, 'Dandiya / Garba', NULL, 'icon/icon1711795290.jpg', 188, 0, 5, '2023-05-22 06:56:43', '2024-03-30 10:41:30'),
(57, 'Piano', NULL, 'icon/icon1711795395.jpg', 193, 0, 2, '2023-05-22 07:04:58', '2024-03-30 10:43:15'),
(58, 'Keyboard', NULL, 'icon/icon1712344284.jpg', 193, 0, 3, '2023-05-22 07:12:28', '2024-04-05 19:11:24'),
(60, 'Tabla', NULL, 'icon/icon1711799525.jpg', 193, 0, 4, '2023-05-22 07:16:07', '2024-03-30 11:52:05'),
(64, 'Ukulele', NULL, 'icon/icon1684740428.jpg', 20, 0, NULL, '2023-05-22 07:27:09', '2023-09-18 05:43:27'),
(65, 'Voilin', NULL, 'icon/icon1711799623.jpg', 193, 0, 6, '2023-05-22 07:30:17', '2024-03-30 11:53:43'),
(67, 'Acting and drama', NULL, 'icon/icon1711794169.jpg', 175, 4, 4, '2023-05-22 07:42:56', '2024-03-30 10:22:50'),
(68, 'Acting', NULL, 'icon/icon1714354965.jpg', 67, 0, NULL, '2023-05-22 07:45:30', '2024-04-29 01:42:45'),
(69, 'Mimicry', NULL, 'icon/icon1712344466.jpg', 67, 0, NULL, '2023-05-22 08:06:16', '2024-04-05 19:14:26'),
(70, 'Comedy', NULL, 'icon/icon1711799744.jpg', 67, 0, NULL, '2023-05-22 08:10:22', '2024-03-30 11:55:44'),
(71, 'Public speaking', NULL, 'icon/icon1712344394.jpg', 67, 0, NULL, '2023-05-22 08:14:09', '2024-04-05 19:13:14'),
(72, 'Story telling', NULL, 'icon/icon1711799880.jpg', 67, 0, NULL, '2023-05-22 08:20:41', '2024-03-30 11:58:00'),
(73, 'Drawing', NULL, 'icon/icon1711794107.jpg', 27, 0, 1, '2023-05-22 08:27:56', '2024-03-30 10:21:47'),
(74, 'Pencil sketching', NULL, 'icon/icon1711800000.jpg', 73, 0, 1, '2023-05-22 08:46:20', '2024-03-30 12:00:00'),
(75, 'Canvas painting', NULL, 'icon/icon1711800074.jpg', 48, 1, 1, '2023-05-22 09:47:51', '2024-03-30 12:01:14'),
(76, 'Water colour painting', NULL, 'icon/icon1711800111.jpg', 48, 2, 2, '2023-05-22 09:56:47', '2024-03-30 12:01:51'),
(77, 'Fabric painting', NULL, 'icon/icon1711800138.jpg', 48, 3, 3, '2023-05-22 10:04:57', '2024-03-30 12:02:18'),
(78, 'Acrylic painting', NULL, 'icon/icon1711800164.jpg', 48, 4, 4, '2023-05-22 10:16:26', '2024-03-30 12:02:44'),
(79, 'Caricature', NULL, 'icon/icon1711800036.jpg', 73, 0, 3, '2023-05-22 10:22:49', '2024-03-30 12:00:36'),
(80, 'Mandala art', NULL, 'icon/icon1711800195.jpg', 48, 5, 5, '2023-05-22 10:27:23', '2024-03-30 12:03:15'),
(81, 'Doodling', NULL, 'icon/icon1712170234.jpg', 73, 0, 2, '2023-05-22 10:30:17', '2024-04-03 18:50:34'),
(82, 'Warli painting', NULL, 'icon/icon1711800234.jpg', 48, 6, 6, '2023-05-22 10:34:27', '2024-03-30 12:03:54'),
(83, '3D art', NULL, 'icon/icon1711801355.jpg', 48, 10, 10, '2023-05-22 10:43:12', '2024-03-30 12:22:35'),
(84, 'Resin art', NULL, 'icon/icon1711801387.jpg', 48, 11, 11, '2023-05-22 10:49:21', '2024-03-30 12:23:07'),
(85, 'Yoga', NULL, 'icon/icon1711944342.jpg', 50, 0, NULL, '2023-05-22 11:04:40', '2024-04-01 04:05:42'),
(86, 'Aerobics', NULL, 'icon/icon1711944377.jpg', 50, 0, NULL, '2023-05-22 11:16:53', '2024-04-01 04:06:17'),
(87, 'Zumba', NULL, 'icon/icon1711944416.jpg', 50, 0, NULL, '2023-05-22 11:20:49', '2024-04-01 04:06:56'),
(88, 'General fitness', NULL, 'icon/icon1711944449.jpg', 50, 0, NULL, '2023-05-22 11:29:17', '2024-04-01 04:07:29'),
(90, 'Relaxation', NULL, 'icon/icon1712346565.jpg', 26, 2, NULL, '2023-06-26 09:33:01', '2024-04-05 19:49:25'),
(91, 'Indoor sports', NULL, 'icon/icon1711793701.jpg', 26, 3, NULL, '2023-06-26 09:35:50', '2024-03-30 10:15:01'),
(92, 'Foreign languages', NULL, 'icon/icon1711793595.jpg', 25, 1, 1, '2023-06-26 09:40:57', '2024-03-30 10:13:15'),
(93, 'Writing', NULL, 'icon/icon1711793495.jpg', 24, 0, NULL, '2023-06-26 09:44:23', '2024-03-30 10:11:35'),
(94, 'Film-making', NULL, 'icon/icon1711793429.jpg', 24, 0, NULL, '2023-06-26 09:46:23', '2024-03-30 10:10:30'),
(95, 'Designing', NULL, 'icon/icon1711793369.jpg', 190, 0, NULL, '2023-06-26 09:48:18', '2024-03-30 10:09:29'),
(96, 'Abacus', NULL, 'icon/icon1712168452.jpg', 196, 0, NULL, '2023-06-26 09:51:13', '2024-04-03 18:20:52'),
(97, 'Vedic maths', NULL, 'icon/icon1712168509.jpg', 196, 0, NULL, '2023-06-26 09:52:16', '2024-04-03 18:21:49'),
(98, 'Needle work', NULL, 'icon/icon1711793278.jpg', 192, 0, 1, '2023-06-26 10:00:57', '2024-03-30 10:07:58'),
(99, 'Cooking', NULL, 'icon/icon1711793128.jpg', 192, 0, 3, '2023-06-26 10:16:07', '2024-03-30 10:05:28'),
(100, 'Beauty &  skin care', NULL, 'icon/icon1711793178.jpg', 192, 0, 2, '2023-06-26 10:29:42', '2024-03-30 10:06:18'),
(101, 'Gardening', NULL, 'icon/icon1711793003.jpg', 192, 0, NULL, '2023-06-26 10:31:14', '2024-03-30 10:03:23'),
(102, 'Ettiquettes', NULL, 'icon/icon1711792962.jpg', 192, 0, 4, '2023-06-26 10:34:29', '2024-03-30 10:02:42'),
(103, 'Money matters', NULL, 'icon/icon1711792849.jpg', 192, 0, 6, '2023-06-26 10:40:06', '2024-04-05 19:54:18'),
(105, 'Meditation', NULL, 'icon/icon1711944516.jpg', 90, 0, NULL, '2023-06-29 14:19:21', '2024-04-01 04:08:36'),
(106, 'Reiki', NULL, 'icon/icon1711944588.jpg', 90, 0, NULL, '2023-06-29 14:20:37', '2024-04-01 04:09:48'),
(107, 'Pranic healing', NULL, 'icon/icon1711944620.jpg', 90, 0, NULL, '2023-06-29 14:21:02', '2024-04-01 04:10:20'),
(108, 'Chess', NULL, 'icon/icon1711944663.jpg', 91, 0, NULL, '2023-06-29 14:21:44', '2024-04-01 04:11:03'),
(109, 'Rubik\'s cube', NULL, 'icon/icon1711944710.jpg', 91, 0, NULL, '2023-06-29 14:23:16', '2024-04-01 04:11:50'),
(110, 'English', NULL, 'icon/icon1714360833.png', 92, 0, NULL, '2023-06-29 14:23:58', '2024-04-29 03:20:33'),
(111, 'French', NULL, 'icon/icon1712345204.jpg', 92, 0, NULL, '2023-06-29 14:26:36', '2024-04-05 19:26:44'),
(112, 'Spanish', NULL, 'icon/icon1712345230.jpg', 92, 0, NULL, '2023-06-29 14:27:08', '2024-04-05 19:27:10'),
(113, 'Chinese', NULL, 'icon/icon1712167158.jpg', 92, 0, NULL, '2023-06-29 14:28:41', '2024-04-03 17:59:18'),
(114, 'Poems', NULL, 'icon/icon1712167706.jpg', 93, 0, NULL, '2023-06-29 14:54:04', '2024-04-03 18:08:26'),
(115, 'German', NULL, 'icon/icon1712167192.jpg', 92, 0, NULL, '2023-06-30 12:14:57', '2024-04-03 17:59:52'),
(116, 'Japanese', NULL, 'icon/icon1712167274.jpg', 92, 0, NULL, '2023-06-30 12:22:27', '2024-04-03 18:01:14'),
(117, 'Korean', NULL, 'icon/icon1712167300.jpg', 92, 0, NULL, '2023-06-30 12:24:11', '2024-04-03 18:01:40'),
(118, 'Arabic', NULL, 'icon/icon1712167379.jpg', 92, 0, NULL, '2023-06-30 12:27:45', '2024-04-03 18:02:59'),
(119, 'Hindi', NULL, 'icon/icon1714356595.png', 51, 0, NULL, '2023-06-30 12:29:27', '2024-04-29 02:09:55'),
(120, 'Sanskrit', NULL, 'icon/icon1714358458.png', 51, 0, NULL, '2023-06-30 12:32:28', '2024-04-29 02:40:58'),
(121, 'Tamil', NULL, 'icon/icon1714356816.png', 51, 0, NULL, '2023-06-30 12:34:27', '2024-04-29 02:13:36'),
(122, 'Urdu', NULL, 'icon/icon1714356948.png', 51, 0, NULL, '2023-06-30 12:36:55', '2024-04-29 02:15:48'),
(123, 'Novels', NULL, 'icon/icon1712167724.jpg', 93, 0, NULL, '2023-07-01 12:32:46', '2024-04-03 18:08:44'),
(124, 'Plays', NULL, 'icon/icon1712167788.jpg', 93, 0, NULL, '2023-07-01 12:36:29', '2024-04-03 18:09:48'),
(125, 'Lyrics', NULL, 'icon/icon1712167813.jpg', 93, 0, NULL, '2023-07-01 12:37:04', '2024-04-03 18:10:13'),
(126, 'Creative journaling', NULL, 'icon/icon1712167847.jpg', 93, 0, NULL, '2023-07-01 12:37:56', '2024-04-03 18:10:47'),
(127, 'Blogs', NULL, 'icon/icon1712167931.jpg', 93, 0, NULL, '2023-07-01 12:38:38', '2024-04-03 18:12:11'),
(128, 'Basics of film making', NULL, 'icon/icon1712168041.jpg', 94, 0, NULL, '2023-07-01 12:41:21', '2024-04-03 18:14:01'),
(129, 'Animation', NULL, 'icon/icon1712168069.jpg', 94, 0, NULL, '2023-07-01 12:44:33', '2024-04-03 18:14:29'),
(130, 'Interior design', NULL, 'icon/icon1712168411.jpg', 95, 0, NULL, '2023-07-01 12:52:25', '2024-04-03 18:20:11'),
(131, 'Jewellery design', NULL, 'icon/icon1712168428.jpg', 95, 0, NULL, '2023-07-01 12:54:43', '2024-04-03 18:20:28'),
(132, 'Hand sewing', NULL, 'icon/icon1712168547.jpg', 98, 0, NULL, '2023-07-01 12:56:19', '2024-04-03 18:22:27'),
(133, 'Buttoning', NULL, 'icon/icon1712168583.jpg', 98, 0, NULL, '2023-07-01 12:58:16', '2024-04-03 18:23:03'),
(134, 'Basic embroidery', NULL, 'icon/icon1712168637.jpg', 98, 0, NULL, '2023-07-01 13:02:46', '2024-04-03 18:23:57'),
(135, 'Crocheting', NULL, 'icon/icon1712345848.jpg', 98, 0, NULL, '2023-07-01 13:03:22', '2024-04-05 19:37:28'),
(136, 'Self make-up', NULL, 'icon/icon1712168819.jpg', 100, 0, NULL, '2023-07-01 13:05:35', '2024-04-03 18:27:00'),
(137, 'Professional make-up', NULL, 'icon/icon1712346009.jpg', 100, 0, NULL, '2023-07-01 13:16:38', '2024-04-05 19:40:09'),
(138, 'Nail art', NULL, 'icon/icon1712168891.jpg', 100, 0, NULL, '2023-07-01 13:18:55', '2024-04-03 18:28:11'),
(139, 'Hairstyle', NULL, 'icon/icon1712346060.jpg', 100, 0, NULL, '2023-07-01 13:22:16', '2024-04-05 19:41:00'),
(140, 'Skin care for self', NULL, 'icon/icon1712346145.jpg', 100, 0, NULL, '2023-07-01 13:26:39', '2024-04-05 19:42:25'),
(141, 'Kitchen to the rescue', NULL, 'icon/icon1712346204.jpg', 100, 0, NULL, '2023-07-01 13:29:35', '2024-04-05 19:43:24'),
(142, 'Beverages', NULL, 'icon/icon1712169171.jpg', 99, 0, NULL, '2023-07-01 13:32:43', '2024-04-03 18:32:51'),
(143, 'Baking', NULL, 'icon/icon1712169252.jpg', 99, 0, NULL, '2023-07-01 13:33:40', '2024-04-03 18:34:12'),
(144, 'Indian', NULL, 'icon/icon1712169516.jpg', 99, 0, NULL, '2023-07-01 13:35:55', '2024-04-03 18:38:36'),
(145, 'Continental', NULL, 'icon/icon1712169612.jpg', 99, 0, NULL, '2023-07-01 13:37:53', '2024-04-03 18:40:12'),
(146, 'Italian', NULL, 'icon/icon1712169635.jpg', 99, 0, NULL, '2023-07-01 13:40:37', '2024-04-03 18:40:35'),
(147, 'Mexican', NULL, 'icon/icon1712169691.jpg', 99, 0, NULL, '2023-07-01 14:04:12', '2024-04-03 18:41:31'),
(148, 'Salads', NULL, 'icon/icon1712169784.jpg', 99, 0, NULL, '2023-07-01 14:06:04', '2024-04-03 18:43:04'),
(149, 'No-gas cooking', NULL, 'icon/icon1712169844.jpg', 99, 0, NULL, '2023-07-01 14:06:29', '2024-04-03 18:44:04'),
(150, 'Clueless in the kitchen', NULL, 'icon/icon1712169867.jpg', 99, 0, NULL, '2023-07-01 14:08:23', '2024-04-03 18:44:27'),
(151, 'Basics of home gardening', NULL, 'icon/icon1712169915.jpg', 101, 0, NULL, '2023-07-01 14:09:04', '2024-04-03 18:45:15'),
(152, 'Social ettiquettes', NULL, 'icon/icon1712169943.jpg', 102, 0, NULL, '2023-07-01 14:09:54', '2024-04-03 18:45:43'),
(153, 'Dining ettiquettes', NULL, 'icon/icon1714358880.png', 102, 0, NULL, '2023-07-01 14:10:31', '2024-04-29 02:48:00'),
(154, 'Basics of banking', NULL, 'icon/icon1713463190.jpg', 103, 0, NULL, '2023-07-01 14:11:37', '2024-04-18 17:59:50'),
(155, 'General courses', NULL, 'icon/icon1711792640.jpg', 192, 0, 7, '2023-07-01 14:14:44', '2024-03-30 09:57:20'),
(156, 'Typing', NULL, 'icon/icon1712170031.jpg', 155, 0, NULL, '2023-07-01 14:15:13', '2024-04-03 18:47:11'),
(157, 'Self defense', NULL, 'icon/icon1712170058.jpg', 155, 0, NULL, '2023-07-01 14:17:21', '2024-04-03 18:47:38'),
(158, 'Emergency response', NULL, 'icon/icon1712170080.jpg', 155, 0, NULL, '2023-07-01 14:19:04', '2024-04-03 18:48:00'),
(159, 'Madhubani painting', NULL, 'icon/icon1711800281.jpg', 48, 7, 7, '2023-09-11 09:23:39', '2024-03-30 12:04:41'),
(160, 'Pichwai painting', NULL, 'icon/icon1711801289.jpg', 48, 8, 8, '2023-09-11 09:29:32', '2024-03-30 12:21:29'),
(161, 'Lippan art', NULL, 'icon/icon1711801326.jpg', 48, 9, 9, '2023-09-11 09:31:22', '2024-03-30 12:22:06'),
(162, 'Editing', NULL, 'icon/icon1712168138.jpg', 94, 0, NULL, '2023-09-12 06:07:47', '2024-04-03 18:15:38'),
(163, 'Photography', NULL, 'icon/icon1712168176.jpg', 94, 0, NULL, '2023-09-12 06:08:29', '2024-04-03 18:16:16'),
(164, 'Mobile photography', NULL, 'icon/icon1712168279.jpg', 94, 0, NULL, '2023-09-12 06:09:24', '2024-04-03 18:17:59'),
(165, 'Kannada', NULL, 'icon/icon1714357309.png', 51, 0, NULL, '2023-09-12 06:58:07', '2024-04-29 02:21:49'),
(166, 'Bangla', NULL, 'icon/icon1714357472.png', 51, 0, NULL, '2023-09-12 06:58:54', '2024-04-29 02:24:32'),
(169, 'Punjabi', NULL, 'icon/icon1712167609.jpg', 51, 0, NULL, '2023-09-12 07:06:50', '2024-04-03 18:06:49'),
(170, 'Marathi', NULL, 'icon/icon1714357649.png', 51, 0, NULL, '2023-09-12 07:07:33', '2024-04-29 02:27:29'),
(171, 'Contemporary', NULL, 'icon/icon1711795323.jpg', 188, 0, 6, '2023-09-15 05:50:05', '2024-03-30 10:42:03'),
(172, 'Basics of calligraphy', NULL, 'icon/icon1711801475.jpg', 49, 0, NULL, '2023-09-16 12:05:34', '2024-03-30 12:24:35'),
(173, 'Creative writing', NULL, 'icon/icon1712168006.jpg', 93, 0, NULL, '2023-09-18 11:10:25', '2024-04-03 18:13:26'),
(174, 'Handwriting improvement', NULL, 'icon/icon1711944207.jpg', 49, 0, NULL, '2023-09-19 07:15:59', '2024-04-01 04:03:27'),
(175, 'Performing arts', NULL, 'icon/icon1711791229.jpg', 0, 0, 1, '2023-11-08 11:45:11', '2024-03-30 09:33:49'),
(188, 'Dancing', NULL, 'icon/icon1711794633.jpg', 175, 0, 2, '2024-01-27 13:52:51', '2024-03-30 10:30:33'),
(189, 'Bharatnatyam', NULL, 'icon/icon1711795067.jpg', 188, 0, 2, '2024-01-27 13:54:48', '2024-03-30 10:37:47'),
(190, 'Applied Art', NULL, 'icon/icon1711792219.jpg', 0, 0, 6, '2024-01-27 13:59:07', '2024-03-30 09:50:19'),
(191, 'Maths can be fun too!!', NULL, 'icon/icon1711792301.jpg', 0, 0, 7, '2024-01-27 14:00:59', '2024-03-30 09:51:41'),
(192, 'Life skills', NULL, 'icon/icon1711792447.jpg', 0, 0, 8, '2024-01-27 14:02:04', '2024-03-30 09:54:07'),
(193, 'Instrumental music', NULL, 'icon/icon1711794424.jpg', 175, 0, 3, '2024-01-27 14:25:30', '2024-03-30 10:27:04'),
(194, 'Guitar', NULL, 'icon/icon1711795359.jpg', 193, 0, 1, '2024-01-27 14:27:27', '2024-03-30 10:42:39'),
(195, 'Ukelele', NULL, 'icon/icon1711799560.jpg', 193, 0, 5, '2024-01-27 14:30:19', '2024-03-30 11:52:40'),
(196, 'Fun with maths', NULL, 'icon/icon1711793330.jpg', 191, 0, NULL, '2024-01-27 23:12:04', '2024-03-30 10:08:50'),
(197, 'Miniature tray gardening', NULL, 'icon/icon1712347182.jpg', 101, 0, NULL, '2024-04-05 19:59:42', '2024-04-05 19:59:42'),
(198, 'Terrarium gardening', NULL, 'icon/icon1712347253.jpg', 101, 0, NULL, '2024-04-05 20:00:53', '2024-04-05 20:00:53'),
(199, 'Growing microgreens', NULL, 'icon/icon1712347308.jpg', 101, 0, NULL, '2024-04-05 20:01:48', '2024-04-05 20:01:48'),
(200, 'Basics of investing in mutual funds', NULL, 'icon/icon1713463488.jpg', 103, 0, NULL, '2024-04-05 20:11:55', '2024-04-18 18:04:48'),
(201, 'Basics of investing in  stock market', NULL, 'icon/icon1712348062.jpg', 103, 0, NULL, '2024-04-05 20:14:22', '2024-04-05 20:14:22');

-- --------------------------------------------------------

--
-- Table structure for table `circullum`
--

CREATE TABLE `circullum` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `circullum_topic`
--

CREATE TABLE `circullum_topic` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `circullum_id` int(11) NOT NULL,
  `topic` text NOT NULL,
  `description` text DEFAULT NULL,
  `is_complete` tinyint(1) NOT NULL DEFAULT 0,
  `cover_time` time NOT NULL DEFAULT '00:00:01',
  `class_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `circullum_topic`
--

INSERT INTO `circullum_topic` (`id`, `course_id`, `circullum_id`, `topic`, `description`, `is_complete`, `cover_time`, `class_url`) VALUES
(1, 19, 1, 'Web Designing Beginner', 'description', 1, '00:00:01', NULL),
(2, 19, 1, 'Startup Designing with HTML5 & CSS3', 'description', 0, '00:00:01', NULL),
(3, 19, 2, 'Web Designing Beginner', 'Web Designing Beginner', 2, '17:00:00', NULL),
(4, 110, 3, 'RGGGAERGRF', 'wertghjsdfghjsedfghj', 1, '14:22:00', 'https://mohita.hybridplus.in/admin/v1/circullum/circullum-add/110'),
(5, 110, 4, 'wefsdfefwef', 'sdfghjkhjk', 0, '12:45:00', 'https://mohita.hybridplus.in/admin/v1/circullum/circullum-add/110'),
(6, 110, 5, 'wertyuiolkjhgfdsazxc vm', 'wertyuiolkjhgfdsazxc vm', 0, '12:45:00', 'https://mohita.hybridplus.in/admin/v1/circullum/circullum-add/110qw'),
(7, 110, 3, 'wertjsdfghsdfghje', 'frgtdgrgrgsg', 0, '12:34:00', 'fgearhtht'),
(8, 110, 3, 'wefsdfefwef', 'asdfghjnbvcxzxcvbn', 0, '12:34:00', 'https://mohita.hybridplus.in/admin/v1/circullum/circullum-add/110');

-- --------------------------------------------------------

--
-- Table structure for table `class_course`
--

CREATE TABLE `class_course` (
  `id` int(200) NOT NULL,
  `course_id` varchar(2000) DEFAULT NULL,
  `course_name` varchar(2000) NOT NULL,
  `time` varchar(2000) DEFAULT NULL,
  `url` varchar(2000) NOT NULL,
  `start_date` varchar(2000) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `class_course`
--

INSERT INTO `class_course` (`id`, `course_id`, `course_name`, `time`, `url`, `start_date`, `created_at`, `updated_at`) VALUES
(1131, '294', 'Class1', NULL, 'https://etcetra.hybridplus.in/', '2023-09-25', '2023-09-16 06:31:02', '2023-09-16 06:31:02'),
(1132, '294', 'Class2', NULL, 'https://etcetra.hybridplus.in/', '2023-10-02', '2023-09-16 06:31:02', '2023-09-16 06:31:02'),
(1133, '294', 'Class3', NULL, 'https://etcetra.hybridplus.in/', '2023-10-09', '2023-09-16 06:31:02', '2023-09-16 06:31:02'),
(1269, '303', 'Class1', '02:12', 'https://etcetra.hybridplus.in/', '2023-10-23', '2023-10-12 07:41:39', '2023-10-12 07:41:39'),
(1270, '304', 'Class1', '14:15', 'https://etcetra.hybridplus.in/', '2023-10-23', '2023-10-12 07:43:53', '2023-10-12 07:43:53'),
(1271, '304', 'Class2', '14:15', 'https://etcetra.hybridplus.in/', '2023-10-30', '2023-10-12 07:43:53', '2023-10-12 07:43:53'),
(1272, '304', 'Class3', '14:15', 'https://etcetra.hybridplus.in/', '2023-11-06', '2023-10-12 07:43:53', '2023-10-12 07:43:53'),
(1273, '304', 'Class4', '14:15', 'https://etcetra.hybridplus.in/', '2023-11-13', '2023-10-12 07:43:53', '2023-10-12 07:43:53'),
(1274, '305', 'Class1', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-02-25', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1275, '305', 'Class2', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-02-19', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1276, '305', 'Class3', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-03', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1277, '305', 'Class4', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-02-26', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1278, '305', 'Class5', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-10', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1279, '305', 'Class6', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-04', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1280, '305', 'Class7', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-17', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1281, '305', 'Class8', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-11', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1282, '305', 'Class9', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-24', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1283, '305', 'Class10', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-18', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1284, '305', 'Class11', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-31', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1285, '305', 'Class12', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-03-25', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1286, '305', 'Class13', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-07', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1287, '305', 'Class14', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-01', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1288, '305', 'Class15', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-14', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1289, '305', 'Class16', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-08', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1290, '305', 'Class17', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-21', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1291, '305', 'Class18', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-15', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1292, '305', 'Class19', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-28', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1293, '305', 'Class20', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-22', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1294, '305', 'Class21', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-05-05', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1295, '305', 'Class22', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-04-29', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1296, '305', 'Class23', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-05-12', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1297, '305', 'Class24', '10:00', 'https://meet.google.com/fxn-dbon-xgy', '2024-05-06', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(1298, '306', 'Class1', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-02-26', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1299, '306', 'Class2', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-02-27', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1300, '306', 'Class3', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-02-28', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1301, '306', 'Class4', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-04', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1302, '306', 'Class5', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-05', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1303, '306', 'Class6', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-06', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1304, '306', 'Class7', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-11', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1305, '306', 'Class8', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-12', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1306, '306', 'Class9', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-13', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1307, '306', 'Class10', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-18', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1308, '306', 'Class11', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-19', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1309, '306', 'Class12', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-20', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1310, '306', 'Class13', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-25', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1311, '306', 'Class14', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-26', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1312, '306', 'Class15', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-27', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1313, '306', 'Class16', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-01', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1314, '306', 'Class17', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-02', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1315, '306', 'Class18', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-03', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1316, '306', 'Class19', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-08', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1317, '306', 'Class20', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-09', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1318, '306', 'Class21', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-10', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1319, '306', 'Class22', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-15', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1320, '306', 'Class23', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-16', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1321, '306', 'Class24', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-17', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1322, '306', 'Class25', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-22', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1323, '306', 'Class26', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-23', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1324, '306', 'Class27', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-24', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1325, '306', 'Class28', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-29', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1326, '306', 'Class29', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-30', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1327, '306', 'Class30', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-01', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1328, '306', 'Class31', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-06', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1329, '306', 'Class32', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-07', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1330, '306', 'Class33', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-08', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1331, '306', 'Class34', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-13', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1332, '306', 'Class35', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-14', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1333, '306', 'Class36', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-15', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(1334, '307', 'Class1', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-02-26', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1335, '307', 'Class2', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-02-27', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1336, '307', 'Class3', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-02-28', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1337, '307', 'Class4', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-04', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1338, '307', 'Class5', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-05', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1339, '307', 'Class6', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-06', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1340, '307', 'Class7', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-11', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1341, '307', 'Class8', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-12', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1342, '307', 'Class9', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-13', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1343, '307', 'Class10', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-18', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1344, '307', 'Class11', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-19', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1345, '307', 'Class12', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-20', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1346, '307', 'Class13', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-25', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1347, '307', 'Class14', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-26', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1348, '307', 'Class15', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-03-27', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1349, '307', 'Class16', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-01', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1350, '307', 'Class17', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-02', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1351, '307', 'Class18', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-03', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1352, '307', 'Class19', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-08', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1353, '307', 'Class20', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-09', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1354, '307', 'Class21', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-10', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1355, '307', 'Class22', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-15', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1356, '307', 'Class23', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-16', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1357, '307', 'Class24', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-17', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1358, '307', 'Class25', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-22', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1359, '307', 'Class26', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-23', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1360, '307', 'Class27', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-24', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1361, '307', 'Class28', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-29', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1362, '307', 'Class29', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-04-30', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1363, '307', 'Class30', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-01', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1364, '307', 'Class31', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-06', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1365, '307', 'Class32', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-07', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1366, '307', 'Class33', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-08', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1367, '307', 'Class34', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-13', '2024-02-18 04:10:30', '2024-02-18 04:10:30'),
(1368, '307', 'Class35', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-14', '2024-02-18 04:10:31', '2024-02-18 04:10:31'),
(1369, '307', 'Class36', '12:00', 'https://meet.google.com/fpn-kfxb-xhp', '2024-05-15', '2024-02-18 04:10:31', '2024-02-18 04:10:31');

-- --------------------------------------------------------

--
-- Table structure for table `cms_pages`
--

CREATE TABLE `cms_pages` (
  `id` bigint(20) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_pages`
--

INSERT INTO `cms_pages` (`id`, `slug`, `title`, `description`, `created_at`, `updated_at`) VALUES
(1, 'AboutUs', 'About Us', 'Mohito is an Indian video-class social networking service. It features special effects, emoticons, stickers and short videos that have a duration of 15 seconds to one minute under genres like dance, travel, singing, acting, comedy, and education. Thrill allows users to download videos. Mohito was released almost immediately after TikTok was banned by the Indian Government, and more than 100 million users downloaded it in just 6 months.', '2022-03-12 03:12:24', '2022-11-11 21:42:17'),
(2, 'PrivacyPolicy', 'Privacy Policy', 'Log-in Data. User ID, mobile phone number, password, gender, and IP address. We may collect an indicative age range which tells us that you are of the appropriate age to access our Platform and certain features of our Platform (collectively, \"Log-in Data\").\n\nContent You Share. This comprises all of the information you make available to other users via Platform, comprising such as:\n\n- Information about you or relating to you that is voluntarily shared by you on the Platform, including without limitation, any quotes, images, political opinions, religious views, profile photo, user bio and handle, inter alia.\n- Any posts that you make on the Platform.\n\nInformation we receive from other sources. We may also be working closely with third parties (including, for example, business partners, sub-contractors in technical, analytics providers, search information providers) and may receive information about you from such sources. Such data may be shared internally and combined with data collected on this Platform.\n\nLog Data. \"Log Data\" is information that we automatically collect when you use the Platform, whether through the use of cookies, web beacons, log files, scripts, including, but not limited to:\n- technical information, such as your mobile carrier-related information, configuration information made available by your web browser or other programs you use to access the Platform, your IP address and your device’s version and identification number;\n- information about what you have searched for and looked at while using the Platform, such as web search terms used, social media profiles visited, mini applications used, and details of other information and content accessed or requested by you while using the Platform;\n- general information about communications on the platform, such as the identity of a user that you have communicated with and the time, data and duration of your communications; and\n- metadata, which means information related to items you have made available through the Platform, such as the date, time or location that a shared photograph or video was taken or posted.\n\nCookies. Our Platform uses cookies to distinguish you from other users of our Platform. This helps us to provide you with a good user experience when you browse our Platform and also allows us to improve the Platform. We collect the cookie data from the cookies on your device. For detailed information on the cookies we use and the purposes for which we use them, kindly see our cookie policy\n\nSurveys. If you choose to participate in a survey, we may request you to provide certain Personal Information i.e. any information that could be used to identify you (\"Personal Information\"). We may use a third-party service provider to conduct these surveys and this will be notified to you prior to you completing the survey.', '2022-03-12 03:12:29', '2022-03-12 03:12:29'),
(3, 'TermsConditions', 'Terms & Conditions', 'CHANGES TO TERMS AND SERVICES#\nOur Platform is dynamic and may change rapidly. As such, we may change the services we provide at our discretion. We may temporarily, or permanently, stop providing Services or any features to you generally.\n\nWe may remove or add functionalities to our Platform and Services without any notice. However, if we make a change where your consent is required, we will make sure to ask for it. Please be sure to keep visiting this page from time to time to stay updated on our latest changes and developments.\n\nVisit this page to see any changes that we may make and services that we may add or modify, from time to time.\n\nOUR SERVICES#\nWe agree to provide you with our Services. The Services includes all of Moj’s products, features, applications, services, technologies, and software that we provide to you. The Services is made up of the following aspects (the Services):\n\nOur Platform lets users of the Platform to upload or post or otherwise make available content through the Platform including, without limitation, any photographs, user videos, sound recordings and the musical works embodied therein, including videos that incorporate locally stored sound recordings from your personal music library and ambient noise (\"User Content\").\n\nWhen you publish any User Content on the Platform, you retain whatever ownership rights in that content you had to begin with. However, you grant us a license to use that content.\n\nYou also grant other users the right to share/ communicate such User Content for a limited private or non-commercial use alone.\n\nAny User Content will be considered non-confidential. You must not post any User Content on or through the Services or transmit to us any User Content that you consider to be confidential or belonging to third parties, or in violation of applicable laws.\n\nWhen you submit User Content through the Services, you agree and represent that you own that User Content, or you have received all necessary permissions, clearances from, or are authorised by, the owner of any part of the content to submit it to the Services, to transmit it from the Services to other third-party platforms, and/or adopt any third party content.\n\nIf you only own the rights in and to a sound recording, but not to the underlying musical works embodied in such sound recordings, then you must not post such sound recordings to the Services unless you have all permissions, clearances from, or are authorised by, the owner of any part of the content to submit it to the Services.\n\nYou grant us a worldwide, royalty-free, sublicensable, and transferable license to host, store, use, display, reproduce, modify, adapt, edit, publish, and distribute any User Content. This license is for the limited purpose of operating, developing, providing, promoting, and improving the Services and researching and developing new ones. You also grant us a perpetual license to create derivative works from, promote, exhibit, broadcast, syndicate, publicly perform, and publicly display User Content in any form and in any/all media or distribution methods (currently known or later developed).\n\nTo the extent it is necessary, when you appear in, create, upload, post, or send User Content, you also grant us unrestricted, worldwide, perpetual right and license to use your name, likeness, and voice, including in connection with commercial or sponsored content. This means, among other things, that you will not be entitled to any compensation from Moj if your data is used by us for marketing, advertising, or improving our Services.\n\nWhile we are not required to do so, we may access, review, screen, and delete your content at any time and for any reason, including to provide and develop the Services or if we think your content violates these Terms as well as for purposes as mandated by applicable laws. You alone, though, remain responsible for the content you create, upload, post, send, or store through the Service.\n\nYou further acknowledge and agree that we may generate revenues, increase goodwill or otherwise increase our value from your use of the Services, including, by way of example and not limitation, through the sale of advertising, sponsorships, promotions, usage data, and except as specifically permitted by us in these Terms or in another agreement you enter into with us, you will have no right to share in any such revenue, goodwill or value whatsoever.\n\nYou further acknowledge that, except as specifically permitted by us in these Terms or in any another agreement you may enter into with us, you have no right to receive any income or other consideration from any content that you publish on the Platform or your use of any musical works, sound recordings or audio-visual clips made available to you on or through the Services, including in any User Content created by you.\n\nIf you are a composer or author of a musical work and are affiliated with a performing rights organization, then you must notify your performing rights organization of the royalty-free license you grant through these Terms in your User Content to us. You are solely responsible for ensuring your compliance with the relevant performing rights organization’s reporting obligations. If you have assigned your rights to a music publisher, then you must obtain consent from such music publisher to grant the royalty-free license(s) set forth in these Terms in your User Content or have such music publisher enter into these Terms with us.\n\nAuthoring a musical work (e.g., wrote a song) does not necessarily give you the right to grant us the licenses in these Terms. If you are a recording artist under contract with a record label, then you are solely responsible for ensuring that your use of the Services is in compliance with any contractual obligations you may have to your record label, including if you create any new recordings through the Services that may be claimed by your label.\n\nWe use the information we have, to study our Service and collaborate with third parties for research purposes in order to make our Service better and contribute to the well-being of our community.', '2022-03-12 03:12:31', '2022-03-12 03:12:31'),
(8, 'contactus', 'Contact Us', 'Email us At : mohita@edu.com\r\nContact : +91 88614 55444', '2022-12-19 10:34:26', '2022-12-19 10:34:26'),
(9, 'FAQs', 'FAQs', 'Our most asking questions', '2022-12-19 10:35:45', '2022-12-19 10:35:45'),
(10, 'latestblog', 'Latest Blog', 'Lates Blog is coming soon', '2022-12-19 10:36:40', '2022-12-19 10:36:40'),
(11, '123', 'Trending course of the month', '1', '2023-11-08 12:56:53', '2023-11-08 12:56:53'),
(12, 'Newsandarticles', 'News and articles', 'Latest news and articles related to extra curricular activities from around the world', '2023-11-08 12:59:05', '2023-11-08 12:59:05');

-- --------------------------------------------------------

--
-- Table structure for table `contactus_inquiry`
--

CREATE TABLE `contactus_inquiry` (
  `id` int(100) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `mobile` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `contactus_inquiry`
--

INSERT INTO `contactus_inquiry` (`id`, `name`, `email`, `mobile`, `message`, `created_at`) VALUES
(2, 'Rahul', 'admin@gmail.com', '9039993430', 'djfbisjff', '2023-05-29 13:02:19');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` text DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL,
  `video_thumbnail` mediumtext DEFAULT NULL,
  `filter` varchar(255) DEFAULT NULL,
  `language` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `skill_level` enum('Beginner','Intermediate','Advanced') NOT NULL DEFAULT 'Beginner',
  `price_type` enum('Free','Paid') NOT NULL DEFAULT 'Free',
  `hashtags` mediumtext NOT NULL,
  `visibility` enum('Public','Private') NOT NULL,
  `gif_image` mediumtext DEFAULT NULL,
  `is_comment_allowed` tinyint(1) NOT NULL DEFAULT 1,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `id_trial` enum('0','1') NOT NULL DEFAULT '0',
  `timing` varchar(20) DEFAULT NULL,
  `short_desc` text DEFAULT NULL,
  `description` mediumtext NOT NULL,
  `course_requirment_description` varchar(2000) NOT NULL,
  `total_class` int(4) DEFAULT 1,
  `price` int(11) DEFAULT NULL,
  `is_commentable` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `class_held_on` text DEFAULT NULL,
  `class_time` varchar(225) NOT NULL,
  `start_date` date DEFAULT NULL,
  `retting` float NOT NULL DEFAULT 0,
  `is_certification` tinyint(1) DEFAULT NULL,
  `duration` int(11) NOT NULL DEFAULT 1,
  `slug` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `user_id`, `title`, `image`, `video`, `video_thumbnail`, `filter`, `language`, `category`, `skill_level`, `price_type`, `hashtags`, `visibility`, `gif_image`, `is_comment_allowed`, `is_enabled`, `id_trial`, `timing`, `short_desc`, `description`, `course_requirment_description`, `total_class`, `price`, `is_commentable`, `class_held_on`, `class_time`, `start_date`, `retting`, `is_certification`, `duration`, `slug`, `created_at`, `updated_at`) VALUES
(303, 99, 'demo by deepak', 'course/image/1697096498.png', NULL, 'course/video_thumbnail/1697096498.png', NULL, '', '171', 'Beginner', 'Paid', '[\"dancing\"]', 'Public', NULL, 1, 1, '0', '02:12', 'demo demo', 'test test', 'demo test', 1, 12345, 'Yes', 'Monday', '', NULL, 0, NULL, 12, 'demo-by-deepak', '2023-10-12 07:41:39', '2023-10-12 07:44:44'),
(304, 99, 'by deepak choudhary', 'course/image/1697096632.jpeg', NULL, 'course/video_thumbnail/1697096633.jpeg', NULL, '', '171', 'Intermediate', 'Free', '[]', 'Public', NULL, 1, 1, '0', '14:15', 'sdfg asd asdw d wd as zd sqwdxa', 'asA WD s wd qe d ad q wf a s asd', 'adsss s  d d d d', 1, NULL, 'Yes', 'Monday', '', NULL, 0, NULL, 30, 'by-deepak-choudhary', '2023-10-12 07:43:53', '2023-10-12 07:43:53'),
(305, 136, 'DANCE', 'course/image/1707773968.jpg', 'course/prev_video/1707773975.mp4', 'course/video_thumbnail/1707773995.jpg', NULL, '', '56', 'Beginner', 'Paid', '[\"dancing\"]', 'Public', NULL, 1, 1, '0', '10:00', 'test course', 'course post create and tets', 'course post create and tets', 1, 600, 'Yes', 'Sunday Monday', '', NULL, 0, NULL, 90, 'dance', '2024-02-12 21:39:56', '2024-02-12 21:39:56'),
(306, 138, 'Water colour painting', 'course/image/1708229259.jpg', 'course/prev_video/1708229263.mp4', 'course/video_thumbnail/1708229360.jpg', NULL, '', '76', 'Intermediate', 'Paid', '[\"music\"]', 'Public', NULL, 1, 1, '0', '12:00', 'sdfgh', 'awsdfghjk rfgh', 'sedrftghj ghjk', 1, 799, 'Yes', 'Monday Tuesday Wednesday', '', NULL, 0, NULL, 90, 'rtfgyh', '2024-02-18 04:09:21', '2024-02-18 04:09:21'),
(307, 138, 'Pichwai painting', 'course/image/1708229367.jpg', 'course/prev_video/1708229369.mp4', 'course/video_thumbnail/1708229429.jpg', NULL, '', '160', 'Intermediate', 'Paid', '[\"music\"]', 'Public', NULL, 1, 1, '0', '12:00', 'sdfgh', 'awsdfghjk rfgh', 'sedrftghj ghjk', 1, 799, 'Yes', 'Monday Tuesday Wednesday', '', NULL, 0, NULL, 90, 'rtfgyh', '2024-02-18 04:10:30', '2024-02-18 04:10:30');

-- --------------------------------------------------------

--
-- Table structure for table `course_comments`
--

CREATE TABLE `course_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `comment` mediumtext NOT NULL,
  `comment_by` bigint(20) UNSIGNED NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `course_enroll`
--

CREATE TABLE `course_enroll` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `enroll_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `course_enroll`
--

INSERT INTO `course_enroll` (`id`, `course_id`, `user_id`, `transaction_id`, `enroll_date`) VALUES
(2, 305, 103, 'pay_NbhH5izuader9i', '0000-00-00 00:00:00'),
(3, 305, 102, 'pay_NcBoBGQlXro8JM', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `course_hashtags`
--

CREATE TABLE `course_hashtags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `course_id` bigint(20) UNSIGNED NOT NULL,
  `hashtag_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `symbol` varchar(50) NOT NULL,
  `image` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `code`, `symbol`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'INR', '₹', '', 0, '2022-06-27 03:59:11', '2022-08-01 09:19:57'),
(2, 'USD', '$', '', 1, '2022-06-27 03:59:44', '2022-06-27 03:59:44'),
(3, 'AED', 'د.إ', '', 1, '2022-06-27 04:00:18', '2022-10-28 06:53:35'),
(15, 'Shib', '', 'currency1658999244.png', 1, '2022-07-28 09:07:25', '2022-07-28 09:07:25'),
(16, 'Bitcoin', 'BTC', '', 1, '2022-08-08 07:37:43', '2022-08-08 07:37:43'),
(17, 'Bitcoin', 'BTC', '', 1, '2022-10-28 06:50:17', '2022-10-28 06:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hash_tags`
--

CREATE TABLE `hash_tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL DEFAULT 1,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `hash_tags`
--

INSERT INTO `hash_tags` (`id`, `user_id`, `name`, `is_active`, `created_at`, `updated_at`) VALUES
(34, 1, 'dancing', 1, '2022-11-25 11:42:23', '2022-11-25 11:42:23'),
(35, 1, 'music', 1, '2022-11-25 11:42:36', '2022-11-25 11:42:36'),
(36, 1, 'love', 1, '2022-11-25 11:42:47', '2022-11-25 11:42:47'),
(37, 1, 'dancelife', 1, '2022-11-25 11:42:59', '2022-11-25 11:42:59'),
(38, 1, 'hiphop', 1, '2022-11-25 11:43:14', '2022-11-25 11:43:14'),
(39, 1, 'choreography', 1, '2022-11-25 11:43:49', '2022-11-25 11:43:49'),
(40, 1, 'livemusic', 1, '2022-11-25 11:44:26', '2022-11-25 11:44:26'),
(41, 1, 'happy', 1, '2022-11-25 11:44:37', '2022-11-25 11:44:37'),
(42, 1, 'musicproducer', 1, '2022-11-25 11:44:56', '2022-11-25 11:44:56');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'en', 'English', '2022-05-11 07:36:17', '2022-05-11 07:36:17');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(4, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(5, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(6, '2016_06_01_000004_create_oauth_clients_table', 1),
(7, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(8, '2019_08_19_000000_create_failed_jobs_table', 1),
(9, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(10, '2022_02_15_102223_create__user_otp_table', 1),
(11, '2022_11_11_174353_create_permission_tables', 1),
(12, '2022_11_11_175717_create_media_table', 1),
(13, '2024_02_10_100207_add_since_to_teacher_profile_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 20),
(3, 'App\\Models\\User', 3),
(3, 'App\\Models\\User', 6),
(3, 'App\\Models\\User', 8),
(3, 'App\\Models\\User', 9),
(3, 'App\\Models\\User', 16),
(3, 'App\\Models\\User', 17),
(3, 'App\\Models\\User', 18),
(3, 'App\\Models\\User', 25),
(3, 'App\\Models\\User', 45),
(3, 'App\\Models\\User', 46),
(3, 'App\\Models\\User', 47),
(3, 'App\\Models\\User', 48),
(3, 'App\\Models\\User', 49),
(3, 'App\\Models\\User', 50),
(3, 'App\\Models\\User', 51),
(3, 'App\\Models\\User', 52),
(3, 'App\\Models\\User', 53),
(3, 'App\\Models\\User', 54),
(3, 'App\\Models\\User', 55),
(3, 'App\\Models\\User', 56),
(3, 'App\\Models\\User', 57),
(3, 'App\\Models\\User', 58),
(3, 'App\\Models\\User', 59),
(3, 'App\\Models\\User', 61),
(3, 'App\\Models\\User', 62),
(3, 'App\\Models\\User', 63),
(3, 'App\\Models\\User', 64),
(3, 'App\\Models\\User', 65),
(3, 'App\\Models\\User', 66),
(3, 'App\\Models\\User', 67),
(3, 'App\\Models\\User', 68),
(3, 'App\\Models\\User', 69),
(3, 'App\\Models\\User', 70),
(3, 'App\\Models\\User', 71),
(3, 'App\\Models\\User', 72),
(3, 'App\\Models\\User', 73),
(3, 'App\\Models\\User', 74),
(3, 'App\\Models\\User', 75),
(3, 'App\\Models\\User', 76),
(3, 'App\\Models\\User', 77),
(3, 'App\\Models\\User', 78),
(3, 'App\\Models\\User', 79),
(3, 'App\\Models\\User', 80),
(3, 'App\\Models\\User', 81),
(3, 'App\\Models\\User', 82),
(3, 'App\\Models\\User', 83),
(3, 'App\\Models\\User', 84),
(3, 'App\\Models\\User', 85),
(3, 'App\\Models\\User', 86),
(3, 'App\\Models\\User', 87),
(3, 'App\\Models\\User', 88),
(3, 'App\\Models\\User', 89),
(3, 'App\\Models\\User', 90),
(3, 'App\\Models\\User', 91),
(3, 'App\\Models\\User', 92),
(3, 'App\\Models\\User', 93),
(3, 'App\\Models\\User', 94),
(3, 'App\\Models\\User', 95),
(3, 'App\\Models\\User', 96),
(3, 'App\\Models\\User', 97),
(3, 'App\\Models\\User', 98),
(3, 'App\\Models\\User', 100),
(3, 'App\\Models\\User', 101),
(3, 'App\\Models\\User', 102),
(3, 'App\\Models\\User', 103),
(3, 'App\\Models\\User', 104),
(3, 'App\\Models\\User', 105),
(3, 'App\\Models\\User', 106),
(3, 'App\\Models\\User', 107),
(3, 'App\\Models\\User', 108),
(3, 'App\\Models\\User', 109),
(3, 'App\\Models\\User', 110),
(3, 'App\\Models\\User', 111),
(3, 'App\\Models\\User', 112),
(3, 'App\\Models\\User', 113),
(3, 'App\\Models\\User', 114),
(3, 'App\\Models\\User', 115),
(3, 'App\\Models\\User', 116),
(3, 'App\\Models\\User', 117),
(3, 'App\\Models\\User', 118),
(3, 'App\\Models\\User', 119),
(3, 'App\\Models\\User', 120),
(3, 'App\\Models\\User', 121),
(3, 'App\\Models\\User', 122),
(3, 'App\\Models\\User', 123),
(3, 'App\\Models\\User', 124),
(3, 'App\\Models\\User', 125),
(3, 'App\\Models\\User', 126),
(3, 'App\\Models\\User', 127),
(3, 'App\\Models\\User', 128),
(3, 'App\\Models\\User', 129),
(3, 'App\\Models\\User', 133),
(3, 'App\\Models\\User', 137),
(3, 'App\\Models\\User', 139),
(3, 'App\\Models\\User', 140),
(3, 'App\\Models\\User', 141),
(3, 'App\\Models\\User', 142),
(3, 'App\\Models\\User', 143),
(3, 'App\\Models\\User', 144),
(3, 'App\\Models\\User', 145),
(3, 'App\\Models\\User', 146),
(3, 'App\\Models\\User', 147),
(3, 'App\\Models\\User', 148),
(3, 'App\\Models\\User', 150),
(3, 'App\\Models\\User', 151),
(3, 'App\\Models\\User', 154),
(3, 'App\\Models\\User', 156),
(3, 'App\\Models\\User', 157),
(3, 'App\\Models\\User', 159),
(3, 'App\\Models\\User', 160),
(3, 'App\\Models\\User', 161),
(3, 'App\\Models\\User', 166),
(3, 'App\\Models\\User', 167),
(3, 'App\\Models\\User', 168),
(3, 'App\\Models\\User', 170),
(4, 'App\\Models\\User', 5),
(4, 'App\\Models\\User', 12),
(4, 'App\\Models\\User', 13),
(4, 'App\\Models\\User', 14),
(4, 'App\\Models\\User', 15),
(4, 'App\\Models\\User', 19),
(4, 'App\\Models\\User', 21),
(4, 'App\\Models\\User', 22),
(4, 'App\\Models\\User', 60),
(4, 'App\\Models\\User', 99),
(4, 'App\\Models\\User', 131),
(4, 'App\\Models\\User', 132),
(4, 'App\\Models\\User', 134),
(4, 'App\\Models\\User', 135),
(4, 'App\\Models\\User', 136),
(4, 'App\\Models\\User', 138),
(4, 'App\\Models\\User', 144),
(4, 'App\\Models\\User', 149),
(4, 'App\\Models\\User', 151),
(4, 'App\\Models\\User', 153),
(4, 'App\\Models\\User', 154),
(4, 'App\\Models\\User', 155),
(4, 'App\\Models\\User', 158),
(4, 'App\\Models\\User', 162),
(4, 'App\\Models\\User', 163),
(4, 'App\\Models\\User', 164),
(4, 'App\\Models\\User', 165),
(4, 'App\\Models\\User', 169),
(5, 'App\\Models\\User', 7),
(5, 'App\\Models\\User', 23),
(5, 'App\\Models\\User', 24);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('00ba30d0a3accb4e854b86b5e542a21d91e3df9325a5d13651da14b78597f7d1c36dd1be7c2342d9', 21, 1, 'CATCHIN', '[]', 0, '2023-02-07 05:36:11', '2023-02-07 05:36:11', '2024-02-07 11:06:11'),
('0ceaa5984bdaa0ecfd415c31118fbd2d28399468404a9672d7bc720064422f33fd8cbab14fc41fa8', 22, 1, 'CATCHIN', '[]', 0, '2023-02-07 05:40:24', '2023-02-07 05:40:24', '2024-02-07 11:10:24'),
('0df78d5667cec0debae7f8d20322b760ae137405fa2692bed09a713d80ac206dc0fc975f1c2cf123', 22, 1, 'CATCHIN', '[]', 0, '2023-02-07 05:42:10', '2023-02-07 05:42:10', '2024-02-07 11:12:10'),
('1b667bf761fe0b25237551faad983b8ad17289bd795d401ad4f88442cfab971ea07567f3f54b5ef2', 35, 1, 'CATCHIN', '[]', 0, '2023-02-07 11:23:22', '2023-02-07 11:23:22', '2024-02-07 11:23:22'),
('2637b5820a72fb8266f3155e5b03d56e4487fe24d2a2c0031fb4f006fb4aecb1c2aa6b40bb7ad052', 36, 1, 'CATCHIN', '[]', 0, '2023-02-08 06:53:09', '2023-02-08 06:53:09', '2024-02-08 06:53:09'),
('5e8f8e1a77fea0e2453c35d5542e3439568199c747023842baaaa6777f0c2737a0cd8af49b0d2b13', 36, 1, 'CATCHIN', '[]', 0, '2023-02-08 06:49:35', '2023-02-08 06:49:35', '2024-02-08 06:49:35'),
('756fee25ec8886c48fa5d134a7e8069941326a4ef67ce271634c50d2354d84f59f636b750b82a6c6', 36, 1, 'CATCHIN', '[]', 0, '2023-02-08 06:43:45', '2023-02-08 06:43:45', '2024-02-08 06:43:45'),
('7b4b5f01e91b0c1190e9d4b4b64eac5e6c0ea82ee8577e02624e6557e9a42e171b7e79ebd8a0ac87', 36, 1, 'CATCHIN', '[]', 0, '2023-02-08 06:33:48', '2023-02-08 06:33:48', '2024-02-08 06:33:48'),
('816b63dd65226c3ff123fff35834468e2e07da0c28c9bbf2b54980d876b9302c5ab2ddd460b19f04', 36, 1, 'CATCHIN', '[]', 0, '2023-02-08 06:48:51', '2023-02-08 06:48:51', '2024-02-08 06:48:51'),
('98f528494a40a670f69f933a6a4cf09ccfa5ed6f283f2a7c0a9d58e225774d3aadd71063e863d8fc', 36, 1, 'CATCHIN', '[]', 0, '2023-02-08 07:22:22', '2023-02-08 07:22:22', '2024-02-08 07:22:22'),
('cec7324139e27b3ca6aa5f1b56be4139060a55309f2df600cbd5c3f2aa646ba9eb4fb170c1ffc918', 36, 1, 'CATCHIN', '[]', 0, '2023-02-07 11:25:56', '2023-02-07 11:25:56', '2024-02-07 11:25:56'),
('ed452c3b3083d02fe4447e34dd259d3d51c4d6067aa5a66c84474563e3387f7b71e41d7350b4afa5', 36, 1, 'CATCHIN', '[]', 0, '2023-02-07 11:25:42', '2023-02-07 11:25:42', '2024-02-07 11:25:42'),
('f038c7b76dbfbcbd2e37706ca4d41d1cd441a3cace0bd9d969f3dec0f8ba601691b4b8069a7daca6', 36, 1, 'CATCHIN', '[]', 0, '2023-02-08 07:19:30', '2023-02-08 07:19:30', '2024-02-08 07:19:30');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `scopes` text DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `secret` varchar(100) DEFAULT NULL,
  `provider` varchar(255) DEFAULT NULL,
  `redirect` text NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'mohita', '5jwfnUAUruCSaQYFiwKApC6jusdeF2eFjhCRnd4U', NULL, 'http://localhost', 1, 0, 0, '2023-02-07 05:35:13', '2023-02-07 05:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-02-07 05:35:13', '2023-02-07 05:35:13');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) NOT NULL,
  `access_token_id` varchar(100) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('deepakjt9011@gmail.com', '$2y$10$HLmuamLqw0Yy5LWJN7OSFe.WgmNjQAqeO/5gppJ9H9czAOPexn4sG', '2023-09-26 02:22:38'),
('akash@gmail.com', '$2y$10$iEe.GBfnBR8mdvsZiSFJOesLCoe6auerre0E1GxZUTE2bYgL85N/e', '2023-09-26 02:30:47'),
('ttr@yopmail.com', '$2y$10$3qTNg8i8G.69To7DEeeIOO7Aof80QZGdfPipFG8NmGONmfZdIKEaO', '2024-02-10 04:45:22'),
('wfgh@yopmail.com', '$2y$10$uT5oRr/Ld0khqu3AqJGi1eUpqVbQALzoR.goFDbLC12Ym0iDwPT6G', '2024-02-12 15:39:12'),
('mohitapant22@gmail.com', '$2y$10$xhgIMD2Wz77cVLxwSWN9K.xen23H/91lmyur5.1TmgjCOjP9U5yPy', '2024-04-19 10:07:17');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'appuser_view', 'web', NULL, NULL),
(2, 'set_notification', 'web', NULL, NULL),
(3, 'cms_view', 'web', NULL, NULL),
(4, 'cms_edit', 'web', NULL, NULL),
(5, 'cms_delete', 'web', NULL, NULL),
(6, 'sitesetting_view', 'web', NULL, NULL),
(7, 'cms_add', 'web', NULL, NULL),
(8, 'access_permission', 'web', NULL, NULL),
(9, 'banner_view', 'web', NULL, NULL),
(10, 'banner_add', 'web', NULL, NULL),
(11, 'categories_add', 'web', NULL, NULL),
(12, 'category_view', 'web', NULL, NULL),
(14, 'categories_delete', 'web', NULL, NULL),
(15, 'tutor_view', 'web', NULL, NULL),
(16, 'tutor_add', 'web', NULL, NULL),
(17, 'tutor_edit', 'web', NULL, NULL),
(18, 'tutor_block', 'web', NULL, NULL),
(19, 'tutor_delete', 'web', NULL, NULL),
(20, 'tutor_access', 'web', NULL, NULL),
(21, 'dashboard_user', 'web', NULL, NULL),
(22, 'dashboard_video', 'web', NULL, NULL),
(23, 'course_view', 'web', NULL, NULL),
(24, 'course_delete', 'web', NULL, NULL),
(25, 'course_block', 'web', NULL, NULL),
(26, 'comments_view', 'web', NULL, NULL),
(27, 'comments_block', 'web', NULL, NULL),
(28, 'comments_delete', 'web', NULL, NULL),
(29, 'course_add', 'web', NULL, NULL),
(30, 'appuser_delete', 'web', NULL, NULL),
(31, 'appuser_varify', 'web', NULL, NULL),
(34, 'appuser_deactivation', 'web', NULL, NULL),
(35, 'appuser_block', 'web', NULL, NULL),
(36, 'withdrawal_view', 'web', NULL, NULL),
(37, 'add_user', 'web', NULL, NULL),
(40, 'changepassword', 'web', NULL, NULL),
(41, 'appuser_edit', 'web', NULL, NULL),
(42, 'add_admin', 'web', NULL, NULL),
(43, 'admin_block', 'web', NULL, NULL),
(44, 'admin_delete', 'web', NULL, NULL),
(45, 'admin_edit', 'web', NULL, NULL),
(46, 'categories_edit', 'web', NULL, NULL),
(47, 'course_edit', 'web', NULL, NULL),
(48, 'banner_delete', 'web', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'super admin', 'web', '2022-11-11 13:07:20', '2022-11-11 14:50:50'),
(2, 'admin', 'web', '2022-11-11 13:07:20', '2022-11-11 13:07:20'),
(3, 'user', 'web', '2022-11-11 13:09:12', '2022-11-11 13:09:12'),
(4, 'tutor', 'web', '2022-11-11 16:52:50', '2022-11-11 16:52:50'),
(5, 'content writer', 'web', '2022-11-16 08:18:30', '2022-11-16 08:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(14, 1),
(15, 1),
(15, 5),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(23, 4),
(24, 1),
(24, 4),
(25, 1),
(25, 4),
(26, 1),
(27, 1),
(28, 1),
(29, 4),
(30, 1),
(31, 1),
(34, 1),
(35, 1),
(37, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 4),
(48, 1);

-- --------------------------------------------------------

--
-- Table structure for table `session`
--

CREATE TABLE `session` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `class_url` text NOT NULL,
  `active_date` date NOT NULL,
  `active_time` time NOT NULL,
  `class_end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `value` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`, `created_at`, `updated_at`) VALUES
(1, 'payment_network_user', '[\"PayTM\",\"PhonePay\",\"Paypal\"]', '2022-06-27 09:24:33', '2022-06-27 09:24:33'),
(3, 'commission_fee', '2', '2022-06-27 06:20:39', '2022-06-27 06:20:39'),
(4, 'email', 'info@mohita.com', '2022-07-05 04:22:46', '2022-11-11 19:27:12'),
(5, 'phone', '9024266200', '2022-07-05 04:23:45', '2022-11-11 19:27:27'),
(6, 'advertisement_image', 'advertisement1668194896.jpg', '2022-07-06 01:19:01', '2022-11-11 19:28:16'),
(7, 'advertisement_link', 'google.com', '2022-07-27 03:30:48', '2022-08-08 10:58:09'),
(8, 'advertisement_title', 'Offer', '2022-07-27 03:30:48', '2022-07-28 10:29:18'),
(9, 'spin_wheel_reset_target', '1000', '2022-07-29 08:23:48', '2023-01-30 06:47:28'),
(10, 'report_reason', 'Spreading misinformation,Organizing or promoting violence,Hate group or contains hate speech,Illegal goods or services,Sexually explicit content,Impersonation', '2022-08-08 07:18:30', '2022-08-08 07:18:30');

-- --------------------------------------------------------

--
-- Table structure for table `teacher_profile`
--

CREATE TABLE `teacher_profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile_name` varchar(255) NOT NULL,
  `intro_text` text DEFAULT NULL,
  `experence` float DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `currency` varchar(5000) NOT NULL,
  `passing_out` int(11) DEFAULT NULL,
  `degree_obtained` varchar(255) DEFAULT NULL,
  `degree_from` varchar(255) DEFAULT NULL,
  `since` varchar(255) DEFAULT NULL,
  `tag` text DEFAULT NULL,
  `intro_video` text DEFAULT NULL,
  `admin_commission` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `teacher_profile`
--

INSERT INTO `teacher_profile` (`id`, `user_id`, `profile_name`, `intro_text`, `experence`, `city`, `country`, `currency`, `passing_out`, `degree_obtained`, `degree_from`, `since`, `tag`, `intro_video`, `admin_commission`) VALUES
(8, 99, '', 'hello', 5, NULL, NULL, '', NULL, NULL, NULL, NULL, '[\"dancing\",\"music\"]', NULL, 1),
(9, 136, '', 'bfv ghe', 1, NULL, NULL, '', 2021, 'fgvh', 'gvhbn', '2023', '[\"Singing\"]', 'user/teacher/intro_video/1707770930.mp4', 1),
(10, 138, '', 'sdrtyu tufuyk', 2, NULL, NULL, '', 2021, 'rtyu', 'fghj', '2022', '[\"Singing\",\"Hindustani classical\",\"Western\"]', 'user/teacher/intro_video/1708228304.mp4', 1),
(11, 144, '', 'Anshu is an experienced management professional working in the banking industry for the past more than 20 years. He has a passion for teaching and his course Basics of banking is one of our most popular courses, equally liked by students, homemakers and working professionals.', 11, NULL, NULL, '', 2013, 'Management Strategy', 'MBA', '2013', '[\"Basics of banking\"]', 'user/teacher/intro_video/1713487988.mp4', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `subscriber_id` int(11) NOT NULL,
  `teacher_id` int(11) DEFAULT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `price` float(10,2) NOT NULL,
  `teacher_commission` varchar(2000) NOT NULL,
  `admin_commission` varchar(2000) NOT NULL,
  `status` varchar(40) NOT NULL,
  `payment_request_id` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `course_id`, `subscriber_id`, `teacher_id`, `transaction_id`, `price`, `teacher_commission`, `admin_commission`, `status`, `payment_request_id`, `created_at`, `updated_at`) VALUES
(3, 305, 103, 136, 'pay_NbhH5izuader9i', 600.00, '60', '540', 'Credit', 'pay_NbhH5izuader9i', '2024-02-16 21:19:51', '2024-02-16 21:19:51'),
(4, 305, 102, 136, 'pay_NcBoBGQlXro8JM', 600.00, '60', '540', 'Credit', 'pay_NcBoBGQlXro8JM', '2024-02-18 03:12:11', '2024-02-18 03:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `trial_class`
--

CREATE TABLE `trial_class` (
  `id` int(200) NOT NULL,
  `course_id` varchar(200) NOT NULL,
  `user_id` varchar(200) NOT NULL,
  `transaction_id` varchar(2000) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `dob` varchar(200) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `avtars` varchar(255) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL DEFAULT 'Male',
  `cover_image` varchar(255) DEFAULT NULL,
  `location` text DEFAULT NULL,
  `rating` varchar(255) DEFAULT '0',
  `notification` varchar(1) DEFAULT '1',
  `two_FA_toggle` varchar(1) NOT NULL DEFAULT '1',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `deactivation_request` tinyint(1) NOT NULL DEFAULT 0,
  `social_login_id` text DEFAULT NULL,
  `social_login_type` varchar(255) DEFAULT NULL,
  `firebase_token` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `dob`, `email_verified_at`, `password`, `phone`, `avtars`, `gender`, `cover_image`, `location`, `rating`, `notification`, `two_FA_toggle`, `status`, `deactivation_request`, `social_login_id`, `social_login_type`, `firebase_token`, `remember_token`, `created_at`, `updated_at`, `is_verified`, `deleted_at`) VALUES
(1, 'Admin', 'admin@gmail.com', NULL, NULL, '$2y$10$O04avh/NlGGI6lAVYwg1k.W997GzuACqDZvAE.0gRXDoGJqy.qbm.', NULL, NULL, 'Male', NULL, NULL, '0', '1', '1', 'active', 0, NULL, NULL, 'eWl5vMZi-1I3Eezw6Bjm5X:APA91bHDdifBKssKtSJ7YEVtGQeqDUiCaghA-nygDMmanMswiYkR2I8AhvIdeCyDxYvjArC9RW32ee4suayPvEUQVe1Fv24n0ncByklvHwrfwTqqGYHynpqhH4cUyKV2P_KFe4PRTqqr', 'ngnSjCkj0FfUc6dvtBJ6Vt3Z99ZBpA0RgedR0SfPTFejlK0VErWPLopRzkLw', '2022-07-20 15:53:51', '2023-08-22 06:34:29', 0, NULL),
(99, 'Deepak choudhary', 'deepak@gmail.com', '1995-06-14', '2024-03-04 21:15:06', '$2a$10$WgR3kpBsrOZ1sieQqiQb5.GRofYNCy7IbZKdzQMnQcs87howbPxTS', '1234567890', 'user/teacher/1697096348.jpeg', 'Male', NULL, NULL, '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2023-10-12 02:09:09', '2023-10-12 02:09:09', 0, NULL),
(102, 'kali', 'kalich42545@yopmail.com', NULL, NULL, '$2y$10$O04avh/NlGGI6lAVYwg1k.W997GzuACqDZvAE.0gRXDoGJqy.qbm.', '7874663366', NULL, 'Male', NULL, NULL, '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-02-03 07:41:54', '2024-02-03 07:41:54', 0, NULL),
(103, 'kali1', 'kali1@mailinator.com', '1998-09-09', NULL, '$2y$10$qXRopsGDH6Bykdz2CPn19uyPV39xRV/wCMfO76/qN4uTrRqXUFypy', '7877366585', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, '9FINjJCBP5b7ZGumupl7urpzRMl1TVDhMQnRoqOPFrrK6kOAZ5IFVvzkfJzP', '2024-02-03 08:16:27', '2024-02-03 08:16:27', 1, NULL),
(134, 'ttr', 'ttr@yopmail.com', '1980-09-09', NULL, '$2y$10$XWa53Ehymn4QiNZ.8U4FoeIydIJRviYOqi6oZfup/b0gU/HRwguzy', '8890098877', NULL, 'Male', NULL, 'fghj', '0', '1', '1', 'active', 0, NULL, NULL, NULL, 'ulGDzV80Y4aRPpAS77uB0zuI7aoQUcC7QGqBY2aW2aaoOp6sEhH590Srvwby', '2024-02-08 12:52:43', '2024-02-08 12:52:43', 0, NULL),
(135, 'sdfg', 'wfgh@yopmail.com', '2024-02-10', NULL, '$2y$10$Wgu5YmDFOjDF0oNOIky07eP.40F8LNKInT3mkhd0QshqiGEYRFGBa', '3456789088', NULL, 'Male', NULL, 'fghjkl', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-02-10 02:28:16', '2024-02-10 02:28:16', 0, NULL),
(136, 'etr', 'yty@yopmail.com', '2024-02-13', NULL, '$2y$10$Ckud6zLeWdOhVq/2symiyeRc3xN.UsZ9PWrvpBK/CGhIGEZ1lnCmG', '3456789887', NULL, 'Male', NULL, 'fgh', '0', '1', '1', 'active', 0, NULL, NULL, NULL, 'm02kLSSwqZTD9yiYxnaal3hwd1hoQi2eufdGyXL4efwNkXasc1uC1jQEqEPM', '2024-02-12 15:17:51', '2024-02-12 15:17:51', 0, NULL),
(137, 'student1', 'stundent1@yopmail.com', '1990-09-09', NULL, '$2y$10$xWWDt6XRv2nF116o624zL.QMWeODShJwjhIxi6KMM/edKcOcvddm6', '+917877366585', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-02-17 22:10:47', '2024-02-17 22:10:47', 0, NULL),
(138, 'teacher1', 'teacher1@yopmail.com', '1998-09-09', NULL, '$2y$10$0ZWjzy4quwJ0SojyUTM82.FlUmV5UH3MccvCAdfZW9QbAGnOAVJim', '3456890987', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-02-17 22:18:58', '2024-02-17 22:18:58', 0, NULL),
(139, 'hjk', 'kalicharanmishra02@gmail.com', '1997-08-08', NULL, '$2y$10$kzoh9YQZEUKnUDRwxDD9..0ue4lejn96KxcGUZpj9V36K2EMsslqO', '7877366585', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-03-09 12:47:47', '2024-03-09 12:47:47', 0, NULL),
(140, 'rftgh', 'kalicharanmishra@gmail.com', '2024-03-09', NULL, '$2y$10$zRYOIXk3fZGoyprGGbzJ/eiOVSS7WNKnfyRmJRrEj/UFpYx2zNUG.', '7877366585', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-03-09 12:51:38', '2024-03-09 12:51:38', 0, NULL),
(141, 'jhg', 'gerty@yopmail.com', '1999-09-09', NULL, '$2y$10$39mmu0smpQrkjUP2NwhX2eU/LQr9Xb2kah8S/wWqUB78REfIrmpKe', '8877446677', NULL, 'Male', NULL, 'jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-03-09 13:10:10', '2024-03-09 13:10:10', 0, NULL),
(142, 'ytr', 'rty@yopmail.com', '1998-09-09', NULL, '$2y$10$MQH24ZyQBa0eS.sIaTFm4u6Z/LBFsbEw2SQjDwaShgp3JKGV.CT8q', '6677226655', NULL, 'Male', NULL, 'jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-03-09 13:11:25', '2024-03-09 13:11:25', 0, NULL),
(143, 'Dimpi', 'mohitapant22@gmail.com', '1975-06-22', NULL, '$2y$10$onqiPD1J1EUoJMYF45AjCeu/KzdXbUTtzFPkCSN8rTMnj54FVW7t.', '9108449118', NULL, 'Female', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-04-19 07:01:51', '2024-04-19 07:01:51', 0, NULL),
(144, 'Anshu', 'bhadurianshuman@gmail.com', '1974-10-14', NULL, '$2y$10$XvHB6JN2zThAHrjy01tbSOqkixnY.CjyY15r737SQC4mUU9Hj57fS', '7760311499', NULL, 'Male', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-04-19 07:22:44', '2024-04-19 07:22:44', 0, NULL),
(151, 'arvind', 'arvind@mailinator.cm', '2005-03-08', NULL, '$2y$10$LOygPJmQp7jCGCzGpS.CIuhp0kmh1bA20Y.IEu.LJQ/biGZ.vyMO6', '08894477557', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-05-04 02:29:55', '2024-05-04 02:29:55', 0, NULL),
(153, 'arvind', 'arvind@mailinator.cm', '2024-05-04', NULL, '$2y$10$V/3ZxKHIt3eGv20QGYWTdu7IkRUBElFVuTE/xgf4Le8w0M9wgJLlO', '8894477557', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-05-04 03:43:45', '2024-05-04 03:43:45', 0, NULL),
(154, 'Aanya Bhaduri', 'aanyabhaduri@gmail.com', '2007-06-17', NULL, '$2y$10$LEFrCGH7EeW4vchgQgQNSO2NtOGUDQqBNQmy45UpIxS/vLEoBfgby', '7777000474', NULL, 'Female', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-05-17 17:47:53', '2024-05-17 17:47:53', 0, NULL),
(155, 'Aanya Bhaduri', 'aanyabhaduri@gmail.com', '2007-06-17', NULL, '$2y$10$0oFdTneQYIreozBEbPcNjuHoov7XkEtuLZKaAVUbH8tM8IZnhjRea', '7777000474', NULL, 'Female', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-05-17 18:12:52', '2024-05-17 18:12:52', 0, NULL),
(156, 'Anshuman', 'mohitapant22@gmail.com', '1974-10-14', NULL, '$2y$10$Re9nw1ExOfUp9APDH3GIIuXzg1QDYTjupePcksrk1sZH1X0rk4pJC', '8861608811', NULL, 'Male', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-05-29 21:06:35', '2024-05-29 21:06:35', 0, NULL),
(157, 'Kali', 'Kali@mailinator.com', '1999-02-12', NULL, '$2y$10$bQf8WmNB1lS.cxH5qhCCpelpy9UwrWivlgHUCn/9xRSc.9wmX/lOy', '1234567890', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-05-29 23:06:45', '2024-05-29 23:06:45', 0, NULL),
(158, 'Ayush', 'ayush123@gmail.com', '2000-01-01', NULL, '$2y$10$HEeZxixv151mnwHxRvjM/usurLHeBwPg6X23N72KByaqaF8L8GLYi', '9876543210', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-05-29 23:19:53', '2024-05-29 23:19:53', 0, NULL),
(159, 'asdfgh', 'kalicharanmishra02@gmail.com', '2024-06-08', NULL, '$2y$10$E1UwfzozbogI/7q5REJOEO2ERb5gQwfqYGlt7VVZDOaCYLRqo62NG', '07877366585', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-08 19:56:16', '2024-06-08 19:56:16', 0, NULL),
(160, 'mishra mishra', 'addgsfg@gmail.com', '2024-06-08', NULL, '$2y$10$LGvceRZpzrOOsKbgIYmbBu8C6L4yeku9rRnBLzDaVOkW7cp78LDWK', '2345678945', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-08 20:08:28', '2024-06-08 20:08:28', 0, NULL),
(161, 'ertyu', 'qwert@yopmail.com', '2024-06-08', NULL, '$2y$10$AouHYCw2xvCUci8H4Q05E.jINlxhXX1gNkiPvbJR.l2Hr0CrRN3Ku', '2434569876', NULL, 'Male', NULL, 'jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-08 20:10:05', '2024-06-08 20:10:05', 0, NULL),
(162, 'iuyt', 'dfgh@yopmail.com', '2024-06-09', NULL, '$2y$10$qfaMtRajGzXZ9PmI2eOVJufYxEW6.ziZqXM50LuH5SBef9QWdRLrm', '3458765678', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-09 02:49:40', '2024-06-09 02:49:40', 0, NULL),
(163, 'jgjj', 'trb@yopmail.com', '2024-06-09', NULL, '$2y$10$bPNLPcFLjQOGXkt90qtSS.IHJHZ/D7mrGDrVyXm5vD5M8YPB2USTq', '3355772299', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-09 02:53:54', '2024-06-09 02:53:54', 0, NULL),
(164, 'fgh', 'yfyi@yopmail.com', '2024-06-09', NULL, '$2y$10$wJHwl1P7.AX98.HRObwz3uBms1/xm8mfxR6Q/ljXKrHbAuWqQF7iW', '7755364476', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-09 02:56:43', '2024-06-09 02:56:43', 0, NULL),
(165, 'fghj', 'fghl@yopmail.com', '2024-06-09', NULL, '$2y$10$A8uivAoL52F5sVPNWWxgYun/B93S8e6XP6JzS.2Af4fIQ4mKaMLJu', '2257754499', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-09 09:23:14', '2024-06-09 09:23:14', 0, NULL),
(166, 'mishra mishra', 'kalicharanmishra2@gmail.com', '2024-06-10', NULL, '$2y$10$nTkJWnoATssJ.Po158KgJuOPkCRDfBAShuWhUaAWUcI8DkfxajEla', '6778888665', NULL, 'Male', NULL, 'b-500,near atal hospital', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-10 15:13:43', '2024-06-10 15:13:43', 0, NULL),
(167, 'testkali', NULL, '1996-04-07', NULL, '$2y$10$0sdSyvosDiDfLFJkLGTxVO7gz6fNmE4RO.S6OOzZdtRdqmSqzNGpm', '7062829445', NULL, 'Male', NULL, 'Jaipur', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-10 15:15:38', '2024-06-10 15:15:38', 0, NULL),
(168, 'Aahan Nhaduri', NULL, '2007-06-17', NULL, '$2y$10$.ydOCGXqpRLj.4pGlbsvGOZMETjYD/wbHzwTLbKv1zW54MWTs0sDq', '7777000373', NULL, 'Male', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-16 19:01:06', '2024-06-16 19:01:06', 0, NULL),
(169, 'Aahan Bhaduri', 'aahanbhaduri@gmail.com', '2007-06-17', NULL, '$2y$10$NbaSHE9ixLsFa8q4FmHfFOxLIJMVutWuIPehSeVfRY.A2i4EoNHra', '7777000373', NULL, 'Male', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-18 11:00:29', '2024-06-18 11:00:29', 0, NULL),
(170, 'Anshu', 'bhadurianshuman@gmail.com', '1974-10-14', NULL, '$2y$10$seuG/i7qYGNzutMXEx/fIuV8lT/ES7OOUOYJKIaxxOiVwVki/Smpi', '7760311499', NULL, 'Male', NULL, 'Mumbai', '0', '1', '1', 'active', 0, NULL, NULL, NULL, NULL, '2024-06-18 11:25:59', '2024-06-18 11:25:59', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_activity_counters`
--

CREATE TABLE `user_activity_counters` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `month` varchar(255) NOT NULL,
  `month_start_date` date NOT NULL,
  `month_end_date` date NOT NULL,
  `like_counter` bigint(20) NOT NULL,
  `view_counter` bigint(20) NOT NULL,
  `invite_counter` bigint(20) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_metas`
--

CREATE TABLE `user_metas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `meta_key` mediumtext NOT NULL,
  `meta_value` mediumtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Table structure for table `user_otp`
--

CREATE TABLE `user_otp` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `otp` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attendence`
--
ALTER TABLE `attendence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `circullum`
--
ALTER TABLE `circullum`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `circullum_topic`
--
ALTER TABLE `circullum_topic`
  ADD PRIMARY KEY (`id`),
  ADD KEY `circullam` (`circullum_id`);

--
-- Indexes for table `class_course`
--
ALTER TABLE `class_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_pages`
--
ALTER TABLE `cms_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contactus_inquiry`
--
ALTER TABLE `contactus_inquiry`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_comments`
--
ALTER TABLE `course_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_enroll`
--
ALTER TABLE `course_enroll`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course_hashtags`
--
ALTER TABLE `course_hashtags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hash_tags`
--
ALTER TABLE `hash_tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_auth_codes_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `trial_class`
--
ALTER TABLE `trial_class`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_activity_counters`
--
ALTER TABLE `user_activity_counters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_metas`
--
ALTER TABLE `user_metas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_otp`
--
ALTER TABLE `user_otp`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendence`
--
ALTER TABLE `attendence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202;

--
-- AUTO_INCREMENT for table `circullum`
--
ALTER TABLE `circullum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `circullum_topic`
--
ALTER TABLE `circullum_topic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `class_course`
--
ALTER TABLE `class_course`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1370;

--
-- AUTO_INCREMENT for table `cms_pages`
--
ALTER TABLE `cms_pages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `contactus_inquiry`
--
ALTER TABLE `contactus_inquiry`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=308;

--
-- AUTO_INCREMENT for table `course_comments`
--
ALTER TABLE `course_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `course_enroll`
--
ALTER TABLE `course_enroll`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `course_hashtags`
--
ALTER TABLE `course_hashtags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hash_tags`
--
ALTER TABLE `hash_tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `session`
--
ALTER TABLE `session`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `teacher_profile`
--
ALTER TABLE `teacher_profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `trial_class`
--
ALTER TABLE `trial_class`
  MODIFY `id` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=171;

--
-- AUTO_INCREMENT for table `user_activity_counters`
--
ALTER TABLE `user_activity_counters`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_metas`
--
ALTER TABLE `user_metas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_otp`
--
ALTER TABLE `user_otp`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `circullum_topic`
--
ALTER TABLE `circullum_topic`
  ADD CONSTRAINT `circullam` FOREIGN KEY (`circullum_id`) REFERENCES `circullum_topic` (`id`);

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
