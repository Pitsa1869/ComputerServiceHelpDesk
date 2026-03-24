CREATE DATABASE  IF NOT EXISTS `k00325530_compservice` /*!40100 DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci */;
USE `k00325530_compservice`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: k00325530_compservice
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `comment`
--

DROP TABLE IF EXISTS `comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comment` (
  `commentID` int(11) NOT NULL AUTO_INCREMENT,
  `ticketID` int(11) NOT NULL,
  `userID` varchar(45) DEFAULT NULL,
  `contents` varchar(244) DEFAULT NULL,
  `dateTimeStamp` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`commentID`),
  KEY `fk_ticketID_comments_idx` (`ticketID`),
  KEY `fk_UserID_comments_idx` (`userID`),
  CONSTRAINT `fk_UserID_comments` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticketID_comments` FOREIGN KEY (`ticketID`) REFERENCES `tickets` (`ticketID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comment`
--

LOCK TABLES `comment` WRITE;
/*!40000 ALTER TABLE `comment` DISABLE KEYS */;
INSERT INTO `comment` VALUES (1,2,'janeh@mail.com','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque commodo sapien sit amet est pharetra laoreet. Vivamus suscipit malesuada mauris fringilla tempus. Vestibulum placerat metus eu tortor blandit, at gravida lorem pretium. Proin','2026-03-20 16:01:19'),(2,2,'jack@lit.ie','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque commodo sapien sit amet est pharetra laoreet. Vivamus suscipit malesuada mauris fringilla tempus. Vestibulum placerat metus eu tortor blandit, at gravida lorem pretium. Proin','2026-03-20 16:03:00'),(14,2,'janeh@mail.com','Hello','2026-03-20 16:44:46'),(15,1,'jack@lit.ie','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque commodo sapien sit amet est pharetra laoreet. Vivamus suscipit malesuada mauris fringilla tempus. Vestibulum placerat metus eu tortor blandit, at gravida lorem pretium. Proin','2026-03-24 01:22:07');
/*!40000 ALTER TABLE `comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tickets`
--

DROP TABLE IF EXISTS `tickets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tickets` (
  `ticketID` int(11) NOT NULL AUTO_INCREMENT,
  `topic` varchar(45) DEFAULT NULL,
  `ticketText` varchar(244) DEFAULT NULL,
  `dateTimeStamp` datetime DEFAULT current_timestamp(),
  `ticketAuthorID` varchar(45) DEFAULT NULL,
  `status` varchar(45) DEFAULT 'Active',
  `dateTimeClosed` datetime DEFAULT NULL,
  `assignedTechnicianID` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`ticketID`),
  KEY `fk_ticketAuthor_tickets_idx` (`ticketAuthorID`),
  KEY `fk_ticketTexchnician_tickets_idx` (`assignedTechnicianID`),
  CONSTRAINT `fk_ticketAuthor_tickets` FOREIGN KEY (`ticketAuthorID`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ticketTexchnician_tickets` FOREIGN KEY (`assignedTechnicianID`) REFERENCES `user` (`userID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tickets`
--

LOCK TABLES `tickets` WRITE;
/*!40000 ALTER TABLE `tickets` DISABLE KEYS */;
INSERT INTO `tickets` VALUES (1,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque commodo sapien sit amet est pharetra laoreet. Vivamus suscipit malesuada mauris fringilla tempus. Vestibulum placerat metus eu tortor blandit, at gravida lorem pretium. Proin','2026-03-19 15:57:42','janeh@mail.com','Closed','2026-03-19 16:57:42','flann@gmail.com'),(2,'Lorem ipsum dolor sit amet','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque commodo sapien sit amet est pharetra laoreet. Vivamus suscipit malesuada mauris fringilla tempus. Vestibulum placerat metus eu tortor blandit, at gravida lorem pretium. Proin','2026-03-19 17:36:37','janeh@mail.com','Assigned',NULL,'flann@gmail.com'),(3,'fdsadsfdssadffasd','Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pr','2026-03-19 18:53:58','janeh@mail.com','Active',NULL,NULL);
/*!40000 ALTER TABLE `tickets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `UserNr` int(11) NOT NULL AUTO_INCREMENT,
  `FirstName` varchar(45) NOT NULL,
  `LastName` varchar(45) NOT NULL,
  `PassWord` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `mobile` varchar(45) DEFAULT NULL,
  `userID` varchar(45) DEFAULT NULL,
  `userTypeNr` int(11) NOT NULL,
  `userEnabled` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`UserNr`),
  UNIQUE KEY `email_UNIQUE` (`email`),
  UNIQUE KEY `userID_UNIQUE` (`userID`),
  KEY `fk_user_userType1_idx` (`userTypeNr`),
  CONSTRAINT `fk_user_userType1` FOREIGN KEY (`userTypeNr`) REFERENCES `usertype` (`userTypeNr`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'John','Smith','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','jsmith@college.ie','0875869745','jsmith@college.ie',1,1),(2,'Jane','Murphy','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','janeh@mail.com','0871234567','janeh@mail.com',3,1),(3,'Harry','Boland','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','harry@lit.ie','01234567','harry@lit.ie',3,1),(4,'James','Flannery','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','flann@gmail.com','0875426987','flann@gmail.com',2,1),(5,'James','Murphy','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','james@framework.com','0862356897','james@framework.com',3,1),(6,'Jack','McKeown','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','jack@lit.ie','0875458745','jack@lit.ie',2,1),(25,'elvis','presley','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','presley@tus.ie','0865478745','presley@tus.ie',3,1),(42,'Jimm','O','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','jimmy@ob.com','085457854','jimmy@ob.com',1,0),(44,'New','Customer','cf8f0c0d32522bc3d2ebe59d1fa46611d3369c96','cust@gmail.com','0854789654','cust@gmail.com',3,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertype` (
  `userTypeNr` int(11) NOT NULL,
  `userTypeDescr` varchar(45) NOT NULL DEFAULT 'UNKNOWN',
  PRIMARY KEY (`userTypeNr`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'ADMIN'),(2,'TECHNICIAN'),(3,'CUSTOMER'),(99,'UNKNOWN');
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-24  1:25:29
