-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 27, 2019 at 12:00 AM
-- Server version: 5.6.34-log
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mygym`
--

-- --------------------------------------------------------

--
-- Table structure for table `anatomy`
--

CREATE TABLE `anatomy` (
  `anatomy_id` int(11) NOT NULL,
  `anatomy_name` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `anatomy`
--

INSERT INTO `anatomy` (`anatomy_id`, `anatomy_name`) VALUES
(1, 'Neck'),
(2, 'Traps'),
(3, 'Shoulders'),
(4, 'Chest'),
(5, 'Biceps'),
(6, 'Forearm'),
(7, 'Abs'),
(8, 'Quads'),
(9, 'Calves'),
(10, 'Lats'),
(11, 'Triceps'),
(12, 'Middle Back'),
(13, 'Lower Back'),
(14, 'Glutes'),
(15, 'Hamstrings');

-- --------------------------------------------------------

--
-- Table structure for table `bmi`
--

CREATE TABLE `bmi` (
  `bmi_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `bmi_value` float NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bodyfat`
--

CREATE TABLE `bodyfat` (
  `data_id` int(11) NOT NULL,
  `Axilla_skinfold` int(11) NOT NULL,
  `Suprailiac_skinfold` int(11) NOT NULL,
  `Chest_skinfold` int(11) NOT NULL,
  `Tricep_skinfold` int(11) NOT NULL,
  `Abdominal_skinfold` int(11) NOT NULL,
  `Thigh_skinfold` int(11) NOT NULL,
  `Subscapular_skinfold` int(11) NOT NULL,
  `bodyfat` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bodyfat`
--

INSERT INTO `bodyfat` (`data_id`, `Axilla_skinfold`, `Suprailiac_skinfold`, `Chest_skinfold`, `Tricep_skinfold`, `Abdominal_skinfold`, `Thigh_skinfold`, `Subscapular_skinfold`, `bodyfat`, `member_id`, `date`, `status`) VALUES
(1, 10, 14, 12, 16, 15, 17, 13, 15, 9, '2018-08-13 22:50:37', 'Acceptable'),
(2, 10, 7, 10, 7, 10, 7, 10, 10, 9, '2018-08-13 23:02:05', 'Lean');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `category_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`, `category_status`) VALUES
(1, 'supplement', 'Active'),
(3, 'Accessories', 'Active'),
(4, 'Training Clothing', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `class`
--

CREATE TABLE `class` (
  `class_id` int(11) NOT NULL,
  `class_name` varchar(255) NOT NULL,
  `class_description` varchar(2500) NOT NULL,
  `instructor_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `color` varchar(10) NOT NULL COMMENT 'color of the class',
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive ,D = Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class`
--

INSERT INTO `class` (`class_id`, `class_name`, `class_description`, `instructor_id`, `image`, `color`, `status`) VALUES
(1, 'cardio', '', 0, '', '', 'A'),
(2, 'zumba', '', 0, '', '', 'A'),
(3, 'aerobic', '', 0, '', '', 'A'),
(4, 'Thaibo', '', 0, '', '', 'A'),
(5, 'crossFit', '', 0, '', '', 'A'),
(6, 'fat burn', 'Weight loss is simple: if you burn more calories than you consume, youâ€™ll drop pounds. But too many guys still underestimate how much they eat and overestimate how many calories they burn. Avoid the guesswork and keep a food journal for a week. Count up exactly how many calories youâ€™re averaging. You may be surprised', 4, '1526136030_slim-woman-measuring-her-waist-metric-tape-measure-23662153.jpg', '', 'A'),
(7, 'Yoga', 'ince the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including vers', 16, '', '', 'A'),
(8, 'Strength training', 'Strength training is a type of physical exercise specializing in the use of resistance to induce muscular contraction which builds the strength, anaerobic endurance, and size of skeletal muscles.', 5, '1526732152_Schlecht.jpg', '', 'A'),
(9, 'jklkj', 'k;kl;', 0, '', '', 'A'),
(10, 'fdhdfhfdhf', 'dhfdhdfhdhd', 4, '', '', 'A'),
(11, 'Abs', 'Abdominal exercises are those that affect the abdominal muscles.', 0, '1535291385_build-six-pack-abs-main.jpg', '', 'A'),
(12, 'fjhf', 'fhfghfg', 0, '', '', 'A'),
(13, 'yuyiyu', 'yuiyiy', 0, '', '', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `class_session`
--

CREATE TABLE `class_session` (
  `class_session_id` int(11) NOT NULL,
  `class_session_name` varchar(50) NOT NULL COMMENT 'Name of the class session',
  `class_id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `class_session`
--

INSERT INTO `class_session` (`class_session_id`, `class_session_name`, `class_id`, `day`, `start_time`, `end_time`, `status`) VALUES
(1, '', 7, 'Monday', '2019-05-05 09:00:00', '2019-05-05 10:30:00', 'A'),
(2, '', 5, 'Friday', '2019-05-05 13:00:00', '2019-05-05 15:00:00', 'A'),
(3, '', 4, 'Tuesday', '2019-05-05 05:00:00', '2019-05-05 07:00:00', 'A'),
(4, '', 0, '', '2019-05-05 00:02:00', '2019-05-05 23:01:00', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `contact_inbox`
--

CREATE TABLE `contact_inbox` (
  `contact_id` int(11) NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `time` datetime NOT NULL,
  `status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_inbox`
--

INSERT INTO `contact_inbox` (`contact_id`, `fname`, `lname`, `email`, `telephone`, `subject`, `message`, `time`, `status`) VALUES
(1, 'Lakshan Buddhika', 'Peramuna', 'peramuna100@outlook.com', '+94771188110', 'Best Gym Ever', 'HAHAHAHAHAHA', '0000-00-00 00:00:00', 'Delete'),
(2, 'sergio', 'ramos', 'xyz12345@live.com', '+94771188000', 'Best Gym Ever', 'wkdoqwjfioqewj', '0000-00-00 00:00:00', 'Delete'),
(3, 'Cristiano', 'Ronaldo', 'ronaldo7@gmail.com', '+94771888114', 'Best Gym', 'Thank you for everything', '2018-06-23 21:05:12', 'Read'),
(4, 'Bill', 'Anderson', 'billanderson@gamil.com', '+94771818145', 'I want to know about Zumba class', 'hahahahahhaha', '2018-06-24 19:46:23', 'Delete'),
(5, 'Liliana', 'Mejia', 'Mejia@maillinator.com', '+94771818110', 'Test', 'test123', '2018-07-01 23:53:33', 'Read'),
(6, 'Jan', 'Easterday', 'pglbuddhika@gmail.com', '+94771188110', 'test3', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', '2018-07-07 20:02:54', 'Read');

-- --------------------------------------------------------

--
-- Table structure for table `contact_outbox`
--

CREATE TABLE `contact_outbox` (
  `reply_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `reply` text NOT NULL,
  `time_out` datetime NOT NULL,
  `status_reply` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contact_outbox`
--

INSERT INTO `contact_outbox` (`reply_id`, `contact_id`, `staff_id`, `reply`, `time_out`, `status_reply`) VALUES
(1, 4, 12, 'okay', '2018-07-01 19:33:54', 'DeleteReply'),
(2, 4, 12, 'it\'s on Monday 9.00 AM to 10.00 AM', '2018-07-01 20:28:07', 'DeleteReply'),
(3, 4, 12, 'test', '2018-07-01 20:29:17', 'DeleteReply'),
(4, 5, 12, '', '2018-07-02 00:07:50', 'DeleteReply'),
(5, 6, 12, 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose injected humour and the like', '2018-07-07 20:30:15', 'Active'),
(6, 5, 12, 'hahahahahahha', '2018-08-04 23:36:45', 'Active'),
(7, 6, 12, 'it\'s happy to business with you', '2018-08-04 23:41:04', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(25) NOT NULL,
  `event_title` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `event_venue` varchar(50) NOT NULL,
  `event_description` varchar(2550) NOT NULL,
  `event_image` varchar(255) NOT NULL,
  `event_status` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_title`, `event_date`, `event_venue`, `event_description`, `event_image`, `event_status`) VALUES
(1, 'Z Gym New Year Party ', '2017-12-31', 'Hotel Sunshine', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum', '1522689355_rsz_shutterstock_520564297.jpg', 'Active'),
(2, 'Christmas Event 2018', '2018-12-30', 'Hotel White', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary', '1522906940_party.jpg', 'Active'),
(3, 'Mrs.Fitness', '2018-04-10', 'Z Gym', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. ', '1523187521_248681_1.jpg', 'Active'),
(4, 'Fitness Day 2018', '2018-08-29', 'Z Gym', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary', '1523187983_1350318146915.jpg', 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `exercise`
--

CREATE TABLE `exercise` (
  `exercise_id` int(11) NOT NULL,
  `exercise_name` varchar(200) NOT NULL,
  `anatomy_id` int(11) NOT NULL,
  `exercise_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exercise`
--

INSERT INTO `exercise` (`exercise_id`, `exercise_name`, `anatomy_id`, `exercise_status`) VALUES
(1, 'Isometric Neck Exercise - Front And Back', 1, 'Active'),
(2, 'Lying Face Down Plate Neck Resistance', 1, 'Active'),
(3, 'Seated Head Harness Neck Resistance', 1, 'Active'),
(4, 'Barbell Shrug', 2, 'Active'),
(5, 'Snatch Pull', 2, 'Active'),
(6, 'Upright Cable Row', 2, 'Active'),
(7, 'Arm Circles', 3, 'Active'),
(8, 'Arnold Dumbbell Press', 3, 'Active'),
(10, 'Barbell Bench Press - Medium Grip', 4, 'Active'),
(11, 'Dumbbell Flyes', 4, 'Active'),
(12, 'Pushups', 4, 'Active'),
(13, 'Barbell Curl', 5, 'Active'),
(14, 'Hammer Curls', 5, 'Active'),
(15, 'Overhead Cable Curl', 5, 'Active'),
(16, 'Palms-Down Dumbbell Wrist Curl Over A Bench', 6, 'Active'),
(17, 'Palms-Down Wrist Curl Over A Bench', 6, 'Active'),
(18, 'Palms-Up Barbell Wrist Curl Over A Bench', 6, 'Active'),
(19, 'Sit-Up', 7, 'Active'),
(20, 'Leg Pull-In', 7, 'Active'),
(21, 'Gorilla Chin/Crunch', 7, 'Active'),
(22, 'Barbell Full Squat', 8, 'Active'),
(23, 'Barbell Hack Squat', 8, 'Active'),
(24, 'Barbell Lunge', 8, 'Active'),
(25, 'Seated Calf Raise', 9, 'Active'),
(26, 'Calf Raise On A Dumbbell', 9, 'Active'),
(27, 'Donkey Calf Raises', 9, 'Active'),
(28, 'Close-Grip Front Lat Pulldown', 10, 'Active'),
(29, 'Pullups', 10, 'Active'),
(30, 'Wide-Grip Lat Pulldown', 10, 'Active'),
(31, 'Weighted Bench Dip', 11, 'Active'),
(32, 'Close-Grip Barbell Bench Press', 11, 'Active'),
(33, 'EZ-Bar Skullcrusher', 11, 'Active'),
(34, 'Bent Over Barbell Row', 12, 'Active'),
(35, 'Seated Cable Rows', 12, 'Active'),
(36, 'T-Bar Row with Handle', 12, 'Active'),
(37, 'Hyperextensions (Back Extensions)', 13, 'Active'),
(38, 'Stiff Leg Barbell Good Morning', 13, 'Active'),
(39, 'Stiff-Legged Barbell Deadlift\r\n', 13, 'Active'),
(40, 'Butt Lift (Bridge)', 14, 'Active'),
(41, 'Glute Kickback', 14, 'Active'),
(42, 'Leg Lift', 14, 'Active'),
(43, 'Barbell Lunge', 15, 'Active'),
(44, 'Dumbbell Lunges', 15, 'Active'),
(45, 'Flutter Kicks', 15, 'Active'),
(46, 'Low-Incline Barbell Bench Press', 4, 'Active'),
(50, 'Back Flyes - With Bands', 3, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `qty` int(15) NOT NULL,
  `unit_price` int(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `last_updated_time` datetime NOT NULL,
  `created_user` int(11) NOT NULL,
  `last_updated_user` int(11) NOT NULL,
  `item_status` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`item_id`, `item_name`, `category_id`, `qty`, `unit_price`, `created_time`, `last_updated_time`, `created_user`, `last_updated_user`, `item_status`) VALUES
(1, 'Serious Mass', 1, 7, 5000, '2018-08-27 23:46:20', '2018-08-27 23:46:20', 12, 12, 'Deleted'),
(2, 'Shoesfghjfg', 3, 365, 4000565, '2018-08-29 21:42:20', '2018-08-29 21:42:20', 12, 12, 'Deleted'),
(3, 'Premium Equipment Mat', 4, 24, 3500, '2018-09-01 12:00:12', '2018-09-08 21:33:40', 12, 14, 'Activate'),
(4, 'Shoes', 3, 20, 4000, '2018-09-01 12:03:19', '2018-09-01 12:03:19', 12, 12, 'Activate'),
(5, 'Shoes', 3, 20, 576, '2018-09-01 12:06:38', '2018-09-01 12:06:38', 12, 12, 'Activate'),
(6, 'Stretch Mat', 3, 12, 2500, '2018-09-08 21:34:49', '2018-09-08 21:34:49', 14, 14, 'Activate');

-- --------------------------------------------------------

--
-- Table structure for table `login_member`
--

CREATE TABLE `login_member` (
  `member_email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `login_status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_member`
--

INSERT INTO `login_member` (`member_email`, `password`, `member_id`, `login_status`) VALUES
('logan@xyz.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1, ''),
('aqua@jl.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 2, ''),
('lucky@lucky.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 3, ''),
('lucky@lucky.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 4, ''),
('lucky@lucky.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 5, ''),
('lucky@lucky.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 6, ''),
('ramsey@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 7, ''),
('isco@gmail.com', '5c07441561e48b0e48693d9b57fc9e268af9aba8', 9, ''),
('lucky@lucky.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 13, ''),
('lbpking100@live.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 15, ''),
('lakshan@fexcon.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 16, ''),
('peramuna69@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 17, ''),
('ppglbuddhika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 19, ''),
('pglbuddhika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 21, ''),
('lbperamuna@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 23, ''),
('pglbuddhika@gmail.com', '07ba9d9be49c2660bfe5a9050e540babbdfae97b', 24, ''),
('lakshan@fexcon.com', '17a133b310b4948f126b444af83487c482fe0e84', 25, ''),
('suko9991@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 26, 'Active');

-- --------------------------------------------------------

--
-- Table structure for table `login_staff`
--

CREATE TABLE `login_staff` (
  `staff_email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_staff`
--

INSERT INTO `login_staff` (`staff_email`, `password`, `staff_id`) VALUES
(' lbp@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 1),
('cr7@cr.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 12),
('frwere@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 6),
('lasithanishan@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 14),
('lbperamuna@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 4),
('nice@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 10),
('nimal@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 5),
('sanjayamaxx@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 7),
('vimukthi@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 17),
('xyz12345@live.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 16);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `member_id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(110) NOT NULL,
  `password` text NOT NULL COMMENT 'password of the member',
  `gender` char(1) NOT NULL COMMENT 'Male = M , Female = F',
  `dob` varchar(30) NOT NULL,
  `nic` varchar(20) NOT NULL,
  `telephone` varchar(30) NOT NULL,
  `address` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `package_id` int(11) NOT NULL COMMENT 'ID of the package ',
  `updated_by` int(11) NOT NULL COMMENT 'ID of the staff member who update the member',
  `lmd` datetime NOT NULL,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive, D = Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`member_id`, `first_name`, `last_name`, `email`, `password`, `gender`, `dob`, `nic`, `telephone`, `address`, `image`, `package_id`, `updated_by`, `lmd`, `status`) VALUES
(1, 'Logan', 'Jackmon', 'logan@xyz.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'm', '', '', '', '', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(2, 'Aqua', 'Khal', 'aqua@jl.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1992-03-06', '920940524V', '+94771888987', 'Gampaha', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(6, 'lakshan', 'peramuna', 'lucky@lucky.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1994-04-03', '940940524V', '+94771888110', 'Ja ela', '', 3, 1, '0000-00-00 00:00:00', 'I'),
(7, 'Aron', 'Ramsey', 'ramsey@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1993-04-04', '930940524V', '+94771888167', 'London', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(9, 'isco', 'alron', 'isco@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1982-04-03', '820940524V', '+771878141', 'Kandy', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(15, 'Natalia', 'jane', 'lbpking100@live.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'F', '1994-12-30', '947852654V', '+94776666218', 'London', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(16, 'Luka', 'Modric', '_lakshan@fexcon.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1994-02-03', '', '+94231666334', 'Spain', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(17, 'Alan', 'Steeve', 'peramuna69@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1999-10-27', '997456234V', '+94231666337', 'ja ela', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(19, 'Paul', 'Kroos', 'ppglbuddhika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1994-04-03', '947456234V', '+94231666334', 'Ja ela', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(21, 'Marco', 'Asensio', '_pglbuddhika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1993-03-03', '937456234V', '+94231666334', 'Spain', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(22, 'Marcelo', 'Jr', '_lbperamuna@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1993-02-03', '937456234V', '+94231666334', 'kluiklui', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(23, 'Harry', 'Kane', 'lbperamuna@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1997-07-07', '977456234V', '+94231666334', 'England', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(24, 'Mauro ', 'Icardi', 'pglbuddhika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1994-03-04', '947456234V', '+94231666334', 'Colombo', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(25, 'James', 'RodrÃ­guez', 'lakshan@fexcon.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1990-05-06', '907456234V', '+94231666334', 'Colombia', '', 0, 0, '0000-00-00 00:00:00', 'A'),
(26, 'Alvaro', 'Morata', 'suko9991@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1992-03-21', '927456234V', '+94231666334', 'Spain', '', 0, 0, '0000-00-00 00:00:00', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `membership`
--

CREATE TABLE `membership` (
  `membership_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `status` varchar(11) NOT NULL,
  `created_time` datetime NOT NULL,
  `lmd` datetime NOT NULL COMMENT 'Last Modified Time'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `membership`
--

INSERT INTO `membership` (`membership_id`, `member_id`, `package_id`, `start_date`, `end_date`, `status`, `created_time`, `lmd`) VALUES
(2, 21, 3, '2018-09-08 00:00:00', '2018-10-08 00:00:00', 'Active', '2018-09-08 13:42:21', '0000-00-00 00:00:00'),
(3, 23, 4, '2018-09-08 00:00:00', '2019-09-03 00:00:00', 'Active', '2018-09-08 16:44:00', '0000-00-00 00:00:00'),
(4, 24, 2, '2018-09-08 00:00:00', '2018-12-07 00:00:00', 'Active', '2018-09-08 17:40:32', '0000-00-00 00:00:00'),
(5, 25, 1, '2018-09-08 00:00:00', '2018-10-08 00:00:00', 'Active', '2018-09-08 18:08:47', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `member_log`
--

CREATE TABLE `member_log` (
  `log_id` int(11) NOT NULL,
  `log_in` datetime NOT NULL,
  `log_out` datetime NOT NULL,
  `log_ip` varchar(200) NOT NULL,
  `log_status` varchar(20) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member_log`
--

INSERT INTO `member_log` (`log_id`, `log_in`, `log_out`, `log_ip`, `log_status`, `member_id`) VALUES
(1, '2018-04-21 22:50:35', '0000-00-00 00:00:00', '::1', 'in', 6),
(2, '2018-04-21 23:08:39', '0000-00-00 00:00:00', '::1', 'in', 6),
(3, '2018-05-03 22:43:47', '0000-00-00 00:00:00', '::1', 'in', 14),
(4, '2018-05-04 21:44:07', '0000-00-00 00:00:00', '::1', 'in', 15),
(5, '2018-05-04 23:04:54', '0000-00-00 00:00:00', '::1', 'in', 15),
(6, '2018-05-26 10:48:51', '0000-00-00 00:00:00', '::1', 'in', 15),
(7, '2018-05-26 18:09:43', '0000-00-00 00:00:00', '::1', 'in', 15),
(8, '2018-05-26 22:49:37', '0000-00-00 00:00:00', '::1', 'in', 15),
(9, '2018-05-27 10:04:37', '0000-00-00 00:00:00', '::1', 'in', 15),
(10, '2018-05-27 20:46:13', '0000-00-00 00:00:00', '::1', 'in', 15),
(11, '2018-05-29 19:11:23', '0000-00-00 00:00:00', '::1', 'in', 15),
(12, '2018-06-02 20:24:46', '0000-00-00 00:00:00', '::1', 'in', 15),
(13, '2018-06-03 16:17:56', '0000-00-00 00:00:00', '::1', 'in', 15),
(14, '2018-06-10 21:38:10', '0000-00-00 00:00:00', '::1', 'in', 15),
(15, '2018-06-10 23:15:07', '0000-00-00 00:00:00', '::1', 'in', 15),
(16, '2018-06-17 14:47:27', '2018-06-17 14:48:27', '::1', 'out', 15),
(17, '2018-06-17 14:50:05', '0000-00-00 00:00:00', '::1', 'in', 15),
(18, '2018-07-08 19:44:37', '0000-00-00 00:00:00', '::1', 'in', 15),
(19, '2018-07-19 20:55:27', '0000-00-00 00:00:00', '::1', 'in', 15),
(20, '2018-07-22 07:57:36', '0000-00-00 00:00:00', '::1', 'in', 15),
(21, '2018-07-22 17:47:02', '0000-00-00 00:00:00', '::1', 'in', 15),
(22, '2018-07-22 23:35:09', '0000-00-00 00:00:00', '::1', 'in', 15),
(23, '2018-07-22 23:46:14', '0000-00-00 00:00:00', '::1', 'in', 15),
(24, '2018-07-25 20:16:50', '0000-00-00 00:00:00', '::1', 'in', 15),
(25, '2018-07-28 22:49:36', '0000-00-00 00:00:00', '::1', 'in', 15),
(26, '2018-07-29 09:11:50', '0000-00-00 00:00:00', '::1', 'in', 15),
(27, '2018-07-29 09:59:42', '0000-00-00 00:00:00', '::1', 'in', 15),
(28, '2018-07-29 10:08:55', '0000-00-00 00:00:00', '::1', 'in', 15),
(29, '2018-07-29 17:53:49', '0000-00-00 00:00:00', '::1', 'in', 15),
(30, '2018-08-03 09:14:54', '0000-00-00 00:00:00', '::1', 'in', 15),
(31, '2018-08-03 23:11:45', '0000-00-00 00:00:00', '::1', 'in', 9),
(32, '2018-08-04 07:15:45', '2018-08-04 07:18:45', '::1', 'out', 15),
(33, '2018-08-05 16:51:15', '2018-08-05 16:51:22', '::1', 'out', 9),
(34, '2018-08-05 16:51:36', '0000-00-00 00:00:00', '::1', 'in', 9),
(35, '2018-08-07 10:31:49', '0000-00-00 00:00:00', '::1', 'in', 9),
(36, '2018-08-07 11:04:03', '0000-00-00 00:00:00', '::1', 'in', 9),
(37, '2018-08-07 14:07:18', '2018-08-07 14:07:19', '::1', 'out', 9),
(38, '2018-08-07 14:07:27', '0000-00-00 00:00:00', '::1', 'in', 9),
(39, '2018-08-07 18:51:22', '0000-00-00 00:00:00', '::1', 'in', 9),
(40, '2018-08-07 19:06:57', '0000-00-00 00:00:00', '::1', 'in', 9),
(41, '2018-08-08 10:29:45', '0000-00-00 00:00:00', '::1', 'in', 15),
(42, '2018-08-08 10:35:18', '0000-00-00 00:00:00', '::1', 'in', 15),
(43, '2018-08-08 10:39:39', '0000-00-00 00:00:00', '::1', 'in', 9),
(44, '2018-08-08 10:42:22', '0000-00-00 00:00:00', '::1', 'in', 15),
(45, '2018-08-08 16:29:16', '0000-00-00 00:00:00', '::1', 'in', 9),
(46, '2018-08-09 09:41:31', '0000-00-00 00:00:00', '::1', 'in', 9),
(47, '2018-08-09 11:46:03', '0000-00-00 00:00:00', '::1', 'in', 9),
(48, '2018-08-10 09:44:30', '0000-00-00 00:00:00', '::1', 'in', 9),
(49, '2018-08-10 19:17:51', '0000-00-00 00:00:00', '::1', 'in', 15),
(50, '2018-08-11 01:27:13', '0000-00-00 00:00:00', '::1', 'in', 9),
(51, '2018-08-11 08:41:02', '0000-00-00 00:00:00', '::1', 'in', 9),
(52, '2018-08-11 19:29:07', '0000-00-00 00:00:00', '::1', 'in', 9),
(53, '2018-08-11 23:43:30', '0000-00-00 00:00:00', '::1', 'in', 9),
(54, '2018-08-12 11:11:26', '0000-00-00 00:00:00', '::1', 'in', 9),
(55, '2018-08-12 23:23:12', '0000-00-00 00:00:00', '::1', 'in', 9),
(56, '2018-08-13 21:40:53', '0000-00-00 00:00:00', '::1', 'in', 9),
(57, '2018-08-19 20:07:03', '0000-00-00 00:00:00', '::1', 'in', 9),
(58, '2018-08-22 20:16:56', '0000-00-00 00:00:00', '::1', 'in', 9),
(59, '2018-08-25 10:02:17', '0000-00-00 00:00:00', '::1', 'in', 9),
(60, '2018-09-02 00:09:54', '0000-00-00 00:00:00', '::1', 'in', 9),
(61, '2018-09-02 01:13:10', '0000-00-00 00:00:00', '::1', 'in', 16),
(62, '2018-09-02 11:31:32', '0000-00-00 00:00:00', '::1', 'in', 16),
(63, '2018-09-06 19:24:49', '0000-00-00 00:00:00', '::1', 'in', 9),
(64, '2018-09-06 21:34:15', '0000-00-00 00:00:00', '::1', 'in', 9),
(65, '2018-09-08 09:27:59', '0000-00-00 00:00:00', '::1', 'in', 9),
(66, '2018-09-08 18:10:42', '0000-00-00 00:00:00', '::1', 'in', 25),
(67, '2018-09-16 22:36:31', '0000-00-00 00:00:00', '::1', 'in', 9),
(68, '2018-09-30 13:19:56', '2018-09-30 16:40:22', '::1', 'out', 9),
(69, '2018-09-30 16:46:46', '2018-09-30 16:54:29', '::1', 'out', 9),
(70, '2018-09-30 16:54:38', '0000-00-00 00:00:00', '::1', 'in', 9),
(71, '2018-09-30 18:47:31', '2018-09-30 18:48:15', '::1', 'out', 9),
(72, '2018-09-30 18:48:19', '0000-00-00 00:00:00', '::1', 'in', 9),
(73, '2018-09-30 19:43:59', '0000-00-00 00:00:00', '::1', 'in', 9),
(74, '2018-09-30 19:46:44', '0000-00-00 00:00:00', '::1', 'in', 9),
(75, '2018-09-30 19:56:59', '0000-00-00 00:00:00', '::1', 'in', 9),
(76, '2018-10-03 16:58:47', '0000-00-00 00:00:00', '::1', 'in', 9),
(77, '2018-10-05 09:46:37', '0000-00-00 00:00:00', '::1', 'in', 9),
(78, '2018-10-05 09:54:30', '0000-00-00 00:00:00', '::1', 'in', 9),
(79, '2018-10-05 13:11:06', '0000-00-00 00:00:00', '::1', 'in', 9),
(80, '2018-10-06 10:46:15', '0000-00-00 00:00:00', '::1', 'in', 9);

-- --------------------------------------------------------

--
-- Table structure for table `module`
--

CREATE TABLE `module` (
  `module_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT 'Descriptions of modules',
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module`
--

INSERT INTO `module` (`module_id`, `name`, `description`, `status`) VALUES
(1, 'staff', '', 'A'),
(2, 'member', '', 'A'),
(3, 'payment', '', 'A'),
(4, 'package', '', 'A'),
(5, 'class', '', 'A'),
(6, 'class_schedule', '', 'A'),
(7, 'equipment', '', 'A'),
(8, 'subscription', '', 'A'),
(9, 'workout', '', 'A'),
(10, 'report', '', 'A'),
(11, 'message', '', 'A'),
(12, 'event', '', 'A'),
(13, 'backup', '', 'A'),
(14, 'tracking', '', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `module_role`
--

CREATE TABLE `module_role` (
  `module_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `module_role`
--

INSERT INTO `module_role` (`module_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(4, 2),
(5, 1),
(5, 2),
(6, 1),
(6, 2),
(6, 3),
(7, 1),
(7, 2),
(8, 1),
(8, 2),
(9, 1),
(9, 2),
(9, 3),
(10, 1),
(11, 1),
(11, 2),
(11, 3),
(12, 1),
(12, 2),
(12, 3),
(13, 1),
(13, 2),
(14, 1);

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `package_id` int(20) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `package_description` text NOT NULL,
  `fee` float NOT NULL,
  `duration` int(11) NOT NULL,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive, D = Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`package_id`, `package_name`, `package_description`, `fee`, `duration`, `status`) VALUES
(1, 'Basic', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,', 2000, 1, 'A'),
(2, 'Value Pack', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,', 5000, 3, 'D'),
(3, 'Gold', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,', 2000, 6, 'D'),
(4, 'Platinum', 'A personal trainer is an individual certified to have a varying degree of knowledge of general fitness involved in exercise prescription and instruction. They motivate clients by setting goals and providing feedback and accountability to clients. Wikipedia', 6000, 12, 'A');

-- --------------------------------------------------------

--
-- Table structure for table `register_member`
--

CREATE TABLE `register_member` (
  `reg_id` int(11) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `activation_code` varchar(255) NOT NULL,
  `email_status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `register_member`
--

INSERT INTO `register_member` (`reg_id`, `uname`, `email`, `password`, `activation_code`, `email_status`) VALUES
(2, 'peramuna', 'peramuna49@hotmail.com', 'e85918998d76c5a411de518f7fdfaffcf83407b4', '514f065de590aaab05e86e442bb0cd47', 'Unverified'),
(3, 'Lasitha', 'lakshan49@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '1006ff12c465532f8c574aeaa4461b16', 'Unverified'),
(4, 'Lasitha', 'lakshan49@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '8cff9bf6694dccfc3b6a613d05d51d16', 'Unverified'),
(5, 'Lasitha', 'lakshan49@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '412604be30f701b1b1e3124c252065e6', 'Unverified'),
(6, 'Lasitha', 'lakshan49@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '52bdba949576e6bcec5682a4993bfb58', 'Unverified'),
(7, 'Lasitha', 'lakshan49@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '908c9a564a86426585b29f5335b619bc', 'Unverified'),
(8, 'king', 'peramuna100@outlook.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'b5b03f06271f8917685d14cea7c6c50a', 'Unverified'),
(9, 'king', 'peramuna100@outlook.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '18f4af2e90e7feea928965095fbd4d31', 'Unverified'),
(10, 'king', 'peramuna100@outlook.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '373d71f842ca1c1bff5a1d8b1da9f1b2', 'Unverified'),
(11, 'king', 'peramuna100@outlook.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '42aa61c7ccfa95dc4db4d894530def8a', 'Unverified'),
(12, 'king', 'peramuna100@outlook.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '78c58f11547724e65c6fde2ddc7dfdfc', 'Unverified'),
(13, 'king', 'peramuna100@outlook.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '1fc5309ccc651bf6b5d22470f67561ea', 'Unverified'),
(14, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '5fd28676525f025716fa72429d241209', 'Unverified'),
(15, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'd53697441ef12a45422f6660202f9840', 'Unverified'),
(16, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'e834628a514af2290509181bf4348c6d', 'Unverified'),
(17, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '0d29d12b8c2169b35189bdffd68a7995', 'Unverified'),
(18, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '2e7f535455049bda7e8c9df49e3d293c', 'Unverified'),
(19, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'd4469ef60d8c2f45230bdb7ca7e3e053', 'Unverified'),
(20, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'a188f3460170e7c988fb9a27034f0f06', 'Unverified'),
(21, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '48f7170b9b4bc029d38adcc2d157027a', 'Unverified'),
(22, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'c64c1dc40ade60a3aba8332e10260c93', 'Unverified'),
(23, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '4b34cc1bf1623b6d6532ed63ff6ae276', 'Unverified'),
(24, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '178fd725f2be67a85fd2d73cc13cb753', 'Unverified'),
(25, 'siyabalapitiya', 'lbpcreations99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '675f9820626f5bc0afb47b57890b466e', 'Unverified'),
(33, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '42df59af01e92da78b4b264baf972f8d', 'Unverified'),
(34, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'bc44b9e1df4dfc8cbf8a5f08f4ac01a8', 'Unverified'),
(35, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '5ca3e9b122f61f8f06494c97b1afccf3', 'Unverified'),
(36, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '6595d842ae9e6c1ecfd9f976dcb8e058', 'Unverified'),
(37, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '961fbfb28115cd7e4197ae1441c67a6f', 'Unverified'),
(38, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '912575c953fa7add432c5c9db31fae70', 'Unverified'),
(39, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '1e8ca836c962598551882e689265c1c5', 'Unverified'),
(40, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '8606bdb6f1fa707fc6ca309943eea443', 'Unverified'),
(41, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '86158a6b3924670a32dad65bbc41bd95', 'Unverified'),
(42, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'f075ae724a0ea982e4f09f003990a0e7', 'Unverified'),
(43, 'admin', 'lbperamuna@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '52bdba949576e6bcec5682a4993bfb58', 'Unverified'),
(45, 'vimukthi', 'lbpastro123@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '9dcb88e0137649590b755372b040afad', 'Unverified'),
(49, 'okay', 'luckybanks99@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', 'e82ba7292d1c4fbfbf1933dc51f62e60', 'Unverified'),
(51, 'yasindu', 'yasindumadushan94@gmail.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '09963a393c5a37a7fda7a40e4ab52972', 'Unverified'),
(52, 'lahiru', 'lahiru@envoyortus.com', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', '3b2f2e18045234f3ff3479db338f727a', 'Unverified'),
(54, 'Lakshan123', 'pglbuddhika@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '8c86c617f818ea789cd189816f16455f', 'Confirmed'),
(55, 'Vishwani', 'lbpking100@live.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '238e625ff1f20b656f8986f42a76092f', 'Confirmed'),
(56, 'suko', 'suko9991@gmail.com', '203859ccae2e6263e60bfbd7593b12650a6d855d', '030e65da2b1c944090548d36b244b28d', 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `role_description` varchar(255) NOT NULL,
  `role_status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`role_id`, `role_name`, `role_description`, `role_status`) VALUES
(1, 'Manage staff', 'Users with this role can manage staff', 'A'),
(2, 'View Staff', 'Users with this role can view staff', 'A'),
(3, 'Manage Member', 'Users with this role can manage member', 'A'),
(4, 'View Member', 'Users with this role can view member', 'A'),
(5, 'View Staff Login log', 'Users with this role can view staff login log', 'A'),
(6, 'View Member Login log', 'Users with this role can view member login log', 'A'),
(7, 'View payment', 'Users with this role can view payment', 'A'),
(8, 'Manage Payment', 'Users with this role can manage payment', 'A'),
(9, 'View Package', 'Users with this role can view package', 'A'),
(10, 'Manage Package', 'Users with this role can manage package', 'A'),
(11, 'View Class', 'Users with this role can view class', 'A'),
(12, 'Manage Class', 'Users with this role can manage class', 'A'),
(13, 'View Class Schedule', 'Users with this role can view class schedule', 'A'),
(14, 'Manage Class Schedule', 'Users with this role can manage class schedule', 'A'),
(15, 'View Equipment', 'Users with this role can view equipment', 'A'),
(16, 'Manage Equipment', 'Users with this role can manage equipment', 'A'),
(17, 'View Subscription', 'Users with this role can view subscription', 'A'),
(18, 'Manage Subscription', 'Users with this role can manage subscription', 'A'),
(19, 'View Workout', 'Users with this role can view workout', 'A'),
(20, 'View Report', 'Users with this role can view report', 'A'),
(21, 'Manage Report', 'Users with this role can manage report', 'A'),
(22, 'View Message', 'Users with this role can view message', 'A'),
(23, 'Manage Message', 'Users with this role can manage message', 'A'),
(24, 'View Event', 'Users with this role can view event', 'A'),
(25, 'Manage Backup', 'Users with this role can manage backup', 'A'),
(26, 'Manage Workout', 'Users with this role can manage workout', 'A'),
(27, 'Manage Event', 'Users with this role can manage event', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL,
  `first_name` varchar(200) NOT NULL COMMENT 'first name of the user',
  `last_name` varchar(200) NOT NULL COMMENT 'last name of the user',
  `email` varchar(200) NOT NULL COMMENT 'email of the user',
  `password` text NOT NULL,
  `gender` char(1) NOT NULL COMMENT 'Male = M , Female = F',
  `dob` date NOT NULL,
  `nic` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL COMMENT 'telephone number of the user',
  `address` varchar(200) NOT NULL,
  `staff_type` char(1) NOT NULL COMMENT 'S = Super admin, A = Admin , M = Manager , T = Trainer',
  `image` text NOT NULL COMMENT 'image of the user',
  `lmd` datetime NOT NULL COMMENT 'Lat modified time',
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive ,D = Deleted , S = Suspended'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staff_id`, `first_name`, `last_name`, `email`, `password`, `gender`, `dob`, `nic`, `telephone`, `address`, `staff_type`, `image`, `lmd`, `status`) VALUES
(1, 'lakshan ', 'peramuna', 'pglbuddhika@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1994-04-03', '940940524V', '+94771888110', 'Bat cave', 'S', '', '0000-00-00 00:00:00', 'A'),
(4, 'bill', 'gates', 'lbperamuna@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1995-06-04', '', '0771888115', 'new york ', 'A', '', '0000-00-00 00:00:00', 'A'),
(5, 'nimal', 'bandara', 'nimal@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1991-07-04', '910910524V', '+9412345678', 'gampaha', 'T', '', '0000-00-00 00:00:00', 'A'),
(6, 'lucky', 'eryreye', 'frwere@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1993-05-07', '952458254V', '0771888116', 'London', 'M', '', '0000-00-00 00:00:00', 'A'),
(7, 'randy', 'gates', 'sanjayamaxx@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1996-08-06', '960910524V', '+9412345678', 'NJ', 'A', '', '0000-00-00 00:00:00', 'D'),
(10, 'Anne', 'nicey', 'nice@mail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'F', '1994-01-31', '94528452854V', '+9456234991', 'DC', 'M', '', '0000-00-00 00:00:00', 'A'),
(12, 'Cristiano', 'Ronaldo', 'cr7@cr.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1986-04-03', '862856157V', '+94123123464', 'Spain', 'S', '', '0000-00-00 00:00:00', 'A'),
(16, 'garath', 'bale', 'xyz12345@live.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1986-04-09', '860940524V', '+94771188122', 'Walse', 'M', '', '0000-00-00 00:00:00', 'A'),
(17, 'vimukthi', 'deshan', 'vimukthi@gmail.com', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'M', '1995-04-26', '950940924V', '+94123123468', 'Ja ela', 'T', '', '0000-00-00 00:00:00', 'A');

-- --------------------------------------------------------

--
-- Table structure for table `staff_log`
--

CREATE TABLE `staff_log` (
  `log_id` int(11) NOT NULL,
  `log_in` datetime NOT NULL,
  `log_out` datetime NOT NULL,
  `log_ip` varchar(200) NOT NULL,
  `log_status` varchar(20) NOT NULL,
  `staff_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_log`
--

INSERT INTO `staff_log` (`log_id`, `log_in`, `log_out`, `log_ip`, `log_status`, `staff_id`) VALUES
(1, '2019-05-18 10:16:08', '2019-05-18 22:36:03', '127.0.0.1', 'out', 1),
(2, '2019-05-18 22:36:08', '0000-00-00 00:00:00', '127.0.0.1', 'in', 1),
(3, '2019-05-19 18:53:54', '0000-00-00 00:00:00', '127.0.0.1', 'in', 1),
(4, '2019-05-19 19:07:50', '2019-05-19 20:41:19', '127.0.0.1', 'out', 1),
(5, '2019-05-19 20:41:24', '0000-00-00 00:00:00', '127.0.0.1', 'in', 1),
(6, '2019-05-25 12:42:29', '0000-00-00 00:00:00', '127.0.0.1', 'in', 1),
(7, '2019-05-25 23:00:47', '0000-00-00 00:00:00', '127.0.0.1', 'in', 1),
(8, '2019-05-26 17:26:00', '2019-05-26 17:43:18', '127.0.0.1', 'out', 1),
(9, '2019-05-26 17:43:30', '0000-00-00 00:00:00', '127.0.0.1', 'in', 1);

-- --------------------------------------------------------

--
-- Table structure for table `staff_role`
--

CREATE TABLE `staff_role` (
  `staff_role_id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff_role`
--

INSERT INTO `staff_role` (`staff_role_id`, `staff_id`, `role_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27);

-- --------------------------------------------------------

--
-- Table structure for table `temp_login`
--

CREATE TABLE `temp_login` (
  `member_email` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `temp_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `training_member`
--

CREATE TABLE `training_member` (
  `training_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `training_member`
--

INSERT INTO `training_member` (`training_id`, `member_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(3, 1),
(3, 2),
(4, 1),
(5, 1),
(5, 2),
(6, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user_message`
--

CREATE TABLE `user_message` (
  `user_message_id` int(11) NOT NULL,
  `from_user` int(11) NOT NULL,
  `to_user` int(11) NOT NULL,
  `time` datetime NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `type` varchar(5) NOT NULL,
  `status` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_message`
--

INSERT INTO `user_message` (`user_message_id`, `from_user`, `to_user`, `time`, `subject`, `message`, `type`, `status`) VALUES
(1, 15, 14, '2018-07-29 10:01:04', 'test', 'hello world', 'MM', 'Unread'),
(2, 15, 9, '2018-07-29 18:09:21', 'Hello', 'Hello Isco', 'MM', 'Read'),
(4, 15, 12, '2018-07-29 19:13:52', 'Hello CR7', 'You\'re the best in the world', 'MS', 'Read'),
(5, 15, 5, '2018-07-29 19:40:51', 'Hello', 'hello Nimal', 'MS', 'Unread'),
(6, 10, 12, '2018-07-29 20:33:11', 'Hello Nice', 'Test', 'SS', 'Read'),
(7, 12, 14, '2018-07-29 20:37:26', 'Hello Peramuna', 'hello peramuna', 'SM', 'Unread'),
(8, 14, 12, '2018-08-03 18:18:13', 'Hello CR7', 'You\'re the best', 'SS', 'Read'),
(9, 12, 14, '2018-08-03 19:06:12', 'Hello Lasitha', 'Hello ', 'SS', 'Read'),
(10, 12, 7, '2018-08-03 22:57:20', 'Hello Ramsey', 'Hello Ramsey', 'SM', 'Unread'),
(11, 9, 12, '2018-08-03 23:12:54', 'Welcome To Juventus', 'LOve you ', 'MS', 'Read'),
(12, 9, 14, '2018-08-05 16:52:22', 'Hello Mr', 'how do i find a good trainer', 'MS', 'Delete'),
(13, 14, 12, '2018-08-06 17:04:02', 'Hello Lasitha', 'I got your message thanks', 'SS', 'Read'),
(14, 14, 9, '2018-08-06 23:18:42', 'Hello Mr', 'hi iscooooooo', 'SM', 'Delete'),
(15, 14, 9, '2018-08-06 23:20:23', 'Hello Mr', 'hi iscooooooo', 'SM', 'Delete'),
(16, 14, 9, '2018-08-06 23:23:49', 'Hello Mr', 'hi iscooooooo', 'SM', 'Read'),
(17, 9, 14, '2018-08-07 22:07:30', 'Hello Mr', 'I got your message. thank you', 'MS', 'Unread'),
(18, 9, 15, '2018-08-07 22:40:01', 'Hello', 'Hello Natalia', 'MM', 'Unread'),
(19, 9, 15, '2018-08-08 10:40:31', 'Hi', 'Nice to see you in the gym back', 'MM', 'Unread'),
(20, 12, 15, '2018-08-08 10:41:48', 'Hi', 'test 12345', 'SM', 'Unread');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anatomy`
--
ALTER TABLE `anatomy`
  ADD PRIMARY KEY (`anatomy_id`);

--
-- Indexes for table `bmi`
--
ALTER TABLE `bmi`
  ADD PRIMARY KEY (`bmi_id`);

--
-- Indexes for table `bodyfat`
--
ALTER TABLE `bodyfat`
  ADD PRIMARY KEY (`data_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `class`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`class_id`);

--
-- Indexes for table `class_session`
--
ALTER TABLE `class_session`
  ADD PRIMARY KEY (`class_session_id`);

--
-- Indexes for table `contact_inbox`
--
ALTER TABLE `contact_inbox`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `contact_outbox`
--
ALTER TABLE `contact_outbox`
  ADD PRIMARY KEY (`reply_id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `exercise`
--
ALTER TABLE `exercise`
  ADD PRIMARY KEY (`exercise_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `login_member`
--
ALTER TABLE `login_member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `login_staff`
--
ALTER TABLE `login_staff`
  ADD PRIMARY KEY (`staff_email`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `membership`
--
ALTER TABLE `membership`
  ADD PRIMARY KEY (`membership_id`);

--
-- Indexes for table `member_log`
--
ALTER TABLE `member_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `module`
--
ALTER TABLE `module`
  ADD PRIMARY KEY (`module_id`);

--
-- Indexes for table `module_role`
--
ALTER TABLE `module_role`
  ADD PRIMARY KEY (`module_id`,`role_id`);

--
-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `register_member`
--
ALTER TABLE `register_member`
  ADD PRIMARY KEY (`reg_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `staff_log`
--
ALTER TABLE `staff_log`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `staff_role`
--
ALTER TABLE `staff_role`
  ADD PRIMARY KEY (`staff_role_id`);

--
-- Indexes for table `training_member`
--
ALTER TABLE `training_member`
  ADD PRIMARY KEY (`training_id`,`member_id`);

--
-- Indexes for table `user_message`
--
ALTER TABLE `user_message`
  ADD PRIMARY KEY (`user_message_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anatomy`
--
ALTER TABLE `anatomy`
  MODIFY `anatomy_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `bmi`
--
ALTER TABLE `bmi`
  MODIFY `bmi_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bodyfat`
--
ALTER TABLE `bodyfat`
  MODIFY `data_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `class`
--
ALTER TABLE `class`
  MODIFY `class_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `class_session`
--
ALTER TABLE `class_session`
  MODIFY `class_session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `contact_inbox`
--
ALTER TABLE `contact_inbox`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `contact_outbox`
--
ALTER TABLE `contact_outbox`
  MODIFY `reply_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `exercise`
--
ALTER TABLE `exercise`
  MODIFY `exercise_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `membership`
--
ALTER TABLE `membership`
  MODIFY `membership_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `member_log`
--
ALTER TABLE `member_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;
--
-- AUTO_INCREMENT for table `module`
--
ALTER TABLE `module`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `package_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `register_member`
--
ALTER TABLE `register_member`
  MODIFY `reg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `staff_log`
--
ALTER TABLE `staff_log`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `staff_role`
--
ALTER TABLE `staff_role`
  MODIFY `staff_role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `user_message`
--
ALTER TABLE `user_message`
  MODIFY `user_message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
