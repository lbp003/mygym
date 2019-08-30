-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: mygym
-- ------------------------------------------------------
-- Server version 	5.5.5-10.1.40-MariaDB
-- Date: Fri, 30 Aug 2019 12:10:54 +0530

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `anatomy`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `anatomy` (
  `anatomy_id` int(11) NOT NULL AUTO_INCREMENT,
  `anatomy_name` varchar(200) NOT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`anatomy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `anatomy`
--

LOCK TABLES `anatomy` WRITE;
/*!40000 ALTER TABLE `anatomy` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `anatomy` VALUES (1,'Neck','2019-08-25 22:33:55'),(2,'Traps','2019-08-25 22:33:55'),(3,'Shoulders','2019-08-25 22:33:55'),(4,'Chest','2019-08-25 22:33:55'),(5,'Biceps','2019-08-25 22:33:55'),(6,'Forearm','2019-08-25 22:33:55'),(7,'Abs','2019-08-25 22:33:55'),(8,'Quads','2019-08-25 22:33:55'),(9,'Calves','2019-08-25 22:33:55'),(10,'Lats','2019-08-25 22:33:55'),(11,'Triceps','2019-08-25 22:33:55'),(12,'Middle Back','2019-08-25 22:33:55'),(13,'Lower Back','2019-08-25 22:33:55'),(14,'Glutes','2019-08-25 22:33:55'),(15,'Hamstrings','2019-08-25 22:33:55');
/*!40000 ALTER TABLE `anatomy` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `anatomy` with 15 row(s)
--

--
-- Table structure for table `bmi`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bmi` (
  `bmi_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `height` float NOT NULL,
  `weight` float NOT NULL,
  `bmi_value` float NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(11) NOT NULL,
  PRIMARY KEY (`bmi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bmi`
--

LOCK TABLES `bmi` WRITE;
/*!40000 ALTER TABLE `bmi` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `bmi` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `bmi` with 0 row(s)
--

--
-- Table structure for table `bodyfat`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bodyfat` (
  `data_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `status` varchar(11) NOT NULL,
  PRIMARY KEY (`data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bodyfat`
--

LOCK TABLES `bodyfat` WRITE;
/*!40000 ALTER TABLE `bodyfat` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `bodyfat` VALUES (1,10,14,12,16,15,17,13,15,9,'2018-08-13 22:50:37','Acceptable'),(2,10,7,10,7,10,7,10,10,9,'2018-08-13 23:02:05','Lean');
/*!40000 ALTER TABLE `bodyfat` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `bodyfat` with 2 row(s)
--

--
-- Table structure for table `class`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) NOT NULL,
  `class_description` varchar(2500) NOT NULL,
  `image` varchar(255) NOT NULL,
  `color` varchar(10) NOT NULL COMMENT 'color of the class',
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive ,D = Deleted',
  PRIMARY KEY (`class_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `class` VALUES (1,'cardio','','','','2019-08-25 22:23:58','A'),(2,'zumba','','','','2019-08-25 22:23:58','A'),(3,'aerobic','','','','2019-08-25 22:23:58','A'),(4,'Thaibo','','','','2019-08-25 22:23:58','A'),(5,'crossFit','','','','2019-08-25 22:23:58','I'),(6,'fat burn','Weight loss is simple: if you burn more calories than you consume, youâ€™ll drop pounds. But too many guys still underestimate how much they eat and overestimate how many calories they burn. Avoid the guesswork and keep a food journal for a week. Count up exactly how many calories youâ€™re averaging. You may be surprised','1526136030_slim-woman-measuring-her-waist-metric-tape-measure-23662153.jpg','','2019-08-25 22:23:58','D'),(7,'Yoga','ince the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including vers','','','2019-08-25 22:23:58','D'),(8,'Strength training','Strength training is a type of physical exercise specializing in the use of resistance to induce muscular contraction which builds the strength, anaerobic endurance, and size of skeletal muscles.','1526732152_Schlecht.jpg','','2019-08-25 22:23:58','D'),(9,'jklkj','k;kl;','','','2019-08-25 22:23:58','A'),(10,'fdhdfhfdhf','dhfdhdfhdhd','','','2019-08-25 22:23:58','A'),(11,'Abs','Abdominal exercises are those that affect the abdominal muscles.','1535291385_build-six-pack-abs-main.jpg','','2019-08-25 22:23:58','D'),(12,'fjhf','fhfghfg','','','2019-08-25 22:23:58','D'),(13,'yuyiyu','yuiyiy','','','2019-08-25 22:23:58','A'),(14,'Nola Pollard','Nemo odio error atqu','','#000000','2019-08-25 22:23:58','A'),(15,'Ursa Franks','Iusto dolor consequa','','#8C2C2C','2019-08-25 22:23:58','A'),(16,'Carl Garza','Sint consequatur Du','','#18C618','2019-08-25 22:23:58','A'),(17,'Portia Burns','Eum et non est mini','IMG_17.webp','#584FB4','2019-08-25 22:23:58','A'),(18,'Bernard Pratt','Quis quo quaerat in ','IMG_18.jpg','#D5B551','2019-08-25 22:23:58','A'),(19,'Cherokee Beasley','Velit atque tempore','IMG_19.','#000000','2019-08-27 12:31:01','A'),(20,'Clio Conway','Est magni in quo ve','','#A03939','2019-08-27 18:58:11','A');
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `class` with 20 row(s)
--

--
-- Table structure for table `class_session`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class_session` (
  `class_session_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_session_name` varchar(50) NOT NULL COMMENT 'Name of the class session',
  `class_id` int(11) NOT NULL,
  `day` varchar(20) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `instructor_id` int(11) NOT NULL COMMENT 'ID of the instructor',
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive',
  PRIMARY KEY (`class_session_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class_session`
--

LOCK TABLES `class_session` WRITE;
/*!40000 ALTER TABLE `class_session` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `class_session` VALUES (1,'Morning session',17,'Mon','08:00:00','11:30:00',46,'2019-08-25 22:24:44','D'),(2,'Friday Special',4,'Fri','14:00:00','16:00:00',35,'2019-08-25 22:24:44','A'),(3,'Good Morning Tuesday',4,'Tue','05:00:00','07:00:00',50,'2019-08-25 22:24:44','D'),(4,'',0,'','00:02:00','23:01:00',0,'2019-08-25 22:24:44','D'),(5,'Clark Henry',3,'Thu','06:30:00','08:30:00',21,'2019-08-25 22:24:44','A'),(6,'Kibo Potts Sunday',14,'Sun','08:00:00','10:00:00',21,'2019-08-25 22:24:44','D');
/*!40000 ALTER TABLE `class_session` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `class_session` with 6 row(s)
--

--
-- Table structure for table `equipment`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the equipment',
  `equipment_name` varchar(100) NOT NULL COMMENT 'Name of the equipment',
  `equipment_description` varchar(255) NOT NULL COMMENT 'Descriptions of equipment',
  `image` varchar(255) NOT NULL COMMENT 'image of the equipment',
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last modified date of the equipment',
  `status` char(1) NOT NULL COMMENT 'A - Active,I - Inactive , D -Deleted',
  PRIMARY KEY (`equipment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `equipment`
--

LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `equipment` VALUES (1,'Cables and Pulleys','Very diverse workout machine in the amount and types of exercises that can be performed by attaching grips to the end of the cables..','IMG_1.png','2019-08-26 08:02:43','A'),(2,'Squat Rack','Where serious squatting takes place. In fitness and strength training, the squat exercise trains your fully body.  All serious strength training regiments should incorporate the squat station gym equipment.','IMG_2.png','2019-08-26 08:02:11','A'),(3,'Brynne Whitley','Reprehenderit sint ','IMG_3.webp','2019-08-26 12:00:24','D'),(4,'Ulric Thompson','Officia tempora exer','IMG_4.','2019-08-29 16:28:37','D'),(5,'Thane Chang','Dolor quia recusanda','','2019-08-27 19:01:27','A');
/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `equipment` with 5 row(s)
--

--
-- Table structure for table `event`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `event_id` int(25) NOT NULL AUTO_INCREMENT,
  `event_title` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `event_venue` varchar(50) NOT NULL,
  `event_description` varchar(2550) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive, D = Deleted',
  PRIMARY KEY (`event_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `event` VALUES (1,'Z Gym New Year Party ','2017-12-31',NULL,NULL,'Hotel Sunshine','Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum','','2019-08-25 22:32:54','A'),(2,'Christmas Event 2018','2018-12-30',NULL,NULL,'Hotel White','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary','','2019-08-25 22:32:54','A'),(3,'Mrs.Fitness','2018-04-10',NULL,NULL,'Z Gym','It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. ','','2019-08-25 22:32:54','A'),(4,'Fitness Day 2018','2018-08-29',NULL,NULL,'Z Gym','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary','','2019-08-27 18:42:32','D'),(5,'Assumenda veniam ea','2019-10-27','00:00:00','00:00:00','Qui necessitatibus n','Cupiditate dolor est','IMG_5.jpg','2019-08-27 00:51:26','A'),(6,'Irure duis ea incidi','2019-06-26','00:00:00','00:00:00','Eius officia nihil o','Aliquam consectetur ','IMG_6.jpg','2019-08-27 11:50:27','A'),(7,'Laborum Laboris cul','2021-01-22','07:25:00','21:13:00','Recusandae Sit temp','Culpa qui voluptati','IMG_7.jpg','2019-08-27 17:24:19','A'),(8,'Dolores sed perspici','2020-03-20','03:00:00','19:40:00','Quisquam sit quo vol','Soluta est illum ex',NULL,'2019-08-27 17:23:43','A'),(9,'Dolore ut aliquip se','2019-02-09','05:13:00','08:00:00','Sit laudantium quia','Voluptatem culpa fu',NULL,'2019-08-27 18:40:35','A'),(10,'Vel aut est quia nis','1983-05-22','00:00:00','00:00:00','Consectetur iusto v','Aut repudiandae unde',NULL,'2019-08-27 18:40:23','I'),(11,'Ab voluptatibus sint','2009-05-01','04:17:00','06:50:00','Voluptatem omnis dol','Amet voluptate veni',NULL,'2019-08-27 18:39:58','D'),(12,'Molestiae nobis dolo','2020-07-18','12:47:00','16:14:00','Ab nihil aut suscipi','Voluptate repellendu',NULL,'2019-08-27 18:19:08','I');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `event` with 12 row(s)
--

--
-- Table structure for table `exercise`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `exercise` (
  `exercise_id` int(11) NOT NULL AUTO_INCREMENT,
  `exercise_name` varchar(200) NOT NULL,
  `anatomy_id` int(11) NOT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive, D = Deleted',
  PRIMARY KEY (`exercise_id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `exercise`
--

LOCK TABLES `exercise` WRITE;
/*!40000 ALTER TABLE `exercise` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `exercise` VALUES (1,'Isometric Neck Exercise - Front And Back',1,'2019-08-25 22:32:25','A'),(2,'Lying Face Down Plate Neck Resistance',1,'2019-08-25 22:32:25','A'),(3,'Seated Head Harness Neck Resistance',1,'2019-08-25 22:32:25','A'),(4,'Barbell Shrug',2,'2019-08-25 22:32:25','A'),(5,'Snatch Pull',2,'2019-08-25 22:32:25','A'),(6,'Upright Cable Row',2,'2019-08-25 22:32:25','A'),(7,'Arm Circles',3,'2019-08-26 19:23:52','A'),(8,'Arnold Dumbbell Press',3,'2019-08-25 22:32:25','A'),(10,'Barbell Bench Press - Medium Grip',4,'2019-08-25 22:32:25','A'),(11,'Dumbbell Flyes',4,'2019-08-25 22:32:25','A'),(12,'Pushups',4,'2019-08-25 22:32:25','A'),(13,'Barbell Curl',5,'2019-08-25 22:32:25','A'),(14,'Hammer Curls',5,'2019-08-25 22:32:25','A'),(15,'Overhead Cable Curl',5,'2019-08-25 22:32:25','A'),(16,'Palms-Down Dumbbell Wrist Curl Over A Bench',6,'2019-08-25 22:32:25','A'),(17,'Palms-Down Wrist Curl Over A Bench',6,'2019-08-25 22:32:25','A'),(18,'Palms-Up Barbell Wrist Curl Over A Bench',6,'2019-08-25 22:32:25','A'),(19,'Sit-Up',7,'2019-08-25 22:32:25','A'),(20,'Leg Pull-In',7,'2019-08-25 22:32:25','A'),(21,'Gorilla Chin/Crunch',7,'2019-08-25 22:32:25','A'),(22,'Barbell Full Squat',8,'2019-08-25 22:32:25','A'),(23,'Barbell Hack Squat',8,'2019-08-25 22:32:25','A'),(24,'Barbell Lunge',8,'2019-08-25 22:32:25','A'),(25,'Seated Calf Raise',9,'2019-08-25 22:32:25','A'),(26,'Calf Raise On A Dumbbell',9,'2019-08-25 22:32:25','A'),(27,'Donkey Calf Raises',9,'2019-08-25 22:32:25','A'),(28,'Close-Grip Front Lat Pulldown',10,'2019-08-25 22:32:25','A'),(29,'Pullups',10,'2019-08-25 22:32:25','A'),(30,'Wide-Grip Lat Pulldown',10,'2019-08-25 22:32:25','A'),(31,'Weighted Bench Dip',11,'2019-08-25 22:32:25','A'),(32,'Close-Grip Barbell Bench Press',11,'2019-08-25 22:32:25','A'),(33,'EZ-Bar Skullcrusher',11,'2019-08-25 22:32:25','A'),(34,'Bent Over Barbell Row',12,'2019-08-25 22:32:25','A'),(35,'Seated Cable Rows',12,'2019-08-25 22:32:25','A'),(36,'T-Bar Row with Handle',12,'2019-08-25 22:32:25','A'),(37,'Hyperextensions (Back Extensions)',13,'2019-08-25 22:32:25','A'),(38,'Stiff Leg Barbell Good Morning',13,'2019-08-25 22:32:25','A'),(39,'Stiff-Legged Barbell Deadlift\r\n',13,'2019-08-25 22:32:25','A'),(40,'Butt Lift (Bridge)',14,'2019-08-25 22:32:25','A'),(41,'Glute Kickback',14,'2019-08-25 22:32:25','A'),(42,'Leg Lift',14,'2019-08-25 22:32:25','A'),(43,'Barbell Lunge',15,'2019-08-25 22:32:25','A'),(44,'Dumbbell Lunges',15,'2019-08-25 22:32:25','A'),(45,'Flutter Kicks',15,'2019-08-25 22:32:25','A'),(46,'Low-Incline Barbell Bench Press',4,'2019-08-25 22:32:25','A'),(50,'Back Flyes - With Bands',3,'2019-08-25 22:32:25','A'),(51,'Lee Levy',7,'2019-08-26 18:55:44','D');
/*!40000 ALTER TABLE `exercise` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `exercise` with 47 row(s)
--

--
-- Table structure for table `member`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_number` varchar(10) NOT NULL,
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
  `created_by` int(11) NOT NULL COMMENT 'created staff member',
  `updated_by` int(11) NOT NULL COMMENT 'ID of the staff member who update the member',
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive, D = Deleted',
  PRIMARY KEY (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=59 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `member` VALUES (1,'','Logan','Jackmon','logan@xyz.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','m','','','','','',0,0,0,'0000-00-00 00:00:00','A'),(2,'','Aqua','Khal','aqua@jl.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1992-03-06','920940524V','+94771888987','Gampaha','',0,0,0,'0000-00-00 00:00:00','A'),(6,'','lakshan','peramuna','lucky@lucky.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1994-04-03','940940524V','+94771888110','Ja ela','',3,0,1,'0000-00-00 00:00:00','I'),(7,'','Aron','Ramsey','ramsey@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1993-04-04','930940524V','+94771888167','London','',0,0,0,'0000-00-00 00:00:00','A'),(9,'','isco','alron','isco@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1982-04-03','820940524V','+771878141','Kandy','',0,0,0,'0000-00-00 00:00:00','A'),(15,'','Natalia','jane','lbpking100@live.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','F','1994-12-30','947852654V','+94776666218','London','',0,0,0,'0000-00-00 00:00:00','A'),(16,'','Luka','Modric','_lakshan@fexcon.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1994-02-03','','+94231666334','Spain','',0,0,0,'0000-00-00 00:00:00','A'),(17,'','Alan','Steeve','peramuna69@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1999-10-27','997456234V','+94231666337','ja ela','',0,0,0,'0000-00-00 00:00:00','A'),(19,'','Paul','Kroos','ppglbuddhika@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1994-04-03','947456234V','+94231666334','Ja ela','',0,0,0,'0000-00-00 00:00:00','A'),(21,'','Marco','Asensio','_pglbuddhika@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1993-03-03','937456234V','+94231666334','Spain','',0,0,0,'0000-00-00 00:00:00','A'),(22,'','Marcelo','Jr','_lbperamuna@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1993-02-03','937456234V','+94231666334','kluiklui','',0,0,0,'0000-00-00 00:00:00','A'),(23,'','Harry','Kane','lbperamuna@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1997-07-07','977456234V','+94231666334','England','',0,0,0,'0000-00-00 00:00:00','A'),(24,'','Mauro ','Icardi','pglbuddhika@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1994-03-04','947456234V','+94231666334','Colombo','',0,0,0,'2019-08-29 01:01:05','I'),(25,'','James','RodrÃ­guez','lakshan@fexcon.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1990-05-06','907456234V','+94231666334','Colombia','',4,0,0,'2019-08-29 19:05:02','A'),(26,'','Alvaro','Morata','suko9991@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1992-03-21','927456234V','+94231666334','Spain','',0,0,0,'0000-00-00 00:00:00','A'),(27,'986','Sopoline','Harper','nakelahoty@mailinator.net','617f28ac08200aabe718976e778c27cf0399dfcb','M','2006-02-24','Doloremque quia saep','+94493388594','Ut dicta eum et est ','',1,1,1,'2019-07-24 22:37:07','A'),(28,'736','Zahir','Mccarty','lozene@mailinator.com','177fa5356d4f1f23ad551b76c946601877c4c536','M','1977-07-20','Consequatur aut occa','+94053648880','Consequatur Incidid','',4,1,1,'2019-07-24 23:27:51','A'),(29,'602','Ronan','Dyer','lofuvezi@mailinator.com','3f64af195ca5114987dfd1e180c2308e079e1dac','M','1996-07-18','Aut quo sunt commodi','+94074157097','Aspernatur est porro','',4,1,1,'2019-07-24 23:36:21','A'),(30,'531','MacKensie','Aguilar','pyquk@mailinator.net','8d8c4c93e46a90f3c3d87124d9aff703cff25b84','M','2010-10-18','Omnis autem aut enim','+94704795577','Excepteur ut nesciun','',1,1,1,'2019-07-24 23:47:57','A'),(31,'126','Jasmine','Stevens','bimyqehyly@mailinator.com','42cf7566b7dcc06fbfc1deefc29603215c5936b1','F','2010-11-18','Necessitatibus ipsum','+94232562997','Non sint dolore ut ','',1,1,1,'2019-07-24 23:49:34','A'),(32,'602','April','Beach','fovyb@mailinator.net','2ec99637abce81611b790154fc75a1c708237d1f','M','1973-02-24','Magnam occaecat eu t','+94416291847','Natus pariatur Nihi','',1,1,1,'2019-07-24 23:51:05','A'),(33,'696','Buckminster','Estes','noviqo@mailinator.net','5c980ec44ad4ab974fb1598b0525ede1011e5bcf','F','1970-10-26','Sequi dolor ea velit','+94285947383','Eos debitis sed aspe','',4,1,1,'2019-07-27 19:34:02','A'),(34,'534','Heidi','Lucas','padaceq@mailinator.net','a87b092a2cdd8cf281bb57f906af3c821af51efd','M','2002-07-10','Soluta aut qui quia ','+94439763617','Est sit fugiat rer','',4,1,1,'2019-07-27 19:35:08','A'),(35,'845','Ira','Burch','vinugivyn@mailinator.net','2ce8be33c7fc4b8b60272becc222672b43929b61','M','2016-07-25','Magna aut soluta exe','+94260769001','Cumque est nostrum ','',4,1,1,'2019-07-27 19:35:36','A'),(36,'681','Dillon','Russell','fobozib@mailinator.net','c813a84766e0e351c18d88dd44a4419e8269b3dd','F','1983-06-01','Magna tempora ea qui','+94310319754','Est incidunt aut ve','',1,1,1,'2019-07-27 19:56:44','A'),(37,'649','Gil','Bowen','gujydagud@mailinator.com','2dd78dbe8c682f614f6e85ec4632ad0bd77b60cf','M','1984-09-22','Vero sed sit ut exc','+94857989045','Minima ut aut repudi','',1,1,1,'2019-07-27 19:58:29','A'),(38,'663','Ori','Henderson','kunab@mailinator.net','3c1b4d64069b0f999a9c947ab10d86bf6cb972fb','F','1980-05-22','Modi aut cupidatat q','+94601741571','Est modi corrupti a','',1,1,1,'2019-07-27 19:59:00','A'),(39,'979','Linus','Riley','zaxaguleq@mailinator.com','035d5e8b0c858249d6ed80925ce122490ce35798','M','2009-02-13','Ratione aut eos poss','+94852618925','Lorem beatae in qui ','',4,1,1,'2019-07-28 09:49:50','A'),(40,'248','Adrian','Huffman','xatehaxur@mailinator.com','f3927bbe5f8a4e99e9a792070075bba21b5406fa','F','1981-06-14','Temporibus exercitat','+94249089679','Veniam sed et facer','',4,1,1,'2019-07-28 10:39:35','A'),(41,'139','Veda','Cruz','xebav@mailinator.com','c3dcbc5beead6d1eba1bfc54ca6b795370ec5553','F','1978-12-28','Non enim consequatur','+94591045727','Commodo sunt iure i','',4,1,1,'2019-07-28 11:01:04','I'),(42,'817','Quinn','Gillespie','xuqixenus@mailinator.net','a547c0629688fb3c6d1d9b399fea0817d35f3a77','M','2019-10-09','Harum et incidunt f','+94677509613','Nemo perferendis dol','',4,1,1,'2019-07-28 12:30:01','A'),(43,'111','Xaviera','Oneill','hopehef@mailinator.com','ad3b575578a23676a5d5e5564b4d2092bdb102f1','F','1994-09-03','Repellendus Molesti','+94576835704','Error laboris accusa','',1,1,1,'2019-07-28 12:32:11','A'),(44,'201','Addison','Steele','lalom@mailinator.com','191a5c9ed901c7015ae161e7d7a77e87891c87d3','M','1974-02-11','Optio dolores offic','+94430776695','Sit facere nobis lab','',4,1,1,'2019-07-31 21:55:35','A'),(45,'168','Colton','Macias','joxyjoruki@mailinator.net','9df1611bd281c7a8be413661df2a20bdf4c3074b','M','2008-06-15','Consequuntur dolores','+94257590170','Rem omnis laboris ex','IMG_45.',1,1,1,'2019-08-25 18:31:05','D'),(46,'933','Walker','Floyd','toqybitu@mailinator.com','b80ac11fc9ffd9f13a73a76662d5be0140e271d2','M','2005-11-05','Dolorem aut voluptat','+94766443218','Consequatur reprehe','IMG_46.',4,1,1,'2019-07-31 21:48:20','I'),(47,'988','Castor','Cabrera','gukuruv@mailinator.net','8322cd9de80baf0efce3263b6182036b32336bbd','F','2007-07-16','Autem maiores sint i','+94662056696','Voluptas id et iste ','IMG_47.',4,1,1,'2019-07-31 21:28:30','D'),(48,'843','Clinton','Freeman','kajomicumy@mailinator.net','31f95fb4b78739d76b28165315c881b20b9ffcaf','F','1986-08-17','Assumenda exercitati','+94994715664','Ut consequatur prov','IMG_48.',4,1,1,'2019-07-31 21:24:01','I'),(49,'764','Tucker','Villarreal','lysumefat@mailinator.net','5366a702d2aa5471cb5cdd23d521db5eaa0d8194','M','1985-11-24','856765345V','94123435779','In est debitis atqu','IMG_49.jpg',4,1,1,'2019-07-29 23:56:30','A'),(50,'651','Scarlet','Camacho','xysih@mailinator.com','a20975b49d1e0550b45dba575dc1dd33bbc16283','F','1971-01-05','Deleniti dignissimos','+94031586444','Non consequatur Cum','IMG_50.',4,1,1,'2019-07-31 21:20:14','A'),(51,'129','Blaze','Whitehead','hunusis@mailinator.com','8e4ac3fb17301f6754436aad0389cb2d27c42ad0','M','1996-02-21','967452345V','+94658015632','Quia sed dolorem cul','IMG_51.',1,1,1,'2019-08-28 10:29:33','D'),(52,'390','Jolene','Harrington','pixydidijo@mailinator.com','7745468c7ed439c5c74eaea7133a54113cee1870','M','1977-03-12','1234567890V','94467893363','Vel quia officia lab','',4,1,1,'2019-08-28 11:09:35','A'),(53,'520','Brent','Wise','rywoco@mailinator.net','3606c3bf463480373745b2df4d5c784fbe5a94b2','M','1987-01-02','567345234V','94719621456','Sequi tempore aliqu','',1,1,1,'2019-08-28 11:29:03','A'),(54,'890','Molly','Larson','rireqahy@mailinator.com','7640eb4db804b5f0234c5e130b05f05ddccc8739','F','1994-06-06','Distinctio Sit con','94546444670','Rerum quod iste in q','',5,1,1,'2019-08-28 11:57:28','A'),(55,'667','Peter','Vaughan','pavovy@mailinator.net','327ae08a32c7ab0aebd0ea08378b1114c2611628','M','1991-11-09','Beatae illo incididu','94335205027','Ex minim magnam ut s','',4,1,1,'2019-08-28 11:58:52','A'),(56,'279','Brynn','Herman','mihucyt@mailinator.net','714aff77f4b166f6867d7b4b616179e1a2ce79c1','M','1982-03-16','Pariatur Minim quas','94248792179','Quae vel exercitatio','',4,1,1,'2019-08-28 12:41:39','A'),(57,'947','Tana','Beck','reqozitoq@mailinator.net','066a5e1ec125cdf3a4ee50d417841f43a732bb61','M','1978-05-04','Non est tempora fugi','94463530175','Eligendi quidem dolo','',1,1,1,'2019-08-28 12:54:10','A'),(58,'246','Hollee','Perkins','lohuriv@mailinator.com','3f23bbc0e3c31eb8b35f1b0426313f20205248e7','M','1990-02-04','Non exercitation ad ','94257893326','Et dolore ipsum tem','',1,1,1,'2019-08-28 23:31:42','A');
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `member` with 47 row(s)
--

--
-- Table structure for table `member_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_in` datetime NOT NULL,
  `log_out` datetime NOT NULL,
  `log_ip` varchar(200) NOT NULL,
  `status` char(1) NOT NULL COMMENT 'I = IN , O = OUT',
  `member_id` int(11) NOT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member_log`
--

LOCK TABLES `member_log` WRITE;
/*!40000 ALTER TABLE `member_log` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `member_log` VALUES (1,'2018-04-21 22:50:35','0000-00-00 00:00:00','::1','I',6,'2019-08-25 22:28:41'),(2,'2018-04-21 23:08:39','0000-00-00 00:00:00','::1','I',6,'2019-08-25 22:28:41'),(3,'2018-05-03 22:43:47','0000-00-00 00:00:00','::1','I',14,'2019-08-25 22:28:41'),(4,'2018-05-04 21:44:07','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(5,'2018-05-04 23:04:54','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(6,'2018-05-26 10:48:51','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(7,'2018-05-26 18:09:43','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(8,'2018-05-26 22:49:37','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(9,'2018-05-27 10:04:37','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(10,'2018-05-27 20:46:13','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(11,'2018-05-29 19:11:23','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(12,'2018-06-02 20:24:46','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(13,'2018-06-03 16:17:56','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(14,'2018-06-10 21:38:10','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(15,'2018-06-10 23:15:07','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(16,'2018-06-17 14:47:27','2018-06-17 14:48:27','::1','O',15,'2019-08-25 22:28:41'),(17,'2018-06-17 14:50:05','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(18,'2018-07-08 19:44:37','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(19,'2018-07-19 20:55:27','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(20,'2018-07-22 07:57:36','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(21,'2018-07-22 17:47:02','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(22,'2018-07-22 23:35:09','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(23,'2018-07-22 23:46:14','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(24,'2018-07-25 20:16:50','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(25,'2018-07-28 22:49:36','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(26,'2018-07-29 09:11:50','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(27,'2018-07-29 09:59:42','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(28,'2018-07-29 10:08:55','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(29,'2018-07-29 17:53:49','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(30,'2018-08-03 09:14:54','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(31,'2018-08-03 23:11:45','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(32,'2018-08-04 07:15:45','2018-08-04 07:18:45','::1','O',15,'2019-08-25 22:28:41'),(33,'2018-08-05 16:51:15','2018-08-05 16:51:22','::1','O',9,'2019-08-25 22:28:41'),(34,'2018-08-05 16:51:36','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(35,'2018-08-07 10:31:49','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(36,'2018-08-07 11:04:03','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(37,'2018-08-07 14:07:18','2018-08-07 14:07:19','::1','O',9,'2019-08-25 22:28:41'),(38,'2018-08-07 14:07:27','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(39,'2018-08-07 18:51:22','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(40,'2018-08-07 19:06:57','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(41,'2018-08-08 10:29:45','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(42,'2018-08-08 10:35:18','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(43,'2018-08-08 10:39:39','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(44,'2018-08-08 10:42:22','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(45,'2018-08-08 16:29:16','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(46,'2018-08-09 09:41:31','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(47,'2018-08-09 11:46:03','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(48,'2018-08-10 09:44:30','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(49,'2018-08-10 19:17:51','0000-00-00 00:00:00','::1','I',15,'2019-08-25 22:28:41'),(50,'2018-08-11 01:27:13','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(51,'2018-08-11 08:41:02','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(52,'2018-08-11 19:29:07','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(53,'2018-08-11 23:43:30','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(54,'2018-08-12 11:11:26','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(55,'2018-08-12 23:23:12','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(56,'2018-08-13 21:40:53','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(57,'2018-08-19 20:07:03','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(58,'2018-08-22 20:16:56','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(59,'2018-08-25 10:02:17','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(60,'2018-09-02 00:09:54','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(61,'2018-09-02 01:13:10','0000-00-00 00:00:00','::1','I',16,'2019-08-25 22:28:41'),(62,'2018-09-02 11:31:32','0000-00-00 00:00:00','::1','I',16,'2019-08-25 22:28:41'),(63,'2018-09-06 19:24:49','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(64,'2018-09-06 21:34:15','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(65,'2018-09-08 09:27:59','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(66,'2018-09-08 18:10:42','0000-00-00 00:00:00','::1','I',25,'2019-08-25 22:28:41'),(67,'2018-09-16 22:36:31','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(68,'2018-09-30 13:19:56','2018-09-30 16:40:22','::1','O',9,'2019-08-25 22:28:41'),(69,'2018-09-30 16:46:46','2018-09-30 16:54:29','::1','O',9,'2019-08-25 22:28:41'),(70,'2018-09-30 16:54:38','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(71,'2018-09-30 18:47:31','2018-09-30 18:48:15','::1','O',9,'2019-08-25 22:28:41'),(72,'2018-09-30 18:48:19','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(73,'2018-09-30 19:43:59','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(74,'2018-09-30 19:46:44','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(75,'2018-09-30 19:56:59','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(76,'2018-10-03 16:58:47','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(77,'2018-10-05 09:46:37','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(78,'2018-10-05 09:54:30','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(79,'2018-10-05 13:11:06','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41'),(80,'2018-10-06 10:46:15','0000-00-00 00:00:00','::1','I',9,'2019-08-25 22:28:41');
/*!40000 ALTER TABLE `member_log` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `member_log` with 80 row(s)
--

--
-- Table structure for table `membership`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `membership` (
  `membership_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `last_paid_date` datetime NOT NULL COMMENT 'Actual paid date',
  `payment_status` char(1) NOT NULL COMMENT 'P - Paid, L - Late',
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive, D = Deleted',
  `created_by` int(11) NOT NULL COMMENT 'last updated staff person',
  `updated_by` int(11) NOT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Last Modified Time',
  PRIMARY KEY (`membership_id`),
  KEY `member_id` (`member_id`),
  CONSTRAINT `membership_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `member` (`member_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `membership`
--

LOCK TABLES `membership` WRITE;
/*!40000 ALTER TABLE `membership` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `membership` VALUES (2,21,3,'2018-09-08 00:00:00','2019-08-28 00:00:00','2018-09-08 00:00:00','L','A',1,0,'2019-08-29 00:38:17'),(3,23,4,'2018-09-08 00:00:00','2019-09-03 00:00:00','0000-00-00 00:00:00','P','A',1,0,'0000-00-00 00:00:00'),(4,24,2,'2018-09-08 00:00:00','2018-12-07 00:00:00','0000-00-00 00:00:00','L','I',1,0,'2019-08-29 19:34:38'),(5,25,4,'2019-08-29 00:00:00','2020-08-29 00:00:00','2019-08-29 00:00:00','P','A',1,1,'2019-08-29 19:05:02'),(6,39,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 09:49:50'),(7,40,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 10:39:35'),(8,41,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 11:01:04'),(9,42,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 12:30:01'),(10,43,1,'2019-08-28 00:00:00','2019-09-28 00:00:00','2019-08-29 00:00:00','P','A',1,1,'2019-08-29 20:09:42'),(11,44,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 12:32:59'),(12,45,1,'2019-07-28 00:00:00','2019-08-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 12:33:45'),(13,46,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 15:48:57'),(14,47,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 15:53:51'),(15,48,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 16:29:19'),(16,49,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 16:30:33'),(17,50,4,'2019-07-28 00:00:00','2020-07-28 00:00:00','2019-07-28 00:00:00','P','A',1,1,'2019-07-28 16:33:30'),(18,51,1,'2019-07-28 00:00:00','2019-08-28 00:00:00','2019-07-28 00:00:00','P','D',1,1,'2019-08-28 10:29:33'),(19,52,4,'2019-08-28 00:00:00','2020-08-28 00:00:00','2019-08-28 00:00:00','P','A',1,1,'2019-08-28 11:09:35'),(20,56,4,'2019-08-28 00:00:00','2020-08-28 00:00:00','2019-08-28 00:00:00','P','A',1,1,'2019-08-28 12:41:39'),(21,57,1,'2019-08-28 00:00:00','2019-09-28 00:00:00','2019-08-28 00:00:00','P','A',1,1,'2019-08-28 12:54:10'),(22,58,1,'2019-08-28 00:00:00','2019-09-28 00:00:00','2019-08-28 00:00:00','P','A',1,1,'2019-08-28 23:31:42');
/*!40000 ALTER TABLE `membership` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `membership` with 21 row(s)
--

--
-- Table structure for table `module`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `module` (
  `module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `description` varchar(255) NOT NULL COMMENT 'Descriptions of modules',
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive',
  PRIMARY KEY (`module_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `module`
--

LOCK TABLES `module` WRITE;
/*!40000 ALTER TABLE `module` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `module` VALUES (1,'staff','','2019-08-25 22:34:41','A'),(2,'member','','2019-08-25 22:34:41','A'),(3,'payment','','2019-08-25 22:34:41','A'),(4,'package','','2019-08-25 22:34:41','A'),(5,'class','','2019-08-25 22:34:41','A'),(6,'class_schedule','','2019-08-25 22:34:41','A'),(7,'equipment','','2019-08-25 22:34:41','A'),(8,'subscription','','2019-08-25 22:34:41','A'),(9,'workout','','2019-08-25 22:34:41','A'),(10,'report','','2019-08-25 22:34:41','A'),(11,'message','','2019-08-25 22:34:41','A'),(12,'event','','2019-08-25 22:34:41','A'),(13,'backup','','2019-08-25 22:34:41','A'),(14,'tracking','','2019-08-25 22:34:41','A');
/*!40000 ALTER TABLE `module` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `module` with 14 row(s)
--

--
-- Table structure for table `package`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package` (
  `package_id` int(20) NOT NULL AUTO_INCREMENT,
  `package_name` varchar(255) NOT NULL,
  `package_description` text NOT NULL,
  `fee` float NOT NULL,
  `duration` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive, D = Deleted',
  PRIMARY KEY (`package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package`
--

LOCK TABLES `package` WRITE;
/*!40000 ALTER TABLE `package` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `package` VALUES (1,'Basic','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,',2000,1,NULL,'2019-08-25 22:30:46','A'),(2,'Value Pack','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,',5000,3,NULL,'2019-08-25 22:30:46','D'),(3,'Gold','There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary,',2000,6,NULL,'2019-08-25 22:30:46','D'),(4,'Platinum','A personal trainer is an individual certified to have a varying degree of knowledge of general fitness involved in exercise prescription and instruction. They motivate clients by setting goals and providing feedback and accountability to clients. Wikipedia',6000,12,NULL,'2019-08-25 22:30:46','A'),(5,'Ronan Savage','Non quia culpa asper',3500,6,'IMG_5.png','2019-08-28 00:40:47','A'),(6,'Vanna Baird','Ullamco aut sapiente',78566,2,'IMG_6.jpg','2019-08-28 00:34:45','D');
/*!40000 ALTER TABLE `package` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `package` with 6 row(s)
--

--
-- Table structure for table `payment_history`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_history` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `paid_date` datetime NOT NULL,
  `payment_method` char(1) NOT NULL,
  `status` char(1) NOT NULL DEFAULT 'S' COMMENT 'S = success , F = Failed',
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_history`
--

LOCK TABLES `payment_history` WRITE;
/*!40000 ALTER TABLE `payment_history` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `payment_history` VALUES (1,22,58,'2019-08-28 00:00:00','2019-09-28 00:00:00','2019-08-28 00:00:00','C','S','2019-08-28 23:36:18'),(2,5,25,'2019-08-29 00:00:00','2020-08-29 00:00:00','2019-08-29 00:00:00','C','S','2019-08-29 19:05:02'),(3,5,25,'2019-08-29 00:00:00','2020-08-29 00:00:00','2019-08-29 00:00:00','C','S','2019-08-29 19:10:42'),(4,10,43,'2019-08-28 00:00:00','2019-09-28 00:00:00','2019-08-29 00:00:00','C','S','2019-08-29 20:09:42');
/*!40000 ALTER TABLE `payment_history` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `payment_history` with 4 row(s)
--

--
-- Table structure for table `role`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(255) NOT NULL,
  `role_description` varchar(255) NOT NULL,
  `lmd` datetime NOT NULL,
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `role` VALUES (1,'Manage staff','Users with this role can manage staff','0000-00-00 00:00:00','A'),(2,'View Staff','Users with this role can view staff','0000-00-00 00:00:00','A'),(3,'Manage Member','Users with this role can manage member','0000-00-00 00:00:00','A'),(4,'View Member','Users with this role can view member','0000-00-00 00:00:00','A'),(5,'View Staff Login log','Users with this role can view staff login log','0000-00-00 00:00:00','A'),(6,'View Member Login log','Users with this role can view member login log','0000-00-00 00:00:00','A'),(7,'View payment','Users with this role can view payment','0000-00-00 00:00:00','A'),(8,'Manage Payment','Users with this role can manage payment','0000-00-00 00:00:00','A'),(9,'View Package','Users with this role can view package','0000-00-00 00:00:00','A'),(10,'Manage Package','Users with this role can manage package','0000-00-00 00:00:00','A'),(11,'View Class','Users with this role can view class','0000-00-00 00:00:00','A'),(12,'Manage Class','Users with this role can manage class','0000-00-00 00:00:00','A'),(13,'View Class Session','Users with this role can view class session','0000-00-00 00:00:00','A'),(14,'Manage Class Session','Users with this role can manage class session','0000-00-00 00:00:00','A'),(15,'View Equipment','Users with this role can view equipment','0000-00-00 00:00:00','A'),(16,'Manage Equipment','Users with this role can manage equipment','0000-00-00 00:00:00','A'),(17,'View Subscription','Users with this role can view subscription','0000-00-00 00:00:00','A'),(18,'Manage Subscription','Users with this role can manage subscription','0000-00-00 00:00:00','A'),(19,'View Workout','Users with this role can view workout','0000-00-00 00:00:00','A'),(20,'View Report','Users with this role can view report','0000-00-00 00:00:00','A'),(21,'Manage Report','Users with this role can manage report','0000-00-00 00:00:00','A'),(22,'View Message','Users with this role can view message','0000-00-00 00:00:00','A'),(23,'Manage Message','Users with this role can manage message','0000-00-00 00:00:00','A'),(24,'View Event','Users with this role can view event','0000-00-00 00:00:00','A'),(25,'Manage Backup','Users with this role can manage backup','0000-00-00 00:00:00','A'),(26,'Manage Workout','Users with this role can manage workout','0000-00-00 00:00:00','A'),(27,'Manage Event','Users with this role can manage event','0000-00-00 00:00:00','A');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `role` with 27 row(s)
--

--
-- Table structure for table `staff`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'Lat modified time',
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive ,D = Deleted , S = Suspended',
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff`
--

LOCK TABLES `staff` WRITE;
/*!40000 ALTER TABLE `staff` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `staff` VALUES (1,'lakshan ','peramuna','pglbuddhika@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1994-04-03','940940524V','+94771888110','Bat cave','S','','0000-00-00 00:00:00','A'),(4,'bill','gates','lbperamuna@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1995-06-04','','0771888115','new york ','A','','0000-00-00 00:00:00','A'),(5,'nimal','bandara','nimal@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1991-07-04','910910524V','+9412345678','gampaha','T','','0000-00-00 00:00:00','A'),(6,'lucky','eryreye','frwere@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1993-05-07','952458254V','0771888116','London','M','','0000-00-00 00:00:00','A'),(7,'randy','gates','sanjayamaxx@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1996-08-06','960910524V','+9412345678','NJ','A','','0000-00-00 00:00:00','D'),(10,'Anne','nicey','nice@mail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','F','1994-01-31','94528452854V','+9456234991','DC','M','','0000-00-00 00:00:00','A'),(12,'Cristiano','Ronaldo','cr7@cr.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1986-04-03','862856157V','+94123123464','Spain','S','','0000-00-00 00:00:00','A'),(16,'garath','bale','xyz12345@live.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1986-04-09','860940524V','+94771188122','Walse','M','','0000-00-00 00:00:00','A'),(17,'vimukthi','deshan','vimukthi@gmail.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','1995-04-26','950940924V','+94123123468','Ja ela','T','','0000-00-00 00:00:00','A'),(18,'Raphael','Harmon','vyfyweji@mailinator.net','','M','1985-11-03','857940524V','776993509','Iste dolor nulla sol','M','pro_pic_5d1cddb1f0896.jpg','0000-00-00 00:00:00',''),(19,'Holly','Green','nyfedym@mailinator.net','8465cc08208bdb18840aade4bcf374658e900ebc','F','2000-04-16','209876453V','+1 (264) 579-1732','Aspernatur qui do of','T','pro_pic_5d1ce6c98e61e.jpg','2019-07-03 23:02:57','A'),(20,'Adria','Pate','husip@mailinator.net','afb6eda4fbb0883efa1bfdac151c6c4b7be7cd13','M','1980-12-26','Sed nisi qui libero ','5845721882','Omnis atque animi l','T','pro_pic_5d25e47cabfb1.','2019-07-10 18:43:32','A'),(21,'Cassandra','Neal','wegaza@mailinator.net','6bfada3d5d21f2c110019e546294b33d4c646ae4','F','1998-02-08','Velit nesciunt fuga','+1 (704) 535-5723','Cillum eos facere ip','T','pro_pic_5d2604da8df7c.','2019-07-10 21:01:38','A'),(22,'Rudyard','Camacho','pigilytaqe@mailinator.net','a9fe8f7da1bc63b587f4c7054a38830fb7f969d2','M','1993-05-27','Commodo non in velit','+1 (671) 487-6186','Quia totam ut magni ','A','pro_pic_5d2610959d8f8.','2019-07-10 21:51:41','A'),(23,'Natalie','Walls','dyfefiwah@mailinator.net','7d23a072e1d19ef7142c6bbf5a96c2a8ece1355a','M','1971-08-18','','+94701208606','Repudiandae obcaecat','M','pro_pic_5d2981575c50e.','2019-07-13 12:29:35','A'),(24,'Zia','Ferguson','dysiric@mailinator.net','4c92565aa11dbad6e975464680909a82b03783f8','F','1973-01-05','','+94638247432','Rem rerum explicabo','A','pro_pic_5d2982d507da7.','2019-07-13 12:35:57','A'),(25,'Burke','Torres','tyfo@mailinator.com','7b80315d2a09b146741a0bf7ab885587066125c0','F','1972-01-26','Error et ut quas mol','+94212243781','Consequuntur hic arc','A','pro_pic_5d29fd114214c.','2019-07-13 21:17:29','A'),(26,'Nayda','Lopez','jyfyciqu@mailinator.net','a1b7c6be354424f9955c166564843a30e3270fa0','M','2011-07-08','Obcaecati harum perf','+94962098485','Deserunt qui harum u','T','pro_pic_5d29fef525101.','2019-07-13 21:25:33','A'),(27,'Kay','Monroe','linyv@mailinator.net','e8f2744eb2c86391ac571e39cd768f8336013c95','M','1971-07-17','Libero voluptatem R','+94382472263','Perspiciatis sint s','M','pro_pic_5d2ae27f2d0c6.','2019-07-14 13:36:23','A'),(28,'Pandora','Howard','zatawo@mailinator.com','d2fe4e4ff388a0d7ba0b603b438988002b8eaadc','M','1981-05-25','Enim pariatur Est l','+94307594782','Nisi dolore doloribu','M','pro_pic_5d2ae41f2d01e.','2019-07-14 13:43:19','A'),(29,'Briar','Farrell','nuxen@mailinator.com','06c7aae5691be034c6f1d3bd99baec9b47c1458b','F','1983-02-26','Culpa cupidatat accu','+94284360879','Repudiandae eum solu','T','pro_pic_5d2ae4a46784d.','2019-07-14 13:45:32','A'),(30,'Summer','Madden','secekihi@mailinator.net','8be903ed8a66dce21e4a0bf2cc40767d366d7f8c','F','2006-03-23','Nihil dolores nobis ','+94982358119','Quisquam eiusmod vol','A','pro_pic_5d2ae4d72efa0.','2019-07-14 13:46:23','A'),(31,'Sydnee','Booker','zura@mailinator.net','085e8ea122959a73f62bd58e94d2c01ab7c79129','F','2000-05-18','Error voluptatem ull','+94687195130','Culpa exercitation i','A','pro_pic_5d2ae558a80dc.','2019-07-14 13:48:32','A'),(32,'Kiona','Callahan','woxojun@mailinator.net','4ed6739975f6f954c0448d54a6e4516992e88f65','M','2016-03-18','Eaque non voluptatib','+94500707386','Necessitatibus sed e','T','pro_pic_5d2ae638546bc.','2019-07-14 13:52:16','A'),(33,'Shay','Norman','kisyxega@getnada.com','ad991b95af212435602969804bf75fea9f35837b','M','1994-10-01','Est sed consequat ','+94439891863','Possimus quibusdam ','T','pro_pic_5d2ae6b7cd194.','2019-07-14 13:54:23','A'),(34,'Courtney','Pratt','zevil@mailinator.com','543c24d6d185af68deef0c7b913b84cf5c74224d','F','1978-07-04','Amet saepe voluptat','+94524808652','Quam id ipsum qui u','M','pro_pic_5d2b249f1c65f.','2019-07-14 18:18:31','A'),(35,'Juliet','Snow','quxaci@getnada.com','f422272a30a3618209e8c7c57d0294d7bd0fc7d1','M','2010-12-14','Enim accusantium rem','+94797559990','Asperiores consequat','T','pro_pic_5d2b285bd85e4.','2019-07-14 18:34:27','A'),(36,'Yvette','White','malyt@getnada.com','561312321bc49ab1a81e24be7b1670af56235439','M','1985-06-21','Sunt explicabo Volu','+94723719440','Quis sunt laborum v','A','pro_pic_5d2b3189425a8.','2019-07-14 19:13:37','A'),(37,'Oleg','Baldwin','nuhiwil@getnada.com','f6b7a12364c15cbb5cc8a3adc34a2a3e92835e1b','M','2009-12-09','Aut enim est anim s','+94172412788','Incidunt debitis do','M','pro_pic_5d2b3dfa506e1.png','2019-07-14 20:06:42','A'),(38,'Thane','Mendoza','gocoped@getnada.com','5850ddbd43aee7d77e2095cfc4869c4e23d01aa9','F','1992-07-17','923456543V','+94778369745','Do est beatae ut es','A','pro_pic_5d2b41596f761.jpg','2019-07-14 20:21:05','A'),(39,'Kim','Barton','nobimac@getnada.com','0d9ba79b13c8aaf012960b65ddfcac6620527fcf','M','1981-04-16','Quibusdam reiciendis','+94879228189','Ratione ipsum sit d','A','pro_pic_5d2bf426de6eb.jpg','2019-07-15 09:03:58','A'),(40,'Eagan','Vasquez','mymin@getnada.com','ff006ed5e1b0326f5a3a9eedb74fa70ac23f7bc9','F','1980-12-05','Saepe deleniti paria','+94371431649','Tenetur suscipit et ','T','pro_pic_5d2bf51f718b1.','2019-07-15 09:08:07','A'),(41,'Nash','Mcbride','gineji@getnada.com','7ddd296775e0724883b9903ec62ddb5ec80a5c6e','M','2019-02-28','Amet incididunt par','+94480168628','Hic voluptas provide','T','pro_pic_5d2bf863b8609.','2019-07-15 09:22:03','A'),(42,'Jelani','Gaines','qigisy@getnada.com','b7a19884bffa09f3d2af3c85dbbcad0e61e213be','M','1976-08-07','Et nostrum earum cum','+94474411309','Et architecto cupida','T','pro_pic_5d2bf8cd491c2.','2019-07-15 09:23:49','A'),(43,'Cyrus','Langley','romi@getnada.com','aeaa1ae1a39809190002e3b51d2e426a7aa9d646','M','2003-06-09','Harum repellendus A','+94196466620','Vel odio voluptatem ','A','pro_pic_5d2bf96b0efb1.','2019-07-15 09:26:27','A'),(44,'Kennedy','Simmons','fezosas@mailinator.net','7e3f17b5613d6378fdffdb99ea48486f84e96721','F','1996-02-09','Natus est enim eos ','+94544175614','Cupidatat sunt repel','A','pro_pic_5d2c0dfa11955.','2019-07-15 10:54:10','A'),(45,'Lucian','Downs','loziny@mailinator.net','26cf063bb3c5fd154c8e98cc8ac6d125dc848e62','F','1977-11-08','Nostrum aliqua Eum ','+94997792797','Aliqua Quis est lab','A','pro_pic_5d2c0e8b27b2a.','2019-07-15 10:56:35','A'),(46,'Lani','Velez','kajiv@getnada.com','a58cbe50a0eee60ff21c76649899cf49bb0907fa','M','1973-12-13','Consequat Reprehend','+94416202802','Placeat qui distinc','T','pro_pic_5d2c15f9d9f49.jpg','2019-07-15 11:28:17','A'),(47,'Genevieve','Johnston','weju@getnada.com','144c4da86cecc06ce8184dd4c31284eb9bb248ec','F','2018-05-21','Quas in ullamco comm','+94385442771','Esse maiores ipsa ','M','pro_pic_5d2c1c3fe1174.','2019-07-15 11:55:03','A'),(48,'Gwendolyn','Singleton','fuvox@getnada.com','37fdbe8ce96509b3ce535729070f2ba699fd3a93','F','2011-04-26','Ut maiores elit qui','+94211773685','Minima necessitatibu','A','','2019-07-15 13:06:19','A'),(49,'Minerva','Carrillo','mupap@getnada.com','4fbae352588e155821665286094b06304aac94d8','F','2002-04-02','Ipsum saepe impedit','+94176904462','Sit repudiandae aut','M','','2019-07-15 13:11:16','A'),(50,'Roanna','Bass','wiqyc@getnada.com','86213abd63d65fb27fac59e30079a7be3d648471','M','1986-05-21','Quas cum commodi dol','+94338302069','Sint Nam id voluptas','T','','2019-07-15 13:15:28','A'),(51,'Cherokee','Soto','guwepiv@getnada.com','0ff860422bf4896ed317560991335ccfddb6dd28','F','1988-10-28','Corporis reiciendis ','+94960862115','Sapiente sit qui qu','T','','2019-07-15 13:18:48','A'),(52,'Iris','Bray','tewyke@getnada.com','1cd6a0ab4e1fa99cd2db554103fcb602ab44723a','F','2002-11-07','Itaque in repellendu','+94582504679','Accusantium iste qui','A','','2019-07-15 13:19:45','A'),(53,'Faith','Barker','nuhyleno@getnada.com','b71e4902933ae642ffa56c0c131b289ea8a1f554','M','1980-03-02','Perferendis inventor','+94977478768','Animi ducimus sunt','T','','2019-07-15 13:30:00','A'),(54,'Noelani','Cobb','wacozuk@getnada.com','b508800d814459f8be1c6ee79fc7f5d8bd6ac656','M','1980-09-09','Exercitationem ipsum','+94143646973','In eaque cupiditate ','T','','2019-07-15 13:37:59','A'),(55,'Davis','Blankenship','netumodo@getnada.com','07fee14eec871144e425065442936a01ac7506c3','M','1974-01-10','Dolore error excepte','+94910436719','Rerum consectetur e','A','','2019-07-15 13:39:25','A'),(56,'Neville','Sykes','zobyh@getnada.com','478d59999275016d9a132d30924fbc0af821d4cc','F','2006-09-14','Officiis voluptas qu','+94772871526','Aperiam molestias co','A','','2019-07-15 13:45:00','A'),(57,'Cora','Cameron','vavi@getnada.com','00394f28c762457862696c0ec4c7576fd7d9b4f9','F','1974-02-12','Tempore ipsa natus','+94068882437','Provident odit offi','T','57_IMG.jpg','2019-07-15 17:38:29','A'),(58,'Suki','Mccoy','hyzydew@getnada.com','2fc782adf265ffda240dcea6b655a4feef460f8d','F','1974-05-26','743546453V','+94110931474','Est dolores incidunt','M','58_IMG.jpg','2019-07-15 18:22:39','A'),(59,'Aubrey','Yates','kurykyr@getnada.com','58ea1f59a49775037a9aca2f99dff7ecba6999ea','F','1991-05-13','Fuga In nobis modi ','+94979639836','Exercitationem sit b','M','59_IMG.jpg','2019-07-15 18:55:45','A'),(60,'Abbot','Lloyd','rifizuka@getnada.com','0fae9af4f140f9d82d20db71da58395baa360302','F','2004-08-06','Debitis quis obcaeca','+94302113491','Hic quia aliquid fug','T','60_IMG.','2019-07-15 19:38:43','A'),(61,'Ignatius','Randolph','degelexo@getnada.com','908007f153d425d8ed7473f49491cc8be9df157b','F','1984-02-17','Laborum aperiam labo','+94710745988','Ut dolorem pariatur','T','61_IMG.','2019-08-25 18:32:33','I'),(62,'Ciaran','Woodward','nufil@getnada.com','79538ad1673bc3ee3ab649e3f0dd7c1df3790e21','F','1983-05-05','Quis ut velit ut vo','+94446277712','Exercitationem molli','T','62_IMG.','2019-07-15 19:42:34','A'),(63,'Julie','Branch','sajuhefy@getnada.com','6be15539f719c92f94a481473501dd28c8578e27','M','1983-07-03','Facere unde ut minus','+94800837228','Asperiores cupidatat','A','63_IMG.','2019-08-25 18:32:17','D'),(64,'Galena','Day','tigimy@getnada.com','1aadbaef62b977b64427df5777fd75b6808f9b64','M','2011-03-06','Quia duis incidunt ','+94556323762','Unde velit nostrud a','M','64_IMG.jpg','2019-07-15 19:47:21','A'),(65,'Lisandra','Mayo','dogotug@getnada.com','89e30327b954a8a5e2442a5c6a9e3f736cb13d18','F','1996-06-16','Voluptatem ut magna ','+94861593925','Reprehenderit est si','M','65_IMG.jpg','2019-07-15 19:56:51','A'),(66,'Emmanuel','Waller','vujyvum@getnada.com','96bb6965512e889f2fc87636903b5f676bc860b8','M','1973-06-17','Modi natus voluptate','+94973806014','Ipsum dolorem quia ','T','','2019-07-15 19:58:37','I'),(67,'Claudia','Ballard','ruxyn@getnada.com','dab871d587cf31efe16793339993dea554a4757a','M','1979-08-27','Eius enim asperiores','+94012374011','Eligendi quia ut et ','T','67_IMG.','2019-07-15 20:05:24','D'),(68,'Xantha','Morales','ruzi@getnada.com','b43b2c708b1f9b2450e22f0e471ca46f29fab4bb','M','2006-08-05','At laborum Molestia','+94577144728','Illum ab ut neque d','A','68_IMG.','2019-07-15 20:32:28','D'),(69,'Allegra','Dunlap','lymase@getnada.com','ed58a09bdf248015eca42ad447f527e4a967ae5e','M','1994-03-23','Vel at est omnis fug','+94235953373','Officiis minim volup','A','69_IMG.','2019-07-15 20:36:30','D'),(70,'Aidan','Velasquez','tywipaha@getnada.com','a680f654ee06f7e891a32fcd55be12eb38bef4ed','F','1987-09-16','Itaque voluptatum qu','+94388429598','Qui enim ut ut non c','T','70_IMG.jpg','2019-07-15 20:39:29','D'),(71,'Emi','Mcclain','tyzolus@getnada.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','M','2000-02-22','Irure dolorem vero i','+94639664882','Qui aut recusandae ','M','IMG_71.jpg','2019-07-19 21:30:53','A'),(72,'Vielka','Conway','fupopo@getnada.com','40bd001563085fc35165329ea1ff5c5ecbdbbeef','F','1980-03-09','Aut veritatis volupt','+94273808918','440, qwerty, asdf','T','IMG_72.jpg','2019-07-19 21:29:46','A'),(73,'Sarah','Mendoza','meveda@mailinator.net','591e2bde51d7dc8e7a2688bc54cfb63af4646438','M','1995-11-24','Dolore irure ex enim','94982678842','Veniam minus animi','A','','2019-07-28 10:50:58','A');
/*!40000 ALTER TABLE `staff` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `staff` with 65 row(s)
--

--
-- Table structure for table `staff_log`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `staff_log` (
  `log_id` int(11) NOT NULL AUTO_INCREMENT,
  `log_in` datetime NOT NULL,
  `log_out` datetime NOT NULL,
  `log_ip` varchar(200) NOT NULL,
  `status` char(1) NOT NULL COMMENT 'I = IN , O = OUT',
  `staff_id` int(11) NOT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `staff_id` (`staff_id`),
  CONSTRAINT `staff_log_ibfk_1` FOREIGN KEY (`staff_id`) REFERENCES `staff` (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `staff_log`
--

LOCK TABLES `staff_log` WRITE;
/*!40000 ALTER TABLE `staff_log` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `staff_log` VALUES (1,'2019-05-18 10:16:08','2019-05-18 22:36:03','127.0.0.1','O',1,'2019-08-25 22:27:47'),(2,'2019-05-18 22:36:08','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(3,'2019-05-19 18:53:54','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(4,'2019-05-19 19:07:50','2019-05-19 20:41:19','127.0.0.1','O',1,'2019-08-25 22:27:47'),(5,'2019-05-19 20:41:24','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(6,'2019-05-25 12:42:29','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(7,'2019-05-25 23:00:47','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(8,'2019-05-26 17:26:00','2019-05-26 17:43:18','127.0.0.1','O',1,'2019-08-25 22:27:47'),(9,'2019-05-26 17:43:30','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(10,'2019-05-29 18:32:44','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(11,'2019-06-01 12:48:03','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(12,'2019-06-03 10:22:51','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(13,'2019-06-03 10:24:59','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(14,'2019-06-03 10:29:21','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(15,'2019-06-03 12:26:50','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(16,'2019-06-03 12:27:17','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(17,'2019-06-03 17:19:51','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(18,'2019-06-08 10:28:36','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(19,'2019-06-09 16:50:16','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(20,'2019-06-13 16:08:34','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(21,'2019-06-15 10:37:03','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(22,'2019-06-15 20:45:19','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(23,'2019-06-19 18:25:09','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(24,'2019-06-26 10:59:01','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(25,'2019-06-27 22:10:12','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(26,'2019-06-29 17:47:57','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(27,'2019-06-30 22:18:00','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(28,'2019-07-03 16:07:44','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(29,'2019-07-03 16:53:00','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(30,'2019-07-03 17:07:01','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(31,'2019-07-03 17:11:25','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(32,'2019-07-03 17:15:43','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(33,'2019-07-03 17:31:12','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(34,'2019-07-03 17:34:19','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(35,'2019-07-03 17:35:02','0000-00-00 00:00:00','127.0.0.1','I',5,'2019-08-25 22:27:47'),(36,'2019-07-03 17:39:09','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(37,'2019-07-03 17:57:06','0000-00-00 00:00:00','127.0.0.1','I',5,'2019-08-25 22:27:47'),(38,'2019-07-03 19:46:34','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(39,'2019-07-10 18:31:12','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(40,'2019-07-13 12:25:15','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(41,'2019-07-13 21:17:13','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(42,'2019-07-13 21:30:30','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(43,'2019-07-14 09:57:08','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(44,'2019-07-14 18:17:12','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(45,'2019-07-14 20:52:07','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(46,'2019-07-14 21:06:43','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(47,'2019-07-14 22:22:35','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(48,'2019-07-15 07:23:43','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(49,'2019-07-15 10:53:46','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(50,'2019-07-16 07:36:54','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(51,'2019-07-17 20:11:41','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(52,'2019-07-19 08:06:16','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(53,'2019-07-19 17:52:36','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(54,'2019-07-19 21:30:16','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(55,'2019-07-20 11:16:10','0000-00-00 00:00:00','127.0.0.1','I',72,'2019-08-25 22:27:47'),(56,'2019-07-20 11:17:23','0000-00-00 00:00:00','127.0.0.1','I',71,'2019-08-25 22:27:47'),(57,'2019-07-20 11:21:49','0000-00-00 00:00:00','127.0.0.1','I',71,'2019-08-25 22:27:47'),(58,'2019-07-20 11:30:45','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(59,'2019-07-20 11:39:37','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(60,'2019-07-20 16:23:07','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(61,'2019-07-20 22:07:17','0000-00-00 00:00:00','127.0.0.1','I',72,'2019-08-25 22:27:47'),(62,'2019-07-20 22:10:43','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(63,'2019-07-21 10:35:16','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(64,'2019-07-21 16:42:11','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(65,'2019-07-24 17:50:37','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(66,'2019-07-27 19:29:35','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(67,'2019-07-28 09:49:18','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(68,'2019-07-28 15:48:38','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(69,'2019-07-29 23:39:09','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(70,'2019-07-31 19:10:56','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(71,'2019-07-31 19:51:09','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(72,'2019-08-03 07:43:36','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(73,'2019-08-03 10:55:16','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(74,'2019-08-03 11:07:49','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(75,'2019-08-04 07:45:44','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(76,'2019-08-05 08:12:25','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(77,'2019-08-05 17:55:44','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(78,'2019-08-08 11:47:42','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(79,'2019-08-10 20:10:44','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(80,'2019-08-11 09:31:39','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(81,'2019-08-11 17:29:42','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(82,'2019-08-11 17:31:17','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(83,'2019-08-11 23:11:39','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(84,'2019-08-14 10:43:59','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(85,'2019-08-14 17:09:16','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(86,'2019-08-17 06:48:05','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(87,'2019-08-17 11:28:16','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(88,'2019-08-17 21:09:03','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(89,'2019-08-18 10:27:42','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(90,'2019-08-18 22:36:50','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(91,'2019-08-20 22:45:43','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(92,'2019-08-21 16:28:38','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(93,'2019-08-24 09:14:58','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47'),(94,'2019-08-25 11:22:41','0000-00-00 00:00:00','127.0.0.1','I',1,'2019-08-25 22:27:47');
/*!40000 ALTER TABLE `staff_log` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `staff_log` with 94 row(s)
--

--
-- Table structure for table `user_type`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the user type',
  `user_type_name` varchar(50) NOT NULL COMMENT 'Name of the user type',
  `user_type_character` char(1) NOT NULL COMMENT 'S = Super admin, A = Admin , M = Manager , T = Trainer',
  `status` char(1) NOT NULL COMMENT 'A = Active , I = Inactive ,D = Deleted',
  `lmd` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'last modified date',
  PRIMARY KEY (`user_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type`
--

LOCK TABLES `user_type` WRITE;
/*!40000 ALTER TABLE `user_type` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `user_type` VALUES (1,'Super Admin','S','A','2019-07-03 10:56:01'),(2,'Admin','A','A','2019-07-03 10:56:01'),(3,'Manager','M','A','2019-07-03 10:56:01'),(4,'Trainer','T','A','2019-07-03 10:56:01');
/*!40000 ALTER TABLE `user_type` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `user_type` with 4 row(s)
--

--
-- Table structure for table `user_type_role`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_type_role` (
  `user_type_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `lmd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_type_role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `user_type_role_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_type_role`
--

LOCK TABLES `user_type_role` WRITE;
/*!40000 ALTER TABLE `user_type_role` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `user_type_role` VALUES (1,1,1,'2019-08-25 22:30:04'),(2,1,2,'2019-08-25 22:30:04'),(3,1,3,'2019-08-25 22:30:04'),(4,1,4,'2019-08-25 22:30:04'),(5,1,5,'2019-08-25 22:30:04'),(6,1,6,'2019-08-25 22:30:04'),(7,1,7,'2019-08-25 22:30:04'),(8,1,8,'2019-08-25 22:30:04'),(9,1,9,'2019-08-25 22:30:04'),(10,1,10,'2019-08-25 22:30:04'),(11,1,11,'2019-08-25 22:30:04'),(12,1,12,'2019-08-25 22:30:04'),(13,1,13,'2019-08-25 22:30:04'),(14,1,14,'2019-08-25 22:30:04'),(15,1,15,'2019-08-25 22:30:04'),(16,1,16,'2019-08-25 22:30:04'),(17,1,17,'2019-08-25 22:30:04'),(18,1,18,'2019-08-25 22:30:04'),(19,1,19,'2019-08-25 22:30:04'),(20,1,20,'2019-08-25 22:30:04'),(21,1,21,'2019-08-25 22:30:04'),(22,1,22,'2019-08-25 22:30:04'),(23,1,23,'2019-08-25 22:30:04'),(24,1,24,'2019-08-25 22:30:04'),(25,1,25,'2019-08-25 22:30:04'),(26,1,26,'2019-08-25 22:30:04'),(27,1,27,'2019-08-25 22:30:04'),(28,2,1,'2019-08-25 22:30:04'),(29,2,2,'2019-08-25 22:30:04'),(30,2,3,'2019-08-25 22:30:04'),(31,2,4,'2019-08-25 22:30:04'),(32,2,5,'2019-08-25 22:30:04'),(33,2,6,'2019-08-25 22:30:04'),(34,2,7,'2019-08-25 22:30:04'),(35,2,8,'2019-08-25 22:30:04'),(36,2,9,'2019-08-25 22:30:04'),(37,2,10,'2019-08-25 22:30:04'),(38,2,11,'2019-08-25 22:30:04'),(39,2,12,'2019-08-25 22:30:04'),(40,2,13,'2019-08-25 22:30:04'),(41,2,14,'2019-08-25 22:30:04'),(42,2,15,'2019-08-25 22:30:04'),(43,2,16,'2019-08-25 22:30:04'),(44,2,17,'2019-08-25 22:30:04'),(45,2,18,'2019-08-25 22:30:04'),(46,2,19,'2019-08-25 22:30:04'),(47,2,20,'2019-08-25 22:30:04'),(48,2,21,'2019-08-25 22:30:04'),(49,2,22,'2019-08-25 22:30:04'),(50,2,23,'2019-08-25 22:30:04'),(51,2,24,'2019-08-25 22:30:04'),(52,2,25,'2019-08-25 22:30:04'),(53,2,26,'2019-08-25 22:30:04'),(54,2,27,'2019-08-25 22:30:04'),(55,3,2,'2019-08-25 22:30:04'),(56,3,3,'2019-08-25 22:30:04'),(57,3,4,'2019-08-25 22:30:04'),(58,3,7,'2019-08-25 22:30:04'),(59,3,8,'2019-08-25 22:30:04'),(60,3,9,'2019-08-25 22:30:04'),(61,3,10,'2019-08-25 22:30:04'),(62,3,11,'2019-08-25 22:30:04'),(63,3,12,'2019-08-25 22:30:04'),(64,3,13,'2019-08-25 22:30:04'),(65,3,14,'2019-08-25 22:30:04'),(66,3,15,'2019-08-25 22:30:04'),(67,3,16,'2019-08-25 22:30:04'),(68,3,17,'2019-08-25 22:30:04'),(69,3,18,'2019-08-25 22:30:04'),(70,3,19,'2019-08-25 22:30:04'),(71,3,22,'2019-08-25 22:30:04'),(72,3,23,'2019-08-25 22:30:04'),(73,3,24,'2019-08-25 22:30:04'),(74,3,26,'2019-08-25 22:30:04'),(75,3,27,'2019-08-25 22:30:04'),(76,4,4,'2019-08-25 22:30:04'),(77,4,11,'2019-08-25 22:30:04'),(78,4,13,'2019-08-25 22:30:04'),(79,4,15,'2019-08-25 22:30:04'),(80,4,19,'2019-08-25 22:30:04'),(81,4,24,'2019-08-25 22:30:04'),(82,4,26,'2019-08-25 22:30:04'),(83,4,27,'2019-08-25 22:30:04');
/*!40000 ALTER TABLE `user_type_role` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `user_type_role` with 83 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Fri, 30 Aug 2019 12:10:54 +0530
