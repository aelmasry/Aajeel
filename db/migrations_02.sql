ALTER TABLE `sources`
	DROP  `category_id`;
	DROP  `country_id`;
	
ALTER TABLE `sources_rss`
	ADD  `category_id` INT(10) NULL DEFAULT '0' AFTER `source_id`,
	ADD  `country_id` INT(10) NOT NULL DEFAULT '0' AFTER `category_id`;

	
		
ALTER TABLE `articles`
	ADD  `category_id` INT(10) NULL DEFAULT '0' AFTER `source_id`,
	ADD  `country_id` INT(10) NOT NULL DEFAULT '0' AFTER `category_id`;

ALTER TABLE `countries` ADD  `code` CHAR(5) NULL AFTER `alias`;
	
ALTER TABLE `sources` DROP  `getdata`;
ALTER TABLE `sources` ADD  `country_id` INT(10) NOT NULL DEFAULT '0' AFTER `logo`;