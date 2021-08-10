-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: Aug 10, 2021 at 12:48 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simple-authentication`
--

-- --------------------------------------------------------

--
-- Table structure for table `bo_users`
--

DROP TABLE IF EXISTS `bo_users`;
CREATE TABLE IF NOT EXISTS `bo_users` (
  `bu_id` int(11) NOT NULL AUTO_INCREMENT,
  `bu_name` varchar(50) NOT NULL,
  `bu_username` varchar(20) NOT NULL,
  `bu_password` varchar(100) NOT NULL,
  `bu_email_address` varchar(30) NOT NULL,
  `bu_phone` varchar(15) NOT NULL,
  `bu_token` varchar(100) DEFAULT NULL,
  `bu_reset_password_token` varchar(255) DEFAULT NULL,
  `bu_reset_password_expires` datetime DEFAULT NULL,
  `bu_2fa` varchar(6) DEFAULT NULL,
  `bu_created_at` datetime DEFAULT NULL,
  `bu_updated_at` datetime DEFAULT NULL,
  `bu_is_active` enum('Y','N') NOT NULL,
  PRIMARY KEY (`bu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bo_users`
--

INSERT INTO `bo_users` (`bu_id`, `bu_name`, `bu_username`, `bu_password`, `bu_email_address`, `bu_phone`, `bu_token`, `bu_reset_password_token`, `bu_reset_password_expires`, `bu_2fa`, `bu_created_at`, `bu_updated_at`, `bu_is_active`) VALUES
(1, 'Marino', 'admin', '$2y$10$YYiMJ4XjcKwvgdZqqCVzKur4j3NXXWckSrt4r8w0VDiBsEuJAXume', 'marinoimola@gmail.com', '6285156252911', '9a212ede70574c59eec7bfe595dd8012feeeae48', '', '2021-08-10 20:33:05', '', '2021-08-04 10:31:15', '2021-08-10 19:42:25', 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`(250))
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2021_08_09_140158_create_jobs_table', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
