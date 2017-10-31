CREATE DATABASE  IF NOT EXISTS `quickpub`;
USE `quickpub`;

CREATE TABLE `flow_entrys` (
	`entry_id` int(11) NOT NULL AUTO_INCREMENT,
	`flow_id` int(11) NOT NULL,
	`owner_id` int(11) NOT NULL,
	`created_by_role` varchar(2) NOT NULL,
	`content` text,
	PRIMARY KEY (`entry_id`,`flow_id`,`owner_id`),
	UNIQUE KEY `entry_id_UNIQUE` (`entry_id`)
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

CREATE TABLE `flows` (
	`flow_id` int(11) NOT NULL AUTO_INCREMENT,
	`name` varchar(45) NOT NULL,
	`owner_id` int(11) NOT NULL,
	`created_by_role` varchar(2) NOT NULL,
	PRIMARY KEY (`flow_id`,`owner_id`,`name`),
	UNIQUE KEY `flow_id_UNIQUE` (`flow_id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8;

CREATE TABLE `login_info` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`primary_email` varchar(45) NOT NULL,
	`password` varchar(60) NOT NULL,
	`date_added` varchar(17) NOT NULL,
	`token` varchar(30) NOT NULL,
	PRIMARY KEY (`user_id`,`primary_email`),
	UNIQUE KEY `user_id_UNIQUE` (`user_id`),
	UNIQUE KEY `primary_email_UNIQUE` (`primary_email`),
	UNIQUE KEY `token_UNIQUE` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

CREATE TABLE `user_info` (
	`user_id` int(11) NOT NULL AUTO_INCREMENT,
	`primary_email` varchar(45) NOT NULL,
	`secondary_email` varchar(45) DEFAULT NULL,
	`first_name` varchar(15) NOT NULL,
	`middle_name` varchar(15) DEFAULT NULL,
	`last_name` varchar(15) NOT NULL,
	`prefix` varchar(3) NOT NULL,
	`date_added` varchar(17) NOT NULL,
	`roles` varchar(45) DEFAULT NULL,
	PRIMARY KEY (`user_id`,`primary_email`),
	UNIQUE KEY `user_id_UNIQUE` (`user_id`),
	UNIQUE KEY `primary_email_UNIQUE` (`primary_email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
