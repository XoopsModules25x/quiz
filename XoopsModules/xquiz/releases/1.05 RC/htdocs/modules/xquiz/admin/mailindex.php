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
include("admin_header.php");

xoops_loadLanguage('modinfo', 'xquiz');
xoops_loadLanguage('main', 'xquiz');
xoops_loadLanguage('admin', 'xquiz');

include('../xoops_version.php');

if(!isset($_POST['id'])){
	$id = isset ($_GET['id']) ? $_GET['id'] : '';
}else {
	$id = $_POST['id'];
}
if(!isset($_POST['op'])){
	$op = isset ($_GET['op']) ? $_GET['op'] : '';
}else {
	$op = $_POST['op'];
}

if(!isset($_POST['op'])){ $_POST['op']=" ";}
if(!isset($email)){ $email="";}
if(!isset($nbjours)){ $nbjours=0;}
if(!isset($i)){ $i=0;}
if(!isset($help)){ $help="";}

if ( isset ($id)) {
	$forms_id = $forms_id_handler->get($id);
	if ( is_object($forms_id) ) {
		extract($forms_id->toArray());
	}
}

$m = 0;

xoops_cp_header();


if (isset($_POST))
{
    foreach ($_POST as $k => $v)
    {
        $$k = $v;
    } 
} 

if (isset($_GET))
{
    foreach ($_GET as $k => $v)
    {
        $$k = $v;
    } 
}

if(!isset($op)){$op=" ";}
switch ($op) {
case "upform":
	xquiz_mailindex_upform($id, $forms_id_handler);
	break;
case "addform":
	xquiz_mailindex_addform($forms_id_handler);
	break;
default: 

	$GLOBALS['xquizTpl'] = new XoopsTpl();
	$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);

	if ($id != '') {
		forms_adminMenu(2, _AM_XQUIZ_FORMS);
		$forms_id = $forms_id_handler->get($id);
		$GLOBALS['xquizTpl']->assign('form', $forms_id->getForm($_SERVER['QUERY_STRING'], $_SERVER['PHP_SELF'].'?op=upform&id='.$id));
	} else {
		forms_adminMenu(2, _AM_XQUIZ_CREATE);
		$GLOBALS['xquizTpl']->assign('form', $forms_id_handler->getForm($_SERVER['QUERY_STRING'], $_SERVER['PHP_SELF'].'?op=addform'));
	}

	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_edit_mailindex.html');
}
xoops_cp_footer();
?>




