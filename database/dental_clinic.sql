-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2023 at 07:43 PM
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
-- Database: `dental_clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `accountID` int(10) NOT NULL,
  `accFirstName` varchar(100) NOT NULL,
  `accLastName` varchar(100) NOT NULL,
  `accEmail` varchar(100) NOT NULL,
  `accPassword` varchar(20) NOT NULL,
  `accRole` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`accountID`, `accFirstName`, `accLastName`, `accEmail`, `accPassword`, `accRole`) VALUES
(100001, 'Benedict', 'Comia', 'bene@gmail.com', 'Benedict_016', 'Admin'),
(100002, 'Grant', 'Obiedo', 'grant@gmail.com', 'Grant_016', 'Employee'),
(100003, 'Berlie', 'Garcia', 'berlie@gmail.com', 'Berlie_016', 'Employee'),
(100004, 'Kris', 'Dimaapi', 'kris@gmail.com', 'Kris_016', 'Employee'),
(100005, 'Clarence', 'Castro', 'clarence@gmail.com', 'Clarence_016', 'Employee');

-- --------------------------------------------------------

--
-- Stand-in structure for view `appointments`
-- (See below for the actual view)
--
CREATE TABLE `appointments` (
`requestID` int(10)
,`patientID` int(10)
,`requestServices` varchar(150)
,`requestDate` date
,`requestTime` time
,`requestNotes` text
,`requestStatus` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patientID` int(10) NOT NULL,
  `patientFirstName` varchar(30) DEFAULT NULL,
  `patientLastName` varchar(30) DEFAULT NULL,
  `patientAge` int(11) DEFAULT NULL,
  `patientSex` varchar(10) DEFAULT NULL,
  `patientMobileNo` varchar(15) DEFAULT NULL,
  `patientEmail` varchar(70) DEFAULT NULL,
  `patientAddress` varchar(100) DEFAULT NULL,
  `patientOccupation` varchar(30) DEFAULT NULL,
  `patientBalance` decimal(15,2) DEFAULT 0.00,
  `patientStatus` varchar(15) DEFAULT 'Not Verified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patientID`, `patientFirstName`, `patientLastName`, `patientAge`, `patientSex`, `patientMobileNo`, `patientEmail`, `patientAddress`, `patientOccupation`, `patientBalance`, `patientStatus`) VALUES
(200001, 'Benoite', 'Melley', 44, 'F', '0937-839-9538', 'bmelley0@auda.org.au', '984 Di Loreto Center', 'GIS Technical Architect', 0.00, 'Verified'),
(200002, 'Barrie', 'Meaders', 12, 'M', '0922-109-5888', 'bmeaders1@ameblo.jp', '3 Independence Hill', 'Librarian', 0.00, 'Verified'),
(200003, 'Wilburt', 'Thurston', 54, 'M', '0924-645-0618', 'wthurston2@ebay.com', '6 Graceland Place', 'GIS Technical Architect', 0.00, 'Verified'),
(200004, 'Worden', 'Lean', 47, 'M', '0966-241-7510', 'wlean3@printfriendly.com', '278 Jana Avenue', 'Accountant III', 0.00, 'Verified'),
(200005, 'Zuzana', 'Whittle', 27, 'F', '0922-524-6481', 'zwhittle4@home.pl', '89290 Butterfield Crossing', 'Compensation Analyst', 0.00, 'Verified'),
(200006, 'Perry', 'Bernadon', 56, 'F', '0954-541-8220', 'pbernadon5@e-recht24.de', '34 Tony Road', 'Help Desk Operator', 0.00, 'Verified'),
(200007, 'Deny', 'Gover', 50, 'F', '0924-109-4926', 'dgover6@myspace.com', '22 New Castle Park', 'Occupational Therapist', 0.00, 'Verified'),
(200008, 'Fernande', 'Tewkesbury.', 26, 'F', '0993-757-7386', 'ftewkesbury7@nationalgeographic.com', '4374 Cardinal Crossing', 'Electrical Engineer', 0.00, 'Verified'),
(200009, 'Mill', 'Clifford', 51, 'M', '0950-252-2893', 'mclifford8@yolasite.com', '8300 Amoth Terrace', 'Financial Advisor', 0.00, 'Verified'),
(200010, 'Bev', 'Cocker', 20, 'M', '0980-945-1834', 'bcocker9@arizona.edu', '1 Golf View Place', 'Human Resources Assistant IV', 0.00, 'Verified'),
(200011, 'Jarvis', 'Bewshea', 22, 'M', '0937-626-2573', 'jbewsheaa@sciencedaily.com', '532 Amoth Avenue', 'Senior Cost Accountant', 24000.00, 'Verified'),
(200012, 'Tedie', 'Isbell', 67, 'M', '0956-931-3447', 'tisbellb@fc2.com', '744 Florence Hill', 'Financial Advisor', 0.00, 'Verified'),
(200013, 'Mamie', 'Van Merwe', 32, 'F', '0903-364-3842', 'mvanmerwec@chron.com', '12 Kensington Terrace', 'Health Coach IV', 0.00, 'Verified'),
(200014, 'Maurene', 'Wadesworth', 46, 'F', '0932-196-0069', 'mwadesworthd@fc2.com', '6 Barby Center', 'Senior Quality Engineer', 0.00, 'Verified'),
(200015, 'Marta', 'Gilligan', 68, 'F', '0910-139-9570', 'mgilligane@boston.com', '63275 Autumn Leaf Point', 'Web Developer III', 0.00, 'Verified'),
(200016, 'Leif', 'Sired', 53, 'M', '0922-305-3955', 'lsiredf@cnet.com', '77756 Farwell Way', 'Environmental Tech', 0.00, 'Verified'),
(200017, 'Tanya', 'Cuer', 37, 'F', '0935-479-8432', 'tcuerg@goo.gl', '342 Fallview Hill', 'Physical Therapy Assistant', 0.00, 'Verified'),
(200018, 'Marlene', 'Trimbey', 69, 'F', '0925-813-7172', 'mtrimbeyh@slate.com', '2 Lyons Crossing', 'Occupational Therapist', 0.00, 'Verified'),
(200019, 'Adele', 'Easey', 11, 'F', '0906-441-6105', 'aeaseyi@stumbleupon.com', '9727 Erie Street', 'Web Developer II', 0.00, 'Verified'),
(200020, 'Domini', 'Barrasse', 52, 'F', '0909-668-4827', 'dbarrassej@narod.ru', '00586 Swallow Drive', 'Clinical Specialist', 0.00, 'Verified'),
(200021, 'Melvin', 'De Nisco', 51, 'M', '0951-822-1027', 'mdeniscok@va.gov', '88670 Tony Lane', 'VP Sales', 0.00, 'Verified'),
(200022, 'Lauretta', 'Godin', 23, 'F', '0956-595-2954', 'lgodinl@furl.net', '9882 Fairfield Parkway', 'Media Manager III', 0.00, 'Verified'),
(200023, 'Kriste', 'Baudouin', 65, 'F', '0919-684-9821', 'kbaudouinm@zdnet.com', '418 Bluestem Hill', 'Programmer I', 0.00, 'Verified'),
(200024, 'Zarah', 'Smittoune', 31, 'F', '0991-302-1338', 'zsmittounen@baidu.com', '48938 Eastlawn Crossing', 'Structural Engineer', 0.00, 'Verified'),
(200025, 'Alaster', 'Granham', 22, 'M', '0973-862-2291', 'agranhamo@columbia.edu', '00345 Stang Drive', 'Analyst Programmer', 0.00, 'Verified'),
(200026, 'Andreas', 'Wannell', 31, 'M', '0941-481-3357', 'awannellp@vistaprint.com', '70173 Hooker Alley', 'Junior Executive', 0.00, 'Verified'),
(200027, 'Artie', 'Gildea', 12, 'M', '0944-899-5235', 'agildeaq@marketwatch.com', '8 Fuller Crossing', 'Senior Quality Engineer', 0.00, 'Verified'),
(200028, 'Leanna', 'Dilleston', 13, 'F', '0943-593-6466', 'ldillestonr@wikia.com', '3073 Memorial Pass', 'Associate Professor', 0.00, 'Verified'),
(200029, 'Allan', 'Hammerich', 59, 'M', '0968-410-5354', 'ahammerichs@linkedin.com', '3009 Scoville Trail', 'Automation Specialist I', 0.00, 'Verified'),
(200030, 'Iolanthe', 'Dreossi', 36, 'F', '0922-450-6231', 'idreossit@hexun.com', '3234 8th Point', 'Physical Therapy Assistant', 0.00, 'Verified'),
(200043, 'Kanye', 'West', 45, 'M', '0954-234-6482', 'kanye@west.com', 'Biringan City, Samar', 'Artist', 0.00, 'Not Verified'),
(200044, 'Avalynn', 'Schroeder', 19, 'F', '0976-173-2879', 'avalynn@gmail.com', 'Tulo West, Batangas City, Batangas', 'Unemployed', 0.00, 'Not Verified');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE `requests` (
  `requestID` int(10) NOT NULL,
  `patientID` int(10) DEFAULT NULL,
  `requestServices` varchar(150) DEFAULT NULL,
  `requestDate` date DEFAULT NULL,
  `requestTime` time DEFAULT NULL,
  `requestNotes` text DEFAULT NULL,
  `requestStatus` varchar(10) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`requestID`, `patientID`, `requestServices`, `requestDate`, `requestTime`, `requestNotes`, `requestStatus`) VALUES
(300024, 200011, 'Orthodontics Treatment', '2023-01-25', '09:00:00', '', 'Approved'),
(300025, 200011, 'Orthodontics Treatment', '2023-02-24', '09:30:00', 'My 2nd Adjustment of Braces', 'Approved'),
(300026, 200011, 'Orthodontics Treatment, Root Canal', '2023-03-27', '13:00:00', 'I am currently experiencing persistent pain and increased tooth sensitivity.', 'Approved'),
(300027, 200011, 'Root Canal', '2023-03-30', '10:00:00', 'My 2nd Session for Root Canal Treatment.', 'Approved'),
(300028, 200011, 'Orthodontics Treatment', '2023-04-01', '09:30:00', '', 'Approved'),
(300029, 200013, 'Extraction', '2023-02-28', '10:00:00', '', 'Approved'),
(300030, 200017, 'Extraction', '2023-04-22', '11:00:00', '', 'Approved'),
(300031, 200024, 'Extraction', '2023-04-07', '13:30:00', '', 'Approved'),
(300032, 200029, 'Root Canal', '2023-05-20', '10:30:00', '', 'Approved'),
(300033, 200029, 'Root Canal', '2023-05-23', '10:00:00', '', 'Approved'),
(300034, 200029, 'Root Canal', '2023-05-26', '13:30:00', '', 'Approved'),
(300035, 200007, 'Restoration', '2023-06-14', '09:30:00', '', 'Approved'),
(300036, 200022, 'Restoration', '2023-06-14', '13:30:00', '', 'Approved'),
(300037, 200010, 'Crown', '2023-07-21', '09:30:00', '', 'Approved'),
(300038, 200010, 'Crown', '2023-07-23', '10:00:00', '', 'Approved'),
(300039, 200010, 'Crown', '2023-07-25', '10:30:00', 'I will have pay the full balance on the 4th session.', 'Approved'),
(300040, 200010, 'Crown', '2023-07-27', '10:00:00', '', 'Approved'),
(300041, 200013, 'Consultation, Orthodontics Treatment', '2023-11-24', '09:00:00', '', 'Pending'),
(300042, 200018, 'Bleaching', '2023-11-24', '13:30:00', '', 'Approved'),
(300043, 200021, 'Extraction', '2023-11-24', '08:00:00', '', 'Approved'),
(300044, 200043, 'Oral Prophylaxis', '2023-11-25', '08:30:00', '', 'Pending'),
(300045, 200044, 'Orthodontics Treatment', '2023-11-25', '10:00:00', '', 'Pending'),
(300046, 200019, 'Extraction', '2023-11-25', '13:00:00', '', 'Pending'),
(300047, 200017, 'Consultation', '2023-11-25', '14:30:00', '', 'Pending'),
(300048, 200014, 'Restoration', '2023-11-27', '09:00:00', '', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transactionID` int(10) NOT NULL,
  `patientID` int(10) DEFAULT NULL,
  `transChargeAmount` decimal(15,2) DEFAULT NULL,
  `transAmountPaid` decimal(15,2) DEFAULT NULL,
  `transDate` date DEFAULT NULL,
  `transTime` time DEFAULT current_timestamp(),
  `transNotes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transactionID`, `patientID`, `transChargeAmount`, `transAmountPaid`, `transDate`, `transTime`, `transNotes`) VALUES
(500001, 200011, 40000.00, 10000.00, '2023-01-25', '17:39:21', 'Orthodontics Treatment'),
(500002, 200011, 0.00, 1000.00, '2023-02-24', '17:40:07', 'Orthodontics Treatment'),
(500003, 200011, 8000.00, 5000.00, '2023-03-27', '17:40:41', 'Orthodontics Treatment, Root Canal'),
(500004, 200011, 0.00, 4000.00, '2023-03-30', '17:41:00', 'Root Canal'),
(500005, 200011, 0.00, 1000.00, '2023-04-01', '17:41:28', 'Orthodontics Treatment'),
(500006, 200013, 700.00, 700.00, '2023-02-28', '18:01:19', 'Extraction'),
(500007, 200017, 700.00, 700.00, '2023-04-22', '18:01:41', 'Extraction'),
(500008, 200024, 700.00, 700.00, '2023-04-07', '18:01:58', 'Extraction'),
(500009, 200029, 8000.00, 4000.00, '2023-05-20', '18:07:19', 'Root Canal'),
(500010, 200029, 0.00, 2000.00, '2023-05-23', '18:07:39', 'Root Canal'),
(500011, 200029, 0.00, 2000.00, '2023-05-26', '18:08:05', 'Root Canal'),
(500012, 200007, 1000.00, 1000.00, '2023-06-14', '18:11:41', 'Restoration'),
(500013, 200022, 1000.00, 1000.00, '2023-06-14', '18:12:00', 'Restoration'),
(500014, 200010, 10000.00, 4000.00, '2023-07-21', '18:18:27', 'Crown'),
(500015, 200010, 0.00, 2000.00, '2023-07-23', '18:18:37', 'Crown'),
(500016, 200010, 0.00, 4000.00, '2023-07-27', '18:19:00', 'Crown'),
(500017, 200011, 0.00, 1000.00, '2023-05-01', '17:41:28', 'Orthodontics Treatment'),
(500018, 200011, 0.00, 1000.00, '2023-06-01', '17:41:28', 'Orthodontics Treatment'),
(500019, 200011, 0.00, 1000.00, '2023-07-01', '17:41:28', 'Orthodontics Treatment');

-- --------------------------------------------------------

--
-- Structure for view `appointments`
--
DROP TABLE IF EXISTS `appointments`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `appointments`  AS SELECT `requests`.`requestID` AS `requestID`, `requests`.`patientID` AS `patientID`, `requests`.`requestServices` AS `requestServices`, `requests`.`requestDate` AS `requestDate`, `requests`.`requestTime` AS `requestTime`, `requests`.`requestNotes` AS `requestNotes`, `requests`.`requestStatus` AS `requestStatus` FROM `requests` WHERE `requests`.`requestStatus` = 'Approved' ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`accountID`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patientID`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`requestID`),
  ADD KEY `patientID` (`patientID`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transactionID`),
  ADD KEY `patientID_relation` (`patientID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `accountID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100006;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patientID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=200045;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `requestID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300049;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transactionID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=500020;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`patientID`) REFERENCES `patients` (`patientID`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `patientID_relation` FOREIGN KEY (`patientID`) REFERENCES `patients` (`patientID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
