
use yii2basic;

CREATE TABLE IF NOT EXISTS user (
   `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
   `username` VARCHAR(45) NOT NULL,
   `email` VARCHAR(60) NOT NULL,
   `pass` CHAR(64) DEFAULT '',
   `auth_key` varchar(32) NOT NULL,
   `password_hash` varchar(255) NOT NULL DEFAULT '',
   `password_reset_token` varchar(255) NOT NULL DEFAULT '',
   `status` smallint(10) NOT NULL DEFAULT 0,
/* `role` int(11) NOT NULL DEFAULT 1,*/
   `created_at` int(11) NOT NULL DEFAULT 0,
   `updated_at` int(11) NOT NULL DEFAULT 0,
/* type ENUM('public','author','admin') NOT NULL DEFAULT 'public',*/
/* `date_entered` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,*/
   PRIMARY KEY (`id`),
   UNIQUE INDEX `username_UNIQUE` (`username` ASC),
   UNIQUE INDEX `email_UNIQUE` (`email` ASC) 
)
ENGINE = InnoDB;