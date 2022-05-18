# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.7.32)
# Database: onboard
# Generation Time: 2022-05-18 19:07:03 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table list_tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `list_tasks`;

CREATE TABLE `list_tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `task_order` int(11) DEFAULT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `list_id` (`list_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lists`;

CREATE TABLE `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) CHARACTER SET utf8mb4 NOT NULL DEFAULT '',
  `description` longtext CHARACTER SET utf8mb4,
  `tasks_order` text CHARACTER SET utf8mb4,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table project_lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project_lists`;

CREATE TABLE `project_lists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(11) DEFAULT NULL,
  `list_id` int(11) DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_id` (`project_id`,`list_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `projects`;

CREATE TABLE `projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4,
  `is_template` tinyint(1) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tasks`;

CREATE TABLE `tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT '',
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_completed` tinyint(1) DEFAULT '0',
  `parent_id` int(11) DEFAULT '0' COMMENT 'For subtasks, set this to its parent task. Else set it to 0.',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` int(11) DEFAULT '0' COMMENT 'Soft delete. When a task is deleted by the user, set this field to 1.',
  `completed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_lists
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_lists`;

CREATE TABLE `user_lists` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `list_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_list` (`list_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_projects
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_projects`;

CREATE TABLE `user_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_project` (`project_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table user_tasks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user_tasks`;

CREATE TABLE `user_tasks` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `is_deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) DEFAULT NULL,
  `lastname` varchar(20) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `description` longtext,
  `phone_work` varchar(12) DEFAULT NULL,
  `phone_private` varchar(12) DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `is_deleted` tinyint(1) DEFAULT '0',
  `api_user` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  `password_hash` varchar(250) NOT NULL DEFAULT '',
  `password_salt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `title`, `description`, `phone_work`, `phone_private`, `img`, `is_admin`, `is_deleted`, `api_user`, `api_secret`, `password_hash`, `password_salt`)
VALUES
	(1,'admin',NULL,'admin',NULL,NULL,NULL,NULL,NULL,1,0,'4ba1d4852680ed840b7966e7b9aa0e26','d45ab08c78ffac926a699e5067eca0e9','$2y$10$4hSA.4Ef9QEkaCcFlT6J8uOM.2Ihz0v8GMQZpOe.1ABMfArxzr9rS',NULL);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
