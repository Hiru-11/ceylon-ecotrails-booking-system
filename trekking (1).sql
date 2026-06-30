-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 30, 2026 at 08:50 PM
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
-- Database: `trekking`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `currency` varchar(10) DEFAULT 'LKR',
  `notes` text DEFAULT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `booking_date`, `payment_method`, `currency`, `notes`, `total_price`, `status`) VALUES
(1, 1, '2025-11-23', 'Card', 'LKR', 'ef', 19000.00, 'pending'),
(2, 2, '2025-11-23', 'Card', 'LKR', 'fgef', 100000.00, 'pending'),
(3, 3, '2025-11-23', 'Card', 'LKR', 'fgef', 95000.00, 'pending'),
(4, 4, '2025-11-23', 'Card', 'LKR', 'fgef', 47500.00, 'pending'),
(5, 5, '2025-11-23', 'Card', 'LKR', '42r', 250000.00, 'pending'),
(6, 6, '2026-01-04', 'Card', 'LKR', '', 84000.00, 'pending'),
(7, 7, '2026-01-04', '', 'LKR', '', 54000.00, 'pending'),
(8, 8, '2026-01-04', '', 'LKR', '', 10000.00, 'pending'),
(9, 9, '2026-01-04', 'Card', 'LKR', '', 10000.00, 'pending'),
(10, 10, '2026-01-05', 'Card', 'LKR', '', 56000.00, 'pending'),
(11, 11, '2026-06-26', 'Card', 'LKR', '', 18000.00, 'pending'),
(12, 12, '2026-06-27', 'Card', 'LKR', '', 18000.00, 'pending'),
(13, 13, '2026-06-27', 'Card', 'LKR', '', 54000.00, 'pending'),
(14, 14, '2026-06-30', 'Card', 'LKR', '', 340000.00, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `booking_tours`
--

CREATE TABLE `booking_tours` (
  `tour_id` int(11) NOT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `tour_name` varchar(255) DEFAULT NULL,
  `participants` int(11) DEFAULT NULL,
  `tour_date` date DEFAULT NULL,
  `price_per_person` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_tours`
--

INSERT INTO `booking_tours` (`tour_id`, `booking_id`, `tour_name`, `participants`, `tour_date`, `price_per_person`) VALUES
(1, 1, 'Birdwatching Tour', 2, '2025-10-30', 9500.00),
(2, 2, 'Waterfall Trek', 10, '2025-11-27', 10000.00),
(3, 3, 'Birdwatching Tour', 10, '2025-11-26', 9500.00),
(4, 4, 'Birdwatching Tour', 5, '2025-11-24', 9500.00),
(5, 5, 'Mountain Climbing Adventure', 10, '2025-11-26', 25000.00),
(6, 6, 'Cultural Heritage Hike', 3, '2026-01-08', 18000.00),
(7, 6, 'Waterfall Trek', 3, '2026-01-06', 10000.00),
(8, 7, 'Birdwatching Tour', 2, '2026-01-14', 9500.00),
(9, 7, 'Rainforest Expedition', 2, '2026-01-07', 17500.00),
(10, 8, 'Waterfall Trek', 1, '2026-01-14', 10000.00),
(11, 9, 'Waterfall Trek', 1, '2026-01-16', 10000.00),
(12, 10, 'Cultural Heritage Hike', 2, '2026-01-06', 18000.00),
(13, 10, 'Waterfall Trek', 2, '2026-01-06', 10000.00),
(14, 11, 'Cultural Heritage Hike', 1, '2026-06-02', 18000.00),
(15, 12, 'Cultural Heritage Hike', 1, '0000-00-00', 18000.00),
(16, 13, 'Cultural Heritage Hike', 3, '2026-06-20', 18000.00),
(17, 14, 'Waterfall Trek', 34, '2026-06-04', 10000.00);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `full_name`, `email`, `phone`, `message`, `submitted_at`) VALUES
(4, 'Cookie Gunawardena', 'cookie@gmail.com', '0776344527', 'Please provide me with details regarding customizable tours', '2026-01-04 07:27:49'),
(5, 'Hirunie Gunawardena', 'test@gmail.com', '0776366534', 'Can you please provide details regarding customizable events. Thankyou.', '2026-01-04 15:02:15'),
(6, 'Tharushie Gunawardena', 'test@gmail.com', '0776533420', 'Hi', '2026-01-04 15:03:21'),
(7, 'Tharushie Gunawardena', 'test@gmail.com', '0776533420', 'Hi', '2026-01-04 15:06:46'),
(8, 'Brownie Gunawardena', 'test@gmail.com', '0776533425', 'Hi', '2026-01-04 15:08:27'),
(9, 'Dinesh Gunawardena', 'test@gmail.com', '0776344250', 'Hi', '2026-01-04 15:14:18'),
(10, 'Hirunie', 'ashley@gmail.com', '0778677560', 'hi', '2026-01-05 04:50:30');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `date` varchar(50) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `activities` text DEFAULT NULL,
  `max_participants` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `name`, `type`, `image`, `description`, `date`, `location`, `activities`, `max_participants`) VALUES
(1, 'Eco Awareness Festival', 'Community Event', 'Resources/cyclingbanner.avif', 'Join us for a full-day festival dedicated to environmental education and sustainability awareness. Enjoy workshops, local food stalls, and performances that celebrate Sri Lanka’s natural beauty.', '10th December 2025', 'Kandy City Park', 'Eco talks, recycling workshops, tree planting, and local music shows', 300),
(2, 'Rainforest Conservation Camp', 'Volunteer Program', 'Resources/rainforest.jpg', 'Spend two meaningful days in the heart of the Sinharaja Forest Reserve helping to conserve biodiversity and learning about sustainable living practices from local experts.', '18th–19th December 2025', 'Sinharaja Rainforest', 'Trail restoration, tree planting, wildlife observation, and eco-camping', 40),
(3, 'Mountain Clean-Up Challenge', 'Outdoor Activity', 'Resources/cleaninigmountains.jpg', 'Take part in our adventure-based cleanup challenge on Sri Lanka’s famous peaks. A rewarding way to promote eco-tourism while enjoying panoramic mountain views.', '27th December 2025', 'Knuckles Mountain Range', 'Hiking, cleanup drive, team competitions, and eco-awareness sessions', 60);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `media_type` enum('image','video') DEFAULT 'image',
  `media_path` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `category`, `media_type`, `media_path`, `description`) VALUES
(1, 'Mountain Trail', 'mountain trail', 'image', 'Resources/mountainclimbingsrilanka.jpg', NULL),
(2, 'Mountain Camping', 'mountain trail', 'image', 'Resources/mountaincamping.png', NULL),
(3, 'Mountain Climbing', 'mountain trail', 'image', 'Resources/rockclimbing.jpg', NULL),
(4, 'Rainforest Walk', 'rainforest', 'image', 'Resources/rainforestwalk.jpg', NULL),
(5, 'Rainforest Cleaning', 'rainforest', 'image', 'Resources/mountaincleaning.jpg', NULL),
(6, 'Greenery', 'rainforest', 'image', 'Resources/gallery.jpg', NULL),
(7, 'Bird Watching 1', 'BirdWatching', 'image', 'Resources/birdwatching.jpg', NULL),
(8, 'Bird Watching 2', 'BirdWatching', 'image', 'Resources/Birds.jpg', NULL),
(9, 'Bird Photography', 'BirdWatching', 'image', 'Resources/birdphotography.jpg', NULL),
(10, 'Sigiriya', 'cultural visit', 'image', 'Resources/sigiriya.webp', NULL),
(11, 'Cultural Heritage Sites', 'people culture', 'image', 'Resources/culturalheritagesites.jpg', NULL),
(12, 'Wildlife Rainforest Video', 'wildlife rainforest', 'video', 'Resources/galleryvideo1.mp4', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `difficulty` varchar(20) NOT NULL,
  `duration` varchar(50) NOT NULL,
  `group_size` varchar(50) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `next_departure` datetime NOT NULL,
  `places_visited` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`id`, `name`, `description`, `difficulty`, `duration`, `group_size`, `price`, `next_departure`, `places_visited`, `image`) VALUES
(1, 'Cultural Heritage Hike', 'Experience Sri Lanka’s rich history through a guided hike across ancient temples, stone carvings, and rural villages. Explore local markets, interact with artisans, and participate in traditional cooking sessions.', 'Moderate', '2 Days / 1 Night', 'Up to 10 people', 18000.00, '2025-11-15 08:00:00', 'Sigiriya, Dambulla, Polonnaruwa, Local Villages', 'Resources/sigiriya.webp'),
(2, 'Waterfall Trek', 'Embark on an adventure through lush forests and hidden waterfalls. Swim in natural pools, enjoy birdwatching, and capture stunning landscapes along the way.', 'Easy', '1 Day', 'Up to 12 people', 10000.00, '2025-11-22 07:30:00', 'Bambarakanda Falls, Diyaluma Falls, Udaweriya Forest', 'Resources/waterfalltrekking.jpg'),
(3, 'Birdwatching Tour', 'Spot rare and exotic bird species in Sri Lanka’s protected wetlands and forests, guided by an experienced ornithologist. Learn about habitat conservation and bird photography tips.', 'Easy', '1 Day', 'Up to 8 people', 9500.00, '2025-11-20 06:00:00', 'Kumana National Park, Bundala Wetlands, Yala Forest', 'Resources/birdwatchingtours.jpg'),
(4, 'Rainforest Expedition', 'Explore Sri Lanka’s dense rainforests with expert guides. Discover hidden streams, diverse flora, and fauna. Enjoy short nature photography sessions along the way.', 'Moderate', '2 Days / 1 Night', 'Up to 10 people', 17500.00, '2025-11-28 07:00:00', 'Sinharaja Forest Reserve, Kithulgala, Belihuloya', 'Resources/rainforestexpeditions.jpg'),
(5, 'Mountain Climbing Adventure', 'Challenge yourself with thrilling mountain climbs. Learn safety techniques, enjoy panoramic views, and camp under the stars.', 'Hard', '3 Days / 2 Nights', 'Up to 8 people', 25000.00, '2025-11-30 06:00:00', 'Adam\'s Peak, Knuckles Mountain Range, Horton Plains', 'Resources/climbingmountain.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `emergency_name` varchar(100) DEFAULT NULL,
  `emergency_number` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `phone`, `emergency_name`, `emergency_number`, `created_at`) VALUES
(1, '', '', 'pasindubishan20@gmail.com', NULL, '', '', '2025-11-23 16:40:52'),
(2, '', '', 'test@gmail.com', NULL, '', '', '2025-11-23 16:41:45'),
(3, '', '', 'test@gmail.com', NULL, '', '', '2025-11-23 16:42:28'),
(4, '', '', 'test@gmail.com', NULL, '', '', '2025-11-23 16:42:59'),
(5, '', '', 'test@gmail.com', NULL, '', '', '2025-11-23 16:54:11'),
(6, '', '', 'tharushie@gmail.com', NULL, '', '', '2026-01-04 07:09:04'),
(7, 'Hirunie', 'Gunawardena', 'hiruniegunawardena@gmail.com', NULL, 'Tharushie Gunawardena', '0762456778', '2026-01-04 07:25:49'),
(8, 'Aaron', 'De Silva', 'aaron@gmal.com', NULL, 'Nimal De Silva', '0765433273', '2026-01-04 14:42:57'),
(9, 'Brown', 'Gunawardena', 'hiruniegunawardena@gmail.com', NULL, 'Tharushie Gunawardena', '0762456778', '2026-01-04 14:50:12'),
(10, 'Aaron', 'Gunawardena', 'hiruniegunawardena@gmail.com', NULL, 'Hirunie', '0776455398', '2026-01-05 04:49:38'),
(11, 'Aaron', 'Gunawardena', 'hiruniegunawardena@gmail.com', NULL, 'Hirunie', '0776455398', '2026-06-26 18:23:37'),
(12, 'Hirunie', 'Gunawardena', 'hiruniegunawardena@gmail.com', NULL, 'Thraushie', '0775433527', '2026-06-26 18:32:47'),
(13, 'Aaron', 'Gunawardena', 'ashley@gmail.com', NULL, 'Hirunie', '0887656787', '2026-06-27 17:43:20'),
(14, 'Hirunie', 'Gunawardena', 'hiruniegunawardena@gmail.com', NULL, 'Tharushie Gunawardena', '0762456778', '2026-06-30 15:25:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `booking_tours`
--
ALTER TABLE `booking_tours`
  ADD PRIMARY KEY (`tour_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `booking_tours`
--
ALTER TABLE `booking_tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `booking_tours`
--
ALTER TABLE `booking_tours`
  ADD CONSTRAINT `booking_tours_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
