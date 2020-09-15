CREATE TABLE `xquiz_item` (
	`item_id` int(10) NOT NULL auto_increment,
	`item_title` varchar(255) NOT NULL,
	`item_caption` text,
	`item_category` int(11) NOT NULL,
	`item_link` varchar(255) NOT NULL,
	`item_linktarget`  TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',
	`item_status` tinyint(1) NOT NULL,
	`item_create` int (10) NOT NULL,
	`item_uid` int(11) NOT NULL,
	`item_order` int(11) NOT NULL,
	`item_img` varchar(255) NOT NULL,
	`item_type` varchar (60) NOT NULL,
	`item_startdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`item_enddate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `item_languagecode` varchar (60) NOT NULL,
	PRIMARY KEY (`item_id`),
	KEY `select` (`item_category`, `item_status`, `item_type`),
	KEY `order` (`item_order`)
) ENGINE=MyISAM;

CREATE TABLE `xquiz_category` (
	`category_id` int (11) unsigned NOT NULL  auto_increment,
	`category_title` varchar (255)   NOT NULL ,
	`category_created` int (10)   NOT NULL default '0',
	PRIMARY KEY (`category_id`)
) ENGINE=MyISAM;