-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 24, 2022 at 05:52 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_quizapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cities`
--

CREATE TABLE `tbl_cities` (
  `id` int(11) NOT NULL,
  `city_name` varchar(100) NOT NULL,
  `country_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_cities`
--

INSERT INTO `tbl_cities` (`id`, `city_name`, `country_id`) VALUES
(1, 'Beijing', 1),
(2, 'Shanghai', 1),
(3, 'Wuhan', 1),
(4, 'Kathmandu', 2),
(5, 'Pokhara', 2),
(6, 'Dang', 2),
(7, 'Palpa', 2),
(8, 'Delhi', 3),
(9, 'Punjab', 3),
(10, 'Mumbai', 3),
(11, 'Bombai', 3),
(12, 'Islamabad', 4),
(13, 'Karachi', 4),
(14, 'Toronto', 5),
(15, 'Vancouver', 5),
(16, 'New York', NULL),
(17, 'Miami', 6),
(18, 'Tokyo', 7),
(19, 'Osaka', 7);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_confidential`
--

CREATE TABLE `tbl_confidential` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `profile_img` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `phone` bigint(25) DEFAULT NULL,
  `country` int(11) DEFAULT NULL,
  `city` int(11) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `status` int(11) DEFAULT 2,
  `block` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_confidential`
--

INSERT INTO `tbl_confidential` (`id`, `name`, `username`, `profile_img`, `email`, `password`, `phone`, `country`, `city`, `gender`, `status`, `block`) VALUES
(1, 'Anup Pokharel', 'anuppokharel703', '62b2839825e10_IMG_20220223_141628.jpg', 'anup.pokharel30@gmail.com', 'e6e6249a9d25e5917fb924679cf53369', 9841854241, 2, 4, 'male', 1, 1),
(2, 'Durga KC', 'durga1', '62b34886849de_b3c9dfa78c7a93bbd84f9c8fcbcc2a0e.jpg', 'durga@gmail.com', '2904a936068a124774e77463ac472ffc', 9854587854, 2, 6, 'female', 2, 1),
(3, 'Manoj Chamlagai', 'manoj1', '62b2c868e7e6e_photo-1500648767791-00dcc994a43e.jfif', 'manoj@gmail.com', '977c0156d7403e2bebba75cdf5652678', 9856545875, 2, 4, 'male', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contacts`
--

CREATE TABLE `tbl_contacts` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `message` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_contacts`
--

INSERT INTO `tbl_contacts` (`id`, `username`, `email`, `message`, `password`) VALUES
(1, 'durga1', 'durga@gmail.com', 'Hello please do add the questions so we could participate on quiz. Thank you!', 'durga123');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_countries`
--

CREATE TABLE `tbl_countries` (
  `id` int(11) NOT NULL,
  `country_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_countries`
--

INSERT INTO `tbl_countries` (`id`, `country_name`) VALUES
(6, 'America'),
(5, 'Canada'),
(1, 'China'),
(3, 'India'),
(7, 'Japan'),
(2, 'Nepal'),
(4, 'Pakistan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_questions`
--

CREATE TABLE `tbl_questions` (
  `id` int(11) NOT NULL,
  `question` varchar(100) NOT NULL,
  `firstOption` varchar(100) NOT NULL,
  `secondOption` varchar(100) NOT NULL,
  `thirdOption` varchar(100) NOT NULL,
  `fourthOption` varchar(100) NOT NULL,
  `answer` varchar(100) NOT NULL,
  `question_image` varchar(100) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_questions`
--

INSERT INTO `tbl_questions` (`id`, `question`, `firstOption`, `secondOption`, `thirdOption`, `fourthOption`, `answer`, `question_image`, `topic_id`, `created_at`) VALUES
(1, 'When was Nepal stock market established?', '2055', '2056', '2032', '2059', 'secondOption', '62b3376ae13ac_Nepse.jpg', 11, '2022-06-22 21:28:37'),
(2, 'Which type of mutual Funds aren\'t traded in NEPSE?', 'Open Ended Mutal Funds', 'Close Ended Mutal Funds', 'Open Started Mutal Funds', 'Open and Close Ended Mutal Funds', 'firstOption', '62b33949047e7_48-62356b557879a.jpg', 10, '2022-06-22 21:31:17'),
(3, 'What is the minimum paid up capital for Commercial Banks?', '6 Arba', '3 Arba', '9 Arba', '8 Arba', 'fourthOption', '62b34a4521982_images (1).jpg', 1, '2022-06-22 22:43:45'),
(4, 'Does Microfinance Companies have higher Interest rates in Savings Account than Commercial Banks?', 'Yes', 'Yes by 5% only', 'Yes by 1.234% only', 'No', 'firstOption', '62b34aac5566d_yesterday-today-tomorrow-microfinance-main.jpg', 3, '2022-06-22 22:45:28');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scores`
--

CREATE TABLE `tbl_scores` (
  `id` int(11) NOT NULL,
  `today_top_score` bigint(20) DEFAULT NULL,
  `today_average_score` bigint(20) DEFAULT NULL,
  `total_top_score` bigint(20) DEFAULT NULL,
  `total_average_score` bigint(20) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_scores`
--

INSERT INTO `tbl_scores` (`id`, `today_top_score`, `today_average_score`, `total_top_score`, `total_average_score`, `user_id`) VALUES
(1, 0, 0, 0, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_topics`
--

CREATE TABLE `tbl_topics` (
  `id` int(11) NOT NULL,
  `topic_name` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_topics`
--

INSERT INTO `tbl_topics` (`id`, `topic_name`, `image`) VALUES
(1, 'Bank', '62b2bc9338614_c6be6c28-8ff2-43bd-a06b-44460a66056b.jpg'),
(2, 'Dev Bank', '62b2bcd6deb56_images.jpg'),
(3, 'Microfinance', '62b2bcf83d703_microfinance.jpg'),
(4, 'Finance', '62b2bd346478a_stock.jpg'),
(5, 'Hydropower', '62b2bd548ecb5_istockphoto-626349590-612x612.jpg'),
(6, 'Non life insurance', '62b3de79ed57c_asdfsgfasdg.jpg'),
(7, 'Life insurance', '62b2bdc9b686a_istockphoto-1199060622-612x612.jpg'),
(8, 'Hotel ', '62b2bdf646a48_198190921.jpg'),
(9, 'Manufacturing and processing', '62b2be12c51bc_istockphoto-1157027831-612x612.jpg'),
(10, 'Mutual fund', '62b2be3974029_z8-11-620x400.jpg'),
(11, 'Others', '62b2be54029c2_types-of-stocks.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `country_id` (`country_id`);

--
-- Indexes for table `tbl_confidential`
--
ALTER TABLE `tbl_confidential`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `profile_img` (`profile_img`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tbl_contacts`
--
ALTER TABLE `tbl_contacts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `country_name` (`country_name`);

--
-- Indexes for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `topic_id` (`topic_id`);

--
-- Indexes for table `tbl_scores`
--
ALTER TABLE `tbl_scores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tbl_topics`
--
ALTER TABLE `tbl_topics`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_confidential`
--
ALTER TABLE `tbl_confidential`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_contacts`
--
ALTER TABLE `tbl_contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_countries`
--
ALTER TABLE `tbl_countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_scores`
--
ALTER TABLE `tbl_scores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_topics`
--
ALTER TABLE `tbl_topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_cities`
--
ALTER TABLE `tbl_cities`
  ADD CONSTRAINT `tbl_cities_ibfk_1` FOREIGN KEY (`country_id`) REFERENCES `tbl_countries` (`id`);

--
-- Constraints for table `tbl_questions`
--
ALTER TABLE `tbl_questions`
  ADD CONSTRAINT `tbl_questions_ibfk_1` FOREIGN KEY (`topic_id`) REFERENCES `tbl_topics` (`id`);

--
-- Constraints for table `tbl_scores`
--
ALTER TABLE `tbl_scores`
  ADD CONSTRAINT `tbl_scores_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_confidential` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
