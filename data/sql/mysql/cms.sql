USE yii2basic;

/* alter table `roles_users` drop foreign key `roles_users_ibfk_1`,
drop foreign key `roles_users_ibfk_2`; */

/* alter table `user_tokens` drop foreign key `user_tokens_ibfk_1`; */
DROP TABLE IF EXISTS `comment`;
DROP TABLE IF EXISTS `page_has_file`;
DROP TABLE IF EXISTS `page`; 
DROP TABLE IF EXISTS `file`;

DROP TABLE IF EXISTS `user`; 

CREATE TABLE IF NOT EXISTS user (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(45) NOT NULL,
	`email` VARCHAR(60) NOT NULL,
	`pass` CHAR(64) NOT NULL,
	`auth_key` varchar(32) NOT NULL,
	`password_hash` varchar(255) NOT NULL DEFAULT '',
	`password_reset_token` varchar(255) NOT NULL DEFAULT '',
	`status` smallint(10) NOT NULL DEFAULT 0,
	`role` int(11) NOT NULL DEFAULT 1,
	`created_at` int(11) NOT NULL DEFAULT 0,
	`updated_at` int(11) NOT NULL DEFAULT 0,
	type ENUM('public','author','admin') NOT NULL DEFAULT 'public',
	`date_entered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `username_UNIQUE` (`username` ASC),
	UNIQUE INDEX `email_UNIQUE` (`email` ASC) 
)
ENGINE = InnoDB;
/* DEFAULT CHARACTER SET = utf8; */

CREATE TABLE IF NOT EXISTS `page` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`live` TINYINT(1) UNSIGNED NOT NULL DEFAULT 0,
	`title` VARCHAR(100) NOT NULL,
	`content` LONGTEXT NULL,
	`date_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`date_published` DATE NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_page_user_idx` (`user_id` ASC),
	INDEX `date_published` (`date_published` ASC),
	CONSTRAINT `fk_page_user`
	FOREIGN KEY (`user_id` )
	REFERENCES user (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `comment` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`page_id` INT UNSIGNED NOT NULL,
	`comment` MEDIUMTEXT NOT NULL,
	`date_entered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`),
	INDEX `fk_comment_user_idx` (`user_id` ASC),
	INDEX `fk_comment_page_idx` (`page_id` ASC),
	INDEX `date_entered` (`date_entered` ASC),
	CONSTRAINT `fk_comment_user`
	FOREIGN KEY (`user_id`)
	REFERENCES user (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION,
	CONSTRAINT `fk_comment_page`
	FOREIGN KEY (`page_id`)
	REFERENCES page (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `file` (
	`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT UNSIGNED NOT NULL,
	`name` VARCHAR(80) NOT NULL,
	`type` VARCHAR(45) NOT NULL,
	`size` INT UNSIGNED NOT NULL,
	`description` MEDIUMTEXT NULL,
	`date_entered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`date_updated` DATETIME DEFAULT NULL,
	PRIMARY KEY (`id`),
	INDEX `fk_file_user1_idx` (`user_id` ASC),
	INDEX `name` (name ASC),
	INDEX `date_entered` (`date_entered` ASC),
	CONSTRAINT `fk_file_user`
	FOREIGN KEY (`user_id`)
	REFERENCES user (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION
)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `page_has_file` (
	`page_id` INT UNSIGNED NOT NULL,
	`file_id` INT UNSIGNED NOT NULL,
	PRIMARY KEY (`page_id`, `file_id`),
	INDEX `fk_page_has_file_file_idx` (file_id ASC),
	INDEX `fk_page_has_file_page_idx` (page_id ASC),
	CONSTRAINT `fk_page_has_file_page`
	FOREIGN KEY (`page_id`)
	REFERENCES page (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION,
	CONSTRAINT `fk_page_has_file_file`
	FOREIGN KEY (`file_id`)
	REFERENCES file (`id`)
	ON DELETE CASCADE
	ON UPDATE NO ACTION
)
ENGINE = InnoDB;


/* DEFAULT CHARACTER SET = utf8;
COLLATE = utf8_general_ci; */
