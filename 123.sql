/*
SQLyog Ultimate v12.09 (64 bit)
MySQL - 10.1.37-MariaDB : Database - laravel_test
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`laravel_test` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `laravel_test`;

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2017_07_12_145959_create_permission_tables',1);

/*Table structure for table `model_has_permissions` */

DROP TABLE IF EXISTS `model_has_permissions`;

CREATE TABLE `model_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_permissions` */

/*Table structure for table `model_has_roles` */

DROP TABLE IF EXISTS `model_has_roles`;

CREATE TABLE `model_has_roles` (
  `role_id` int(10) unsigned NOT NULL,
  `model_id` int(10) unsigned NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `model_has_roles` */

insert  into `model_has_roles`(`role_id`,`model_id`,`model_type`) values (1,1,'App\\User'),(3,26,'App\\User'),(4,27,'App\\User'),(5,19,'App\\User'),(5,23,'App\\User'),(5,24,'App\\User'),(5,25,'App\\User'),(5,28,'App\\User');

/*Table structure for table `notification` */

DROP TABLE IF EXISTS `notification`;

CREATE TABLE `notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(200) DEFAULT NULL,
  `field` varchar(200) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text,
  `create_dt` date DEFAULT NULL,
  `update_dt` date DEFAULT NULL,
  `chconfirm` tinyint(4) DEFAULT '0' COMMENT '0:no, 1:yes',
  `comment` text,
  `chdate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `notification` */

insert  into `notification`(`id`,`sender`,`field`,`subject`,`message`,`create_dt`,`update_dt`,`chconfirm`,`comment`,`chdate`) values (1,'subadmin','field','aaa','bbb','2019-07-29','2019-07-29',1,'asdf',NULL),(2,'subadmin','field','aaa1','bbb2','2019-07-29','2019-07-29',0,NULL,NULL),(3,'Admin','field','213','123123\r\nsd\r\nfs\r\ndf\r\nsd\r\nfsdf','2019-07-30','2019-07-30',0,NULL,NULL),(4,'Admin','field','123','123\r\n2\r\n3\r\n2\r\n3\r\n23\r\n2\r\n3\r\n2\r\n3','2019-07-31','2019-07-31',1,NULL,'2019-08-01');

/*Table structure for table `password_resets` */

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_resets` */

insert  into `password_resets`(`email`,`token`,`created_at`) values ('admin@admin.com','$2y$10$7hMCfSsWG6uR2xfpg0zbQ.tZkPk5XuFvXOHMMJ2Cy7tDrmxhyB9RG','2019-07-26 07:57:55'),('pandaios@eclipso.ch','$2y$10$tUEVZGAX5muRjXVpjRZUQOxVoos0BKLLnmB9mCXl6OOa5R3Ce0TVi','2019-08-01 02:44:26');

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'users_manage','web','2019-07-25 17:30:48','2019-07-25 17:30:48'),(3,'customers_manage','web','2019-07-25 17:36:19','2019-07-25 17:38:59'),(5,'notifications_manage','web','2019-07-25 17:39:25','2019-07-25 17:39:25'),(6,'receipts_manage','web','2019-07-25 17:39:34','2019-07-25 17:39:43'),(7,'confirming the notification','web','2019-07-25 17:40:01','2019-07-25 17:40:01'),(8,'See the receipt','web','2019-07-25 17:40:07','2019-07-25 17:40:07'),(9,'only send notifications','web','2019-07-25 17:40:47','2019-07-25 17:40:47'),(10,'sub users manage','web','2019-07-25 17:42:13','2019-07-25 17:54:34');

/*Table structure for table `receipt` */

DROP TABLE IF EXISTS `receipt`;

CREATE TABLE `receipt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender` varchar(200) DEFAULT NULL,
  `field` varchar(200) DEFAULT NULL,
  `filename` varchar(200) DEFAULT NULL,
  `create_dt` date DEFAULT NULL,
  `update_dt` date DEFAULT NULL,
  `basefilename` varchar(200) DEFAULT NULL,
  `ch` tinyint(4) DEFAULT '0',
  `chdate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `receipt` */

insert  into `receipt`(`id`,`sender`,`field`,`filename`,`create_dt`,`update_dt`,`basefilename`,`ch`,`chdate`) values (1,'Admin','field','1564435295.sql','2019-07-29','2019-07-29','1.sql',1,'2019-08-01'),(2,'Admin','field','1564435304.sql','2019-07-29','2019-07-29','2.sql',1,'2019-08-01');

/*Table structure for table `role_has_permissions` */

DROP TABLE IF EXISTS `role_has_permissions`;

CREATE TABLE `role_has_permissions` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `role_has_permissions` */

insert  into `role_has_permissions`(`permission_id`,`role_id`) values (1,1),(3,1),(3,3),(5,1),(5,3),(6,1),(6,3),(6,4),(7,1),(7,5),(8,1),(8,5),(9,4),(10,1),(10,3);

/*Table structure for table `roles` */

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `roles` */

insert  into `roles`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'administrator','web','2019-07-25 17:30:48','2019-07-25 17:30:48'),(3,'super admin','web','2019-07-25 17:41:52','2019-07-25 17:41:52'),(4,'sub admin','web','2019-07-25 17:43:13','2019-07-25 17:43:13'),(5,'field','web','2019-07-25 17:43:55','2019-07-25 17:43:55');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`password`,`remember_token`,`created_at`,`updated_at`) values (1,'Admin','admin@admin.com','$2y$10$372AgHC7HJTaL0j/0uK8s.k1mt6SCYC9gomud8GzRohZxdyV6InZO','u6OtQA7oSb89wy37RMO7BGOfFDHvJJJzdKgQtkY4pIpIisVatUffzbzauWaa','2019-07-25 17:30:48','2019-07-26 17:57:00'),(19,'field','pandaios@eclipso.ch','$2y$10$I/0a1R8J6R898Gf4Qz0EGe6gpCo/uwHE2O.FkKq08.B.ycADR92Cq','z28WLGHIhdZDoX4m01I6PMhk0cNjsyECJ1C8gbDoilsU5z2OCqvBOyLXYZO5','2019-07-26 15:25:39','2019-07-26 18:09:14'),(26,'superadmin','superadmin@test.com','$2y$10$t8tl3r5kbm.pobEn/9QlLeyhHqBbZmaSDeklm3RB5Bt3Nt/87cQ6.','pfv679ny05NUzuIsswHjCbGXnG6W2oOocRTVkaUw38oBk5KCnEVhZGnZodpc','2019-07-28 11:39:23','2019-07-28 11:39:23'),(27,'subadmin','subadmin@test.com','$2y$10$6/I/V8.qs3asRg8HQKTu9u8kmrPudf4l1zmCt0AQSbxec4eC0P3Sa','v7p4TmrpBuyxQFNp0sb5dwZBFjLoXfacouDmg8JBJawxw9QavIUpqEqnbhBV','2019-07-28 11:39:40','2019-07-28 11:39:40'),(28,'field1','field1@test.com','$2y$10$a9hu7HBXIVMu0RjqjMcQlOZXQ1GCG08ByYdT7IqTaZ/Ui5C9mhQ2u',NULL,'2019-07-28 20:25:21','2019-07-28 20:25:21');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
