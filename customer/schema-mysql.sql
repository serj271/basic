use yii2basic;

DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`name` varchar(50) NOT NULL,
	`surname` varchar(50) NOT NULL,
	`phone_number` varchar(50) DEFAULT NULL

);

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
	`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	`room_id` int(11) NOT NULL,
	`customer_id` int(11) NOT NULL,
	`price_per_day` decimal(20,2) NOT NULL,
	`date_from` date NOT NULL,
	`date_to` date NOT NULL,
	`reservation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	KEY `room_id` (`room_id`),
	KEY `customer_id` (`customer_id`)
);


