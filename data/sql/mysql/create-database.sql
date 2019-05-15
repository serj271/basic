DROP DATABASE IF EXISTS yii2basic;
CREATE DATABASE yii2basic DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL PRIVILEGES ON yii2basic.* TO 'user_db'@'localhost';


use yii2basic;

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `primary_photo_id` int(10) unsigned DEFAULT NULL,
  `avg_review_rating` decimal(3,1) unsigned DEFAULT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `visible` (`visible`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


LOCK TABLES `products` WRITE;
INSERT INTO `products` VALUES (1,'name products1','product1','description 1',1,2.0,1),(2,'name products2','product2','description 2',2,2.0,1),(3,'name products3','product3','description 3',3,2.0,1);
UNLOCK TABLES;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `auth_key` varchar(32) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `password_reset_token` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `status` smallint(10) NOT NULL,
  `role` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);

