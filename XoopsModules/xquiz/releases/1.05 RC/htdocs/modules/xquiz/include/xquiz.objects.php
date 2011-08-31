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
	xoops_load('xoopsformloader');
	xoops_load("captcha");
	include('formlinebreak.php');
	include('formbreak.php');
	include('formselectform.php');
	include('formselectusers.php');
	include('formselectelement.php');
	if ($GLOBALS['xoopsModuleConfig']['tag'])
		include_once XOOPS_ROOT_PATH . "/modules/tag/include/formtag.php";
?>