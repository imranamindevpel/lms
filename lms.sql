-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 03, 2023 at 02:06 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `folder_id` text COLLATE utf8mb4_unicode_ci,
  `detail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `folder_id`, `detail`, `created_at`, `updated_at`) VALUES
(1, 'Html', NULL, 'Test Mode', '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(2, 'CSS', NULL, 'Test Mode', '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(3, 'Javascript', NULL, 'Test Mode', '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(4, 'Php', NULL, 'Test Mode', '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(5, 'Laravel', NULL, 'Test Mode', '2023-08-03 14:01:58', '2023-08-03 14:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `event` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `who` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `when` datetime NOT NULL,
  `where` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `how` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2023_06_12_084059_create_courses_table', 1),
(7, '2023_06_13_132338_create_user_course_table', 1),
(8, '2023_06_14_065105_create_quizzes_table', 1),
(9, '2023_06_15_195945_create_reports_table', 1),
(10, '2023_06_21_161509_create_logs_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

CREATE TABLE `quizzes` (
  `id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `question` text COLLATE utf8mb4_unicode_ci,
  `option_a` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_b` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_c` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `option_d` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correct_option` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_marks` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `quizzes`
--

INSERT INTO `quizzes` (`id`, `course_id`, `question`, `option_a`, `option_b`, `option_c`, `option_d`, `correct_option`, `total_marks`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 'What does HTML stand for?', 'Hyperlinks and Text Markup Language', 'Hyper Text Markup Language', 'Home Tool Markup Language', 'Hyper Text Makeup Language', 'b', 10, NULL, NULL, NULL),
(2, 1, 'Which HTML tag is used to define an unordered list?', '<ul>', '<li>', '<ol>', '<list>', 'a', 10, NULL, NULL, NULL),
(3, 1, 'What is the correct HTML element for inserting a line break?', '<break>', '<lb>', '<br>', '<newline>', 'c', 10, NULL, NULL, NULL),
(4, 1, 'Which character entity represents the \"at\" symbol (@) in HTML?', '&copy;', '&at;', '&amp;', '&commat;', 'd', 10, NULL, NULL, NULL),
(5, 1, 'What is the purpose of the HTML alt attribute?', 'It specifies the alignment of the image.', 'It provides a title for the image.', 'It specifies an alternative text for an image if it cannot be displayed.', 'It defines the size of the image.', 'c', 10, NULL, NULL, NULL),
(6, 2, 'Which CSS property is used to change the background color?', 'color', 'background-color', 'text-color', 'bgcolor', 'b', 10, NULL, NULL, NULL),
(7, 2, 'Which CSS property is used to add shadows to elements?', 'text-shadow', 'box-shadow', 'shadow', 'element-shadow', 'b', 10, NULL, NULL, NULL),
(8, 2, 'What does CSS stand for?', 'Colorful Style Sheets', 'Creative Style Sheets', 'Cascading Style Sheets', 'Computer Style Sheets', 'c', 10, NULL, NULL, NULL),
(9, 2, 'Which CSS property is used to control the text size?', 'font-style', 'text-size', 'font-size', 'text-style', 'c', 10, NULL, NULL, NULL),
(10, 2, 'In CSS, which property is used to control the space between elements?', 'margin', 'padding', 'border', 'spacing', 'b', 10, NULL, NULL, NULL),
(11, 3, 'What is the correct way to declare a JavaScript variable?', 'v carName;', 'variable carName;', 'var carName;', 'variable = carName;', 'c', 10, NULL, NULL, NULL),
(12, 3, 'Which built-in method returns the length of the string?', 'length()', 'size()', 'count()', 'length', 'd', 10, NULL, NULL, NULL),
(13, 3, 'How do you write \"Hello World\" in an alert box?', 'msg(\"Hello World\");', 'alertBox(\"Hello World\");', 'alert(\"Hello World\");', 'msgBox(\"Hello World\");', 'c', 10, NULL, NULL, NULL),
(14, 3, 'What is the output of the following JavaScript code?\\n\\nconsole.log(2 + \"2\");', '4', '22', 'undefined', 'NaN', 'b', 10, NULL, NULL, NULL),
(15, 3, 'Which function is used to parse a string to an integer in JavaScript?', 'parseInt()', 'parseInteger()', 'stringToInt()', 'toInteger()', 'a', 10, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `quiz_date` date NOT NULL,
  `clock_in` datetime DEFAULT NULL,
  `clock_out` datetime DEFAULT NULL,
  `obtained_marks` int DEFAULT NULL,
  `total_marks` int DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `user_id`, `course_id`, `quiz_date`, `clock_in`, `clock_out`, `obtained_marks`, `total_marks`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(2, 1, 2, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(3, 1, 3, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(4, 1, 4, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(5, 1, 5, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(6, 2, 1, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(7, 2, 2, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(8, 2, 3, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(9, 2, 4, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(10, 2, 5, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(11, 3, 1, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(12, 3, 2, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(13, 3, 3, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(14, 3, 4, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(15, 3, 5, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(16, 4, 1, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(17, 4, 2, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(18, 4, 3, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(19, 4, 4, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(20, 4, 5, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(21, 5, 1, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(22, 5, 2, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(23, 5, 3, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(24, 5, 4, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59'),
(25, 5, 5, '2023-08-03', NULL, NULL, NULL, NULL, NULL, '2023-08-03 14:01:59', '2023-08-03 14:01:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin', 'admin@gmail.com', NULL, '$2y$10$lrkgm418EjLY.EQWiMh40usDgpuncBGNvZ0UbAIy3T6WfdCuXFqRi', NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(2, 'Teacher1', 'teacher', 'teacher1@gmail.com', NULL, '$2y$10$G8sqFP0tH9piddxHKwFTq.zfm28dXuUFb1n9fR0C8lwU6c8GPDonG', NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(3, 'Teacher2', 'teacher', 'teacher2@gmail.com', NULL, '$2y$10$FmFyVYT0uG2PvxyJtpCHPeHPYWyVWqDdkzddiauDhrc7/SLGhKxq.', NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(4, 'Teacher3', 'teacher', 'teacher3@gmail.com', NULL, '$2y$10$geruqo0CS0bzDx7HQzJF9ebPQoFFSr459Jj16bVGxmBkbIhspega.', NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58'),
(5, 'Student', 'student', 'student@gmail.com', NULL, '$2y$10$GObLwzyYQC5DqjTRdMaup.u5Cqt9iDVDXA.VeHD4x9L/CNu4y3Zii', NULL, '2023-08-03 14:01:58', '2023-08-03 14:01:58');

-- --------------------------------------------------------

--
-- Table structure for table `user_course`
--

CREATE TABLE `user_course` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `course_id` bigint UNSIGNED NOT NULL,
  `permission_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `quizzes`
--
ALTER TABLE `quizzes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_course`
--
ALTER TABLE `user_course`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quizzes`
--
ALTER TABLE `quizzes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_course`
--
ALTER TABLE `user_course`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
