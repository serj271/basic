use yii2basic;

CREATE TABLE `product_categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `order` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `image` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
 


DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `primary_photo_id` int(10) unsigned DEFAULT NULL,
  `avg_review_rating` decimal(3,1) unsigned DEFAULT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `visible` (`visible`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

DROP TABLE IF EXISTS product_photo;
CREATE TABLE `product_photo` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`path_fullsize` varchar(255) COLLATE utf8_general_ci NOT NULL,
	`path_thumbnail` varchar(255) COLLATE utf8_general_ci NOT NULL,
	PRIMARY KEY (`id`),
	/* UNIQUE KEY `product_id_path_fullsize` (`product_id`,`path_fullsize`), */
	KEY `product_id` (`product_id`),
	CONSTRAINT `product_photo_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1 ;

/* ALTER TABLE `product_photo`
  ADD CONSTRAINT `product_photo_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE; */

DROP TABLE IF EXISTS parcel;
CREATE TABLE `parcel` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `code` varchar(255) NOT NULL,
  `height` int(10) NOT NULL,
  `width` int(10) NOT NULL,
  `depth` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  CONSTRAINT `parcel_product_id` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci AUTO_INCREMENT=1;

LOCK TABLES `product` WRITE;
INSERT INTO `product` (`id`,`name`,`uri`,`description`,`primary_photo_id`,`avg_review_rating`,`visible`) VALUES (1,'name products1','product1','description 1',1,2.0,1),(2,'name products2','product2','description 2',2,2.0,1),(3,'name products3','product3','description 3',3,2.0,1);
UNLOCK TABLES;

LOCK TABLES `product_photo` WRITE;
INSERT INTO `product_photo` (`id`,`product_id`,`path_fullsize`,`path_thumbnail`) VALUES (1,1,'#','#'),(2,2,'#','#'),(3,3,'#','#');
UNLOCK TABLES;
