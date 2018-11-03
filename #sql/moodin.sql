-- MySQL dump 10.11
--
-- Host: localhost    Database: trustnet_moodin
-- ------------------------------------------------------
-- Server version	5.0.91-community-log

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
-- Table structure for table `custom_fields`
--

DROP TABLE IF EXISTS `custom_fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_fields` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `value` text NOT NULL,
  `item_id` int(11) NOT NULL,
  `index` int(11) NOT NULL,
  `star` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `custom_fields`
--

LOCK TABLES `custom_fields` WRITE;
/*!40000 ALTER TABLE `custom_fields` DISABLE KEYS */;
INSERT INTO `custom_fields` (`id`, `name`, `value`, `item_id`, `index`, `star`) VALUES (1,'Adresa','test',35,0,0),(2,'Nr. Telefon','test',35,0,0),(3,'Adresa','asdasd',40,0,0),(4,'Telefon','asdasd',40,0,0),(5,'Telefon2','asdasd',9,1,0),(6,'Telefon1','asd',9,1,0),(7,'Telefon2','star',10,1,1),(8,'Telefon1','not star',10,1,0),(43,'Telefon','',11,16,0),(42,'Adresa','',11,15,0),(41,'Telefon','',11,14,0),(40,'Adresa','',11,13,0),(39,'Telefon','',11,12,0),(38,'Adresa','',11,11,0),(37,'Telefon','',11,10,0),(36,'elodia','',11,9,0),(35,'Adresa','',11,8,0),(34,'Telefon','',11,7,0),(33,'Adresa','',11,6,0),(32,'Telefon','',11,5,0),(31,'Adresa','',11,4,0),(30,'Telefon','',11,3,0),(29,'Adresa','',11,2,0),(28,'Telefon','',11,1,1),(44,'Adresa','',11,17,0),(45,'Telefon1','+357998xxxx',11,18,0),(48,'Telefon1','+357998xxxx',12,1,0),(49,'Telefon1','(+357)998xxxx',13,1,0),(50,'Mail','Info@latindance.com.cy',13,1,0);
/*!40000 ALTER TABLE `custom_fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fields`
--

DROP TABLE IF EXISTS `fields`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fields` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fields`
--

LOCK TABLES `fields` WRITE;
/*!40000 ALTER TABLE `fields` DISABLE KEYS */;
INSERT INTO `fields` (`id`, `name`) VALUES (1,'Telefon1'),(2,'Telefon2'),(3,'telefon3');
/*!40000 ALTER TABLE `fields` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL auto_increment,
  `item_id` int(11) NOT NULL,
  `image` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` (`id`, `item_id`, `image`) VALUES (33,19,'Aphrodite-Hills-Logo-Head.jpg'),(32,18,'3603_green-directi-Medical-g1.jpg'),(31,17,'202logo_picture.jpg'),(30,16,'302@301_931e291f3371426bfcf3a25504219475.jpg'),(28,15,'chef in topaz.jpg'),(27,14,'hala-sultan-tekke-larnaca-cy113.jpg'),(26,13,'Salsajam_pic1.png'),(21,11,'club topaz.jpg'),(25,12,'club topaz.jpg'),(34,20,'gympics01.JPG'),(35,21,'badminton_doubles.jpg');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `items`
--

DROP TABLE IF EXISTS `items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `items` (
  `id` int(11) NOT NULL auto_increment,
  `question_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `image` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `items`
--

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;
INSERT INTO `items` (`id`, `question_id`, `text`, `image`, `parent_id`, `name`, `tags`) VALUES (16,10,'The meeting place','',0,'Evento Cafe','cafe,friends,chill'),(15,8,'Party in Club Topaz','',12,'Party in Topaz','party,topaz,dance,club'),(14,7,'Hala Sultan Tekke','',0,'Hala Sultan Tekke','Mosque, historical site'),(13,6,'The No. 1 Latin Dance School','',0,'The Latin Dance Cyprus','dance,latin'),(12,4,'The best dance club in Larnaka','',0,'Club Topaz','club,dance'),(17,11,'Apoteke','',0,'Cyprus Pharmacy','pharmacy,medicine,treatment'),(18,12,'The best Hospital','',0,'Larnaca Hospital','doctor,hospital,medicine,treatment'),(19,13,'The best Spa','',0,'Aphrodite Spa','treatment,doctor,medicine'),(20,14,'The best GYM','',0,'Kondylis Gym','sport, gym, workout'),(21,15,'Badminton,soccer','',0,'Badminton PLACE','sport,play');
/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `options` (
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
INSERT INTO `options` (`id`, `name`, `text`) VALUES (1,'Feel good','I\'m happy'),(2,'Feel bad','I\'m sad'),(3,'Need something','i\'m searching');
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question1`
--

DROP TABLE IF EXISTS `question1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question1` (
  `id` int(11) NOT NULL auto_increment,
  `option_id` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question1`
--

LOCK TABLES `question1` WRITE;
/*!40000 ALTER TABLE `question1` DISABLE KEYS */;
INSERT INTO `question1` (`id`, `option_id`, `text`) VALUES (1,1,'Why do you feel good ?'),(2,2,'Why do you feel bad ?'),(3,3,'What do you need ?');
/*!40000 ALTER TABLE `question1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question1_answers`
--

DROP TABLE IF EXISTS `question1_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question1_answers` (
  `id` int(11) NOT NULL auto_increment,
  `question_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `index` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question1_answers`
--

LOCK TABLES `question1_answers` WRITE;
/*!40000 ALTER TABLE `question1_answers` DISABLE KEYS */;
INSERT INTO `question1_answers` (`id`, `question_id`, `text`, `index`) VALUES (19,1,'I\'m joyful',0),(20,1,'I\'m satisfied',0),(21,1,'I\'m relaxed',0),(22,1,'I\'m excited',0),(23,1,'I\'m optimist',0),(24,1,'I\'m enthusiast',0),(25,1,'I\'m in love',0),(29,2,'i\'m bored',0),(28,2,'i\'m sad',0),(27,2,'i\'m tired',0),(26,2,'i\'m angry',0),(30,2,'i\'m stressed',0),(31,2,'i\'m lonely',0),(32,2,'i\'m suffering',0),(33,3,'to eat',0),(34,3,'to drink',0),(35,3,'to buy',0),(36,3,'to see',0),(37,3,'to repair',0),(38,3,'to find',0),(39,3,'to rent/book',0);
/*!40000 ALTER TABLE `question1_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question2`
--

DROP TABLE IF EXISTS `question2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question2` (
  `id` int(11) NOT NULL auto_increment,
  `answer_id` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question2`
--

LOCK TABLES `question2` WRITE;
/*!40000 ALTER TABLE `question2` DISABLE KEYS */;
INSERT INTO `question2` (`id`, `answer_id`, `text`) VALUES (1,2,'De ce raspuns 1_1_1 ?'),(2,5,''),(3,6,''),(4,7,'asd'),(5,19,'What you wanna do?'),(6,20,'What you gonna do ?'),(7,21,'What you gonna do ?'),(8,25,'What you gonna do ?'),(9,24,'What you gonna do ?'),(10,26,'What you wanna do ?'),(11,32,'What you wanna do ?'),(12,33,'When do you want to?'),(13,22,'What you gonna do?'),(14,23,'What you gonna do ?');
/*!40000 ALTER TABLE `question2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question2_answers`
--

DROP TABLE IF EXISTS `question2_answers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question2_answers` (
  `id` int(11) NOT NULL auto_increment,
  `question_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `index` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question2_answers`
--

LOCK TABLES `question2_answers` WRITE;
/*!40000 ALTER TABLE `question2_answers` DISABLE KEYS */;
INSERT INTO `question2_answers` (`id`, `question_id`, `text`, `index`) VALUES (1,0,'Raspuns 1_1_1ab',0),(2,0,'Raspuns 1_1_2',0),(3,0,'Raspuns 1_1_3',0),(4,1,'Raspuns 1_1_1',0),(5,1,'Raspuns 1_1_2',0),(6,1,'Raspuns 1_1_3',0),(7,4,'resr1',0),(8,4,'resr1asd3',0),(9,4,'elodia',0),(10,5,'Jump and dance',0),(11,5,'Make new friends',0),(12,5,'Learn something new',0),(13,6,'Go visit something',0),(14,6,'Go out with my friends',0),(15,6,'Stay at home and watch a movie',0),(16,8,'take her/him out',0),(17,8,'get a room',0),(18,8,'buy her/him a gift',0),(19,9,'do something extreme',0),(20,9,'take a trip',0),(21,9,'meet new people',0),(22,10,'blow some steam off',0),(23,10,'cool down a little',0),(24,10,'seek some relaxation',0),(25,11,'get some medicine',0),(26,11,'go to a doctor',0),(27,11,'seek some treatment',0),(28,12,'like now',0),(29,12,'later',0),(30,12,'all the time',0),(31,7,'Order in',0),(32,7,'go for a walk',0),(33,7,'go see a movie/play',0),(34,13,'go play a sport',0),(35,13,'go to a party',0),(36,13,'go out of the city',0),(37,14,'donate for a cause',0),(38,14,'invest in something',0),(39,14,'try my luck',0);
/*!40000 ALTER TABLE `question2_answers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `question3`
--

DROP TABLE IF EXISTS `question3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `question3` (
  `id` int(11) NOT NULL auto_increment,
  `answer_id` int(11) NOT NULL,
  `text` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `question3`
--

LOCK TABLES `question3` WRITE;
/*!40000 ALTER TABLE `question3` DISABLE KEYS */;
INSERT INTO `question3` (`id`, `answer_id`, `text`) VALUES (1,1,'De ce raspuns 1_1_1 ?'),(2,4,'De ce raspuns 1_1_1_1 ?'),(3,9,'asdasd'),(4,10,'Here is your chance!'),(5,0,''),(6,11,'Here is how !'),(7,13,'Here it is !'),(8,35,'Here is your party !'),(9,36,'Here is where you can go !'),(10,14,'Here is your meeting place !'),(11,25,'Here you can get some !'),(12,26,'Here is your doctor !'),(13,27,'Here is your spa !'),(14,22,'Here you can !'),(15,34,'Here you can play !');
/*!40000 ALTER TABLE `question3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `templates`
--

DROP TABLE IF EXISTS `templates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `templates` (
  `id` int(11) NOT NULL auto_increment,
  `template` text NOT NULL,
  `field` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `templates`
--

LOCK TABLES `templates` WRITE;
/*!40000 ALTER TABLE `templates` DISABLE KEYS */;
INSERT INTO `templates` (`id`, `template`, `field`) VALUES (23,'asdasdsd','Telefon'),(22,'asdasdsd','Adresa'),(21,'asdasdsd','Telefon'),(20,'asdasdsd','Adresa'),(19,'asdasdsd','Telefon'),(24,'asdasdsd','Adresa'),(25,'asdasdsd','Telefon'),(26,'asdasdsd','Adresa'),(27,'asdasdsd','elodia'),(28,'asdasdsd','Telefon'),(29,'asdasdsd','Adresa'),(30,'asdasdsd','Telefon'),(31,'asdasdsd','Adresa'),(32,'asdasdsd','Telefon'),(33,'asdasdsd','Adresa'),(34,'asdasdsd','Telefon'),(35,'asdasdsd','Adresa');
/*!40000 ALTER TABLE `templates` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-12-16  6:22:38
