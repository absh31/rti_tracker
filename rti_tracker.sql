-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2023 at 10:04 AM
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
-- Database: `rti_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblaadhar`
--

CREATE TABLE `tblaadhar` (
  `id` int(11) NOT NULL,
  `aadhar_number` varchar(16) NOT NULL,
  `aadhar_name` varchar(128) NOT NULL,
  `aadhar_gender` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblaadhar`
--

INSERT INTO `tblaadhar` (`id`, `aadhar_number`, `aadhar_name`, `aadhar_gender`) VALUES
(1, '123456123456', 'Abhi Shah', 'MALE'),
(2, '123456789012', 'Bhavika Balasra', 'FEMALE'),
(3, '123123123123', 'Mihir Someshwara', 'MALE'),
(4, '121212121212', 'Dharmit Shah', 'MALE'),
(5, '456456456456', 'Vaishnavi Barot', 'FEMALE'),
(6, '789789789789', 'Diti Soni', 'FEMALE');

-- --------------------------------------------------------

--
-- Table structure for table `tblactivity`
--

CREATE TABLE `tblactivity` (
  `activity_id` int(11) NOT NULL,
  `activity_request_id` int(11) NOT NULL,
  `activity_request_no` varchar(256) NOT NULL,
  `activity_is_appealed` varchar(256) NOT NULL DEFAULT '0',
  `activity_from` varchar(256) NOT NULL,
  `activity_to` varchar(256) NOT NULL,
  `activity_type` varchar(256) NOT NULL,
  `activity_remarks` text NOT NULL,
  `activity_completed` tinyint(1) NOT NULL DEFAULT 0,
  `activity_status` varchar(256) NOT NULL,
  `activity_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `activity_documents` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblactivity`
--

INSERT INTO `tblactivity` (`activity_id`, `activity_request_id`, `activity_request_no`, `activity_is_appealed`, `activity_from`, `activity_to`, `activity_type`, `activity_remarks`, `activity_completed`, `activity_status`, `activity_time`, `activity_documents`) VALUES
(31, 0, '20230205125750', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-05 12:01:50', ''),
(32, 0, '20230205125750', '0', 'nodal', '10', 'Forwarded', 'get data fast', 1, 'Forwarded to Departmental Officer Abhi Shah', '2023-02-05 12:08:09', ''),
(33, 0, '20230205125750', '0', 'Abhi Shah', 'Nodal Officer', 'Revert', 'first data done', 1, 'Reverted back to the Nodal Officer.', '2023-02-05 12:10:08', '15'),
(34, 0, '20230205125750', '0', 'Nodal Officer', 'Applicant', 'Closed', 'first closed', 1, 'Application closed successfully', '2023-02-05 12:11:23', NULL),
(35, 0, '20230205125750', '1', 'Appellate Officer', 'Nodal Officer', 'Appeal Forward', 'appealed rti', 1, 'Reverted back to the Nodal Officer for appeal.', '2023-02-05 12:38:24', NULL),
(36, 0, '20230205125750', '0', 'nodal', '10', 'Forwarded', '', 1, 'Forwarded to Departmental Officer Abhi Shah', '2023-02-05 12:50:34', ''),
(37, 0, '20230205125750', '0', 'Abhi Shah', 'Nodal Officer', 'Revert', 'done again', 1, 'Reverted back to the Nodal Officer.', '2023-02-05 12:51:08', '16'),
(38, 0, '20230205125750', '0', 'Nodal Officer', 'Applicant', 'Closed', 'CLOSe again', 0, 'Application closed successfully', '2023-02-05 12:51:08', NULL),
(39, 0, '20230207052436', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-07 16:32:13', ''),
(40, 0, '20230207052436', '0', 'nodal', '6', 'Forwarded', 'get data fast', 1, 'Forwarded to Departmental Officer Dharmit Shah', '2023-02-10 04:13:45', ''),
(41, 0, '20230209060359', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-09 17:11:30', ''),
(42, 0, '20230209060359', '0', 'nodal', '11', 'Forwarded', '', 1, 'Forwarded to Departmental Officer Diti Soni', '2023-02-09 17:17:27', ''),
(43, 0, '20230209060359', '0', 'Diti Soni', 'Nodal Officer', 'Revert', 'data done', 1, 'Reverted back to the Nodal Officer.', '2023-02-09 17:20:00', '18,17'),
(44, 0, '20230209060359', '0', 'Nodal Officer', 'Applicant', 'Closed', 'CLOSE RTI', 1, 'Application closed successfully', '2023-02-11 04:41:01', NULL),
(45, 0, '20230209062356', '0', 'Nodal Officer', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-09 17:24:37', '19'),
(46, 0, '20230209062356', '0', 'nodal', '11', 'Forwarded', '', 0, 'Forwarded to Departmental Officer Diti Soni', '2023-02-09 17:24:37', ''),
(47, 0, '20230210040158', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-10 04:00:34', '20'),
(48, 0, '20230210040158', '0', 'nodal', '6', 'Forwarded', 'data of all schools', 1, 'Forwarded to Departmental Officer Dharmit Shah', '2023-02-10 04:11:42', '21'),
(49, 0, '20230210040158', '0', 'Dharmit Shah', 'Nodal Officer', 'Rejected', 'no data', 1, 'RTI Rejected and returned to Nodal Officer.', '2023-02-10 04:12:12', NULL),
(50, 0, '20230207052436', '0', 'Dharmit Shah', 'Nodal Officer', 'Revert', 'asfhjk', 1, 'Reverted back to the Nodal Officer.', '2023-02-10 04:24:50', '23'),
(51, 0, '20230207052436', '0', 'Nodal Officer', 'Applicant', 'Closed', 'sdfghjk', 0, 'Application closed successfully', '2023-02-10 04:24:50', NULL),
(52, 0, '20230209060359', '1', 'Appellate Officer', 'Nodal Officer', 'Appeal Forward', 'gbh', 1, 'Reverted back to the Nodal Officer for appeal.', '2023-02-11 04:41:01', NULL),
(53, 0, '20230210055912', '0', 'Nodal Officer', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-10 05:00:09', ''),
(54, 0, '20230210055912', '0', 'nodal', '4', 'Forwarded', '', 0, 'Forwarded to Departmental Officer Mihir Someshwara', '2023-02-10 05:00:09', '24'),
(55, 0, '20230210060140', '0', 'Nodal Officer', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-10 05:01:56', ''),
(56, 0, '20230210060140', '0', 'nodal', '4', 'Forwarded', 'fghj', 0, 'Forwarded to Departmental Officer Mihir Someshwara', '2023-02-10 05:01:56', ''),
(57, 0, '20230210061418', '0', 'Nodal Officer', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-10 05:15:25', ''),
(58, 0, '20230210095135', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 0, 'Application filed successfully', '2023-02-10 08:51:35', ''),
(59, 0, '20230210044827', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 0, 'Application filed successfully', '2023-02-10 15:48:27', ''),
(60, 0, '20230210045204', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 0, 'Application filed successfully', '2023-02-10 15:52:04', ''),
(61, 0, '20230210045353', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 0, 'Application filed successfully', '2023-02-10 15:53:53', ''),
(62, 0, '20230210064419', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 0, 'Application filed successfully', '2023-02-10 17:44:19', ''),
(63, 0, '20230210064632', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-11 08:57:56', ''),
(64, 0, '20230210065250', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-11 04:39:38', ''),
(65, 0, '20230211052818', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 0, 'Application filed successfully', '2023-02-11 04:28:18', ''),
(66, 0, '20230210065250', '0', 'nodal', '11', 'Forwarded', 'fghm', 1, 'Forwarded to Departmental Officer Diti Soni', '2023-02-11 04:47:18', ''),
(67, 0, '20230209060359', '0', 'Nodal Officer', 'Applicant', 'Rejected', 'done', 1, 'Application Rejected successfully', '2023-02-11 04:41:01', NULL),
(68, 0, '20230210065250', '0', 'Diti Soni', 'Nodal Officer', 'Revert', 'fvbngvbn', 0, 'Reverted back to the Nodal Officer.', '2023-02-11 04:47:18', '25'),
(69, 0, '20230211095001', '0', 'Applicant', 'Nodal Officer', 'Filed', '', 1, 'Application filed successfully', '2023-02-11 08:51:10', ''),
(70, 0, '20230211095001', '0', 'nodal', '7', 'Forwarded', 'abc', 1, 'Forwarded to Departmental Officer Diti Soni', '2023-02-11 08:52:30', ''),
(71, 0, '20230211095001', '0', 'Diti Soni', 'Nodal Officer', 'Revert', 'revert', 1, 'Reverted back to the Nodal Officer.', '2023-02-11 08:54:00', '26'),
(72, 0, '20230211095001', '0', 'Nodal Officer', 'Applicant', 'Closed', 'test', 0, 'Application closed successfully', '2023-02-11 08:54:00', NULL),
(73, 0, '20230210064632', '0', 'Nodal Officer', 'Applicant', 'Rejected', 'dfghjk', 1, 'Application Rejected successfully', '2023-02-11 08:57:56', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblappeal`
--

CREATE TABLE `tblappeal` (
  `appeal_id` int(11) NOT NULL,
  `appeal_request_no` varchar(256) NOT NULL,
  `appeal_reason` varchar(300) NOT NULL,
  `appeal_completed` varchar(256) NOT NULL DEFAULT '0',
  `appeal_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `appeal_remarks` text NOT NULL,
  `appeal_other` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblappeal`
--

INSERT INTO `tblappeal` (`appeal_id`, `appeal_request_no`, `appeal_reason`, `appeal_completed`, `appeal_time`, `appeal_remarks`, `appeal_other`) VALUES
(4, '20230205125750', 'PQR', '0', '2023-02-05 12:12:24', '', ''),
(5, '20230209060359', 'Other', '0', '2023-02-10 04:27:21', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblapplicant`
--

CREATE TABLE `tblapplicant` (
  `applicant_id` int(11) NOT NULL,
  `applicant_name` varchar(256) NOT NULL,
  `applicant_email` varchar(256) NOT NULL,
  `applicant_mobile` varchar(256) NOT NULL,
  `applicant_phone` varchar(256) NOT NULL,
  `applicant_gender` varchar(256) NOT NULL,
  `applicant_education` varchar(256) NOT NULL,
  `applicant_more_education` varchar(256) NOT NULL,
  `applicant_aadhar` varchar(32) DEFAULT NULL,
  `applicant_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `applicant_other` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblapplicant`
--

INSERT INTO `tblapplicant` (`applicant_id`, `applicant_name`, `applicant_email`, `applicant_mobile`, `applicant_phone`, `applicant_gender`, `applicant_education`, `applicant_more_education`, `applicant_aadhar`, `applicant_login`, `applicant_other`) VALUES
(5, 'Mihir', 'mihirsomeshwara0712@gmail.com', '9327191260', '', 'Male', 'Literate', 'Graduate', NULL, '2023-02-04 19:09:45', ''),
(6, 'Abhi Shah', 'abhishah3102@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', NULL, '2023-02-09 17:03:58', ''),
(7, 'Abhi Shah', 'abhishah3102@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', NULL, '2023-02-09 17:23:56', ''),
(8, 'Bhavika', 'bhavikabalasra12@gmail.com', '9876543210', '', 'Female', 'Literate', 'Graduate', NULL, '2023-02-10 03:01:58', ''),
(9, 'Abhi Shah', 'abhishah3102@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', NULL, '2023-02-10 04:59:11', ''),
(10, 'Abhi Shah', 'abhishah3102@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', NULL, '2023-02-10 05:01:40', ''),
(11, 'Abhi Shah', 'abhishah3102@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', NULL, '2023-02-10 05:14:18', ''),
(12, 'Abhi Shah', 'absh@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', NULL, '2023-02-10 15:52:04', ''),
(13, 'Abhi Shah', 'ab@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', '123456123456', '2023-02-10 15:53:53', ''),
(14, 'pqrst', 'pqrst@gmail.com', '9876543210', '', 'Male', 'Literate', 'Graduate', 'BcOdMEp2yczZ', '2023-02-10 17:44:18', ''),
(15, 'Abhi Shah', 'pqrs@gmail.com', '7041308465', '', 'Male', 'Literate', 'Graduate', 'AsaYM0l3zsncvhTe', '2023-02-10 17:52:50', ''),
(16, 'ABC', 'abc@gmail.com', '7878787878', '', 'Male', 'Literate', 'Graduate', 'AsaYM0l3zsncvhTe', '2023-02-11 08:50:01', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbldepartment`
--

CREATE TABLE `tbldepartment` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(256) NOT NULL,
  `department_email` varchar(256) NOT NULL,
  `department_other` text NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldepartment`
--

INSERT INTO `tbldepartment` (`department_id`, `department_name`, `department_email`, `department_other`, `is_active`) VALUES
(1, 'Education Department', 'abhishah3102@gmail.com', '', 1),
(2, 'Roads and Buildings Department', 'mihirsomeshwara0712@gmail.com', '', 1),
(3, 'Health Department', 'vaishnavibarot471@gmail.com', '', 1),
(4, 'Railways Department', 'dharmit.shah2001@gmail.com', '', 1),
(5, 'Department of Animal Husbandry, Dairying and Fisheries', 'soniditi0105@gmail.com', '', 1),
(6, 'Department of Consumer Affairs', 'bhavikabalasra@gmail.com', '', 1),
(7, 'Department of Defence', 'mihirsomeshwara0712@gmail.com', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbldocument`
--

CREATE TABLE `tbldocument` (
  `document_id` int(11) NOT NULL,
  `document_request_id` varchar(256) NOT NULL,
  `document_title` varchar(256) NOT NULL,
  `document_path` text NOT NULL,
  `document_type` varchar(256) NOT NULL,
  `document_remarks` text NOT NULL,
  `document_other` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldocument`
--

INSERT INTO `tbldocument` (`document_id`, `document_request_id`, `document_title`, `document_path`, `document_type`, `document_remarks`, `document_other`) VALUES
(15, '20230205125750', '07f5061b0773dd2114e51bb406c70fb0_attachment1.pdf', '../../uploads/07f5061b0773dd2114e51bb406c70fb0_attachment1.pdf', 'attachment', '', ''),
(16, '20230205125750', '07f5061b0773dd2114e51bb406c70fb0_attachment1.pdf', '../../uploads/07f5061b0773dd2114e51bb406c70fb0_attachment1.pdf', 'attachment', '', ''),
(17, '20230209060359', '60201dacb20bb2d41bad7d3a9227e5d9_attachment1.pdf', '../../uploads/60201dacb20bb2d41bad7d3a9227e5d9_attachment1.pdf', 'attachment', '', ''),
(18, '20230209060359', '60201dacb20bb2d41bad7d3a9227e5d9_attachment2.pdf', '../../uploads/60201dacb20bb2d41bad7d3a9227e5d9_attachment2.pdf', 'attachment', '', ''),
(19, '20230209062356', '1679091c5a880faf6fb5e6087eb1b2dc_attachment.pdf', '../bplFiles/1679091c5a880faf6fb5e6087eb1b2dc_attachment.pdf', 'sample doc', '', ''),
(20, '20230210040158', 'c9f0f895fb98ab9159f51fd0297e236d_bplCard.pdf', '../bplFiles/c9f0f895fb98ab9159f51fd0297e236d_bplCard.pdf', 'bplcard', '', ''),
(21, '20230210040158', 'e2424ff29cb8219774787d596ba6d8d6_attachment1.pdf', '../../uploads/e2424ff29cb8219774787d596ba6d8d6_attachment1.pdf', 'attachment', '', ''),
(22, '20230210040158', 'e2424ff29cb8219774787d596ba6d8d6_attachment1.pdf', '../../uploads/e2424ff29cb8219774787d596ba6d8d6_attachment1.pdf', 'attachment', '', ''),
(23, '20230207052436', '95a7a0b5be7d1b6f0c4b74cf3b5a416c_attachment1.pdf', '../../uploads/95a7a0b5be7d1b6f0c4b74cf3b5a416c_attachment1.pdf', 'attachment', '', ''),
(24, '20230210055912', 'e06515248006c084817c372b49025ee6_attachment1.pdf', '../../uploads/e06515248006c084817c372b49025ee6_attachment1.pdf', 'attachment', '', ''),
(25, '20230210065250', 'f4cbf4827de99f59982a1de66bde1e13_attachment1.pdf', '../../uploads/f4cbf4827de99f59982a1de66bde1e13_attachment1.pdf', 'attachment', '', ''),
(26, '20230211095001', 'ffb85903c7accb749967dbab23fd0300_attachment1.pdf', '../../uploads/ffb85903c7accb749967dbab23fd0300_attachment1.pdf', 'attachment', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblnotifications`
--

CREATE TABLE `tblnotifications` (
  `id` int(11) NOT NULL,
  `from` varchar(20) NOT NULL,
  `to` varchar(20) NOT NULL,
  `msg` varchar(256) NOT NULL,
  `request_no` varchar(256) NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `nodal_del` tinyint(1) NOT NULL DEFAULT 0,
  `officer_del` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblnotifications`
--

INSERT INTO `tblnotifications` (`id`, `from`, `to`, `msg`, `request_no`, `time`, `nodal_del`, `officer_del`) VALUES
(1, 'Nodal Officer', '6', 'jaldi karo\r\n', '20230207052436', '2023-02-07 18:14:21', 1, 1),
(2, 'Nodal Officer', '11', 'get data fast\r\n', '20230209060359', '2023-02-09 17:15:42', 0, 1),
(3, 'Nodal Officer', '6', 'good', '20230210040158', '2023-02-11 04:42:45', 1, 0),
(4, 'Nodal Officer', '11', 'sdfgvhb', '20230209062356', '2023-02-11 04:42:15', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblofficer`
--

CREATE TABLE `tblofficer` (
  `officer_id` int(11) NOT NULL,
  `officer_department_id` varchar(256) DEFAULT NULL,
  `officer_role_id` varchar(256) NOT NULL,
  `officer_username` varchar(256) NOT NULL,
  `officer_password` varchar(256) NOT NULL,
  `officer_name` varchar(256) NOT NULL,
  `officer_email` varchar(256) NOT NULL,
  `officer_mobile` varchar(256) NOT NULL,
  `officer_last_login` varchar(256) NOT NULL,
  `officer_last_ip` varchar(256) NOT NULL,
  `officer_other` text NOT NULL,
  `is_active` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblofficer`
--

INSERT INTO `tblofficer` (`officer_id`, `officer_department_id`, `officer_role_id`, `officer_username`, `officer_password`, `officer_name`, `officer_email`, `officer_mobile`, `officer_last_login`, `officer_last_ip`, `officer_other`, `is_active`) VALUES
(1, '', '1', 'admin', 'b18a8d2ac7e157f755aa632a60296506', 'admin', 'abhishah3102@gmail.com', '7041308465', '2023-02-11 10-01-00', '::1', '', 1),
(2, '', '2', 'appellate', 'b18a8d2ac7e157f755aa632a60296506', 'Appellate Officer', 'mihirsomeshwara0712@gmail.com', '7041308465', '2023-02-11 10-17-45', '::1', '', 1),
(3, '', '3', 'nodal', 'b18a8d2ac7e157f755aa632a60296506', 'nodal', 'mihirsomeshwara0712@gmail.com', '7041308465', '2023-02-11 14-27-33', '::1', '', 1),
(4, '1', '4', 'education', 'd0bb80aabb8619b6e35113f02e72752b', 'Mihir Someshwara', 'mihirsomeshwara0712@gmail.com', '7041308465', '2023-02-10 10-31-00', '::1', 'edit done', 1),
(5, '2', '4', 'roads', 'c8e66b33fa1e9e0a922075366ecde908', 'Vaishnavi Barot', 'asdf@asf.com', '1321321321', '2023-02-05 00-41-08', '::1', '', 1),
(6, '4', '4', 'rail', '70036b7bb753dee338a8a6baa67e2103', 'Dharmit Shah', 'dharmit.shah2001@gmail.com', '9327191260', '2023-02-11 14-17-58', '::1', '', 1),
(7, '5', '4', 'dahd', 'b18a8d2ac7e157f755aa632a60296506', 'Diti Soni', 'soniditi0105@gmail.com', '9327191260', '2023-02-11 14-22-01', '::1', '', 0),
(8, '6', '4', 'consumer', '1005b14bd29466723ace30d26f602f5b', 'Bhavika Balasra', 'bhavikabalasra12@gmail.com', '9327191260', '', '', '', 1),
(10, '7', '4', 'defence', '302109d01bd6ec86b692560b314d4658', 'Abhi Shah', 'mihirsomeshwara0712@gmail.com', '9327191260', '2023-02-05 17-32-08', '::1', '', 1),
(11, '3', '4', 'health', '555bf8344ca0caf09b42f55e185526d8', 'Diti Soni', 'soniditi0105@gmail.com', '8989899998', '2023-02-11 10-14-50', '::1', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tblrequest`
--

CREATE TABLE `tblrequest` (
  `request_id` int(11) NOT NULL,
  `request_applicant_id` int(11) NOT NULL,
  `request_department_id` int(11) NOT NULL,
  `request_no` varchar(256) NOT NULL,
  `request_from_bpl` varchar(256) NOT NULL,
  `request_bpl_no` varchar(256) NOT NULL,
  `request_bpl_yoi` varchar(256) NOT NULL,
  `request_bpl_ia` varchar(256) NOT NULL,
  `request_bpl_file` text NOT NULL,
  `request_address` text NOT NULL,
  `request_pincode` varchar(256) NOT NULL,
  `request_country` varchar(256) NOT NULL,
  `request_state` varchar(256) NOT NULL,
  `request_place_type` varchar(256) NOT NULL,
  `request_text` text NOT NULL,
  `request_mode` varchar(256) NOT NULL,
  `request_base_pay` varchar(256) NOT NULL,
  `request_is_base_pay` varchar(256) NOT NULL,
  `request_add_pay` varchar(256) NOT NULL DEFAULT '0',
  `request_is_add_pay` varchar(256) NOT NULL DEFAULT '0',
  `request_current_handler` varchar(256) NOT NULL,
  `request_is_appealed` varchar(256) NOT NULL,
  `request_status` varchar(256) NOT NULL,
  `request_completed` varchar(256) DEFAULT NULL,
  `request_last_update_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `request_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `request_summary` text NOT NULL,
  `request_other` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblrequest`
--

INSERT INTO `tblrequest` (`request_id`, `request_applicant_id`, `request_department_id`, `request_no`, `request_from_bpl`, `request_bpl_no`, `request_bpl_yoi`, `request_bpl_ia`, `request_bpl_file`, `request_address`, `request_pincode`, `request_country`, `request_state`, `request_place_type`, `request_text`, `request_mode`, `request_base_pay`, `request_is_base_pay`, `request_add_pay`, `request_is_add_pay`, `request_current_handler`, `request_is_appealed`, `request_status`, `request_completed`, `request_last_update_time`, `request_time`, `request_summary`, `request_other`) VALUES
(8, 5, 7, '20230205125750', 'No', 'NULL', 'NULL', 'NULL', 'NULL', '18 Maharaj Jagdish Park society part -2, Baherampura, Ahmedabad', '987987', 'India', 'Gujarat', 'Urban', 'New defence data', 'Online', '20', '1', '60', '1', 'none', '1', 'Application closed successfully', '1', '2023-01-05 11:57:50', '2023-02-05 11:57:50', '', ''),
(9, 5, 4, '20230207052436', 'No', 'NULL', 'NULL', 'NULL', 'NULL', '18 Maharaj Jagdish Park society part -2, Baherampura, Ahmedabad', '987987', 'India', 'Gujarat', 'Urban', 'Get all rail data', 'Online', '20', '1', '120', '0', 'none', '0', 'Application closed successfully', '1', '2023-01-07 16:24:36', '2023-02-07 16:24:36', '', ''),
(10, 6, 3, '20230209060359', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'Athdaafklj', '380013', 'India', 'Gujarat', 'Urban', 'DATA', 'Online', '20', '1', '0', '0', 'none', '1', 'Rejected', '1', '2023-02-09 17:03:59', '2023-02-09 17:03:59', '', ''),
(11, 6, 2, '20230209062356', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'HDfahgkj', '380013', 'India', 'Gujarat', 'Urban', 'asdfasdf', 'Online', '20', '1', '0', '0', '11', '0', 'Requested', '0', '2023-02-09 17:23:56', '2023-02-09 17:23:56', '', ''),
(12, 8, 1, '20230210040158', 'Yes', '1234567890', '2018', 'absh', '../bplFiles/c9f0f895fb98ab9159f51fd0297e236d_bplCard.pdf', 'h-123 Ahmedabad ', '380013', 'India', 'Gujarat', 'Urban', 'Data of illiterate people in gujarat', 'Online', '20', 'NA', '0', '0', 'Nodal Officer', '0', 'Requested', '0', '2023-02-10 03:01:58', '2023-02-10 03:01:58', '', ''),
(13, 6, 1, '20230210055912', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'abc', '380013', 'India', 'Gujarat', 'Urban', '', 'Online', '20', '1', '0', '0', '4', '0', 'Requested', '0', '2023-02-10 04:59:12', '2023-02-10 04:59:12', '', ''),
(14, 6, 1, '20230210060140', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'dfghjk', '380013', 'India', 'Gujarat', 'Urban', 'cjk', 'Online', '20', '1', '0', '0', '4', '0', 'Requested', '0', '2023-02-10 05:01:40', '2023-02-10 05:01:40', '', ''),
(15, 6, 6, '20230210061418', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'asdf', '380013', 'India', 'Gujarat', 'Urban', 'dfghjkl', 'Online', '20', '1', '0', '0', 'user', '0', 'Requested', '0', '2023-02-10 05:14:18', '2023-02-10 05:14:18', '', ''),
(16, 6, 3, '20230210095135', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'Athdaafklj', '380013', 'India', 'Gujarat', 'Urban', 'jhkjl', 'Online', '20', '1', '0', '0', 'user', '0', 'Requested', '0', '2023-02-10 08:51:35', '2023-02-10 08:51:35', '', ''),
(17, 6, 1, '20230210044827', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'Athdaafklj', '380013', 'India', 'Gujarat', 'Urban', 'dfghjkl', 'Online', '20', '1', '0', '0', 'user', '0', 'Requested', '0', '2023-02-10 15:48:27', '2023-02-10 15:48:27', '', ''),
(18, 12, 1, '20230210045204', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'werfg', '380013', 'India', 'Gujarat', 'Urban', 'cvhjk', 'Online', '20', '1', '0', '0', 'user', '0', 'Requested', '0', '2023-02-10 15:52:04', '2023-02-10 15:52:04', '', ''),
(19, 13, 3, '20230210045353', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'qwerty', '380013', 'India', 'Gujarat', 'Urban', 'asdfgh', 'Online', '20', '1', '0', '0', 'user', '0', 'Requested', '0', '2023-02-10 15:53:53', '2023-02-10 15:53:53', '', ''),
(20, 14, 4, '20230210064419', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'azxvb jhgdcsx', '876543', 'India', 'Goa', 'Urban', 'EGHJ, ', 'Online', '20', '1', '0', '0', 'user', '0', 'Requested', '0', '2023-02-10 17:44:19', '2023-02-10 17:44:19', '', ''),
(21, 14, 6, '20230210064632', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'azxvb jhgdcsx', '876543', 'India', 'Goa', 'Urban', 'XCDXVGVNM', 'Online', '20', '1', '0', '0', 'none', '0', 'Rejected', '1', '2023-02-10 17:46:32', '2023-02-10 17:46:32', '', ''),
(22, 15, 2, '20230210065250', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'SDFGHJ', '380013', 'India', 'Gujarat', 'Urban', 'CVBNM', 'Online', '20', '1', '120', '0', 'Nodal Officer', '0', 'Requested', '0', '2023-02-10 17:52:50', '2023-02-10 17:52:50', '', ''),
(23, 15, 2, '20230211052818', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'SDFGHJ', '380013', 'India', 'Gujarat', 'Urban', 'wqerty', 'Online', '20', '1', '0', '0', 'user', '0', 'Requested', '0', '2023-02-11 04:28:18', '2023-02-11 04:28:18', '', ''),
(24, 16, 1, '20230211095001', 'No', 'NULL', 'NULL', 'NULL', 'NULL', 'test', '380013', 'India', 'Kerala', 'Urban', 'test', 'Online', '20', '1', '10', '1', 'none', '0', 'Application closed successfully', '1', '2023-02-11 08:50:01', '2023-02-11 08:50:01', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblrole`
--

CREATE TABLE `tblrole` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(256) NOT NULL,
  `role_priority` int(11) NOT NULL,
  `role_department` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblrole`
--

INSERT INTO `tblrole` (`role_id`, `role_name`, `role_priority`, `role_department`, `is_active`) VALUES
(1, 'admin', 1, 0, 1),
(2, 'appellate', 2, 0, 1),
(3, 'nodal', 3, 0, 1),
(4, 'officer', 4, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbltransaction`
--

CREATE TABLE `tbltransaction` (
  `transaction_id` int(11) NOT NULL,
  `transaction_request_id` int(11) NOT NULL,
  `transaction_type` varchar(256) NOT NULL,
  `transaction_tracking_id` varchar(256) NOT NULL,
  `transaction_order_status` varchar(256) NOT NULL,
  `transaction_failure_message` text NOT NULL,
  `transaction_payment_mode` varchar(256) NOT NULL,
  `transaction_amount` varchar(256) NOT NULL,
  `transaction_applicant_id` int(11) NOT NULL,
  `transaction_ip` varchar(256) NOT NULL,
  `transaction_session` varchar(256) NOT NULL,
  `transaction_remarks_applicant` text NOT NULL,
  `transaction_remarks_admin` text NOT NULL,
  `transaction_start_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `transaction_end_time` varchar(256) NOT NULL,
  `transaction_status_time` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblaadhar`
--
ALTER TABLE `tblaadhar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblactivity`
--
ALTER TABLE `tblactivity`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `tblappeal`
--
ALTER TABLE `tblappeal`
  ADD PRIMARY KEY (`appeal_id`);

--
-- Indexes for table `tblapplicant`
--
ALTER TABLE `tblapplicant`
  ADD PRIMARY KEY (`applicant_id`);

--
-- Indexes for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `tbldocument`
--
ALTER TABLE `tbldocument`
  ADD PRIMARY KEY (`document_id`);

--
-- Indexes for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblofficer`
--
ALTER TABLE `tblofficer`
  ADD PRIMARY KEY (`officer_id`);

--
-- Indexes for table `tblrequest`
--
ALTER TABLE `tblrequest`
  ADD PRIMARY KEY (`request_id`);

--
-- Indexes for table `tblrole`
--
ALTER TABLE `tblrole`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbltransaction`
--
ALTER TABLE `tbltransaction`
  ADD PRIMARY KEY (`transaction_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblaadhar`
--
ALTER TABLE `tblaadhar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tblactivity`
--
ALTER TABLE `tblactivity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `tblappeal`
--
ALTER TABLE `tblappeal`
  MODIFY `appeal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblapplicant`
--
ALTER TABLE `tblapplicant`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbldocument`
--
ALTER TABLE `tbldocument`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblofficer`
--
ALTER TABLE `tblofficer`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblrequest`
--
ALTER TABLE `tblrequest`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tblrole`
--
ALTER TABLE `tblrole`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbltransaction`
--
ALTER TABLE `tbltransaction`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
