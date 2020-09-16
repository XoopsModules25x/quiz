CREATE TABLE `xquiz_quiz` (
	`quiz_id` int(10) NOT NULL auto_increment,
	`quiz_title` varchar(255) NOT NULL,
	`quiz_description` text,
	`quiz_category` int(11) NOT NULL,
	`quiz_status` tinyint(1) NOT NULL,
	`quiz_create` int (10) NOT NULL,
	`quiz_uid` int(11) NOT NULL,
	`quiz_order` int(11) NOT NULL,
	`quiz_img` varchar(255) NOT NULL,
	`quiz_type` varchar (60) NOT NULL,
	`quiz_startdate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`quiz_enddate` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	PRIMARY KEY (`quiz_id`),
	KEY `select` (`quiz_category`, `quiz_status`, `quiz_type`),
	KEY `order` (`quiz_order`)
) ENGINE=MyISAM;

CREATE TABLE `xquiz_category` (
	`category_id` int (11) unsigned NOT NULL  auto_increment,
	`category_title` varchar (255)   NOT NULL ,
	`category_created` int (10)   NOT NULL default '0',
	PRIMARY KEY (`category_id`)
) ENGINE=MyISAM;