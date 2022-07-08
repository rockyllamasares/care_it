-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 13, 2022 at 12:52 AM
-- Server version: 10.5.12-MariaDB
-- PHP Version: 7.3.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `id18112491_icare`
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
(1, 'C101410001', 'Albay polyclinic institute', '639956200297', 'albaypolyclinic@yahoo.com', 'rizal st.', 'old albay district', 'legazpi', 'albay', '4500', 'D101010001'),
(3, 'C101410002', 'little angel clinic', '09953404084', 'littleclinic@gmail.com', 'rizal st.', 'penaranda', 'legazpi', 'albay', '4500', 'D101010001'),
(6, 'C121410004', 'Zantua Medical', '09090909', 'Zantua@medical', 'Old albay', 'Albay', 'Legazpi', 'Albay', '4500', 'D101010001'),
(7, 'C121710005', 'ibalong medical center', '09175702551', 'ibalongmedicalcenter1995@gmail.com', 'Rizal Street', 'old albay district', 'legazpi', 'albay', '4500', 'admin');

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
  `photo_path` text DEFAULT NULL,
  `street` varchar(500) DEFAULT NULL,
  `barangay` varchar(500) DEFAULT NULL,
  `city_municipality` varchar(500) DEFAULT NULL,
  `province` varchar(500) DEFAULT NULL,
  `postal_code` varchar(25) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `email_address` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbldoctors`
--

INSERT INTO `tbldoctors` (`id`, `doc_id`, `fullname`, `fname`, `mname`, `lname`, `specialist_id`, `photo_path`, `street`, `barangay`, `city_municipality`, `province`, `postal_code`, `contact_no`, `email_address`) VALUES
(1, 'D101010002', 'Adam Smith', 'adam', 'a', 'smith', 'gynecology', '', 'kanos', 'dita', 'legazpi', 'Albay', '4500', '', 'adam@adam.com'),
(2, 'D101010001', '3, 1 2', '1', '2', '3', 'Sample Specialist', 'Screenshot (2).png', '4', '5', '6', '7', '8', '09987654321', 'doc@doc.com'),
(6, 'D010410003', 'a, a a', 'a', 'a', 'a', 'cardiology', 'www.YTS.MX.jpg', 'a', 'a', 'a', 'a', '23', '123124', 'alturasjonathanpogi@gmail.com'),
(7, 'D010410003', 'a, a a', 'a', 'a', 'a', 'Dental', 'www.YTS.MX.jpg', 'a', 'a', 'a', 'a', 'a', '0905415465', 'alturasjonathanpogi@gmail.com'),
(8, 'D010410003', 'a, a a', 'a', 'a', 'a', 'Dental', 'www.YTS.MX.jpg', 'a', 'a', 'a', 'a', 'a', '0905415465', 'alturasjonathanpogi@gmail.com');

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
(28, 'U121410002', 'Borigas , JC E', 'JC', 'E', 'Borigas ', '09956200323', 'borigasjhoncarlo29@gmail.com ', 'Screenshot_20211205_005111_com.facebook.orca.jpg', 'resettlement site', 'banquerohan', 'legazpi ', 'Albay ', '4500'),
(30, 'U121510004', 'madawac, jamil malab', 'jamil', 'malab', 'madawac', '09956200207', 'jamilmadawac@gmail.com', '16395518194318149593355501881147.jpg', 'Purok 4', 'pinaric', 'Legazpi city Albay', 'albay', '4500'),
(31, 'U121510005', 'Valencia, Mart Jaranilla', 'Mart', 'Jaranilla', 'Valencia', '09956200286', 'martvalencia12@gmail.com', '1639552188796558971656446478725.jpg', 'P.3 309', 'Brgy.16', 'Legazpi City', 'ALBAY', '4500'),
(35, 'U121710007', 'arevalo, christian j', 'christian', 'j', 'arevalo', '09107784325', 'chanarevalo1994@gmail.com', NULL, 'binanuahan', 'legazpi', 'legazpi', 'albay', '4500'),
(36, 'U010510008', 'boyon, jomel a', 'jomel', 'a', 'boyon', '09175702551', 'borigasjhoncarlo29@gmail.com', NULL, 'Rizal Street', 'legazpi', 'legazpi', 'albay', '4500');

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
(2, 'U101010001', 'im sorry dont leave', 1, '5'),
(3, 'U101010001', 'ewrewrwer', 0, '5'),
(4, 'U010510008', 'masakit abg titi', 0, '');

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
(4, 'Dental', NULL),
(5, 'dermatology', NULL),
(6, 'Radiology', NULL),
(7, 'general medicine', NULL),
(8, 'pediatrician', NULL),
(9, 'Surgeon', NULL),
(10, 'cardiology', NULL),
(11, 'pulmonology', NULL),
(12, 'neurology', NULL),
(13, 'pathology', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblusers`
--

CREATE TABLE `tblusers` (
  `id` int(11) NOT NULL,
  `user_id` varchar(25) DEFAULT NULL,
  `username` varchar(500) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `user_type` int(1) NOT NULL DEFAULT 0,
  `verified` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tblusers`
--

INSERT INTO `tblusers` (`id`, `user_id`, `username`, `password`, `user_type`, `verified`) VALUES
(1, 'admin', 'tester@tester.com', '12340', 0, 1),
(38, 'U121510004', 'jamilmadawac@gmail.com', '09203163384mhing', 1, 1),
(39, 'U121510005', 'martvalencia12@gmail.com', 'mart12', 1, 0),
(42, 'D12161', 'ustri123@ustria.com', 'asd123', 2, 0),
(44, 'U121710007', 'chanarevalo1994@gmail.com', 'a', 1, 0),
(45, 'D010410003', 'alturasjonathanpogi@gmail.com', 'a', 2, 1),
(46, 'D010410003', 'alturasjonathanpogi@gmail.com', 'a', 2, 1),
(47, 'U010510008', 'borigasjhoncarlo29@gmail.com', 'a', 1, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbldoctors`
--
ALTER TABLE `tbldoctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbldoctors_schedule`
--
ALTER TABLE `tbldoctors_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tblpatient`
--
ALTER TABLE `tblpatient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tblpatient_diagnose`
--
ALTER TABLE `tblpatient_diagnose`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tblpatient_schedule`
--
ALTER TABLE `tblpatient_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tblprovince`
--
ALTER TABLE `tblprovince`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblspecialist`
--
ALTER TABLE `tblspecialist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tblusers`
--
ALTER TABLE `tblusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
