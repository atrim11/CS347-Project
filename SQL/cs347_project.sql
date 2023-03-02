-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2023 at 08:21 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cs347_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL,
  `content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `like_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `log_posts`
--

CREATE TABLE `log_posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `workout` text DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Phone_Num` varchar(15) NOT NULL,
  `Password` varchar(200) NOT NULL,
  `Username` varchar(200) NOT NULL,
  `F_Name` varchar(255) DEFAULT NULL,
  `L_Name` varchar(200) DEFAULT NULL,
  `Height` int(11) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Date_Joined` date NOT NULL,
  `DOB` date NOT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT 'Other'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `Email`, `Phone_Num`, `Password`, `Username`, `F_Name`, `L_Name`, `Height`, `Weight`, `Date_Joined`, `DOB`, `Gender`) VALUES
(1, 'wellingto3@hotmail.com', '786-434-9833', 'pheX0baj8ae', 'blackcat444', 'Jose', 'Spencer', 71, 181, '2023-02-28', '1979-10-05', 'Male'),
(2, 'captainAmerica@avengers.com', '540-332-2590', 'shield123', 'CaptA', 'Steve', 'Rodgers', 74, 245, '2023-02-28', '1920-07-04', 'Male'),
(3, 'superman@hero.com', '234-987-9944', 'manosteel', 'superman', 'Clark', 'Kent', 72, 230, '2023-02-28', '1950-02-28', 'Male'),
(4, 'SamGrant', '571-443-2281', 'fluffy124', 'SamGrant', 'Sam', 'Grant', 60, 105, '2023-02-28', '2001-04-19', 'Female'),
(5, 'alexa2011@hotmail.com', '712-267-2916', 'Sparky7', 'HollyDSanders', 'Holly', 'Sanders', 61, 144, '2023-03-01', '1968-01-17', 'Female'),
(6, 'cali1992@hotmail.com', '919-427-3925', 'Anita1', 'AnitaSChapman', 'Anita', 'Chapman', 65, 164, '2023-03-22', '1946-09-22', 'Female'),
(7, 'fae1973@gmail.com', '267-968-4041', 'Banks55', 'BBanks', 'Brianne', 'Banks', 61, 111, '2023-03-24', '1993-07-24', 'Female'),
(8, 'ethelyn.vo3@gmail.com', '270-903-2536', 'Ilovesports123', 'teranlie', 'Robert', 'Emmerich', 70, 233, '2023-03-15', '1984-03-30', 'Male'),
(9, 'ida_hegman10@hotmail.com', '703-315-5844', 'Ohyoe4ULah', 'danielle.h1973', 'Charles', 'Clark', 69, 148, '2023-03-31', '1974-08-21', 'Male'),
(10, 'sylvester1995@gmail.com', '330-553-9401', 'zooWai8d', 'JumpyWizard', 'Harold', 'Parrish', 73, 165, '2023-04-12', '1958-10-11', 'Male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`like_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `log_posts`
--
ALTER TABLE `log_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `like_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `log_posts`
--
ALTER TABLE `log_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `log_posts` (`post_id`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `log_posts` (`post_id`);

--
-- Constraints for table `log_posts`
--
ALTER TABLE `log_posts`
  ADD CONSTRAINT `log_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
