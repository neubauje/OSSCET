-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2023 at 08:58 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`course_id`, `course_name`, `summary`, `credits`, `track_id`, `prerequesites`, `default_max_capacity`) VALUES
('ACCT 200', 'Introduction to Financial Accounting', 'Concepts involved in accounting for assets, liabilities, and owners equity; financial statements.', 3, 16, NULL, 30),
('ACCT 210', 'Introduction to Managerial Accounting', 'Concepts involved in uses of accounting data in the managerial process.', 3, 16, NULL, 30),
('ACCT 250', 'Survey of Accounting', 'This course provides a basic introduction to both financial and managerial accounting topics. It concentrates on concepts and relationships involved in preparing and analyzing financial statements and some basic decision making for internal financial managers. This course is for non-BSBA students ONLY. This course will not meet the Eller College of Management requirements for professional admission.', 3, 16, NULL, 50),
('ACCT 310', 'Cost and Managerial Accounting', 'Concepts and analytical procedures necessary in the generation of accounting data for management planning control.', 3, 16, NULL, 30),
('CSC 345', 'Analysis of Discrete Structures', 'Introduction to and analysis of algorithms and characteristics of discrete structures. Course topics include algorithm analysis techniques, recurrence relations, structural induction, hierarchical structures, graphs, hashing, and sorting.', 4, 3, NULL, 20),
('ECE 175', 'Computer Programming for Engineering Applications', 'Fundamentals of C, complexity and efficiency analysis, numerical precision and representations, intro to data structures, structured program design, application to solving engineering problems.', 3, 3, NULL, 15),
('ECE 274A', 'Digital Logic', 'Number systems and coding, logic design, sequential systems, register transfer language.', 4, 3, NULL, 15),
('HIST 207', 'Games and Play in Medieval and Early Modern Europe', 'Games provide entertainment and recreation, but they also reflect, influence, and supply metaphors for many other aspects of life. We will explore the importance of games in shaping medieval and early modern societies by focusing on four games that have come to symbolize the era - chess, jousting, hunting, and dice games. Through our examination of these and other games, we will explore the social, political, religious, economic, legal, military, and intellectual history of medieval and early modern Europe.', 3, 9, 0, 40),
('LAR 440', 'Contemporary Landscape Architecture', 'This course examines 20th and 21st century prominent design figures that have shaped the profession of landscape architecture. Through case reviews of built works including significant gardens, urban designs, recreational areas, corporate landscapes, restored natural sites, heritage sites, waterfront projects, resorts, etc., we will explore the evolution of design ideology and theory in applied landscape architectural practice.', 3, 15, NULL, 40),
('MATH 243', 'Discrete Mathematics in Computer Science', 'Graphs and networks; set theory, logic, discrete structures; induction and recursion;\r\ntechniques of proof. Course calendar on class website.', 3, 8, NULL, 40),
('OSCM 373', 'Basic Operations Management', 'This course is an introduction to the concepts, principles, problems, and practices of operations management. Operations Management is one of the key functional areas in any organization or company that deals with the production of goods and services. This course is concerned with the tasks, issues and decisions of those operations managers who have made the services and products on which we all depend. Emphasis is on managerial processes for effective operations in both goods-producing and service- rendering organization. Topics include operations strategy, process design, capacity planning, facilities location and design, forecasting, production scheduling, inventory control, quality assurance, and project management. The topics are integrated using a systems model of the operations of an organization. ', 3, 16, 0, 30),
('SFWE 101', ' Introduction to Software Engineering', 'This course introduces students to the different software development lifecycle (SDLC) phases used in\r\ndeveloping, delivering, and maintaining software products. Students will also acquire basic software\r\ndevelopment skills and understand common terminology used in the software engineering profession.\r\nStudents will also learn and practice using traditional coding standards/guidelines. Python software\r\ndevelopment libraries and debugging tools will be explored and used in projects to familiarize students SFWE 101 2\r\nwith basic tasks involved in modifying, building, and testing software. The course will also lay the\r\nfoundation for achieving academic and career success in Software Engineering.', 3, 3, NULL, 20),
('SIE 277', 'Object-Oriented Modeling and Design', 'Modeling and design of complex systems using all views of the Unified Modeling Language (UML).\r\nMost effort will be in the problem domain (defining the problem). Some effort will be in the\r\nsolution domain (designing and/or producing hardware or software).', 3, 3, NULL, 20),
('UNIV 301', 'General Education Portfolio', 'UNIV 301 gives you the opportunity to reflect and make meaning of your general education experience while creating your ePortfolio.', 1, 1, NULL, 300);

-- --------------------------------------------------------

--
-- Table structure for table `enrollment`
--

CREATE TABLE `enrollment` (
  `class_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `enrollment_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `enrollment_status` char(1) DEFAULT NULL,
  `grade` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `enrollment`
--

INSERT INTO `enrollment` (`class_id`, `user_id`, `enrollment_date`, `enrollment_status`, `grade`) VALUES
(1, 1, '2023-08-24 20:11:20', 'a', NULL),
(1, 7, '2023-08-24 20:11:38', 'w', NULL),
(1, 8, '2023-08-24 20:10:33', 'w', NULL),
(1, 17, '2023-08-25 20:45:40', 'w', NULL),
(2, 7, '2023-08-24 20:11:44', 'w', NULL),
(3, 1, '2023-08-24 20:11:26', 'a', NULL),
(3, 7, '2023-08-24 20:11:50', 'w', NULL),
(6, 1, '2023-08-24 22:52:29', 'w', NULL),
(6, 10, '2023-08-24 20:12:48', 'a', NULL),
(6, 11, '2023-08-24 20:12:17', 'a', NULL),
(7, 8, '2023-08-24 20:10:44', 'a', NULL),
(11, 1, '2023-08-24 22:52:40', 'a', NULL),
(11, 8, '2023-08-25 19:11:31', 'a', NULL),
(11, 10, '2023-08-25 19:08:37', 'a', NULL),
(11, 11, '2023-08-25 19:09:35', 'a', NULL),
(11, 16, '2023-08-25 20:38:13', 'a', NULL),
(11, 17, '2023-08-25 21:15:23', 'a', NULL),
(11, 19, '2023-08-26 16:07:10', 'q', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `is_reply` tinyint(1) NOT NULL DEFAULT 0,
  `reply_to_id` int(11) DEFAULT NULL,
  `message_timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `message_status` char(1) NOT NULL DEFAULT 'u',
  `sender_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `message_subject` varchar(500) NOT NULL DEFAULT '(No subject)',
  `message_content` varchar(5000) NOT NULL DEFAULT 'This is a test message.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `offerings`
--

CREATE TABLE `offerings` (
  `class_id` bigint(20) NOT NULL,
  `course_id` varchar(10) NOT NULL,
  `teacher_user_id` bigint(20) NOT NULL,
  `room_id` varchar(10) NOT NULL,
  `occupancy` int(11) DEFAULT NULL,
  `vacancies` int(11) DEFAULT NULL,
  `semester_name` varchar(50) NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `monday` tinyint(1) DEFAULT NULL,
  `tuesday` tinyint(1) DEFAULT NULL,
  `wednesday` tinyint(1) DEFAULT NULL,
  `thursday` tinyint(1) DEFAULT NULL,
  `friday` tinyint(1) DEFAULT NULL,
  `saturday` tinyint(1) DEFAULT NULL,
  `sunday` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `offerings`
--

INSERT INTO `offerings` (`class_id`, `course_id`, `teacher_user_id`, `room_id`, `occupancy`, `vacancies`, `semester_name`, `start_time`, `end_time`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(1, 'ACCT 200', 6, '76-232', 24, 23, 'Fall 2023', '11:00:00', '12:00:00', 1, 0, 1, 0, 1, 0, 0),
(3, 'ACCT 250', 6, '113-204', 50, 49, 'Winter 2023', '09:00:00', '10:00:00', 0, 0, 1, 1, 1, 0, 0),
(5, 'SFWE 101', 4, '113-209', 20, 20, 'Fall 2023', '15:00:00', '16:30:00', 0, 1, 0, 1, 0, 0, 0),
(6, 'ECE 274A', 4, '11-1M', 12, 9, 'Winter 2023', '15:00:00', '17:00:00', 0, 0, 0, 0, 0, 1, 1),
(7, 'ACCT 250', 9, '76-232', 24, 23, 'Fall 2023', '09:00:00', '10:30:00', 0, 1, 0, 1, 0, 0, 0),
(8, 'ACCT 310', 9, '56-104', 30, 30, 'Winter 2023', '09:00:00', '10:00:00', 1, 0, 1, 0, 1, 0, 0),
(10, 'ACCT 310', 6, '73-319', 28, 28, 'Spring 2024', '14:00:00', '15:30:00', 0, 0, 1, 1, 0, 0, 0),
(11, 'ECE 274A', 4, '11-1N', 6, 0, 'Fall 2023', '13:00:00', '14:00:00', 1, 1, 1, 1, 0, 0, 0),
(12, 'UNIV 301', 15, '000', 300, 300, 'Fall 2023', '00:00:00', '00:00:00', 1, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `building_name`, `capacity`, `ada_accessible`, `building_address`) VALUES
('000', 'Remote', 'Online (no physical location)', 999, 1, 'uagc.edu'),
('103-108', '0108 Lecture Hall', 'John P. Schaefer Center For Creative Photogragraphy', 224, 1, '1030 N Olive Rd'),
('11-1M', '0001M Class Laboratory', 'John W. Harshbarger Building', 12, 0, '1133 E James E. Rogers Way'),
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `role_id` int(11) NOT NULL,
  `email` varchar(45) NOT NULL DEFAULT 'student@uagc.edu',
  `phone` text NOT NULL DEFAULT '(111)222-3333',
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `dob` date NOT NULL DEFAULT '2001-01-01',
  `ssn` varchar(20) NOT NULL DEFAULT '111-22-3333',
  `admission_date` date NOT NULL DEFAULT current_timestamp(),
  `graduation_date` int(11) DEFAULT NULL,
  `mailing_address` varchar(500) NOT NULL DEFAULT '123 Main St, UAGC, AZ, 12345',
  `cumulative_gpa` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`user_id`, `student_id`, `password`, `role_id`, `email`, `phone`, `first_name`, `last_name`, `dob`, `ssn`, `admission_date`, `graduation_date`, `mailing_address`, `cumulative_gpa`) VALUES
(17, 'Falanx', '12345', 1, 'student@uagc.edu', '(111)222-3333', 'No', 'Thanks', '2001-01-01', '111-22-3333', '2023-08-25', NULL, '123 Main St, UAGC, AZ, 12345', NULL),
(19, 'HatterBear', 'Operations', 1, 'hatter@uagc.edu', '(111)222-3333', 'Alex', 'Hutt', '2001-01-01', '111-22-3333', '2023-08-26', NULL, '123 Main St, UAGC, AZ, 12345', NULL),
(16, 'Jakebunny', '#fastestbun', 1, 'student@uagc.edu', '(111)222-3333', 'Jake', 'Rupert', '2001-01-01', '111-22-3333', '2023-08-25', NULL, '123 Main St, UAGC, AZ, 12345', NULL),
(11, 'mewbauje', 'testing', 1, 'mewb@uagc.edu', '(111)222-3333', 'Jesse', 'Neub', '0000-00-00', '111-22-3333', '2023-08-24', NULL, '123 Main St, UAGC, AZ, 12345', NULL),
(8, 'movesLikeJagger', 'MickeyMouse', 2, 'mj@uagc.edu', '(111)222-3333', 'Mick', 'Jagger', '1943-07-26', '111-22-3333', '2023-08-14', NULL, 'Abbey Road. Look it up.', NULL),
(1, 'neubauje', 'password', 1, 'neubauje@gmail.com', '740-407-8022', 'Jesse', 'Neubauer', '1990-06-29', '111-22-3333', '2023-08-13', NULL, '123 Main St, UAGC, AZ, 12345', NULL),
(10, 'uniqueNY', 'IloveNewYork', 1, 'NewYork@uagc.edu', '(111)222-3333', 'Unique', 'New York', '0000-00-00', '111-22-3333', '2023-08-24', NULL, '123 Main St, UAGC, AZ, 12345', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `subject_tracks`
--

CREATE TABLE `subject_tracks` (
  `track_id` int(11) NOT NULL,
  `track_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `email` varchar(45) DEFAULT 'teacher@uagc.edu',
  `phone` varchar(45) DEFAULT '(111)222-3333',
  `prefix` varchar(5) DEFAULT 'Mx.',
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `ssn` varchar(20) DEFAULT '111-22-3333',
  `hire_date` date NOT NULL DEFAULT current_timestamp(),
  `mailing_address` varchar(500) DEFAULT '1401 University of AZ, Tucson, AZ, 85719',
  `salary` double DEFAULT NULL,
  `bio_summary` varchar(1000) DEFAULT 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`user_id`, `teacher_id`, `password`, `role_id`, `email`, `phone`, `prefix`, `first_name`, `last_name`, `ssn`, `hire_date`, `mailing_address`, `salary`, `bio_summary`) VALUES
(2, 'autumnhound', 'password1', 6, 'student@uagc.edu', '(111)222-3333', 'Ms.', 'Heather', 'Powers', '111-22-3333', '2023-08-14', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(4, 'Trickster', 'Nope', 4, 'trixie@uagc.edu', '(111)222-3333', 'Dr.', 'Anna', 'Phinneagar', '111-22-3333', '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(6, 'Kashiru', 'Money', 4, 'Kashi@uagc.edu', '(111)222-3333', 'Mr.', 'Steven', 'Monteith', '111-22-3333', '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'Kashi is a very busy guy. He is not a cereal.'),
(7, 'testdummy', 'test123', 6, 'test@uagc.edu', '(111)222-3333', 'Mx.', 'Can', 'Do', '111-22-3333', '2023-08-13', '1401 University of AZ  Tucson, AZ  85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.'),
(9, 'BestBetsy', 'HowardHanna', 5, 'betsy@uagc.edu', '(111)222-3333', 'Mrs.', 'Betsy', 'McCloskey', '111-22-3333', '2023-08-20', '1401 University of AZ  Tucson, AZ  85719', NULL, 'Realtor by day, college teacher by night.'),
(15, 'SnapBat', 'bat', 4, 'teacher@uagc.edu', '(111)222-3333', 'Mr.', 'Snap', 'Bat', '111-22-3333', '2023-08-25', '1401 University of AZTucson, AZ85719', NULL, 'Snap is a bat who apparently teaches college courses. He&#039;s not aware of this fact.'),
(18, 'pmtestuser', 'thepassword', 5, 'test@test.com', '(111)222-3333', 'Mx.', 'P', 'M', '111-22-3333', '2023-08-25', '1401 University of AZ, Tucson, AZ, 85719', NULL, 'This is a placeholder for where your biography/summary should go. It will be shown to students, describing you. Please put it in 3rd person and make sure to include your pronouns.');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role_id`, `first_name`, `last_name`) VALUES
(0, 'system', 'none', 9, 'Automated', 'System'),
(1, 'neubauje', 'password', 1, 'Jesse', 'Neubauer'),
(2, 'autumnhound', 'password1', 6, 'Heather', 'Powers'),
(3, 'jewel', 'passwordsRdum', 3, 'Michael', 'Phinneagar'),
(4, 'Trickster', 'Nope', 4, 'Anna', 'Phinneagar'),
(6, 'Kashiru', 'Money', 4, 'Steven', 'Monteith'),
(7, 'testdummy', 'test123', 6, 'Can', 'Do'),
(8, 'movesLikeJagger', 'MickeyMouse', 2, 'Mick', 'Jagger'),
(9, 'BestBetsy', 'HowardHanna', 5, 'Betsy', 'McCloskey'),
(10, 'uniqueNY', 'IloveNewYork', 1, 'Unique', 'New York'),
(11, 'mewbauje', 'testing', 1, 'Jesse', 'Neub'),
(15, 'SnapBat', 'bat', 4, 'Snap', 'Bat'),
(16, 'Jakebunny', '#fastestbun', 1, 'Jake', 'Rupert'),
(17, 'Falanx', '12345', 1, 'No', 'Thanks'),
(18, 'pmtestuser', 'thepassword', 5, 'P', 'M'),
(19, 'HatterBear', 'Operations', 1, 'Alex', 'Hutt');

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
  ADD PRIMARY KEY (`class_id`,`user_id`),
  ADD UNIQUE KEY `class_id` (`class_id`,`user_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offerings`
--
ALTER TABLE `offerings`
  MODIFY `class_id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `subject_tracks`
--
ALTER TABLE `subject_tracks`
  MODIFY `track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
