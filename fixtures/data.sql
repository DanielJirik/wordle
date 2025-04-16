-- MySQL dump 10.13  Distrib 8.0.40, for Linux (x86_64)
--
-- Host: db    Database: thedatabase
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `roles`, `password`, `avatar`) VALUES (1,'admin','[\"ROLE_ADMIN\"]','$2y$13$EyJ4j4EnMi1GJD.S/iB1YOfQCyVa5B5wXJj.O1d4VtPLKRINRZkIC',NULL),(2,'pepik','[]','$2y$13$obX81BikkP3G01mlBCQXWuroH4swCLUtv5Zn6nwEG8MwNdpi9FTt2','6800235340565.png');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_wordle_answer`
--

LOCK TABLES `user_wordle_answer` WRITE;
/*!40000 ALTER TABLE `user_wordle_answer` DISABLE KEYS */;
INSERT INTO `user_wordle_answer` (`id`, `attempts`, `guesses`, `user_id`, `wordle_answer_id`, `status`) VALUES (2,2,'[{\"guess\": \"košař\", \"colors\": [\"red\", \"red\", \"red\", \"red\", \"red\"]}, {\"guess\": \"linux\", \"colors\": [\"green\", \"green\", \"green\", \"green\", \"green\"]}]',1,2,'win'),(3,3,'[{\"guess\": \"košař\", \"colors\": [\"red\", \"red\", \"red\", \"red\", \"red\"]}, {\"guess\": \"tomsn\", \"colors\": [\"red\", \"red\", \"red\", \"red\", \"orange\"]}, {\"guess\": \"linux\", \"colors\": [\"green\", \"green\", \"green\", \"green\", \"green\"]}]',2,2,'win');
/*!40000 ALTER TABLE `user_wordle_answer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `wordle`
--

LOCK TABLES `wordle` WRITE;
/*!40000 ALTER TABLE `wordle` DISABLE KEYS */;
INSERT INTO `wordle` (`id`, `word`, `last_used_at`) VALUES (1,'košař',NULL),(2,'stark',NULL),(3,'roman',NULL),(4,'háček',NULL),(5,'lsblk',NULL),(6,'cisco',NULL),(7,'linux','2025-04-16'),(8,'debug',NULL),(9,'robot',NULL),(10,'mysql',NULL),(11,'joooo',NULL),(12,'login',NULL),(13,'class',NULL),(14,'admin',NULL),(15,'tomsn',NULL),(16,'fanos',NULL),(17,'marek',NULL),(18,'tiger',NULL),(19,'niger',NULL),(20,'gypsy',NULL),(21,'route',NULL),(22,'trace',NULL),(23,'mkdir',NULL),(24,'rmdir',NULL),(25,'samba',NULL),(26,'karel',NULL),(27,'pavel',NULL),(28,'quota',NULL),(29,'chmod',NULL),(30,'fstab',NULL),(31,'lemka',NULL),(32,'mýdlo',NULL),(33,'jádra',NULL),(34,'glock',NULL),(35,'bahno',NULL),(36,'bláto',NULL),(37,'obrna',NULL),(38,'klaus',NULL),(39,'milan',NULL),(40,'češka',NULL),(41,'mrdka',NULL),(42,'iptak',NULL),(43,'rakle',NULL),(44,'alena',NULL),(45,'tomek',NULL),(46,'odpad',NULL),(47,'array',NULL),(48,'games',NULL),(49,'cloud',NULL),(50,'power',NULL),(51,'ferst',NULL);
/*!40000 ALTER TABLE `wordle` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `wordle_answer`
--

LOCK TABLES `wordle_answer` WRITE;
/*!40000 ALTER TABLE `wordle_answer` DISABLE KEYS */;
INSERT INTO `wordle_answer` (`id`, `date`, `wordle_id`) VALUES (2,'2025-04-16',7);
/*!40000 ALTER TABLE `wordle_answer` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-16 21:40:49
