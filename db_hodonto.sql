# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.5-10.1.29-MariaDB)
# Database: db_hodonto
# Generation Time: 2018-12-09 12:23:29 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table tb_dentists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_dentists`;

CREATE TABLE `tb_dentists` (
  `id_dentist` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `doc_number` varchar(75) DEFAULT NULL,
  PRIMARY KEY (`id_dentist`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tb_patients
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_patients`;

CREATE TABLE `tb_patients` (
  `id_patient` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `doc_number` varchar(45) DEFAULT NULL,
  `telephone` varchar(45) DEFAULT NULL,
  `cellphone` varchar(45) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `street` varchar(150) DEFAULT NULL,
  `street_number` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `state` varchar(45) DEFAULT NULL,
  `zipcode` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_patient`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tb_schedules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_schedules`;

CREATE TABLE `tb_schedules` (
  `id_schedule` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_dentist` int(11) NOT NULL,
  `id_patient` int(11) NOT NULL,
  `date_time_begin` datetime NOT NULL,
  `date_time_end` datetime NOT NULL,
  `observation` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id_schedule`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tb_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_users`;

CREATE TABLE `tb_users` (
  `id_user` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(60) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table tb_userspasswordsrecoveries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tb_userspasswordsrecoveries`;

CREATE TABLE `tb_userspasswordsrecoveries` (
  `id_recovery` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `iduser` int(11) NOT NULL,
  `ip` varchar(45) NOT NULL DEFAULT '',
  `dtrecovery` datetime DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_recovery`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
