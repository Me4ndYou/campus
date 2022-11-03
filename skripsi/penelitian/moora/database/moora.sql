/*
SQLyog Ultimate v9.50 
MySQL - 5.5.5-10.4.14-MariaDB : Database - moora
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`moora` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `moora`;

/*Table structure for table `tb_admin` */

DROP TABLE IF EXISTS `tb_admin`;

CREATE TABLE `tb_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`user`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tb_admin` */

insert  into `tb_admin`(`user`,`pass`) values ('admin','admin');

/*Table structure for table `tb_alternatif` */

DROP TABLE IF EXISTS `tb_alternatif`;

CREATE TABLE `tb_alternatif` (
  `kode_alternatif` varchar(16) NOT NULL,
  `nama_alternatif` varchar(255) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `total` double DEFAULT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`kode_alternatif`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_alternatif` */

insert  into `tb_alternatif`(`kode_alternatif`,`nama_alternatif`,`keterangan`,`total`,`rank`) values ('A01','Opo','',NULL,NULL),('A02','Xiomey','',NULL,NULL),('A03','Zenpon','',NULL,NULL),('A04','Xpera','',NULL,NULL),('A05','Glaxy','',NULL,NULL),('A06','Vio','',NULL,NULL),('A07','Ipone','',NULL,NULL);

/*Table structure for table `tb_kriteria` */

DROP TABLE IF EXISTS `tb_kriteria`;

CREATE TABLE `tb_kriteria` (
  `kode_kriteria` varchar(16) NOT NULL,
  `nama_kriteria` varchar(255) DEFAULT NULL,
  `atribut` varchar(16) DEFAULT NULL,
  `bobot` double DEFAULT NULL,
  PRIMARY KEY (`kode_kriteria`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Data for the table `tb_kriteria` */

insert  into `tb_kriteria`(`kode_kriteria`,`nama_kriteria`,`atribut`,`bobot`) values ('C01','RAM (GB)','benefit',0.25),('C02','Kamera (MP)','benefit',0.2),('C03','Storage (GB)','benefit',0.1),('C04','Harga (Rp)','cost',0.25),('C05','Ketebalan','cost',0.2);

/*Table structure for table `tb_rel_alternatif` */

DROP TABLE IF EXISTS `tb_rel_alternatif`;

CREATE TABLE `tb_rel_alternatif` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `kode_alternatif` varchar(16) DEFAULT NULL,
  `kode_kriteria` varchar(16) DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;

/*Data for the table `tb_rel_alternatif` */

insert  into `tb_rel_alternatif`(`ID`,`kode_alternatif`,`kode_kriteria`,`nilai`) values (1,'A01','C01',3),(2,'A01','C02',12),(3,'A01','C03',32),(4,'A01','C04',4000000),(5,'A01','C05',8.8),(6,'A02','C01',3),(7,'A02','C02',10),(8,'A02','C03',64),(9,'A02','C04',3500000),(10,'A02','C05',8),(11,'A03','C01',2),(12,'A03','C02',8),(13,'A03','C03',64),(14,'A03','C04',4000000),(15,'A03','C05',8.8),(19,'A04','C01',3),(20,'A04','C02',12),(21,'A04','C03',64),(22,'A04','C04',6000000),(23,'A04','C05',8.2),(50,'A05','C01',4),(51,'A05','C02',12),(52,'A05','C03',128),(53,'A05','C04',5000000),(54,'A05','C05',8.2),(56,'A06','C01',3),(57,'A06','C02',8),(58,'A06','C03',32),(59,'A06','C04',3500000),(60,'A06','C05',8.5),(62,'A07','C01',4),(63,'A07','C02',12),(64,'A07','C03',128),(65,'A07','C04',7000000),(66,'A07','C05',7.7);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
