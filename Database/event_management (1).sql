-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2024 at 05:36 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `event_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `collegereg`
--

CREATE TABLE `collegereg` (
  `id` int(10) NOT NULL,
  `collegename` varchar(60) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collegereg`
--

INSERT INTO `collegereg` (`id`, `collegename`, `password`, `email`) VALUES
(1, 'Everest Engineering College', 'everest123', 'example@gmail.com'),
(3, 'Cosmos Engineering College', 'cosmos123', 'cosmos@gmail.com'),
(6, 'Nepal Engineering College', 'nepal123', 'nepalcollege@gmail.com'),
(8, 'National College of Information Technology', 'ncit123', 'nationalcollege@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_events`
--

CREATE TABLE `enrolled_events` (
  `eventId` varchar(20) NOT NULL,
  `studentName` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrolled_events`
--

INSERT INTO `enrolled_events` (`eventId`, `studentName`) VALUES
('1', 'Mohan Bahadur Saud'),
('2', 'Mohan Bahadur Saud'),
('3', 'Mohan Bahadur Saud'),
('5', 'Mohan Bahadur Saud'),
('6', 'Mohan Bahadur Saud'),
('8', 'Mohan Bahadur Saud'),
('2', 'Sandip Chapain');

-- --------------------------------------------------------

--
-- Table structure for table `event_details`
--

CREATE TABLE `event_details` (
  `eventId` int(10) NOT NULL,
  `eventName` varchar(40) NOT NULL,
  `eventCategory` varchar(40) NOT NULL,
  `eventDetails` varchar(150) NOT NULL,
  `date` varchar(50) NOT NULL,
  `time` varchar(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `organizer` varchar(50) NOT NULL,
  `suborganizer` varchar(60) NOT NULL,
  `noOfparticipants` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_details`
--

INSERT INTO `event_details` (`eventId`, `eventName`, `eventCategory`, `eventDetails`, `date`, `time`, `location`, `organizer`, `suborganizer`, `noOfparticipants`) VALUES
(2, 'tech fest', 'Technical Events', 'coding competitjon', '2024-09-25', '08:44', 'Sanepa', 'Everest Engineering College', 'sandy', 2),
(4, 'just testing hai ta', 'Professional Development Events', 'yettikai test garna lai ho\r\n', '2024-09-30', '07:56', 'Sanepa', 'Everest Engineering College', 'koi xaina', 0),
(5, 'python bootcamp', 'Workshops', 'bring your own laptop and charger', '2024-09-25', '07:54', 'UN park', 'Everest Engineering College', 'abc company', 1),
(6, 'MERN bootcamp', 'Workshops', '3 days bootcamp for mern stack along with git and github', '2024-09-18', '07:20', 'putalisadak', 'National College of Information Technology', 'random company', 1),
(7, 'college meetup', 'Workshops', 'just meetup and chiya guff gaff', '2024-09-21', '09:34', 'Sankamul', 'Everest Engineering College', 'abc corporation', 0),
(8, 'college meetup', 'Cultural', 'dont come', '2024-09-24', '10:59', 'Sankamul', 'National College of Information Technology', 'abc corporation', 1);

-- --------------------------------------------------------

--
-- Table structure for table `studentreg`
--

CREATE TABLE `studentreg` (
  `id` int(10) NOT NULL,
  `name` varchar(40) NOT NULL,
  `password` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `registration_id` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `studentreg`
--

INSERT INTO `studentreg` (`id`, `name`, `password`, `email`, `registration_id`) VALUES
(8, 'Mohan Bahadur Saud', 'mohan123', 'mohan@gmail.com', '2021-1-12-0111'),
(11, 'Pritam Shrestha', 'pritam123', 'pritamshrestha@gmail.com', '2021-1-12-0130'),
(12, 'Sandip Chapain', 'sandip123', 'sandipchapain@gmail.com', '2021-1-12-0137'),
(13, 'Sandesh Dani', 'sandesh123', 'dannydalle@gmail.com', '2021-1-12-0135');

-- --------------------------------------------------------

--
-- Table structure for table `uniorg`
--

CREATE TABLE `uniorg` (
  `regid` varchar(20) NOT NULL,
  `collegename` varchar(60) NOT NULL,
  `passkey` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uniorg`
--

INSERT INTO `uniorg` (`regid`, `collegename`, `passkey`) VALUES
('2001-1-12', 'Everest Engineering College', 'everest123'),
('2005-1-20', 'National College of Information Technology', 'ncit123'),
('2008-04-23', 'Universal Engineering College', 'universal123'),
('2010-5-15', 'Nepal Engineering College', 'nec123'),
('2015-2-25', 'Cosmos Engineering College', 'cosmos123');

-- --------------------------------------------------------

--
-- Table structure for table `unistud`
--

CREATE TABLE `unistud` (
  `regid` varchar(40) NOT NULL,
  `student_name` varchar(50) NOT NULL,
  `college_name` varchar(50) NOT NULL,
  `passkey` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `unistud`
--

INSERT INTO `unistud` (`regid`, `student_name`, `college_name`, `passkey`) VALUES
('2020-3-11-0134', 'Sanskar Neupane', 'Everest Engineering College', 'sanskar123'),
('2021-1-12-0111', 'Mohan Bahadur Saud', 'Everest Engineering College', 'mohan123'),
('2021-1-12-0130', 'Pritam Shrestha', 'Nepal Engineering College', 'pritam123'),
('2021-1-12-0135', 'Sandesh Dani', 'Cosmos Engineering College', 'sandesh123'),
('2021-1-12-0137', 'Sandip Chapain', 'National College of Information Technology', 'sandip123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `collegereg`
--
ALTER TABLE `collegereg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event_details`
--
ALTER TABLE `event_details`
  ADD PRIMARY KEY (`eventId`);

--
-- Indexes for table `studentreg`
--
ALTER TABLE `studentreg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `uniorg`
--
ALTER TABLE `uniorg`
  ADD PRIMARY KEY (`regid`);

--
-- Indexes for table `unistud`
--
ALTER TABLE `unistud`
  ADD PRIMARY KEY (`regid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `collegereg`
--
ALTER TABLE `collegereg`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `event_details`
--
ALTER TABLE `event_details`
  MODIFY `eventId` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `studentreg`
--
ALTER TABLE `studentreg`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
