-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2021 at 08:23 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.3.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `icare`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbrangay`
--

CREATE TABLE `tblbrangay` (
  `id` int(11) NOT NULL,
  `barangay` text DEFAULT NULL,
  `city_municipality_id` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblbrangay`
--

INSERT INTO `tblbrangay` (`id`, `barangay`, `city_municipality_id`) VALUES
(1, 'BITANO', 'LEGAZPI CITY');

-- --------------------------------------------------------

--
-- Table structure for table `tblcity_municipality`
--

CREATE TABLE `tblcity_municipality` (
  `id` int(11) NOT NULL,
  `city_municipality` text DEFAULT NULL,
  `postal_code` varchar(10) DEFAULT NULL,
  `province_id` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblcity_municipality`
--

INSERT INTO `tblcity_municipality` (`id`, `city_municipality`, `postal_code`, `province_id`) VALUES
(1, 'LEGAZPI CITY', '4500', 'ALBAY');

-- --------------------------------------------------------

--
-- Table structure for table `tblclinic`
--

CREATE TABLE `tblclinic` (
  `id` int(11) NOT NULL,
  `clinic_id` varchar(25) DEFAULT NULL,
  `clinic_name` varchar(500) DEFAULT NULL,
  `contact_no` varchar(25) DEFAULT NULL,
  `email_address` varchar(50) DEFAULT NULL,
  `street` varchar(500) DEFAULT NULL,
  `barangay` varchar(500) DEFAULT NULL,
  `city_municipality` varchar(500) DEFAULT NULL,
  `province` varchar(500) DEFAULT NULL,
  `postal_code` varchar(25) DEFAULT NULL,
  `added_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblclinic`
--

INSERT INTO `tblclinic` (`id`, `clinic_id`, `clinic_name`, `contact_no`, `email_address`, `street`, `barangay`, `city_municipality`, `province`, `postal_code`, `added_by`) VALUES
(1, 'C101410001', 'sample', '09123456789', 'as@asd.com', '1', '2', '3', '4', '5', 'D101010001'),
(3, 'C101410002', 'qweqw', 'qeqwe', 'qweq', 'qwe', 'qweqw', 'eqwe', 'qwe', 'qewe', 'D101010001'),
(4, 'C101510003', 'cagsawa', '090909654789', 'cagsawa@mayon.org', 'food', 'barangay', 'city', 'albay', '4571', 'D101010001');

-- --------------------------------------------------------

--
-- Table structure for table `tbldoctors`
--

CREATE TABLE `tbldoctors` (
  `id` int(11) NOT NULL,
  `doc_id` varchar(25) DEFAULT NULL,
  `fullname` varchar(300) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `specialist_id` varchar(25) DEFAULT NULL,
  `photo_path` text NOT NULL,
  `street` varchar(500) DEFAULT NULL,
  `barangay` varchar(500) DEFAULT NULL,
  `city_municipality` varchar(500) DEFAULT NULL,
  `province` varchar(500) DEFAULT NULL,
  `postal_code` varchar(25) DEFAULT NULL,
  `contact_no` varchar(50) NOT NULL,
  `email_address` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldoctors`
--

INSERT INTO `tbldoctors` (`id`, `doc_id`, `fullname`, `fname`, `mname`, `lname`, `specialist_id`, `photo_path`, `street`, `barangay`, `city_municipality`, `province`, `postal_code`, `contact_no`, `email_address`) VALUES
(2, 'D101010001', '3, 1 2', '1', '2', '3', 'Sample Specialist', 'Screenshot (2).png', '4', '5', '6', '7', '8', '09987654321', 'doc@doc.com');

-- --------------------------------------------------------

--
-- Table structure for table `tbldoctors_schedule`
--

CREATE TABLE `tbldoctors_schedule` (
  `id` int(11) NOT NULL,
  `doctors_id` varchar(25) DEFAULT NULL,
  `schedule_date` date DEFAULT NULL,
  `schedule_from_time` time DEFAULT NULL,
  `schedule_to_time` time DEFAULT NULL,
  `patient_count` int(11) NOT NULL DEFAULT 0,
  `clinic_id` varchar(25) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldoctors_schedule`
--

INSERT INTO `tbldoctors_schedule` (`id`, `doctors_id`, `schedule_date`, `schedule_from_time`, `schedule_to_time`, `patient_count`, `clinic_id`, `status`) VALUES
(1, 'D101010001', '2021-10-15', '08:00:00', '17:05:00', 3, 'C101410001', 0),
(2, 'D101010001', '2021-10-15', '08:00:00', '18:05:00', 3, 'C101410001', 0),
(3, 'D101010001', '2021-10-14', '08:00:00', '18:05:00', 5, 'C101410002', 1),
(5, 'D101010001', '2021-12-13', '08:00:00', '12:00:00', 5, 'C101510003', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tblpatient`
--

CREATE TABLE `tblpatient` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(25) DEFAULT NULL,
  `fullname` varchar(300) DEFAULT NULL,
  `fname` varchar(100) DEFAULT NULL,
  `mname` varchar(100) DEFAULT NULL,
  `lname` varchar(100) DEFAULT NULL,
  `contact_no` varchar(15) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `photo_path` text DEFAULT NULL,
  `street` varchar(500) DEFAULT NULL,
  `barangay` varchar(500) DEFAULT NULL,
  `city_municipality` varchar(500) DEFAULT NULL,
  `province` varchar(500) DEFAULT NULL,
  `postal_code` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpatient`
--

INSERT INTO `tblpatient` (`id`, `patient_id`, `fullname`, `fname`, `mname`, `lname`, `contact_no`, `email_address`, `photo_path`, `street`, `barangay`, `city_municipality`, `province`, `postal_code`) VALUES
(8, 'U101010001', 'lname, fname mi', 'fname', 'mi', 'lname', '09123456789', 'user@user.com', 'Screenshot (1).png', 'street', 'barangay', 'city', 'province', 'postal'),
(21, 'U121110002', 'c, a b', 'a', 'b', 'c', '09123456789', 'a@a.com', NULL, 'd', 'e', 'f', 'g', 'h'),
(24, 'U121110003', 'sd, d a', 'd', 'a', 'sd', '09456781239', 'kajothan102@gmail.com', 'logo.png', 'asd', 'asd', 'asd', 'asd', 'asd');

-- --------------------------------------------------------

--
-- Table structure for table `tblpatient_diagnose`
--

CREATE TABLE `tblpatient_diagnose` (
  `id` int(11) NOT NULL,
  `ps_id` varchar(100) DEFAULT NULL,
  `finding` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `next_check_up` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpatient_diagnose`
--

INSERT INTO `tblpatient_diagnose` (`id`, `ps_id`, `finding`, `prescription`, `next_check_up`) VALUES
(1, '', 'asdas', 'asdasdasd', NULL),
(2, '', 'asdasd', 'asdasd', NULL),
(3, '8', 'ASS', 'ASSa', NULL),
(7, '2', 'May Ubo', 'MAg inum ki gin suwa 3x a day', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpatient_schedule`
--

CREATE TABLE `tblpatient_schedule` (
  `id` int(11) NOT NULL,
  `patient_id` varchar(25) DEFAULT NULL,
  `patient_descriptions` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `doctors_schedule_id` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblpatient_schedule`
--

INSERT INTO `tblpatient_schedule` (`id`, `patient_id`, `patient_descriptions`, `status`, `doctors_schedule_id`) VALUES
(1, 'U101010001', 'Sample Feeling', 1, '2'),
(2, 'U101010001', 'im sorry dont leave', 0, '5'),
(3, 'U101010001', 'ewrewrwer', 0, '5');

-- --------------------------------------------------------

--
-- Table structure for table `tblprovince`
--

CREATE TABLE `tblprovince` (
  `id` int(11) NOT NULL,
  `province` text DEFAULT NULL,
  `postal_code` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblprovince`
--

INSERT INTO `tblprovince` (`id`, `province`, `postal_code`) VALUES
(1, 'ALBAY', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblspecialist`
--

CREATE TABLE `tblspecialist` (
  `id` int(11) NOT NULL,
  `specialist_name` varchar(500) DEFAULT NULL,
  `specialist_descriptions` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblspecialist`
--

INSERT INTO `tblspecialist` (`id`, `specialist_name`, `specialist_descriptions`) VALUES
(1, 'Sample Specialist', NULL),
(3, 'assadasdddddddddd', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `user_id` varchar(25) DEFAULT NULL,
  `username` varchar(25) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `user_type` int(1) NOT NULL DEFAULT 0,
  `verified` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `user_id`, `username`, `password`, `user_type`, `verified`) VALUES
(1, 'admin', 'tester@tester.com', '12340', 0, 1),
(10, 'U101010001', 'user@user.com', 'a', 1, 0),
(16, 'D101010001', 'doc@doc.com', 'a', 2, 0),
(34, 'U121110003', 'kajothan102@gmail.com', 'a', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblbrangay`
--
ALTER TABLE `tblbrangay`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcity_municipality`
--
ALTER TABLE `tblcity_municipality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblclinic`
--
ALTER TABLE `tblclinic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldoctors`
--
ALTER TABLE `tbldoctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbldoctors_schedule`
--
ALTER TABLE `tbldoctors_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpatient`
--
ALTER TABLE `tblpatient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpatient_diagnose`
--
ALTER TABLE `tblpatient_diagnose`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblpatient_schedule`
--
ALTER TABLE `tblpatient_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblprovince`
--
ALTER TABLE `tblprovince`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblspecialist`
--
ALTER TABLE `tblspecialist`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblusers`
--
ALTER TABLE `tblusers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblbrangay`
--
ALTER TABLE `tblbrangay`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcity_municipality`
--
ALTER TABLE `tblcity_municipality`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblclinic`
--
ALTER TABLE `tblclinic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbldoctors`
--
ALTER TABLE `tbldoctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbldoctors_schedule`
--
ALTER TABLE `tbldoctors_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tblpatient_diagnose`
--
ALTER TABLE `tblpatient_diagnose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblpatient_schedule`
--
ALTER TABLE `tblpatient_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblprovince`
--
ALTER TABLE `tblprovince`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblspecialist`
--
ALTER TABLE `tblspecialist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
