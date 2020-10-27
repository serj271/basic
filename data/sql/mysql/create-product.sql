
use yii2basic;

DROP TABLE IF EXISTS product_photo;
DROP TABLE IF EXISTS parcel;
DROP TABLE IF EXISTS `product_category_product`;
DROP TABLE IF EXISTS `order_product`;
DROP TABLE IF EXISTS `order`;

DROP TABLE IF EXISTS `product`;



CREATE TABLE `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `uri` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `primary_photo_id` int(10) unsigned DEFAULT NULL,
  `avg_review_rating` decimal(3,1) unsigned DEFAULT NULL,
  `visible` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `visible` (`visible`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `product_photo` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`product_id` int(10) unsigned NOT NULL,
	`path_fullsize` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
	`path_thumbnail` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE KEY `product_id_path_fullsize` (`product_id`,`path_fullsize`),
	KEY `product_id` (`product_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1 ;

ALTER TABLE `product_photo`
  ADD CONSTRAINT `product_photos_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE;


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
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT=1;

DROP TABLE IF EXISTS `catalog_category`;
CREATE TABLE `catalog_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_categori_id` int(10) unsigned NOT NULL DEFAULT '0',
  `level` int(10) unsigned NOT NULL DEFAULT '0',
  `uri` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `code` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `image` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `text` text COLLATE utf8mb4_general_ci NOT NULL,
  `active` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `position` int(10) unsigned NOT NULL DEFAULT '0',
  `title_tag` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `keywords_tag` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `description_tag` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `creator_id` int(10) NOT NULL DEFAULT '0',
  `updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updater_id` int(10) NOT NULL DEFAULT '0',
  `deleted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `deleter_id` int(10) NOT NULL DEFAULT '0',
  `delete_bit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `reference` varchar(32) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `status` varchar(10) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'new',
  `payment_method` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_price` decimal(6,2) unsigned NOT NULL DEFAULT '0.00',
  `shipping_method` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `vat_rate` decimal(4,2) unsigned NOT NULL DEFAULT '0.00',
  `discount` decimal(6,2) unsigned DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `billing_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `billing_telephone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `billing_addr1` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `billing_addr2` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `billing_addr3` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `billing_postal_code` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `billing_country` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_telephone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shipping_addr1` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_addr2` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `shipping_addr3` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_postal_code` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `shipping_country` char(2) COLLATE utf8mb4_general_ci NOT NULL,
  `notes` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reference` (`reference`),
  KEY `status` (`status`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `order_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `variation_id` int(10) unsigned DEFAULT NULL,
  `variation_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `quantity` mediumint(8) unsigned NOT NULL,
  `price` decimal(8,2) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`,`product_id`),
  CONSTRAINT `order_products_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL,
  `parent_id` int(10) unsigned DEFAULT NULL,
  `uri` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '',
  `delete_bit` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `product_category_product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `category_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_product` (`product_id`),
  KEY `fk_category_id` (`category_id`),
  UNIQUE KEY `ix_category` (`product_id`, `category_id`),
  CONSTRAINT `product_categories_products_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE,
  CONSTRAINT `product_categories_products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `product_category` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

