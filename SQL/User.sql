-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 28, 2023 at 07:43 PM
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
-- Database: `Project`
--

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `User_ID` int(11) NOT NULL,
  `Email` text DEFAULT NULL,
  `Phone#` text DEFAULT NULL,
  `Username` text DEFAULT NULL,
  `Password` text DEFAULT NULL,
  `F_Name` text DEFAULT NULL,
  `L_Name` text DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT 'Other',
  `Height` int(11) DEFAULT NULL,
  `Weight` int(11) DEFAULT NULL,
  `Date_Joined` date DEFAULT NULL,
  `DOB` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`User_ID`, `Email`, `Phone#`, `Username`, `Password`, `F_Name`, `L_Name`, `Gender`, `Height`, `Weight`, `Date_Joined`, `DOB`) VALUES
(1, 'trimmeag@dukes.jmu.edu', '571-207-5051', 'atrimmer', 'password', 'Aidan', 'Trimmer', 'Male', 71, 225, '2023-02-28', '2002-07-02'),
(2, 'captainAmerica@avengers.com', '540-332-2590', 'CaptA', 'shield123', 'Steve', 'Rodgers', 'Male', 74, 245, '2023-02-28', '1920-07-04'),
(3, 'superman@hero.com', '234-987-9944', 'superman', 'manosteel', 'Clark', 'Kent', 'Male', 72, 230, '2023-02-28', '1950-02-28'),
(4, 'SamGrant', '571-443-2281', 'SamGrant', 'fluffy124', 'Sam', 'Grant', 'Female', 60, 105, '2023-02-28', '2001-04-19'),
(5, 'alexa2011@hotmail.com', '712-267-2916', 'HollyDSanders', 'Sparky7', 'Holly', 'Sanders', 'Female', 61, 144, '2023-03-01', '1968-01-17'),
(6, 'cali1992@hotmail.com', '919-427-3925', 'AnitaSChapman', 'Anita1', 'Anita', 'Chapman', 'Female', 65, 164, '2023-03-22', '1946-09-22'),
(7, 'fae1973@gmail.com', '267-968-4041', 'BBanks', 'Banks55', 'Brianne', 'Banks', 'Female', 61, 111, '2023-03-24', '1993-07-24'),
(8, 'ethelyn.vo3@gmail.com', '270-903-2536', 'teranlie', 'Ilovesports123', 'Robert', 'Emmerich', 'Male', 70, 233, '2023-03-15', '1984-03-30'),
(9, 'ida_hegman10@hotmail.com', '703-315-5844', 'danielle.h1973', 'Ohyoe4ULah', 'Charles', 'Clark', 'Male', 69, 148, '2023-03-31', '1974-08-21'),
(10, 'sylvester1995@gmail.com', '330-553-9401', 'JumpyWizard', 'zooWai8d', 'Harold', 'Parrish', 'Male', 73, 165, '2023-04-12', '1958-10-11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `User_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
