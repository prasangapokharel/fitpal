-- phpMyAdmin SQL Dump

-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2024 at 05:43 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `befit`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_recommendations`
--

CREATE TABLE `ai_recommendations` (
  `recommendation_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `recommendation_type` enum('diet','workout') DEFAULT NULL,
  `recommendation_text` text DEFAULT NULL,
  `date_recommended` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `body_stats`
--

CREATE TABLE `body_stats` (
  `user_id` int(11) NOT NULL,
  `bmi` decimal(5,2) DEFAULT NULL,
  `protein_goal` decimal(5,2) DEFAULT NULL,
  `calories_goal` decimal(5,2) DEFAULT NULL,
  `weight_recommendation` decimal(5,2) DEFAULT NULL,
  `weight_goal` decimal(5,2) DEFAULT NULL,
  `date_updated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `body_stats`
--

INSERT INTO `body_stats` (`user_id`, `bmi`, `protein_goal`, `calories_goal`, `weight_recommendation`, `weight_goal`, `date_updated`) VALUES
(1, 14.78, 44.00, 770.00, 33.49, NULL, '2024-12-09 15:19:16'),
(2, 24.78, 149.40, 999.99, 75.35, NULL, '2024-12-09 15:34:17');

-- --------------------------------------------------------

--
-- Table structure for table `nutrition`
--

CREATE TABLE `nutrition` (
  `food_id` int(11) NOT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `protein` decimal(5,2) DEFAULT NULL,
  `carbs` decimal(5,2) DEFAULT NULL,
  `calorie` decimal(5,2) DEFAULT NULL,
  `amount` decimal(5,2) DEFAULT 100.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sms_notifications`
--

CREATE TABLE `sms_notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `weekly_activities` enum('highly_active','active','normal') DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `google_auth_secret` varchar(255) DEFAULT NULL,
  `normal_protein_goal` decimal(5,2) DEFAULT NULL,
  `muscle_building_protein_goal` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `phone`, `email`, `full_name`, `password`, `age`, `profile_image`, `weight`, `height`, `weekly_activities`, `gender`, `status`, `google_auth_secret`, `normal_protein_goal`, `muscle_building_protein_goal`) VALUES
(1, '+1 (236) 177-16', NULL, 'Chaim Harrell', '$2y$10$KxlQ1GhqpIAWzvgLZbDWP.BhNVqE0O68miyHfyuXWdRtvoPGEv1y.', 22, NULL, 22.00, 122.00, 'highly_active', NULL, 'active', NULL, NULL, NULL),
(2, '9811388848', NULL, 'Prasanga Pokharel', '$2y$10$fV9n4NgJB3eT4ChBIxVxKOb0UFykS.GA4AzFI77NNlDS3tEIh5/se', 22, NULL, 83.00, 183.00, 'active', 'male', 'active', '4ILD3E6Z7ND2DR6Q', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_food`
--

CREATE TABLE `user_food` (
  `food_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `food_name` varchar(255) NOT NULL,
  `protein` decimal(5,2) NOT NULL,
  `calorie` decimal(5,2) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_meal`
--

CREATE TABLE `user_meal` (
  `meal_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `food_name` varchar(255) DEFAULT NULL,
  `food_time` enum('breakfast','lunch','dinner','snack') DEFAULT NULL,
  `protein` decimal(5,2) DEFAULT NULL,
  `carbs` decimal(5,2) DEFAULT NULL,
  `calorie` decimal(5,2) DEFAULT NULL,
  `amount` decimal(5,2) DEFAULT NULL,
  `consumed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `workout_log`
--

CREATE TABLE `workout_log` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `exercise_name` varchar(255) DEFAULT NULL,
  `duration_minutes` int(11) DEFAULT NULL,
  `calories_burned` decimal(5,2) DEFAULT NULL,
  `workout_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `workout_log`
--

INSERT INTO `workout_log` (`log_id`, `user_id`, `exercise_name`, `duration_minutes`, `calories_burned`, `workout_date`) VALUES
(1, 2, 'Push-ups', 15, 50.00, '2024-12-09 16:20:22'),
(2, 2, 'Squats', 15, 60.00, '2024-12-09 16:20:22'),
(3, 2, 'Plank', 10, 30.00, '2024-12-09 16:20:22'),
(4, 2, 'Push-ups', 15, 50.00, '2024-12-09 16:21:00'),
(5, 2, 'Squats', 15, 60.00, '2024-12-09 16:21:00'),
(6, 2, 'Plank', 10, 30.00, '2024-12-09 16:21:00'),
(7, 2, 'Push-ups', 15, 50.00, '2024-12-09 16:24:35'),
(8, 2, 'Squats', 15, 60.00, '2024-12-09 16:24:35'),
(9, 2, 'Plank', 10, 30.00, '2024-12-09 16:24:35'),
(10, 2, 'Push-ups', 15, 50.00, '2024-12-09 16:24:40'),
(11, 2, 'Squats', 15, 60.00, '2024-12-09 16:24:40'),
(12, 2, 'Plank', 10, 30.00, '2024-12-09 16:24:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ai_recommendations`
--
ALTER TABLE `ai_recommendations`
  ADD PRIMARY KEY (`recommendation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `body_stats`
--
ALTER TABLE `body_stats`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD PRIMARY KEY (`food_id`),
  ADD UNIQUE KEY `food_name` (`food_name`);

--
-- Indexes for table `sms_notifications`
--
ALTER TABLE `sms_notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_food`
--
ALTER TABLE `user_food`
  ADD PRIMARY KEY (`food_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_meal`
--
ALTER TABLE `user_meal`
  ADD PRIMARY KEY (`meal_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `workout_log`
--
ALTER TABLE `workout_log`
  ADD PRIMARY KEY (`log_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ai_recommendations`
--
ALTER TABLE `ai_recommendations`
  MODIFY `recommendation_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nutrition`
--
ALTER TABLE `nutrition`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sms_notifications`
--
ALTER TABLE `sms_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_food`
--
ALTER TABLE `user_food`
  MODIFY `food_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_meal`
--
ALTER TABLE `user_meal`
  MODIFY `meal_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `workout_log`
--
ALTER TABLE `workout_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ai_recommendations`
--
ALTER TABLE `ai_recommendations`
  ADD CONSTRAINT `ai_recommendations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `body_stats`
--
ALTER TABLE `body_stats`
  ADD CONSTRAINT `body_stats_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `sms_notifications`
--
ALTER TABLE `sms_notifications`
  ADD CONSTRAINT `sms_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_food`
--
ALTER TABLE `user_food`
  ADD CONSTRAINT `user_food_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `user_meal`
--
ALTER TABLE `user_meal`
  ADD CONSTRAINT `user_meal_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `workout_log`
--
ALTER TABLE `workout_log`
  ADD CONSTRAINT `workout_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
