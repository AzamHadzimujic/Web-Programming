-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2025 at 02:32 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `duration` int(10) UNSIGNED NOT NULL DEFAULT 10,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`activity_id`, `user_id`, `category_id`, `name`, `duration`, `date`) VALUES
(4, 2, 1, 'Running', 30, '2025-11-01 08:00:00'),
(5, 3, 2, 'Add your name in the body', 45, '2025-11-02 09:00:00'),
(6, 4, 3, 'Swimming', 60, '2025-11-03 10:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `blogpost`
--

CREATE TABLE `blogpost` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(300) DEFAULT NULL,
  `content` varchar(500) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blogpost`
--

INSERT INTO `blogpost` (`post_id`, `user_id`, `name`, `content`, `created_at`) VALUES
(1, 1, 'Welcome to FitTrack!', 'Admin here — stay tuned for updates and fitness tips!', '2025-10-28 12:00:00'),
(2, 2, 'My Running Journey', 'Started slow, but I am now doing 8km daily!', '2025-11-01 09:45:00'),
(3, 3, 'Yoga for Beginners', 'Sharing my favorite morning poses to start the day right.', '2025-11-02 10:10:00'),
(4, 4, 'Trail Running Experience', 'Nature + running = best combo. Tips inside!', '2025-11-03 15:20:00'),
(5, 5, 'Lifting for Strength', 'Documenting my progress in the gym every week.', '2025-11-04 16:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `name`, `description`) VALUES
(1, 'Cardio', 'Activities that improve cardiovascular health like running or cycling.'),
(2, 'Strength', 'Exercises focused on building muscle and strength.'),
(3, 'Flexibility', 'Stretching, yoga, and activities that improve flexibility.'),
(4, 'Endurance', 'Long-duration activities that enhance stamina.'),
(5, 'Add your name in the body', 'Miscellaneous fitness activities.');

-- --------------------------------------------------------

--
-- Table structure for table `progress_log`
--

CREATE TABLE `progress_log` (
  `progress_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL DEFAULT 75,
  `body_fat` int(11) DEFAULT 25
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `progress_log`
--

INSERT INTO `progress_log` (`progress_id`, `user_id`, `weight`, `body_fat`) VALUES
(1, 2, 74, 22),
(2, 3, 62, 19),
(3, 4, 81, 18),
(4, 5, 68, 21),
(5, 1, 79, 24);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `role` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'admin_user', 'admin@fittrack.com', 'admin_pass123', '2025-11-07 12:05:53', 1),
(2, 'john_doe', 'john@example.com', 'john_pass123', '2025-11-07 12:05:53', 0),
(3, 'jane_smith', 'jane@example.com', 'jane_pass123', '2025-11-07 12:05:53', 0),
(4, 'mark_runner', 'mark@example.com', 'mark_pass123', '2025-11-07 12:05:53', 0),
(5, 'Add your name in the body', 'sara@example.com', 'sara_pass123', '2025-11-07 12:05:53', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `activities_users_FK` (`user_id`),
  ADD KEY `activities_category_FK` (`category_id`);

--
-- Indexes for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `blogpost_users_FK` (`user_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `progress_log`
--
ALTER TABLE `progress_log`
  ADD PRIMARY KEY (`progress_id`),
  ADD KEY `progress_log_users_FK` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `blogpost`
--
ALTER TABLE `blogpost`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `progress_log`
--
ALTER TABLE `progress_log`
  MODIFY `progress_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activities`
--
ALTER TABLE `activities`
  ADD CONSTRAINT `activities_category_FK` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`),
  ADD CONSTRAINT `activities_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `blogpost`
--
ALTER TABLE `blogpost`
  ADD CONSTRAINT `blogpost_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `progress_log`
--
ALTER TABLE `progress_log`
  ADD CONSTRAINT `progress_log_users_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
