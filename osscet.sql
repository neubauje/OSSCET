-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 20, 2023 at 06:13 PM
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
  `course_name` varchar(100) NOT NULL,
  `summary` varchar(1000) DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `track_id` int(11) NOT NULL,
  `prerequesites` tinyint(1) DEFAULT NULL,
  `default_max_capacity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `summary`, `credits`, `track_id`, `prerequesites`, `default_max_capacity`) VALUES
('ACCT 200', 'Introduction to Financial Accounting', 'Concepts involved in accounting for assets, liabilities, and owners equity; financial statements.', 3, 16, NULL, 30),
('ACCT 210', 'Introduction to Managerial Accounting', 'Concepts involved in uses of accounting data in the managerial process.', 3, 16, NULL, 30),
('ACCT 250', 'Survey of Accounting', 'This course provides a basic introduction to both financial and managerial accounting topics. It concentrates on concepts and relationships involved in preparing and analyzing financial statements and some basic decision making for internal financial managers. This course is for non-BSBA students ONLY. This course will not meet the Eller College of Management requirements for professional admission.', 3, 16, NULL, 50),
('ACCT 310', 'Cost and Managerial Accounting', 'Concepts and analytical procedures necessary in the generation of accounting data for management planning control.', 3, 16, NULL, 30),
('COMP 100', 'Computer Science for Testing', 'I have not yet figured out why the capacity reset to 0, but perhaps this will fix the track capture.', 3, 3, NULL, 25),
('EXMP 101', 'Testing the Creation of Courses', 'This is my second attempt to create a course.', 1, 0, NULL, NULL),
('EXMP 103', 'Adding Capacities', 'Now I am adding the capacity and track, but still need to figure out how to accept escape characters such as an apostrophe.', 1, 0, NULL, NULL),
('EXMP 104', 'Once More, with Feeling!', 'I forgot to add the post variables. Trying again.', 2, 0, NULL, 50),
('HIST 207', 'Games and Play in Medieval and Early Modern Europe', 'Games provide entertainment and recreation, but they also reflect, influence, and supply metaphors for many other aspects of life. We will explore the importance of games in shaping medieval and early modern societies by focusing on four games that have come to symbolize the era - chess, jousting, hunting, and dice games. Through our examination of these and other games, we will explore the social, political, religious, economic, legal, military, and intellectual history of medieval and early modern Europe.', 3, 9, 0, NULL),
('OSCM 373', 'Basic Operations Management', 'This course is an introduction to the concepts, principles, problems, and practices of operations management. Operations Management is one of the key functional areas in any organization or company that deals with the production of goods and services. This course is concerned with the tasks, issues and decisions of those operations managers who have made the services and products on which we all depend. Emphasis is on managerial processes for effective operations in both goods-producing and service- rendering organization. Topics include operations strategy, process design, capacity planning, facilities location and design, forecasting, production scheduling, inventory control, quality assurance, and project management. The topics are integrated using a systems model of the operations of an organization. ', 3, 16, 0, NULL);

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
  `semester_name` varchar(50) NOT NULL,
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

--
-- Dumping data for table `offerings`
--

INSERT INTO `offerings` (`class_id`, `course_id`, `teacher_id`, `room_id`, `occupancy`, `vacancies`, `semester_name`, `start_time`, `end_time`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(1, 'ACCT 200', 'Kashiru', '76-232', 24, 24, 'Fall 2023', '10:00:00', '11:00:00', 1, 0, 1, 0, 1, 0, 0),
(2, 'ACCT 210', 'Kashiru', '56-104', 30, 30, 'Spring 2024', '12:00:00', '13:00:00', 0, 1, 1, 1, 0, 0, 0),
(3, 'ACCT 250', 'Kashiru', '113-204', 50, 50, 'Winter 2023', '09:00:00', '10:00:00', 0, 0, 1, 1, 1, 0, 0);

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
  `building_name` varchar(200) DEFAULT NULL,
  `capacity` int(11) NOT NULL,
  `ada_accessible` tinyint(1) DEFAULT NULL,
  `building_address` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `building_name`, `capacity`, `ada_accessible`, `building_address`) VALUES
('103-108', '0108 Lecture Hall', 'John P. Schaefer Center For Creative Photogragraphy', 224, 1, '1030 N Olive Rd'),
('11-1M', '0001M Class Laboratory', 'John W. Harshbarger Building', 16, 0, '1133 E James E. Rogers Way'),
('11-1N', '0001N Class Laboratory', 'John W. Harshbarger Building', 6, 0, '1133 E James E. Rogers Way'),
('11-206', '0206 Classroom', 'John W. Harshbarger Building', 50, 1, '1133 E James E. Rogers Way'),
('113-204', '0204 Lecture Hall', 'Henry Koffler Building', 300, 1, '1340 E University Blvd'),
('113-209', '0209 Classroom', 'Henry Koffler Building', 36, 1, '1340 E University Blvd'),
('4-146', '0146 Classroom', 'Fred Fox School of Music', 142, 1, '1017 N Olive Rd'),
('56-104', '0104 Classroom', 'Bear Down Building', 999, 0, '1428 E University Blvd'),
('73-319', '0319 Computer Instructional', 'Computer Center', 28, 1, '1077 N Highland Ave'),
('76-232', '0232 Seminar', 'Richard A. Harvill Building', 24, 1, '1103 E 2 St'),
('78-415', '0415 Class Laboratory', 'McClelland Park', 22, 1, '650 N Park Ave'),
('81-201', '0201 Lecture Hall', 'Physics-Atmospheric Sciences', 379, 1, '1118 E 4 St'),
('88-301', '0301 Collaborative Classroom', 'Biological Sciences West', 112, 0, '1041 E Lowell St'),
('94-408', '0408 Lecture Hall', 'Meinel Optical Sciences', 77, 0, '1630 E University Blvd');

-- --------------------------------------------------------

--
-- Table structure for table `semesters`
--

CREATE TABLE `semesters` (
  `semester_name` varchar(50) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `semesters`
--

INSERT INTO `semesters` (`semester_name`, `start_date`, `end_date`) VALUES
('Fall 2023', '2023-08-21', '2023-12-15'),
('Fall 2024', '2024-08-26', '2024-12-20'),
('Spring 2024', '2024-01-10', '2024-05-10'),
('Summer 2024', '2024-05-13', '2024-08-07'),
('Winter 2023', '2023-12-18', '2024-01-10');

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
(8, 'movesLikeJagger', 'MickeyMouse', 2, 'mj@uagc.edu', '(111)222-3333', 'Mick', 'Jagger', '1943-07-26', '111-22-3333', 123456789, 102030405, '2023-08-14', NULL, 'Abbey Road. Look it up.', NULL),
(1, 'neubauje', 'password', 1, 'neubauje@gmail.com', '740-407-8022', 'Jesse', 'Neubauer', '1990-06-29', '111-22-3333', 123456789, 102030405, '2023-08-13', NULL, '123 Main St, UAGC, AZ, 12345', NULL);

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
(0, 'None'),
(1, 'Elective'),
(2, 'Social & Behavioral Science'),
(3, 'Engineering & Technology'),
(4, 'Law, Policy & Social Justice'),
(5, 'Music'),
(6, 'Culture & Language'),
(7, 'Biological & Biomedical Science'),
(8, 'Mathematics, Statistic & Data Science'),
(9, 'History'),
(10, 'English & Literature'),
(11, 'Education & Human Development'),
(12, 'Arts & Media'),
(13, 'Agricultural Science'),
(14, 'Animal & Veterinary Science'),
(15, 'Architecture, Planning, & Development'),
(16, 'Business, Economics & Entrepreneurship'),
(17, 'Communication, Journalism, & Public Relations'),
(18, 'Health, Nutrition, & Fitness'),
(19, 'Environment & Sustainability'),
(20, 'Computer & Information Science'),
(21, 'Psychology & Human Behavior'),
(22, 'Physical & Space Sciences'),
(23, 'Philosophy & Religious Studies');

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
  `prefix` varchar(5) DEFAULT NULL,
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

INSERT INTO `teachers` (`user_id`, `teacher_id`, `password`, `role_id`, `email`, `phone`, `prefix`, `first_name`, `last_name`, `ssn`, `bank_account_number`, `bank_routing_number`, `hire_date`, `mailing_address`, `salary`, `bio_summary`) VALUES
(2, 'autumnhound', 'password1', 6, 'student@uagc.edu', '(111)222-3333', 'Ms.', 'Heather', 'Powers', '111-22-3333', 123456789, 102030405, '2023-08-14', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(4, 'Trickster', 'Nope', 2, 'trixie@uagc.edu', '(111)222-3333', 'Mx.', 'Anna', 'Phinneagar', '111-22-3333', 123456789, 102030405, '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(5, 'Pandez', 'IFC2023', 5, 'pandez@uagc.edu', '(111)222-3333', 'Mr.', 'Paul', 'Crozier', '111-22-3334', 123456789, 102030405, '2023-08-14', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(6, 'Kashiru', 'Money', 4, 'Kashi@uagc.edu', '(111)222-3333', 'Mr.', 'Steven', 'Monteith', '111-22-3333', 123456789, 102030405, '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'Kashi is a very busy guy. He is not a cereal.'),
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
-- Indexes for table `semesters`
--
ALTER TABLE `semesters`
  ADD PRIMARY KEY (`semester_name`),
  ADD UNIQUE KEY `semester_name` (`semester_name`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `subject_tracks`
--
ALTER TABLE `subject_tracks`
  ADD PRIMARY KEY (`track_id`),
  ADD UNIQUE KEY `track_id` (`track_id`);

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
  MODIFY `class_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `subject_tracks`
--
ALTER TABLE `subject_tracks`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
