/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.41-84.1 : Database - zedexper_mmrs_esl
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `add_product` */

CREATE TABLE `add_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(55) NOT NULL,
  `price` varchar(55) NOT NULL,
  `discount` varchar(55) NOT NULL,
  `expiry_date` varchar(55) NOT NULL,
  `esl_mac` varchar(55) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

/*Data for the table `add_product` */

insert  into `add_product`(`id`,`name`,`price`,`discount`,`expiry_date`,`esl_mac`) values (25,'Apple Sidra','12','1','1554328800',''),(27,'Pepsi','20','1','1555020000','3027010A33DD'),(34,'Jelly','50','12','1388790000',''),(35,'Chilli Milli','100','12','1517871600',''),(37,'Coca Cola','30','12','1455490800','7354010A33DD'),(40,'TopOp','50','11','1555106400',''),(44,'Jam','50','11','1554933600',''),(47,'Milk','40','11','1554674400','');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
