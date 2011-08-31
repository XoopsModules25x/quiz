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
include '../../../include/cp_header.php';

if (!defined("XOOPS_ROOT_PATH")) {
	die("XOOPS root path not defined");
}

include_once ($GLOBALS['xoops']->path("/modules/xquiz/include/xquiz.objects.php"));
include_once ($GLOBALS['xoops']->path("/modules/xquiz/include/common.php"));
include_once ($GLOBALS['xoops']->path("/modules/xquiz/include/functions.php"));

include_once ($GLOBALS['xoops']->path( "/class/xoopsform/grouppermform.php"));
include_once ($GLOBALS['xoops']->path( "/class/xoopstree.php"));
include_once ($GLOBALS['xoops']->path( "/class/xoopslists.php"));
include_once ($GLOBALS['xoops']->path( "/include/xoopscodes.php"));
include_once ($GLOBALS['xoops']->path( "/class/module.errorhandler.php"));
include_once ($GLOBALS['xoops']->path( "/class/pagenav.php" ));
include_once ($GLOBALS['xoops']->path( "/class/template.php" ));
include_once ($GLOBALS['xoops']->path("/class/uploader.php"));
include_once ($GLOBALS['xoops']->path("/modules/xquiz/include/upload_FA.php"));

$forms_handler = xoops_getmodulehandler('forms', 'xquiz');
$forms_id_handler = xoops_getmodulehandler('forms_id', 'xquiz');
$forms_form_handler = xoops_getmodulehandler('forms_form', 'xquiz');
$forms_menu_handler = xoops_getmodulehandler('forms_menu', 'xquiz');
$forms_users_handler = xoops_getmodulehandler('forms_users', 'xquiz');

$gperm_handler = &xoops_gethandler( 'groupperm' );
$module_handler =& xoops_gethandler('module');
$user_handler =& xoops_gethandler('user');

define('XQUIZ_ROOT_PATH', XOOPS_ROOT_PATH.'/modules/'.$GLOBALS['xoopsModule']->getVar('dirname'));

$GLOBALS['myts'] =& MyTextSanitizer::getInstance();

if( is_dir(XQUIZ_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/mail_template") ){
	$GLOBALS['template_dir'] = XQUIZ_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/mail_template";
} else {
	$GLOBALS['template_dir'] = XQUIZ_ROOT_PATH."/language/english/mail_template";
}

$GLOBALS['user_details'] = xquiz_getuser_id();
?>