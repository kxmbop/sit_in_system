-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2024 at 03:25 AM
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
-- Database: `sit_in_monitoring`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `a_id` int(11) NOT NULL,
  `a_user` varchar(20) DEFAULT NULL,
  `a_pass` varchar(20) DEFAULT NULL,
  `a_name` varchar(50) DEFAULT NULL,
  `a_email` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `a_user`, `a_pass`, `a_name`, `a_email`) VALUES
(123456792, 'kimashi', 'kimashi', 'Kima shi', 'kima@shi.com');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `a_id` int(11) NOT NULL,
  `a_title` text NOT NULL,
  `a_message` text NOT NULL,
  `a_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`a_id`, `a_title`, `a_message`, `a_date`) VALUES
(2, 'No Classes', 'Academic break until May 31st 2024.', '2024-05-28 07:41:22'),
(3, 'Exciting News!', 'We are thrilled to announce our new product launch.', '2024-05-28 07:44:54'),
(4, 'Important Update', 'Please be informed of the upcoming maintenance schedule.', '2024-05-28 07:44:54'),
(5, 'Welcome New Students', 'We extend a warm welcome to all new students joining us this semester.', '2024-05-28 07:44:54'),
(6, 'Research Symposium', 'Join us for our annual research symposium next week.', '2024-05-28 07:44:54'),
(7, 'Holiday Closure', 'Please note that our offices will be closed for the holidays.', '2024-05-28 07:44:54');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `b_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL,
  `b_purpose` varchar(250) NOT NULL,
  `b_labroom` int(11) NOT NULL,
  `b_time_in` datetime DEFAULT NULL,
  `b_request_dt` datetime NOT NULL DEFAULT current_timestamp(),
  `b_ack_dt` datetime DEFAULT NULL,
  `b_status` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`b_id`, `s_id`, `b_purpose`, `b_labroom`, `b_time_in`, `b_request_dt`, `b_ack_dt`, `b_status`) VALUES
(1, 26, 'Python', 526, '2024-05-30 13:08:00', '2024-05-28 10:04:14', '2024-05-28 11:25:06', 'accepted'),
(2, 26, 'C++', 529, '2024-05-31 02:17:00', '2024-05-28 10:17:20', '2024-05-28 13:00:32', 'denied'),
(3, 26, 'C++', 542, '2024-05-31 16:34:00', '2024-05-28 11:28:45', NULL, NULL),
(4, 26, 'Python', 524, '2024-05-28 16:01:00', '2024-05-28 12:59:03', '2024-05-28 13:00:47', 'accepted');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `f_id` int(11) NOT NULL,
  `f_message` text NOT NULL,
  `r_id` int(11) NOT NULL,
  `s_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`f_id`, `f_message`, `r_id`, `s_id`) VALUES
(1, 'Good pc. not lag at all', 21, 26),
(7, 'asdfasdf', 39, 26);

-- --------------------------------------------------------

--
-- Table structure for table `records`
--

CREATE TABLE `records` (
  `r_id` int(11) NOT NULL,
  `s_idno` int(11) NOT NULL,
  `r_purpose` varchar(50) NOT NULL,
  `r_labroom` varchar(3) NOT NULL,
  `time_in` datetime NOT NULL DEFAULT current_timestamp(),
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `records`
--

INSERT INTO `records` (`r_id`, `s_idno`, `r_purpose`, `r_labroom`, `time_in`, `time_out`) VALUES
(21, 24232773, 'Python', '528', '2024-05-07 03:37:50', '2024-05-28 03:00:39'),
(22, 64976936, 'PHP', '524', '2024-05-07 03:37:54', '2024-05-07 03:41:17'),
(23, 95280809, 'C++', '526', '2024-05-07 03:37:58', NULL),
(24, 46695110, 'Ruby', '528', '2024-05-07 03:38:03', NULL),
(25, 59408970, 'C++', '528', '2024-05-07 03:38:07', '2024-05-07 03:40:21'),
(26, 95513303, 'Kotlin', '544', '2024-05-07 03:38:14', NULL),
(27, 19339607, 'Ruby', '528', '2024-05-07 03:38:18', '2024-05-07 03:40:08'),
(28, 73270095, 'PHP', '528', '2024-05-07 03:38:22', NULL),
(29, 27502210, 'Swift', '529', '2024-05-07 03:38:39', '2024-05-07 03:41:05'),
(30, 95513303, 'Python', '528', '2024-05-07 03:38:51', '2024-05-07 03:40:17'),
(31, 23384766, 'JavaScript', '544', '2024-05-07 03:38:55', NULL),
(32, 68608343, 'C#', '529', '2024-05-07 03:38:59', '2024-05-07 03:40:25'),
(34, 70158130, 'PHP', '544', '2024-05-07 03:39:09', NULL),
(35, 95513303, 'C#', '528', '2024-05-07 03:39:13', '2024-05-07 03:41:12'),
(36, 26466865, 'PHP', '542', '2024-05-07 03:39:51', NULL),
(37, 46279534, 'C#', '529', '2024-05-07 03:39:59', '2024-05-07 03:41:15'),
(38, 73495724, 'C++', '542', '2024-05-07 03:40:03', '2024-05-07 03:41:22'),
(39, 24232773, 'asda', 'asd', '2024-05-28 03:20:16', '2024-05-28 06:01:58'),
(40, 24232773, 'PHP', '123', '2024-05-28 03:20:38', NULL),
(41, 24232773, 'C#', '213', '2024-05-28 03:20:54', NULL),
(42, 24232773, 'PHP', 'asd', '2024-05-28 04:47:21', NULL),
(43, 24232773, 'C++', 'qwe', '2024-05-28 04:47:21', NULL),
(44, 24232773, 'PHP', '321', '2024-05-28 04:47:46', '2024-05-28 06:02:26'),
(45, 24232773, 'C++', '213', '2024-05-28 04:47:46', NULL),
(46, 24232773, 'JavaScript', '524', '2024-05-27 23:01:02', NULL),
(47, 24232773, 'Ruby', '528', '2024-05-27 23:01:18', NULL),
(48, 24232773, 'Swift', '544', '2024-05-27 23:03:56', NULL),
(49, 24232773, 'Java', '524', '2024-05-27 23:04:55', NULL),
(50, 24232773, 'Python', '526', '2024-05-30 13:08:00', NULL),
(51, 24232773, 'Python', '526', '2024-05-30 13:08:00', NULL),
(52, 24232773, 'JavaScript', '526', '2024-05-28 06:59:24', NULL),
(53, 24232773, 'Python', '524', '2024-05-28 16:01:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `s_id` int(11) NOT NULL,
  `s_idno` int(8) NOT NULL,
  `s_name` varchar(25) DEFAULT NULL,
  `s_course` varchar(250) DEFAULT NULL,
  `s_email` varchar(250) DEFAULT NULL,
  `s_age` int(11) DEFAULT NULL,
  `s_address` varchar(255) DEFAULT NULL,
  `s_gender` varchar(50) DEFAULT NULL,
  `s_pass` varchar(15) DEFAULT NULL,
  `session` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`s_id`, `s_idno`, `s_name`, `s_course`, `s_email`, `s_age`, `s_address`, `s_gender`, `s_pass`, `session`) VALUES
(26, 24232773, 'Kimberly Mae Alipin', 'BSIT', 'kimberlymaealipin@gmail.com', 21, 'Basak San Nicolas Cebu City', 'Female', 'kimashi', 27),
(27, 29535050, 'Jheny Lausa', 'BSIT', 'Jheny@lausa.com', 21, 'Basak San Nicolas Cebu City', 'Female', 'jiniper', 30),
(28, 64976936, 'Irene Luga', 'BSIT', 'irene@luga.com', 21, 'San Fernando Cebu', 'Female', 'irene', 29),
(29, 46279534, 'Trisha Mitch Bantecil', 'BSIT', 'trishamitch@bantecil.com', 21, 'C.Padilla Cebu City', 'Female', 'trisha', 29),
(30, 26466865, 'Mary Ann Niones', 'BSIT', 'maryann@niones.com', 21, 'C.Padilla Cebu City', 'Female', 'mary', 30),
(31, 73495724, 'Christine Grace Andiason', 'BSIT', 'christinegrace@andiason.com', 21, 'Inayawan Cebu City', 'Female', 'christine', 29),
(32, 98078030, 'Christan Jay Español', 'BSIT', 'christanjay@español.com', 21, 'Guadalupe Cebu City', 'Male', 'chrsitan', 30),
(33, 79902979, 'Rhodeney Dame Ponsica', 'BSIT', 'rhodneydame@ponsica.com', 21, 'Tres de Abril Cebu City', 'Male', 'rhodeney', 30),
(34, 95280809, 'Leo Osabel', 'BSIT', 'leo@osabel.com', 21, 'Buhisan Cebu City', 'Male', 'leo', 30),
(35, 46695110, 'Miles Campomanes', 'BSIT', 'miles@campomanes.com', 23, 'Urgello Cebu City', 'Male', 'miles', 30),
(36, 27633129, 'Jude Saagundo', 'BSIT', 'jude@saagundo.com', 21, 'taga asa ka jude?', 'Male', 'Jude', 30),
(37, 78080319, 'Niel Justin Paulin', 'BSIT', 'nieljustin@paulin.com', 21, 'ambot taga asa ni siya', 'Male', 'niel', 30),
(38, 27502210, 'Nicole Ann Dinuanao', 'BSIT', 'nicoleann@dinuanao.com', 21, 'Colon Cebu City', 'Female', 'nicole', 29),
(39, 73270095, 'Shyra Galon', 'BSIT', 'shyra@galon.com', 21, 'ambot dis.a ni', 'Female', 'Shyra', 30),
(40, 93843851, 'Melvin Sagnoy', 'BSIT', 'melvin@sagnoy.com', 21, 'Lahug Cebu City', 'Male', 'melvin', 30),
(41, 59408970, 'Roy Dumasig', 'BSIT', 'roy@dumasig.com', 29, 'Basak Ibabao Cebu', 'Male', 'roy', 29),
(42, 95513303, 'Allan Villegas', 'BSIT', 'allan@villegas.com', 22, 'Urgello Cebu City', 'Male', 'allan', 28),
(43, 19339607, 'Aldrich Batisla-on', 'BSIT', 'aldrich@batislaon.com', 21, 'idunnoooo', 'Male', 'aldrich', 29),
(44, 70158130, 'John Melvin Burila', 'BSIT', 'johnmelvin@burila.com', 23, 'Colon Cebu City', 'Male', 'john', 30),
(46, 23384766, 'Luigie Gido', 'BSIT', 'luigie@gido.com', 24, 'idunno', 'Male', 'luigie', 30),
(47, 68608343, 'Aaron Gregg Binghay', 'BSIT', 'aarongregg@binghay.com', 24, 'idunno', 'Male', 'aaron', 29);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`a_id`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`b_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `records`
--
ALTER TABLE `records`
  ADD PRIMARY KEY (`r_id`),
  ADD KEY `fk_student_id` (`s_idno`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`s_id`),
  ADD KEY `idx_s_idno` (`s_idno`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123456794;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `a_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `b_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `records`
--
ALTER TABLE `records`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `s_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `records`
--
ALTER TABLE `records`
  ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`s_idno`) REFERENCES `student` (`s_idno`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
