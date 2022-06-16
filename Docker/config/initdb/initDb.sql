SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS `MemberList`;
USE `MemberList`;

CREATE TABLE  if not exists `Members`
(
    `memberId`   int(11) auto_increment primary key ,
    `firstName` varchar(30)  NOT NULL,
    `lastName`  varchar(30)  NOT NULL,
    `date` varchar(255)  NOT NULL,
    `subject` varchar(255)  NOT NULL,
    `country` varchar(255)  NOT NULL,
    `phone` varchar(255)  NOT NULL,
    `email` varchar(255)  NOT NULL UNIQUE,
    `company` varchar(255)   NOT NULL default '',
    `position` varchar(255)  NOT NULL default '',
    `about` varchar(255)  NOT NULL default '',
    `photo` varchar(255)  NOT NULL default ''
)
    DEFAULT CHARSET = utf8;