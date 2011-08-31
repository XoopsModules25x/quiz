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
include_once("admin_header.php");

xoops_loadLanguage('modinfo', 'xquiz');
xoops_loadLanguage('main', 'xquiz');
xoops_loadLanguage('admin', 'xquiz');


if (!isset($op)) {
    $op = '';
}

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

xoops_cp_header();

$GLOBALS['xquizTpl'] = new XoopsTpl();
$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);

forms_adminMenu(5, _AM_XQUIZ_INDEX);

switch($op) {
case "MyMenuAdd":
	xquiz_menu_index_MyMenuAdd($forms_menu_handler, $GLOBALS['xquizTpl']);
    break;
case "MyMenuSave":
    xquiz_menu_index_MyMenuSave($menuid, $forms_menu_handler, $GLOBALS['xquizTpl']);
    break;
case "MyMenuAdmin":
	xquiz_menu_index_MyMenuAdmin($forms_menu_handler, $GLOBALS['xquizTpl']);
	break;
case "MyMenuEdit":
	xquiz_menu_index_MyMenuEdit($menuid, $forms_menu_handler, $GLOBALS['xquizTpl']);
	break;
case "ele_up":
	xquiz_menu_index_ele_up($id, $pos, $forms_menu_handler, $GLOBALS['xquizTpl']);
	break;
case "ele_down":
	xquiz_menu_index_ele_down($id, $pos, $forms_menu_handler, $GLOBALS['xquizTpl']);
	break;
default:
	xquiz_menu_index_MyMenuAdmin($forms_menu_handler, $GLOBALS['xquizTpl']);
	break;
}

include 'footer.php';
xoops_cp_footer();
?>