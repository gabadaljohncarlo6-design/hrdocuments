-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2026 at 09:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hrdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity` text NOT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`log_id`, `user_id`, `activity`, `log_date`) VALUES
(1, 10, 'Updated document \"ok\" to Approved', '2026-07-13 09:46:19'),
(2, 10, 'Updated document \"ok\" to Approved', '2026-07-13 09:48:51'),
(3, 10, 'Updated document \"ok\" to Approved', '2026-07-13 09:48:53'),
(4, 10, 'Updated document \"ok\" to Rejected', '2026-07-13 09:49:06'),
(5, 6, 'Updated document \"ok\" to Rejected', '2026-07-13 09:50:37'),
(6, 6, 'Updated document \"ok\" to Rejected', '2026-07-13 10:52:39'),
(7, 10, 'Updated document \"title\" to Pending', '2026-07-13 22:32:03'),
(8, 10, 'Updated document \"ok\" to Approved', '2026-07-13 22:32:23'),
(9, 10, 'Updated document \"ok\" to Approved', '2026-07-13 22:32:25'),
(10, 11, 'Updated document \"sakto ni sa maam?\" to Approved', '2026-07-19 09:23:03'),
(11, 11, 'Updated document \"sakto ni sa maam?\" to Approved', '2026-07-19 10:18:11'),
(12, 11, 'Updated document \"title\" to Rejected', '2026-07-19 10:19:20'),
(13, 11, 'Updated document \"title\" to Approved', '2026-07-19 10:19:28'),
(14, 13, 'Updated document \"te maam?\" to Approved', '2026-07-20 03:04:26'),
(15, 10, 'Updated document \"sakto ni sa maam?\" to Approved', '2026-07-20 13:39:24'),
(16, 12, 'Updated document \'ELigibilty Certificate\' to Returned', '2026-07-21 04:51:53'),
(17, 12, 'Updated document \'dpcr ah\' to Pending', '2026-07-21 05:04:40'),
(18, 12, 'Updated document \'dga\' to Approved', '2026-07-22 03:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`announcement_id`, `title`, `message`, `created_at`) VALUES
(1, 'meeting', 'may meeting alas 2 rum an ah', '2026-07-20 07:51:02');

-- --------------------------------------------------------

--
-- Table structure for table `documents`
--

CREATE TABLE `documents` (
  `document_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `document_title` varchar(255) NOT NULL,
  `faculty_comment` text DEFAULT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  `remarks` text DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `hr_remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `documents`
--

INSERT INTO `documents` (`document_id`, `user_id`, `category_id`, `document_title`, `faculty_comment`, `file_name`, `file_path`, `remarks`, `status`, `submitted_at`, `hr_remarks`) VALUES
(1, 3, 20, 'title', NULL, '1781595459_Untitled design (1).pdf', '../uploads/1781595459_Untitled design (1).pdf', NULL, 'Approved', '2026-06-16 07:37:39', 'ok sya but you need to imporove more'),
(2, 6, 9, 'title', NULL, '1781597251_infographic.png', '../uploads/1781597251_infographic.png', NULL, 'Approved', '2026-06-16 08:07:31', 'nami mn'),
(3, 6, 18, 'service record', NULL, '1783314455_anon.jpg', '../uploads/1783314455_anon.jpg', NULL, 'Approved', '2026-07-06 05:07:35', 'sge'),
(4, 6, 7, 'ok', NULL, '1783315657_Untitled design.png', '../uploads/1783315657_Untitled design.png', NULL, 'Approved', '2026-07-06 05:27:37', 'hayop ka'),
(5, 11, 9, 'sakto ni sa maam?', NULL, '1784452948_isatumc.jpg', '../uploads/1784452948_isatumc.jpg', NULL, 'Approved', '2026-07-19 09:22:28', 'yes Maam ok gid sya'),
(7, 12, 1, 'PDS', NULL, '1784607841_2015-SALN-Form SeroWan 2024.doc', '../uploads/1784607841_2015-SALN-Form SeroWan 2024.doc', NULL, 'Pending', '2026-07-21 04:24:01', NULL),
(8, 12, 20, 'ELigibilty Certificate', 'paki check maam kun sakto', '1784609405_Applications of Chemistry.docx', '../uploads/1784609405_Applications of Chemistry.docx', NULL, 'Returned', '2026-07-21 04:50:05', 'yes maam pwede mo na submit'),
(9, 12, 4, 'dpcr ah', 'check b boss', '1784610210_Male Teacher DEPED - Copy.png', '../uploads/1784610210_Male Teacher DEPED - Copy.png', NULL, 'Pending', '2026-07-21 05:03:30', 'sktoo oah'),
(10, 12, 9, 'dga', 'fadsfdgd', '1784690349_8c5081f1d800f54a3b2620c9e8b0529a.jpg', '../uploads/1784690349_8c5081f1d800f54a3b2620c9e8b0529a.jpg', NULL, 'Approved', '2026-07-22 03:19:09', 'hgy');

-- --------------------------------------------------------

--
-- Table structure for table `document_categories`
--

CREATE TABLE `document_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_categories`
--

INSERT INTO `document_categories` (`category_id`, `category_name`) VALUES
(1, 'PDS'),
(2, 'IPCR'),
(3, 'UPCR'),
(4, 'DPCR'),
(5, 'Service Credit Accomplishment Report'),
(6, 'Year-End Faculty Clearance'),
(7, 'Clearance Per Job Order Employees'),
(8, 'Part-Time Faculty Clearance'),
(9, 'DTR Monthly'),
(10, 'DTR Yearly'),
(11, 'Faculty Profile'),
(12, 'Job Application'),
(13, 'Request for Personnel Records'),
(14, 'Transcript of Records'),
(15, 'Diploma'),
(16, 'Medical Certificate'),
(17, 'Marriage Certificate'),
(18, 'Service Record'),
(19, 'Job Description - JOCOS'),
(20, 'Eligibility Certificate'),
(21, 'License'),
(22, 'Rating'),
(23, 'Individual Professional Development Plan'),
(24, 'Learning Needs Assessment'),
(25, 'Learning Application Report'),
(26, 'Travel Narrative Report');

-- --------------------------------------------------------

--
-- Table structure for table `document_reviews`
--

CREATE TABLE `document_reviews` (
  `review_id` int(11) NOT NULL,
  `document_id` int(11) NOT NULL,
  `reviewer_id` int(11) NOT NULL,
  `reviewer_role` varchar(20) DEFAULT NULL,
  `action_taken` varchar(100) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `review_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(4) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 6, 'Your document \"service record\" has been Pending by HR.', 0, '2026-07-06 05:23:20'),
(2, 6, 'Your document \"service record\" has been Approved by HR.', 0, '2026-07-06 05:24:04'),
(3, 6, 'Your document \"service record\" has been Approved by HR.', 0, '2026-07-06 05:26:02'),
(4, 6, 'Your document \"service record\" has been Approved by HR.', 0, '2026-07-06 05:27:47'),
(5, 6, 'Your document \"ok\" has been Approved by HR.', 0, '2026-07-06 05:27:52'),
(6, 6, 'Your document \"ok\" has been Approved by HR.', 0, '2026-07-13 09:46:19'),
(7, 6, 'Your document \"ok\" has been Approved by HR.', 0, '2026-07-13 09:48:51'),
(8, 6, 'Your document \"ok\" has been Approved by HR.', 0, '2026-07-13 09:48:53'),
(9, 6, 'Your document \"ok\" has been Rejected by HR.', 0, '2026-07-13 09:49:06'),
(10, 6, 'Your document \"ok\" has been Rejected by HR.', 0, '2026-07-13 09:50:37'),
(11, 6, 'Your document \"ok\" has been Rejected by HR.', 0, '2026-07-13 10:52:39'),
(12, 3, 'Your document \"title\" has been Pending by HR.', 0, '2026-07-13 22:32:03'),
(13, 6, 'Your document \"ok\" has been Approved by HR.', 0, '2026-07-13 22:32:23'),
(14, 6, 'Your document \"ok\" has been Approved by HR.', 0, '2026-07-13 22:32:25'),
(15, 11, 'Your document \"sakto ni sa maam?\" has been Approved by HR.', 1, '2026-07-19 09:23:03'),
(16, 11, 'Your document \"sakto ni sa maam?\" has been Approved by HR.', 1, '2026-07-19 10:18:11'),
(17, 3, 'Your document \"title\" has been Rejected by HR.', 0, '2026-07-19 10:19:20'),
(18, 3, 'Your document \"title\" has been Approved by HR.', 0, '2026-07-19 10:19:28'),
(20, 11, 'Your document \"sakto ni sa maam?\" has been Approved by HR.', 1, '2026-07-20 13:39:24'),
(21, 12, 'Your document \'ELigibilty Certificate\' has been Returned by HR.', 1, '2026-07-21 04:51:53'),
(22, 12, 'Your document \'dpcr ah\' has been Pending by HR.', 1, '2026-07-21 05:04:40'),
(23, 12, 'Your document \'dga\' has been Approved by HR.', 1, '2026-07-22 03:19:23');

-- --------------------------------------------------------

--
-- Table structure for table `requirements_tracker`
--

CREATE TABLE `requirements_tracker` (
  `tracker_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `requirement_status` varchar(20) DEFAULT 'Missing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `log_id` int(11) NOT NULL,
  `event` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `performed_by` varchar(100) DEFAULT NULL,
  `log_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`log_id`, `event`, `description`, `performed_by`, `log_date`) VALUES
(1, 'System Initialized', 'HR Document Management System has been installed.', 'System', '2026-07-21 15:59:25');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(11) NOT NULL,
  `system_name` varchar(255) DEFAULT NULL,
  `school_name` varchar(255) DEFAULT NULL,
  `campus` varchar(255) DEFAULT NULL,
  `official_email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `system_name`, `school_name`, `campus`, `official_email`) VALUES
(1, 'ISAT U HR Document Management System', 'Iloilo Science and Technology University', 'Miagao Campus', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `employee_id` varchar(50) DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL,
  `department` varchar(150) DEFAULT NULL,
  `position_title` varchar(150) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `employee_id`, `first_name`, `middle_name`, `last_name`, `email`, `password`, `role`, `department`, `position_title`, `status`, `created_at`) VALUES
(10, '1111', 'hr', 'hr', 'hr', 'hr@gmail.com', '$2y$10$orMyZwCfai4cAbUCuHh/iuKtdayfsM33W93zA5UGATO0s6TIrh1IW', 'hr', 'hr', NULL, 'Active', '2026-07-13 07:53:52'),
(11, '2024-1234-F', 'Michael ', 'Aguilar', 'Atilano', 'michael@gmail.com', '$2y$10$ffbMOmSWgSy3hNgR06/Bw.KXqteNUHz/4v1zMrARPysGD3Mpnt88S', 'faculty', 'Education', NULL, 'Active', '2026-07-19 09:10:38'),
(12, '2023-1423', 'Gian Alexic', 'Esleyer', 'Ecle', 'gian@gmail.com', '$2y$10$49WG4I0q4ze4p6ajG5LQDuSLNEDQt2OhQTWWWE1n8LkkEZUX.XyvW', 'faculty', 'HBM', '', 'Active', '2026-07-19 09:11:17'),
(14, '2021323', 'Ramon', 'Max', 'Emmanuel', 'admin@gmail.com', '$2y$10$zGiN9SAHCM1/BIR5dyz09e.jnjPSz4F2Xd1XU3kj.sf1raTOk8NUG', 'admin', 'Head Office', 'Administrator', 'Active', '2026-07-20 03:11:01'),
(15, '2023-4111-M', 'John', 'Carlo', 'Gabadal', 'carlo@gmail.com', '$2y$10$W0xzLYUZZ.7wjlvMmw9gEOyV3ZqnTdeLctvk8pO2QS8DGLzKsACoC', 'faculty', 'Computer Studies', NULL, 'Active', '2026-07-21 06:10:09'),
(16, '20213232', 'Kieavane', 'Carlo', 'Gabadal', 'kievanne@gmail.com', '$2y$10$ONHrvNM/R/RT12rCKRKw4ORogYM03LoTWjX7vNqbCIikMvCdDiyKG', 'faculty', '', '', 'Inactive', '2026-07-21 09:52:39'),
(17, '123', 'Emmanuel', 'Pogi', 'Tanagras', 'emmanuel@gmail.com', '$2y$10$0blJPlpNAu8ueChNwfUiP.o1W8Ff6FTi9THNZ/XuAkaxcU3FK.2J6', 'faculty', NULL, NULL, 'Active', '2026-07-21 09:56:56'),
(18, '344738', 'Judifer John', 'Gito', 'Legaspi', 'judifer@gmail.com', '$2y$10$C5pHKp7XizJTLt9VgIXWOuMjE7pDAB.tJNCAeb.usTfFjeyNyYTAe', 'faculty', 'Computer Studies', NULL, 'Active', '2026-07-21 15:02:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`);

--
-- Indexes for table `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `document_categories`
--
ALTER TABLE `document_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `document_reviews`
--
ALTER TABLE `document_reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `requirements_tracker`
--
ALTER TABLE `requirements_tracker`
  ADD PRIMARY KEY (`tracker_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documents`
--
ALTER TABLE `documents`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `document_categories`
--
ALTER TABLE `document_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `document_reviews`
--
ALTER TABLE `document_reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `requirements_tracker`
--
ALTER TABLE `requirements_tracker`
  MODIFY `tracker_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
