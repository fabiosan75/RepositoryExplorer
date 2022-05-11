-- MySQL dump 10.13  Distrib 8.0.29, for Linux (x86_64)
--
-- Host: localhost    Database: RepositoryExplorer
-- ------------------------------------------------------
-- Server version	8.0.29-0ubuntu0.22.04.2

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
-- Table structure for table `ComposerPackageNode`
--

DROP TABLE IF EXISTS `ComposerPackageNode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ComposerPackageNode` (
  `IdNode` tinyint NOT NULL AUTO_INCREMENT COMMENT 'Parent ID for the package',
  `IdParent` tinyint DEFAULT '0' COMMENT 'Parent ID for the package',
  `Name` char(80) DEFAULT '' COMMENT 'name of the package, attribute in Composer SCHEMA ',
  `ShortName` text COMMENT 'ShortName of the package',
  `Vendor` char(80) DEFAULT NULL COMMENT 'Vendor attribute in Composer SCHEMA ',
  `Version` char(12) DEFAULT NULL COMMENT 'Version attribute in Composer SCHEMA ',
  `Source` char(120) DEFAULT NULL COMMENT 'src/Path to package repository',
  `Type` char(20) DEFAULT NULL COMMENT 'Type attribute in Composer SCHEMA',
  `Description` text COMMENT 'Description attribute in Composer SCHEMA ',
  `License` char(20) DEFAULT NULL COMMENT 'license attribute in Composer SCHEMA ',
  `Authors` varchar(200) DEFAULT '' COMMENT 'authors Attr authors in Comp SCHEMA / Json Format',
  `Attributes` text COMMENT 'Attr authors in Composer SCHEMA ',
  `Repositories` varchar(255) DEFAULT '' COMMENT 'Attr authors in Composer SCHEMA / Json Format',
  `Requires` text COMMENT 'Attr authors in Composer SCHEMA ',
  `UserTrCr` char(60) DEFAULT '' COMMENT 'user who created the row',
  `DateTrCr` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Creation datetime',
  `UserTrEd` char(60) DEFAULT '' COMMENT 'Last user changed the row',
  `DateTrEd` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'datetime of data change',
  PRIMARY KEY (`IdNode`),
  KEY `IdParent` (`IdParent`),
  CONSTRAINT `composerpackagenode_ibfk_1` FOREIGN KEY (`IdParent`) REFERENCES `ComposerPackageNode` (`IdNode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COMMENT='Composer package dependency, Node of tree composer project dependencies';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ComposerPackageNode`
--

LOCK TABLES `ComposerPackageNode` WRITE;
/*!40000 ALTER TABLE `ComposerPackageNode` DISABLE KEYS */;
INSERT INTO `ComposerPackageNode` VALUES (1,NULL,'Repository',NULL,NULL,NULL,NULL,'',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:47:49','','2022-05-11 16:47:49'),(2,1,'fabiosan75/proyecto1',NULL,NULL,NULL,NULL,'project',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01'),(3,2,'fabiosan75/libreria1',NULL,NULL,NULL,NULL,'library',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01'),(4,2,'fabiosan75/libreria2',NULL,NULL,NULL,NULL,'library',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01'),(5,4,'fabiosan75/libreria4',NULL,NULL,NULL,NULL,'library',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01'),(6,5,'fabiosan75/libreria5',NULL,NULL,NULL,NULL,'library',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01'),(7,1,'fabiosan75/proyecto2',NULL,NULL,NULL,NULL,'project',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01'),(8,7,'fabiosan75/libreria1',NULL,NULL,NULL,NULL,'library',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01'),(9,7,'fabiosan75/libreria4',NULL,NULL,NULL,NULL,'library',NULL,NULL,'',NULL,'',NULL,'','2022-05-11 16:48:01','','2022-05-11 16:48:01');
/*!40000 ALTER TABLE `ComposerPackageNode` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-11 19:50:03


-- CONSULTA RECURSIVA PARA VER DEPENDENCIAS

WITH RECURSIVE tree_depedency (IdNode, IdParent, Name, dependency) AS
(
  SELECT IdNode,IdParent, Name as Name, CAST(CONCAT(Name, ' -> ') AS CHAR(120)) as dependency
    FROM ComposerPackageNode
    WHERE IdNode = 1 -- the tree node
  UNION ALL
  SELECT t.IdNode, t.IdParent, t.Name, CONCAT(tp.dependency, t.Name, ' -> ') as dependency
    FROM tree_depedency AS tp JOIN ComposerPackageNode AS t
      ON tp.IdNode = t.IdParent
)
SELECT * FROM tree_depedency
ORDER BY dependency; 
