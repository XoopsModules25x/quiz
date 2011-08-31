<?php

/**
 * Questionair forms with export and plugin set (based on formulaire)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       Chronolabs Co-Op http://www.chronolabs.coop/
 * @license         http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xquiz
 * @since           1.0.5
 * @author          Simon Roberts <simon@chronolabs.coop>
 */
function xoops_module_pre_install_xquiz(&$module) {

	xoops_loadLanguage('modinfo', 'xshop');
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms_form")."` (
	  `id_forms_form` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	  `id_form` int(5) NOT NULL DEFAULT '0',
	  `id_req` smallint(5) DEFAULT NULL,
	  `ele_id` smallint(5) unsigned NOT NULL,
	  `ele_type` ENUM('twitter','facebook','name','email','text','textarea','areamodif','select','checkbox','mail','mailunique','radio','yn','date','sep','upload') DEFAULT 'text',
	  `ele_caption` varchar(255) NOT NULL DEFAULT '',
	  `ele_value` text,
	  `date` date NOT NULL DEFAULT '2011-08-24',
	  `uid` int(10) DEFAULT '0',
	  `ip` varchar(50) DEFAULT NULL,
	  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `rep` text,
	  `nbrep` int(5) DEFAULT NULL,
	  `nbtot` int(5) DEFAULT NULL,
	  `pos` int(10) DEFAULT NULL,
	  `created` int(12) unsigned DEFAULT NULL,
	  `updated` int(12) unsigned DEFAULT NULL,  
	  `actioned` INT(12) UNSIGNED DEFAULT '0',
	  PRIMARY KEY (`id_forms_form`),
	  KEY `ele_id` (`ele_id`, `ele_type`)
	) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms_id")."` (
	  `id_form` smallint(5) NOT NULL AUTO_INCREMENT,
	  `title` varchar(128) NOT NULL DEFAULT '',
	  `desc_forms` varchar(255) NOT NULL DEFAULT '',
	  `admin` varchar(5) DEFAULT NULL,
	  `groupe` varchar(255) DEFAULT NULL,
	  `email` varchar(255) DEFAULT NULL,
	  `expe` varchar(5) DEFAULT NULL,
	  `url` varchar(255) DEFAULT NULL,
	  `help` text,
	  `send` varchar(255) DEFAULT NULL,
	  `msend` varchar(5) DEFAULT NULL,
	  `msub` varchar(5) DEFAULT NULL,
	  `mip` varchar(5) DEFAULT NULL,
	  `mnav` varchar(5) DEFAULT NULL,
	  `cod` varchar(255) DEFAULT NULL,
	  `save` varchar(5) DEFAULT NULL,
	  `onlyone` varchar(5) DEFAULT NULL,
	  `image` varchar(255) DEFAULT NULL,
	  `nbjours` int(10) DEFAULT NULL,
	  `afftit` varchar(5) DEFAULT NULL,
	  `affimg` varchar(5) DEFAULT NULL,
	  `ordre` varchar(50) DEFAULT NULL,
	  `qcm` varchar(5) NOT NULL DEFAULT '',
	  `affres` varchar(5) DEFAULT NULL,
	  `affrep` varchar(5) DEFAULT NULL,
	  `tag` varchar(255) DEFAULT '',
	  `created` int(12) unsigned DEFAULT NULL,
	  `updated` int(12) unsigned DEFAULT NULL,  
	  PRIMARY KEY (`id_form`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms_id")."` (`id_form`,`title`,`admin`,`groupe`,`email`,`expe`,`url`,`help`,`send`,`msend`,`msub`,`mip`,`mnav`,`cod`,`save`,`onlyone`,`image`,`nbjours`,`afftit`,`affimg`,`ordre`,`qcm`,`affres`,`affrep`) values (1,'Exemple de xquiz','','0','me@mydomain.com','','/modules/xquiz/index.php?id=1','xquiz de demo','envoyer','','','','','ISO-8859-1','1','0','',0,'1','1','tit','','','')";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms_menu")."` (
	  `menuid` int(4) unsigned NOT NULL AUTO_INCREMENT,
	  `position` int(4) unsigned NOT NULL,
	  `indent` int(2) unsigned NOT NULL DEFAULT '0',
	  `itemname` varchar(60) NOT NULL DEFAULT '',
	  `margintop` varchar(12) NOT NULL DEFAULT '0',
	  `marginbottom` varchar(12) NOT NULL DEFAULT '0',
	  `itemurl` varchar(255) NOT NULL DEFAULT '',
	  `bold` tinyint(1) NOT NULL DEFAULT '0',
	  `status` tinyint(1) NOT NULL DEFAULT '1',
	  `created` int(12) unsigned DEFAULT NULL,
	  `updated` int(12) unsigned DEFAULT NULL,  
	  PRIMARY KEY (`menuid`),
	  KEY `idxmymenustatus`(`status`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8";
	
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms_menu")."` ( `menuid`,`position`,`indent`,`itemname`,`margintop`,`marginbottom`,`itemurl`,`bold`,`status`) values (1,0,0,'Exemple d`utilisation d`un quiz','0','0','http://localhost/modules/xquiz/xquiz.php?id=1',0,1)";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms_answers")."` (
	  `id_answer` int(19) unsigned NOT NULL AUTO_INCREMENT,
	  `id_form` int(5) unsigned DEFAULT '0',
	  `id_ele` int(5) unsigned DEFAULT '0',
	  `id_user` int(10) unsigned DEFAULT '0',
	  `value_ele` text,
	  `value_score` int(10) unsigned DEFAULT '0',
	  `value_answers` int(10) unsigned DEFAULT '0',
	  `response` int(13) unsigned DEFAULT '0',
	  `created` int(12) unsigned DEFAULT NULL,
	  `updated` int(12) unsigned DEFAULT NULL,  
	  PRIMARY KEY (`id_answer`)
	) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms_oauth")."` (
	  `oid` INT(13) UNSIGNED NOT NULL AUTO_INCREMENT,
	  `mode` ENUM('valid','invalid','expired','disabled','other') DEFAULT NULL,
	  `consumer_key` VARCHAR(255) DEFAULT NULL,
	  `consumer_secret` VARCHAR(255) DEFAULT NULL,
	  `oauth_token` VARCHAR(255) DEFAULT NULL,
	  `oauth_token_secret` VARCHAR(255) DEFAULT NULL,
	  `username` VARCHAR(64) DEFAULT NULL,
	  `ip` VARCHAR(64) DEFAULT NULL,
	  `netbios` VARCHAR(255) DEFAULT NULL,
	  `uid` INT(13) UNSIGNED DEFAULT '0', 
	  `created` INT(13) UNSIGNED DEFAULT '0', 
	  `actioned` INT(13) UNSIGNED DEFAULT '0', 
	  `updated` INT(13) UNSIGNED DEFAULT '0',
	  `tweeted` INT(13) UNSIGNED DEFAULT '0',  
	  `friends` INT(13) UNSIGNED DEFAULT '0',
	  `mentions` INT(13) UNSIGNED DEFAULT '0',
	  `tweets` INT(13) UNSIGNED DEFAULT '0',  
	  `calls` INT(13) UNSIGNED DEFAULT '0',
	  `remaining_hits` INT(13) UNSIGNED DEFAULT '0',
	  `hourly_limit` INT(13) UNSIGNED DEFAULT '0',
	  `api_resets` INT(13) UNSIGNED DEFAULT '0',  
	  PRIMARY KEY (`oid`)
	) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms_responses")."` (
	  `id_score` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `id_form` int(10) unsigned DEFAULT '0',
	  `minimum` int(10) unsigned DEFAULT '0',
	  `maximum` int(10) unsigned DEFAULT '0',
	  `html` text,
	  `title` varchar(255) DEFAULT NULL,
	  `created` int(12) unsigned DEFAULT NULL,
	  `updated` int(12) unsigned DEFAULT NULL,  
	  PRIMARY KEY (`id_score`)
	) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms_users")."` (
	  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `id_form` int(10) unsigned DEFAULT NULL,
	  `uid` int(13) unsigned DEFAULT NULL,
	  `name` varchar(128) DEFAULT NULL,
	  `email` varchar(255) DEFAULT NULL,
	  `twitter` varchar(64) DEFAULT NULL,
	  `facebook` varchar(255) DEFAULT NULL,
	  `score` int(10) unsigned DEFAULT NULL,
	  `questions` int(10) unsigned DEFAULT NULL,
	  `followed` tinyint(1) unsigned DEFAULT '0',
	  `answers` int(10) unsigned DEFAULT NULL,
	  `created` int(12) unsigned DEFAULT NULL,
	  `updated` int(12) unsigned DEFAULT NULL,
	  PRIMARY KEY (`id_user`)
	) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "CREATE TABLE `".$GLOBALS['xoopsDB']->prefix("forms")."` (
	  `ele_type` ENUM('twitter','facebook','name','email','text','textarea','areamodif','select','checkbox','mail','mailunique','radio','yn','date','sep','upload') DEFAULT 'text',
	  `ele_caption` VARCHAR(255) DEFAULT NULL,
	  `ele_order` SMALLINT(2) DEFAULT '0',
	  `ele_req` TINYINT(1) UNSIGNED DEFAULT '1',
	  `ele_value` TEXT,
	  `ele_scores` TEXT,
	  `ele_display` TINYINT(1) UNSIGNED DEFAULT '1',
	  `id_form` INT(5) UNSIGNED DEFAULT NULL,
	  `ele_id` SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,  
	  `created` INT(12) UNSIGNED DEFAULT '0',
	  `updated` INT(12) DEFAULT '0',
	  `actioned` INT(12) UNSIGNED DEFAULT '0', 
	  PRIMARY KEY (`ele_id`),
	  KEY `COMMON` (`id_form`,`ele_type`,`ele_order`,`ele_req`,`ele_display`)
	) ENGINE=INNODB DEFAULT CHARSET=utf8";
	
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,1,'sep','{null}',0,0,'a:3:{i:0;s:72:\"<font color=#e00000><h5><center>Titre du xquiz</center></h5></font>\";i:1;i:5;i:2;i:35;}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,2,'textarea','Text area',1,0,'a:3:{i:0;s:25:\"Voici un texte quelconque\";i:1;i:2;i:2;i:35;}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,3,'date','date de création',2,0,'a:1:{i:0;s:10:\"2004-05-04\";}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,4,'text','Text box : nom de l\'utilisateur',3,0,'a:3:{i:0;i:30;i:1;i:255;i:2;s:7:\"{UNAME}\";}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,5,'text','Text box : adresse e-mail de l\'utilisateur',4,0,'a:3:{i:0;i:30;i:1;i:255;i:2;s:8:\"{EMAIL} \";}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,6,'sep','{null}',5,0,'a:3:{i:0;s:84:\"<font color=#4A766E><h5><center>Les informs_ations commencent ici</center></h5></font>\";i:1;i:5;i:2;i:35;}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,7,'radio','Radio button : un seul bouton peut être coché',6,0,'a:2:{s:14:\"premier bouton\";i:0;s:13:\"second bouton\";i:1;}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,8,'checkbox','Check boxes',8,0,'a:5:{s:11:\"1ère option\";i:1;s:11:\"2ème option\";i:1;s:11:\"3ème option\";i:1;s:11:\"4ème option\";i:1;s:11:\"5ème option\";i:1;}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,9,'areamodif','Texte area non modifiable',7,0,'a:3:{i:0;s:107:\"Le champ suivant permet de créer autant d\'options souhaitées. Elles sont ensuite à cocher par l\'utilisateur\";i:1;i:5;i:2;i:35;}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,10,'upload','Fichier joint',9,0,'a:3:{i:0;N;i:1;d:204800;i:2;a:6:{i:0;a:4:{i:1;s:3:\"pdf\";s:5:\"value\";s:3:\"pdf\";i:0;i:0;s:3:\"key\";i:0;}i:1;a:4:{i:1;s:3:\"doc\";s:5:\"value\";s:3:\"doc\";i:0;i:1;s:3:\"key\";i:1;}i:2;a:4:{i:1;s:3:\"txt\";s:5:\"value\";s:3:\"txt\";i:0;i:2;s:3:\"key\";i:2;}i:3;a:4:{i:1;s:3:\"gif\";s:5:\"value\";s:3:\"gif\";i:0;i:3;s:3:\"key\";i:3;}i:4;a:4:{i:1;s:4:\"mpeg\";s:5:\"value\";s:4:\"mpeg\";i:0;i:4;s:3:\"key\";i:4;}i:5;a:4:{i:1;s:3:\"jpg\";s:5:\"value\";s:3:\"jpg\";i:0;i:5;s:3:\"key\";i:5;}}}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,11,'select','Select boxes',10,0,'a:3:{i:0;i:1;i:1;i:0;i:2;a:3:{s:8:\"Option 1\";i:1;s:8:\"Option 2\";i:0;s:8:\"Option 3\";i:0;}}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,12,'yn','Simple oui/ non radio buttons',11,0,'a:2:{s:4:\"_YES\";i:1;s:3:\"_NO\";i:0;}',1)";
	$sql[] = "INSERT INTO `".$GLOBALS['xoopsDB']->prefix("forms")."` ( `id_form`,`ele_id`,`ele_type`,`ele_caption`,`ele_order`,`ele_req`,`ele_value`,`ele_display`) values (1,13,'mailunique','Email You',0,0,'a:1:{s:2:\"Me\";i:1;}',1)";

	foreach($sql as $question)
		if (!$GLOBALS['xoopsDB']->queryF($question))
			xoops_error($question, 'SQL Failed to Execute!');
			
	return true;
}
	
?>