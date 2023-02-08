-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 08, 2023 at 06:25 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

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
(40, 0, '20230207052436', '0', 'nodal', '6', 'Forwarded', 'get data fast', 0, 'Forwarded to Departmental Officer Dharmit Shah', '2023-02-07 16:32:13', '');

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
(4, '20230205125750', 'PQR', '0', '2023-02-05 12:12:24', '', '');

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
  `applicant_login` timestamp NOT NULL DEFAULT current_timestamp(),
  `applicant_other` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblapplicant`
--

INSERT INTO `tblapplicant` (`applicant_id`, `applicant_name`, `applicant_email`, `applicant_mobile`, `applicant_phone`, `applicant_gender`, `applicant_education`, `applicant_more_education`, `applicant_login`, `applicant_other`) VALUES
(5, 'Mihir', 'mihirsomeshwara0712@gmail.com', '9327191260', '', 'Male', 'Literate', 'Graduate', '2023-02-04 19:09:45', '');

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
(16, '20230205125750', '07f5061b0773dd2114e51bb406c70fb0_attachment1.pdf', '../../uploads/07f5061b0773dd2114e51bb406c70fb0_attachment1.pdf', 'attachment', '', '');

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
(1, 'Nodal Officer', '6', 'jaldi karo\r\n', '20230207052436', '2023-02-07 18:14:21', 1, 1);

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
(1, '', '1', 'admin', 'b18a8d2ac7e157f755aa632a60296506', 'admin', 'abhishah3102@gmail.com', '7041308465', '2023-01-31 22-57-37', '::1', '', 1),
(2, '', '2', 'appellate', 'b18a8d2ac7e157f755aa632a60296506', 'Appellate Officer', 'mihirsomeshwara0712@gmail.com', '7041308465', '2023-02-05 17-44-05', '::1', '', 1),
(3, '', '3', 'nodal', 'b18a8d2ac7e157f755aa632a60296506', 'nodal', 'mihirsomeshwara0712@gmail.com', '7041308465', '2023-02-07 20-50-59', '::1', '', 1),
(4, '1', '4', 'education', 'd0bb80aabb8619b6e35113f02e72752b', 'Mihir Someshwara', 'mihirsomeshwara0712@gmail.com', '7041308465', '2023-02-05 00-26-39', '::1', 'edit done', 1),
(5, '2', '4', 'roads', 'c8e66b33fa1e9e0a922075366ecde908', 'Vaishnavi Barot', 'asdf@asf.com', '1321321321', '2023-02-05 00-41-08', '::1', '', 1),
(6, '4', '4', 'rail', '70036b7bb753dee338a8a6baa67e2103', 'Dharmit Shah', 'dharmit.shah2001@gmail.com', '9327191260', '2023-02-07 21-59-47', '::1', '', 1),
(7, '5', '4', 'dahd', 'dahd', 'Diti Soni', 'soniditi0105@gmail.com', '9327191260', '2022-12-09 00-28-35', '::1', '', 0),
(8, '6', '4', 'consumer', '1005b14bd29466723ace30d26f602f5b', 'Bhavika Balasra', 'bhavikabalasra12@gmail.com', '9327191260', '', '', '', 1),
(10, '7', '4', 'defence', '302109d01bd6ec86b692560b314d4658', 'Abhi Shah', 'mihirsomeshwara0712@gmail.com', '9327191260', '2023-02-05 17-32-08', '::1', '', 1),
(11, '3', '4', 'health', '555bf8344ca0caf09b42f55e185526d8', 'Diti Soni', 'soniditi0105@gmail.com', '8989899998', '2023-01-31 22-56-55', '::1', '', 1);

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
(8, 5, 7, '20230205125750', 'No', 'NULL', 'NULL', 'NULL', 'NULL', '18 Maharaj Jagdish Park society part -2, Baherampura, Ahmedabad', '987987', 'India', 'Gujarat', 'Urban', 'New defence data', 'Online', '20', '1', '60', '1', 'none', '1', 'Application closed successfully', '1', '2023-02-05 11:57:50', '2023-02-05 11:57:50', '', ''),
(9, 5, 4, '20230207052436', 'No', 'NULL', 'NULL', 'NULL', 'NULL', '18 Maharaj Jagdish Park society part -2, Baherampura, Ahmedabad', '987987', 'India', 'Gujarat', 'Urban', 'Get all rail data', 'Online', '20', '1', '0', '0', '6', '0', 'Requested', '0', '2023-02-07 16:24:36', '2023-02-07 16:24:36', '', '');

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
-- AUTO_INCREMENT for table `tblactivity`
--
ALTER TABLE `tblactivity`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tblappeal`
--
ALTER TABLE `tblappeal`
  MODIFY `appeal_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblapplicant`
--
ALTER TABLE `tblapplicant`
  MODIFY `applicant_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbldepartment`
--
ALTER TABLE `tbldepartment`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbldocument`
--
ALTER TABLE `tbldocument`
  MODIFY `document_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tblnotifications`
--
ALTER TABLE `tblnotifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblofficer`
--
ALTER TABLE `tblofficer`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tblrequest`
--
ALTER TABLE `tblrequest`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
