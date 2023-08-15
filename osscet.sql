-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 15, 2023 at 02:04 AM
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
-- Database: `osscet`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `course_id` varchar(10) NOT NULL,
  `title` varchar(45) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  `prerequesites` tinyint(1) DEFAULT NULL,
  `default_max_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `class_id` bigint(20) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` char(1) DEFAULT NULL,
  `grade` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offerings`
--

CREATE TABLE `offerings` (
  `class_id` bigint(20) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `teacher_id` varchar(20) NOT NULL,
  `room_id` varchar(10) NOT NULL,
  `occupancy` int(11) DEFAULT NULL,
  `vacancies` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `monday` tinyint(1) DEFAULT NULL,
  `tuesday` tinyint(1) DEFAULT NULL,
  `wednesday` tinyint(1) DEFAULT NULL,
  `thursday` tinyint(1) DEFAULT NULL,
  `friday` tinyint(1) DEFAULT NULL,
  `saturday` tinyint(1) DEFAULT NULL,
  `sunday` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Undergrad'),
(2, 'Graduate student'),
(3, 'Applicant'),
(4, 'Professor'),
(5, 'Instructor'),
(6, 'Aide'),
(7, 'Department head'),
(8, 'Advisor'),
(9, 'Administrator'),
(10, 'Technician');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` varchar(10) NOT NULL,
  `room_name` varchar(45) NOT NULL,
  `building_name` varchar(45) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `ada_accessible` tinyint(1) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `user_id` int(11) NOT NULL,
  `student_id` varchar(20) NOT NULL,
  `password` varchar(45) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `dob` date DEFAULT NULL,
  `ssn` varchar(20) DEFAULT NULL,
  `bank_account_number` int(11) DEFAULT NULL,
  `bank_routing_number` int(11) DEFAULT NULL,
  `admission_date` date NOT NULL DEFAULT current_timestamp(),
  `graduation_date` int(11) DEFAULT NULL,
  `mailing_address` varchar(500) DEFAULT NULL,
  `cumulative_gpa` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `student_id`, `password`, `role_id`, `email`, `phone`, `first_name`, `last_name`, `dob`, `ssn`, `bank_account_number`, `bank_routing_number`, `admission_date`, `graduation_date`, `mailing_address`, `cumulative_gpa`) VALUES
(8, 'movesLikeJagger', 'MickeyMouse', 2, 'mj@uagc.edu', '(111)222-3333', 'Mick', 'Jagger', '1943-07-26', '111-22-3333', 123456789, 102030405, '2023-08-14', NULL, '123 Main St, UAGC, AZ, 12345', NULL),
(1, 'neubauje', 'password', 1, 'neubauje@gmail.com', '(111)222-3333', 'Jesse', 'Neubauer', '1990-06-29', '111-22-3333', 123456789, 102030405, '2023-08-13', NULL, '123 Main St, UAGC, AZ, 12345', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_tracks`
--

CREATE TABLE `subject_tracks` (
  `track_id` int(11) NOT NULL,
  `track_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subject_tracks`
--

INSERT INTO `subject_tracks` (`track_id`, `track_name`) VALUES
(1, 'Elective'),
(2, 'Social science'),
(3, 'Physics'),
(4, 'Law'),
(5, 'Music'),
(6, 'Language'),
(7, 'Biology'),
(8, 'Math'),
(9, 'History'),
(10, 'Literature'),
(11, 'Education'),
(12, 'Art');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `user_id` int(11) NOT NULL,
  `teacher_id` varchar(20) NOT NULL,
  `password` varchar(45) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `title` varchar(5) DEFAULT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `ssn` varchar(20) DEFAULT NULL,
  `bank_account_number` int(11) DEFAULT NULL,
  `bank_routing_number` int(11) DEFAULT NULL,
  `hire_date` date NOT NULL DEFAULT current_timestamp(),
  `mailing_address` varchar(500) DEFAULT NULL,
  `salary` double DEFAULT NULL,
  `bio_summary` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`user_id`, `teacher_id`, `password`, `role_id`, `email`, `phone`, `title`, `first_name`, `last_name`, `ssn`, `bank_account_number`, `bank_routing_number`, `hire_date`, `mailing_address`, `salary`, `bio_summary`) VALUES
(2, 'autumnhound', 'password1', 6, 'student@uagc.edu', '(111)222-3333', 'Ms.', 'Heather', 'Powers', '111-22-3333', 123456789, 102030405, '2023-08-14', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(4, 'Trickster', 'Nope', 2, 'trixie@uagc.edu', '(111)222-3333', 'Mx.', 'Anna', 'Phinneagar', '111-22-3333', 123456789, 102030405, '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(5, 'Pandez', 'IFC2023', 5, 'pandez@uagc.edu', '(111)222-3333', 'Mr.', 'Paul', 'Crozier', '111-22-3334', 123456789, 102030405, '2023-08-14', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(6, 'Kashiru', 'Money', 4, 'Kashi@uagc.edu', '(111)222-3333', 'Mx.', 'Steven', 'Monteith', '111-22-3333', 123456789, 102030405, '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(7, 'testdummy', 'test123', 6, 'test@uagc.edu', '(111)222-3333', 'Mx.', 'Can', 'Do', '111-22-3333', 123456789, 102030405, '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 3,
  `first_name` varchar(20) DEFAULT NULL,
  `last_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `first_name`, `last_name`) VALUES
(1, 'neubauje', 'password', 1, 'Jesse', 'Neubauer'),
(2, 'autumnhound', 'password1', 6, 'Heather', 'Powers'),
(3, 'jewel', 'passwordsRdum', 3, 'Michael', 'Phinneagar'),
(4, 'Trickster', 'Nope', 2, 'Anna', 'Phinneagar'),
(5, 'Pandez', 'IFC2023', 5, 'Paul', 'Crozier'),
(6, 'Kashiru', 'Money', 4, 'Steven', 'Monteith'),
(7, 'testdummy', 'test123', 6, 'Can', 'Do'),
(8, 'movesLikeJagger', 'MickeyMouse', 2, 'Mick', 'Jagger');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_id`),
  ADD UNIQUE KEY `course_id` (`course_id`);

--
-- Indexes for table `enrollment`
--
ALTER TABLE `enrollment`
  ADD PRIMARY KEY (`class_id`,`student_id`),
  ADD UNIQUE KEY `class_id` (`class_id`,`student_id`);

--
-- Indexes for table `offerings`
--
ALTER TABLE `offerings`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject_tracks`
--
ALTER TABLE `subject_tracks`
  ADD PRIMARY KEY (`track_id`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`user_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `offerings`
--
ALTER TABLE `offerings`
  MODIFY `class_id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
