-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 31, 2026 at 06:46 PM
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
-- Database: `drupal10`
--

-- --------------------------------------------------------

--
-- Table structure for table `event_registration`
--

CREATE TABLE `event_registration` (
  `id` int(11) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `college` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `event_date` date DEFAULT NULL,
  `event_name` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Stores event registrations';

--
-- Dumping data for table `event_registration`
--

INSERT INTO `event_registration` (`id`, `full_name`, `email`, `college`, `department`, `created`, `event_date`, `event_name`, `category`) VALUES
(1, 'Ponapati vyshnavi', 'vyshnaviponapati@gmail.com', 'Alliance University', 'cse', 1769843578, NULL, NULL, NULL),
(2, 'Ponapati vyshnavi', 'vponapatibtech24@ced.alliance.edu.in', 'Alliance University', 'cse', 1769853950, NULL, NULL, NULL),
(3, 'Ponapati vyshnavi', 'ponapativyshnavi@gmail.com', 'Alliance University', 'cse', 1769855767, '2026-02-20', NULL, NULL),
(4, 'Ponapati vyshnavi', 'vyshnaviponapati@gmail.com', 'Alliance University', 'cse', 1769868513, '2026-02-12', 'Web', 'Online Workshop'),
(5, 'Ponapati vyshnavi', 'vponapatibtech24@ced.alliance.edu.in', 'Alliance University', 'cse', 1769872497, '2026-02-12', 'Web', 'Online Workshop');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event_registration`
--
ALTER TABLE `event_registration`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event_registration`
--
ALTER TABLE `event_registration`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
