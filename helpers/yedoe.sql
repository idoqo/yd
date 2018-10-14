-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 24, 2016 at 05:05 PM
-- Server version: 5.6.27-0ubuntu0.14.04.1
-- PHP Version: 5.6.17-3+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yedoe_git`
--

-- --------------------------------------------------------

--
-- Table structure for table `applications`
--

CREATE TABLE IF NOT EXISTS `applications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `jobID` int(10) unsigned NOT NULL,
  `userID` int(10) unsigned NOT NULL,
  `attachment` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `app_date` date DEFAULT NULL COMMENT '1 = pending, 2 = app delete, 3 = rejected',
  `applicant_delete` tinyint(4) NOT NULL DEFAULT '0',
  `seen` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `jobID` (`jobID`),
  KEY `user_ref` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=9 ;

--
-- Dumping data for table `applications`
--

INSERT INTO `applications` (`id`, `jobID`, `userID`, `attachment`, `status`, `app_date`, `applicant_delete`, `seen`) VALUES
(4, 26, 11, NULL, 1, '2015-08-20', 0, '0'),
(5, 25, 3, NULL, 1, '2015-08-20', 0, '0'),
(6, 20, 16, NULL, 1, '2015-08-23', 0, '0'),
(7, 19, 16, NULL, 1, '2015-08-23', 0, '0'),
(8, 20, 3, NULL, 1, '2015-08-28', 0, '0');

-- --------------------------------------------------------

--
-- Table structure for table `employer`
--

CREATE TABLE IF NOT EXISTS `employer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(10) unsigned NOT NULL,
  `staff_size` int(10) unsigned NOT NULL,
  `teaser` longtext COLLATE utf8_bin NOT NULL,
  `industry` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `employer`
--

INSERT INTO `employer` (`id`, `userId`, `staff_size`, `teaser`, `industry`) VALUES
(1, 6, 0, '', '15'),
(2, 10, 0, 'Tesla Motors is committed to hiring and developing top talent from across the world for any given discipline.   Our world-class teams operate with a non-conventional automotive product development philosophy of high inter-disciplinary collaboration, flat organizational structure, and technical contribution at all levels.  You will be expected to challenge and to be challenged, to create, and to innovate.  These jobs are not for everyone, you must have a genuine passion for producing the best vehicles in the world.  Without passion, you will find what we''re trying to do too difficult.', '12');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE IF NOT EXISTS `jobs` (
  `jobID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `description` longtext COLLATE utf8_bin,
  `requirements` longtext COLLATE utf8_bin,
  `posted_by` int(10) unsigned DEFAULT NULL,
  `budget` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `posted_date` date NOT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `emp_deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`jobID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=27 ;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`jobID`, `title`, `description`, `requirements`, `posted_by`, `budget`, `type`, `posted_date`, `expiry_date`, `status`, `emp_deleted`) VALUES
(19, 'Kumasi Sales representative', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet tempor neque. Nunc vel sodales velit, sit amet sagittis augue. Vestibulum at dui blandit, laoreet enim id, hendrerit neque. Nulla fringilla neque ultricies tristique accumsan. Vestibulum pharetra eu dolor et aliquam. Duis aliquam risus vel nibh mattis mattis. Sed laoreet nisl in efficitur consequat. Cras vitae nibh tellus. Nullam luctus consequat imperdiet. Sed efficitur faucibus consectetur. Proin sapien mauris, vulputate sit amet lectus at, mattis vehicula ante.2', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet tempor neque. Nunc vel sodales velit, sit amet sagittis augue. Vestibulum at dui blandit, laoreet enim id, hendrerit neque. Nulla fringilla neque ultricies tristique accumsan. Vestibulum pharetra eu dolor et aliquam. Duis aliquam risus vel nibh mattis mattis. Sed laoreet nisl in efficitur consequat. Cras vitae nibh tellus. Nullam luctus consequat imperdiet. Sed efficitur faucibus consectetur. Proin sapien mauris, vulputate sit amet lectus at, mattis vehicula ante.2', 5, '1300-2300', 'Paid', '2015-08-13', '0000-00-00 00:00:00', 1, 0),
(20, 'Teaching Assistant', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"', 5, '1000-1500', 'Non-paid', '2015-08-13', '2015-08-29 00:00:00', 1, 0),
(21, 'Teaching Assistant', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"', 5, '1000-1500', 'Non-paid', '2015-08-13', '2015-08-29 00:00:00', 1, 0),
(22, 'Test Job', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"', '', 5, '-', 'Non-paid', '2015-08-13', '2015-08-29 00:00:00', 1, 0),
(23, 'Another one', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?"', '', 5, '-', 'Paid', '2015-08-13', '2015-09-05 00:00:00', 1, 0),
(24, 'Optometry Interns needed', 'Africa carries a disproportionate ratio in terms of blindness and visual impairment. It is estimated that Africa carries large percentage of the world''s blindness. It is no surprise that this reality also mirrors the situation in terms of the burden of world poverty. There is an increasing recognition of the need to highlight the link between poverty, development and health care.', 'The duties include but not limited to the following, volunteer intern will help work with professionals to provide diagnostic tests, measure and record vision, and test eye muscle function also show patients how to insert, remove, and care for contact lenses, and they apply eye dressings. Under the direction of the physician, administer eye medications. They also maintain optical and surgical instruments and may assist the ophthalmologist in surgery.  \r\nThis opportunity is ongoing program and therefore any date can apply.', 6, '-', 'Non-paid', '2015-08-17', '2015-08-28 00:00:00', 1, 0),
(25, 'Firmware Internship / Co-Op (Fall 2015)', 'You will develop firmware for Tuscan''s current and next generations of battery management systems, charging systems, and autopilot program. You will work within the development team to automate testing, implement new tests, and create innovative automated test systems.  You will contribute to cross-functional system architecture, software system design, and rapid prototyping.\r\nYour application to the Firmware Internship will be considered for all opportunities across Autopilot, Firmware, Infotainment, Body Controls, Gateway, Charging Systems, and Power Electronics teams in Palo Alto, CA.', 'Proficiency in C/C++ and strong scripting skills in at least one common language (Python, Perl, Shell).\r\nFamiliarity with National Instrument Testing Software (LabView, TestStand, VeriStand).\r\nExperience designing and developing complex power electronics control systems including AC-DC and DC-DC converter topologies.\r\nExperience designing real-time embedded systems in C.\r\nExperience with CAN bus systems and associated tools.\r\nFamiliarity with automotive ECUs, especially those in hybrid and electric powertrains.\r\nExperience with FPGA/CPLD device programming.\r\nAbility to read and interpret electrical schematics and work efficiently with hardware design resources.\r\nCapable of hands-on bring up, debug and code optimization.\r\nExperience with DSPs, microcontrollers and realtime operating systems.\r\nFamiliarity with thermal control hardware, including compressors, pumps, and thermocouples are a plus.\r\nExperience implementing real-time control strategies, especially PID based control development is a plus.\r\nFamiliarity with Vector analysis tools is a plus.\r\nPrior AUTOSAR or other automotive RTOS embedded programming experience is a plus.', 10, '1200-3200', 'Paid', '2015-08-19', '2016-01-20 00:00:00', 1, 0),
(26, 'Data Scientist', 'The Data Scientist will work with teams addressing statistical, machine learning and data understanding problems in a commercial technology and consultancy development environment. In this role, you will lead the development and deployment of modern machine learning, operational research, semantic analysis, and statistical methods for finding structure in large data sets. As a Data Scientist, you will contribute to cross-disciplinary teams across EDM projects supporting advanced analytics needs for all Global Operationâ€™s enterprise functions. These projects will provide you the opportunity to analyse large, complex data sets sources from GEâ€™s CRM, ERP & finance systems. Focus of these projects includes operational optimization to reduce cost and to identify growth opportunities.', 'Applicants must be majoring in a "STEM" field and should have an stomach for problem solving', 10, '1000-1400', 'Paid', '2015-08-20', '2015-08-31 00:00:00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `job_skills`
--

CREATE TABLE IF NOT EXISTS `job_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `job` int(10) unsigned DEFAULT NULL,
  `skill` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=4 ;

--
-- Dumping data for table `job_skills`
--

INSERT INTO `job_skills` (`id`, `job`, `skill`) VALUES
(1, 23, 7),
(2, NULL, NULL),
(3, 25, 12);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msg_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender` int(10) unsigned NOT NULL,
  `receiver` int(10) unsigned NOT NULL,
  `subject` varchar(50) COLLATE utf8_bin NOT NULL DEFAULT 'No Subject',
  `message` longtext COLLATE utf8_bin,
  `attachment` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `receiver_seen` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `receiver_delete` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  `sender_delete` char(2) COLLATE utf8_bin NOT NULL DEFAULT '0',
  PRIMARY KEY (`msg_id`),
  KEY `receiver` (`receiver`),
  KEY `sender` (`sender`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=41 ;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `sender`, `receiver`, `subject`, `message`, `attachment`, `date_sent`, `receiver_seen`, `receiver_delete`, `sender_delete`) VALUES
(1, 3, 5, 'No Subject', '<input type="file" name="attachment">', NULL, '2015-08-14 15:28:06', '0', '0', '0'),
(2, 3, 5, 'No Subject', 'watsup', NULL, '2015-08-14 19:48:27', '0', '0', '0'),
(3, 5, 3, 'No Subject', 'Yeah. You there?', NULL, '2015-08-14 20:20:49', '0', '0', '0'),
(12, 3, 5, 'No Subject', 'How far?', NULL, '2015-08-14 20:57:19', '0', '0', '0'),
(13, 5, 4, 'No Subject', 'Sneak peak --&gt; You guys are interviewing tomorrow!', NULL, '2015-08-14 21:01:12', '0', '0', '0'),
(14, 5, 3, 'No Subject', 'Where have u been all day???', NULL, '2015-08-14 21:02:27', '0', '0', '0'),
(17, 3, 5, 'No Subject', 'Sorry I could''t get across...', NULL, '2015-08-16 00:32:17', '0', '0', '0'),
(18, 3, 5, 'No Subject', 'citur sollicitudin eget in purus. Phasellus vitae nulla vel orci auctor vulputate. Suspendisse potenti. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce facilisis, tellus in condimentum ultrices, dolor purus maximus arcu, nec malesuada tellus nunc in urna. Duis fermentum mattis leo a condimentum. Pellentesque sit amet bibendum risus, in dignissim enim. Proin accumsan justo vitae nisi consequat, ut elementum metus rutrum. Phasellus elementum blandit ligula, eu elementum nulla porta sit amet. Donec eget quam varius, varius sapien non, placerat urna. Sed eleifend ex id convallis ultrices.\r\n\r\nCras eu interdum mauris, in vestibulum neque. Vivamus elit nunc, pellentesque vel quam id, lac', NULL, '2015-08-16 00:32:42', '0', '0', '0'),
(19, 4, 5, 'No Subject', 'Guess what!!!\r\n', NULL, '2015-08-16 00:35:03', '0', '0', '0'),
(20, 5, 4, 'No Subject', '???', NULL, '2015-08-16 00:36:34', '0', '0', '0'),
(21, 3, 5, 'No Subject', '', NULL, '2015-08-18 13:48:47', '0', '0', '0'),
(22, 6, 5, 'No Subject', 'Hello', NULL, '2015-08-18 13:53:18', '0', '0', '0'),
(23, 6, 3, 'No Subject', 'Hello', NULL, '2015-08-18 13:54:36', '0', '0', '0'),
(24, 3, 6, 'No Subject', 'Morning', NULL, '2015-08-18 13:55:02', '0', '0', '0'),
(25, 3, 6, 'No Subject', 'How is it going?', NULL, '2015-08-20 12:15:23', '0', '0', '0'),
(26, 6, 5, 'No Subject', 'Been a while boss\r\n', NULL, '2015-08-20 12:56:12', '0', '0', '0'),
(27, 6, 3, 'No Subject', 'So far so good. How about you?', NULL, '2015-08-20 13:13:12', '0', '0', '0'),
(28, 3, 6, 'No Subject', 'Same here.', NULL, '2015-08-21 14:03:40', '0', '0', '0'),
(29, 5, 6, 'No Subject', 'Yay bro. How is Manchester?', NULL, '2015-08-22 21:44:18', '0', '0', '0'),
(30, 5, 6, 'No Subject', 'Heard of ur deployment...', NULL, '2015-08-22 21:44:32', '0', '0', '0'),
(31, 5, 3, 'No Subject', 'Why the lengthy blabbing?', NULL, '2015-08-23 00:49:34', '0', '0', '0'),
(34, 5, 9, 'No Subject', 'Hello maame', NULL, '2015-08-23 13:19:52', '0', '0', '0'),
(35, 5, 3, 'No Subject', 'So why should we hire you?', NULL, '2015-08-24 10:02:33', '0', '0', '0'),
(36, 3, 5, 'No Subject', 'I have always wanted to contribute my own quota to how everyone interacts, I believe the company is on same track with me and blah blah blah', NULL, '2015-08-24 11:02:42', '0', '0', '0'),
(37, 3, 6, 'No Subject', 'How is machester today?', NULL, '2015-08-24 11:19:06', '0', '0', '0'),
(38, 5, 17, 'No Subject', 'Hii', NULL, '2015-08-24 16:23:48', '0', '0', '0'),
(39, 3, 6, 'No Subject', 'dvxvxcv', NULL, '2015-09-01 18:39:20', '0', '0', '0'),
(40, 25, 9, 'No Subject', 'Hello', NULL, '2015-09-13 12:14:42', '0', '0', '0');

-- --------------------------------------------------------

--
-- Table structure for table `portfolios`
--

CREATE TABLE IF NOT EXISTS `portfolios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `employer` varchar(50) COLLATE utf8_bin NOT NULL,
  `end_date` date NOT NULL,
  `started_date` date DEFAULT NULL,
  `emp_review` longtext COLLATE utf8_bin,
  `photo` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `photo2` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `photo3` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `userID` int(10) unsigned NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=6 ;

--
-- Dumping data for table `portfolios`
--

INSERT INTO `portfolios` (`id`, `title`, `employer`, `end_date`, `started_date`, `emp_review`, `photo`, `photo2`, `photo3`, `userID`, `description`) VALUES
(4, 'Administrative Assistant', 'Case Foundation', '2015-07-08', '2013-07-07', NULL, NULL, NULL, NULL, 3, 'Cras eu interdum mauris, in vestibulum neque. Vivamus elit nunc, pellentes'),
(5, 'Medical Residency', 'KNUST Hospital, Kumasi', '2015-10-17', '2013-07-16', NULL, NULL, NULL, NULL, 3, 'Part of a surgery team that successfully carried out a kidney transplant using the first solar-powered dialysis machine in Africa.');

-- --------------------------------------------------------

--
-- Table structure for table `seekers`
--

CREATE TABLE IF NOT EXISTS `seekers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `expertise` text COLLATE utf8_bin COMMENT 'listed info  written by user themselves',
  `cv_file` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `hobby` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userID` (`userID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `seeker_edu`
--

CREATE TABLE IF NOT EXISTS `seeker_edu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(10) unsigned NOT NULL,
  `institution` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `location` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `major` varchar(50) COLLATE utf8_bin NOT NULL,
  `date_started` date NOT NULL,
  `date_ending` date NOT NULL,
  `award` varchar(50) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=3 ;

--
-- Dumping data for table `seeker_edu`
--

INSERT INTO `seeker_edu` (`id`, `userID`, `institution`, `location`, `major`, `date_started`, `date_ending`, `award`, `description`) VALUES
(1, 3, 'University of Cape Coast', NULL, 'Classics and Oriental Studies\r\n', '2013-02-01', '2017-08-01', 'BSc.', ''),
(2, 24, 'Sikkim Manipal University', NULL, 'Business Administration\r\n', '2014-06-01', '2018-11-01', 'BSc.', '');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE IF NOT EXISTS `skills` (
  `skill_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `skill` varchar(100) COLLATE utf8_bin NOT NULL,
  `skill_parent` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=30 ;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`skill_id`, `skill`, `skill_parent`) VALUES
(2, 'Administrative', 0),
(4, 'Banking and Finance', 0),
(5, 'Business Development', 0),
(6, 'Construction and Architecture', 0),
(7, 'Consultancy', 0),
(8, 'Auditing', 0),
(9, 'Creativity and Designs', 0),
(10, 'Customer Care', 0),
(11, 'Energy', 0),
(12, 'Engineering', 0),
(13, 'Fashion', 0),
(14, 'Human Resources', 0),
(15, 'Information Technology', 0),
(16, 'Insurance', 0),
(17, 'Journalism', 0),
(18, 'Legal', 0),
(20, 'Medicals & Health', 0),
(21, 'Non-Profit', 0),
(22, 'Production and Manufacturing', 0),
(23, 'Quality Assurance and Safety', 0),
(26, 'Tourism', 0),
(27, 'Sales & Marketing', 0),
(28, 'Logistics', 0),
(29, 'Education', 0);

-- --------------------------------------------------------

--
-- Table structure for table `skill_cat`
--

CREATE TABLE IF NOT EXISTS `skill_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=25 ;

--
-- Dumping data for table `skill_cat`
--

INSERT INTO `skill_cat` (`id`, `cat_name`) VALUES
(1, 'Administrative'),
(2, 'Auditing'),
(3, 'Banking and Finance'),
(4, 'Business Development'),
(5, 'Construction and Architecture'),
(6, 'Consultancy'),
(7, 'Creativity and Designs'),
(8, 'Customer Care'),
(9, 'Education'),
(10, 'Energy'),
(11, 'Engineering'),
(12, 'Fashion'),
(13, 'Human Resources'),
(14, 'Information Technology'),
(15, 'Insurance'),
(16, 'Journalism'),
(17, 'Legal'),
(18, 'Logistics'),
(19, 'Medicals & Health'),
(20, 'Non-Profit'),
(21, 'Production and Manufacturing'),
(22, 'Quality Assurance and Safety'),
(23, 'Sales & Marketing'),
(24, 'Tourism');

-- --------------------------------------------------------

--
-- Table structure for table `userlist`
--

CREATE TABLE IF NOT EXISTS `userlist` (
  `userID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `utype` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `fname` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `lname` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `website` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `tel` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `location` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `compName` varchar(150) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `displayPic` varchar(65) COLLATE utf8_bin NOT NULL DEFAULT 'default_dp.png',
  `overview` longtext COLLATE utf8_bin,
  `reg_date` date NOT NULL,
  `last_logged` date DEFAULT NULL,
  PRIMARY KEY (`userID`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=31 ;

--
-- Dumping data for table `userlist`
--

INSERT INTO `userlist` (`userID`, `utype`, `fname`, `lname`, `website`, `email`, `tel`, `location`, `compName`, `password`, `displayPic`, `overview`, `reg_date`, `last_logged`) VALUES
(3, 'student', 'Mormont', 'Jorah', NULL, 'mormont@yahoo.com', 'Telephone', 'Kumasi', NULL, '$2y$10$Af/.kZZlpAA7Tkh8/Rx6ve7mOq3/kGwhLc62ZOSMt.zRQ3szE4XY6', 'default_dp.png', 'But I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful.                                                                                                    ', '2015-08-09', '2016-01-24'),
(4, 'student', 'Esther', 'Daniels', NULL, 'esta@yahoo.com', '', 'Kumasi', NULL, '$2y$10$t01/6iBe..cfsoomdOhMcO5tdOLlNgKgmgN45m2G4i0m09Yts4n4y', 'default_dp.png', '', '2015-08-09', '0000-00-00'),
(5, 'employer', NULL, NULL, 'http://www.projectnaija.com', 'jobs@buildbrothers.com', '', 'Otukpo', 'Build Brothers Inc', '$2y$10$SOrtD2sIZoUt0IvqyAoJzOsfnm6P1XXHTLnllvVtUywdxkoisCgwS', 'briefcase.png', '', '0000-00-00', '0000-00-00'),
(6, 'employer', NULL, NULL, 'http://www.android.com', 'jobs@android.com', 'Telephone', 'Cape Coast', 'RLG Computers', '$2y$10$SOrtD2sIZoUt0IvqyAoJzOsfnm6P1XXHTLnllvVtUywdxkoisCgwS', 'briefcase.png', '                        Overview                    ', '0000-00-00', '0000-00-00'),
(7, 'student', 'Abena', 'Naah', NULL, 'abena@gmail.com', '', 'Accra', NULL, '$2y$10$dCdyazFS3/6RNj8bUeqcqO4g1pQ8jCSe6plqwhv0gKhxZ0PJR5aGm', 'default_dp.png', '', '2015-08-19', '0000-00-00'),
(9, 'student', 'Serwaah', 'Ayew', NULL, 'millicent@yahoo.com', 'Telephone', 'Accra', NULL, '$2y$10$tFGggwCLb8upSDp0YxjPg.f6Sr6mWsE/c16YD2NXdrdINlApK9A2a', 'default_dp.png', '         ', '2015-08-19', '0000-00-00'),
(10, 'employer', NULL, NULL, 'http://www.tvr.com', 'tuscan@yahoo.com', '', 'Kumasi', 'Tuscan Corp.', '$2y$10$Af/.kZZlpAA7Tkh8/Rx6ve7mOq3/kGwhLc62ZOSMt.zRQ3szE4XY6', 'briefcase.png', 'Tuscan''s goal is to accelerate the worldâ€™s transition to electric mobility with a full range of increasingly affordable electric cars. California-based Tesla designs and manufactures EVs, as well as EV powertrain components for partners such as Toyota and Daimler. Tesla has delivered over 40,000 electric vehicles to customers in 31 countries. Model S is the worldâ€™s first premium sedan to be engineered from the ground up as an electric vehicle. Model S was named Motor Trendâ€™s prestigious 2013 Car of the Year, achieved the best safety score of any car ever tested by the NHTSA, and Consumer Reports is calling it the best car it has ever tested.', '2015-08-19', '2016-01-24'),
(11, 'student', 'Okoko', 'Michaels', NULL, 'okmichaels@yahoo.com', 'Telephone', 'Kumasi', NULL, '$2y$10$KwSlNCi4oYIs2qovHjB1r.sw5DmiWZV8/2kadIvztXWoq2mV8w9ce', 'default_dp.png', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit', '2015-08-19', '0000-00-00'),
(13, 'employer', NULL, NULL, NULL, 'work@arudhra.com', '', 'Tamale', 'Arudhra Corp', '$2y$10$ZU0D8v2egQdt7BMMs0ZzauoRvF3MLJXgfF5Upq3tsAywWrKpld83q', 'briefcase.png', '', '2015-08-19', '0000-00-00'),
(14, 'student', 'Onoja', 'Godswill', NULL, 'obanla@gmail.com', '', 'Makurdi', NULL, '$2y$10$60BH3I29drRgZZmW/MPPEerP9vqUF/6C3b8eAbDyXK7SQSbM5EYOi', 'default_dp.png', '', '2015-08-19', '0000-00-00'),
(15, 'student', 'Aboyi', 'Eaweb', NULL, 'jobs@eaweb.wapka.mobi', '', 'Cape Coast', NULL, '$2y$10$lrHG.brZu93br8eAM51Jfe0c8.4fGG60HagOClYt.xFCptpCEUPn.', 'default_dp.png', '', '2015-08-19', '0000-00-00'),
(16, 'student', 'Maliq', 'Alubarika', NULL, 'maliq@github.io', 'Telephone', 'Kumasi', NULL, '$2y$10$TjbqNeNE9zYg2OJjgjY6ROVtcA6moeG4vRfwYnSG13yEKJgxsSMKO', 'default_dp.png', '', '2015-08-19', '0000-00-00'),
(17, 'student', 'Aboude', 'Ayew', NULL, 'a.ayew@hotmail.com', '', 'Cape Coast', NULL, '$2y$10$g.aWUQpTKs1eHdXjYWndwugPmoeuTdgfQ9FNtWpDtE.F3w8mPIc3a', 'default_dp.png', '', '2015-08-24', '0000-00-00'),
(18, 'student', 'Malaika', 'Roosevelt', NULL, 'segoe@yahoo.com', '', 'Kumasi', NULL, '$2y$10$X9hXb8.UurSWTP94TgMPQOwrAmnKzHLv1EBmzWuRTvDNAm4K8RdAC', 'default_dp.png', '', '2015-08-25', '0000-00-00'),
(19, 'student', 'karisma', 'ikpa', NULL, 'ikpasammy@gmail.com', '', '', NULL, '$2y$10$0VnBYo5SMWc90EqhDrdq/uRO1xSzWcxK2A72aRCS74belpcsZNi.W', 'default_dp.png', '', '2015-08-25', '0000-00-00'),
(20, 'student', 'karisma', 'ikpa', NULL, 'glitzy44@ovi.com', '', 'Greater Accra\n', NULL, '$2y$10$PkIClhFw/xCV.vm.6gc48.degPEytASNRVCvARX9wgmoynN8KXf3K', 'default_dp.png', '', '2015-08-25', '0000-00-00'),
(21, 'student', 'Okoko', 'Michaels', NULL, 'trojanwkty@gmail.com', '', 'Kumasi\r\n', NULL, '$2y$10$/Q7/QV/7w15qzo8j0Pfx9e5L6toBiw3P.F7cg13z.S.mcnz9u5DL2', 'default_dp.png', '', '2015-08-26', '0000-00-00'),
(22, 'student', 'abdulrasak', 'abdul', NULL, 'abdulrazark93@gmail.com', '', 'Kumasi\n', NULL, '$2y$10$Bw4QET579BX7UsG9fPVInupLP.Yud9EqMnlH4.D28OExCFcW6DgcS', 'default_dp.png', '', '2015-08-26', '0000-00-00'),
(23, 'student', 'Aboude', 'Ayew', NULL, 'austine@gmail.com', '', '', NULL, '$2y$10$r4XsD7EnTyisHCPZrAWvD.8SCcOz41gHxobrZ4oSoX19qcai3Bj3i', 'default_dp.png', '', '2015-09-01', '0000-00-00'),
(24, 'student', 'Lian', 'Osei', NULL, 'osei@yahoo.com', 'Telephone', 'Kumasi', NULL, '$2y$10$1T7frqFL81TAv8h26ZmjZuLmiIPyLRuF9aDt8g3tY..mNpOy.ajA6', 'default_dp.png', '                        Overview                    ', '2015-09-12', '0000-00-00'),
(25, 'employer', NULL, NULL, NULL, 'jobs@accghana.com', '', 'Brong-Ahafo\r\n', 'Sikkim Manipal university', '$2y$10$i1qcnCbkw58z6Sj9CkviXeG2aWIvUiGbdv9mrEazxqn97yr1KnnBq', 'briefcase.png', '', '2015-09-13', '0000-00-00'),
(26, 'student', 'Laweezy', 'Emvino', NULL, 'onoja.lawrence@yahoo.com', '', 'Accra\r\n', NULL, '$2y$10$zYEUJl.yBR6DI16zLf/Fz.zhb6XFya1CzEFhZtm8YsU97r2VBCMRi', 'default_dp.png', '', '2015-09-15', '0000-00-00'),
(27, 'student', 'Kweku', 'Steve', NULL, 'steve@yahoo.com', '', 'Kumasi\r\n', NULL, '$2y$10$i6lZ.ZzOs4NXEyWqZiJHFO5AkzTHWBJyftTR.Rbye1JWHSGVSr9DS', 'default_dp.png', '', '2015-10-05', '0000-00-00'),
(28, 'student', 'Vivian', 'Osei', NULL, 'oseivi@gmail.com', '', 'Kumasi', NULL, '$2y$10$f6Lmr.veaS/N2sHRFxE9mOliGIgk3LVNA7JdFfrGP.TWIyTVjW1dS', 'default_dp.png', NULL, '2016-01-24', '2016-01-24'),
(29, 'student', 'Jenny', 'Onah', NULL, 'jenny@fb.co', '', 'Calabar', NULL, '$2y$10$zyZl7fa8MlNsC5uN4Zu4VuIc1qYRSGUmPWcDERIM/eGYMr6yENATO', 'default_dp.png', NULL, '2016-01-24', '2016-01-24'),
(30, 'employer', NULL, NULL, NULL, 'jobs@assisi.com', '', 'Kumasi', 'Assisi Inc', '$2y$10$YeH1A.0rSBmn.UGlYFtfh.dKf86JOZ8W7OSZxHnaHFxJb2CpuicE6', 'briefcase.png', NULL, '2016-01-24', '2016-01-24');

-- --------------------------------------------------------

--
-- Table structure for table `user_skills`
--

CREATE TABLE IF NOT EXISTS `user_skills` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `skill_id` int(10) unsigned DEFAULT NULL,
  `proficiency` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `skill_id` (`skill_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=30 ;

--
-- Dumping data for table `user_skills`
--

INSERT INTO `user_skills` (`id`, `user_id`, `skill_id`, `proficiency`) VALUES
(1, 18, 9, 0),
(20, 3, 20, 0),
(21, 16, 2, 0),
(24, 11, 12, 0),
(25, 3, 12, 0),
(26, 17, 8, 0),
(28, 17, 4, 0),
(29, 26, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE IF NOT EXISTS `watchlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `watcher` int(10) unsigned NOT NULL,
  `watchee` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applications`
--
ALTER TABLE `applications`
  ADD CONSTRAINT `applications_ibfk_1` FOREIGN KEY (`jobID`) REFERENCES `jobs` (`jobID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `applications_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `userlist` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employer`
--
ALTER TABLE `employer`
  ADD CONSTRAINT `employer_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `userlist` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`receiver`) REFERENCES `userlist` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`sender`) REFERENCES `userlist` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `portfolios`
--
ALTER TABLE `portfolios`
  ADD CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `userlist` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `seekers`
--
ALTER TABLE `seekers`
  ADD CONSTRAINT `seekers_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `userlist` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_skills`
--
ALTER TABLE `user_skills`
  ADD CONSTRAINT `user_skills_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `userlist` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_skills_ibfk_2` FOREIGN KEY (`skill_id`) REFERENCES `skills` (`skill_id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
