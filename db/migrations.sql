ALTER TABLE `users` ADD COLUMN `active` INT(11) NULL DEFAULT '1' AFTER `role_id`;

ALTER TABLE `articles` ADD COLUMN `hits` INT(10) NULL DEFAULT '0' AFTER `permalink`;

ALTER TABLE `articles` DROP COLUMN `publish_up`;


DROP TABLE IF EXISTS `tags`;

CREATE TABLE IF NOT EXISTS `tags` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255) NOT NULL,
	`alias` VARCHAR(255) NOT NULL,
	`hits` INT(10) NOT NULL DEFAULT '0',
	`status` INT(10) NOT NULL DEFAULT '1',
	`created` DATETIME NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `name` (`name`),
	INDEX `alias` (`alias`, `status`)
)
COLLATE='utf8_general_ci'
ENGINE=InnoDB;


ALTER TABLE `articles`
	ADD INDEX `category_id` (`category_id`),
	ADD INDEX `source_id` (`source_id`),
        ADD INDEX `created` (`created`);




