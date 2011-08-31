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
xoops_loadLanguage('forms', 'xquiz');

if(!isset($_POST['op'])){
	$op = isset ($_GET['op']) ? $_GET['op'] : 'main';
}else {
	$op = $_POST['op'];
}
if(!isset($_POST['id'])){
	$id = isset ($_GET['id']) ? $_GET['id'] : '0';
}else {
	$id = $_POST['id'];
}

// get the module id
$module_id = $xoopsModule->getVar('mid'); 

// Include the functions
xoops_cp_header();

$myts =& MyTextSanitizer::getInstance();

$criteria = new Criteria('1','1');
$criteria->setSort('`title`');
$criteria->setOrder('DESC');

$forms_ids = $forms_id_handler->getObjects($criteria, true);

if ( $forms_ids ) {
	foreach ( $forms_ids as $key => $item ) {
    	$data[$key] = $item->getVar('title');
    	$criteria = new Criteria('menuid',$key);
		$forms_menus = $forms_menu_handler->getObjects($criteria);
		if ($forms_menus) {
			foreach( $forms_menus as $menuid => $forms_menu ) {
				$status[$key] = $forms_menu->getVar('status');
			}
		}
	}
}

$GLOBALS['xquizTpl'] = new XoopsTpl();
$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);

// table with the legend
$script_a = '<script type="text/javascript">
Text[4]=["'._AM_XQUIZ_REN.'","'._AM_XQUIZ_REN_TEXT.'"]
Text[5]=["'._AM_XQUIZ_SUP.'","'._AM_XQUIZ_SUP_TEXT.'"]
Text[6]=["'._AM_XQUIZ_MODIF.'","'._AM_XQUIZ_MODIF_TEXT.'"]
Text[7]=["'._AM_XQUIZ_LISTE.'","'._AM_XQUIZ_LISTE_TEXT.'"]
Text[8]=["'._AM_XQUIZ_DEST.'","'._AM_XQUIZ_DEST_TEXT.'"]
Text[9]=["'._AM_XQUIZ_SEE_FORM.'","'._AM_XQUIZ_SEE_FORM_TEXT.'"]
Text[10]=["'._AM_XQUIZ_CHANGE_STATUS.'","'._AM_XQUIZ_CHANGE_STATUS_TEXT.'"]
Text[11]=["'._AM_XQUIZ_EXPORT.'","'._AM_XQUIZ_EXPORT_TEXT.'"]
Text[12]=["'._AM_XQUIZ_CLONE.'","'._AM_XQUIZ_CLONE_TEXT.'"]

Style[1]=["white","#F6B542","","","",,"black","#FFFFFF","","","",,,,2,"#F6C063",2,,,,,"",1,,,]

var TipId="help"
var FiltersEnabled = 0 // [for IE5.5+] if your not going to use transitions or filters in any of the tips set this to zero.
mig_clay()

</script>';
		
$GLOBALS['xquizTpl']->assign('script_a', $script_a);
		
switch ($op) {
case "addform":
	xquiz_modforms_addform($forms_id_handler);
	break;
case "cloneform":
	xquiz_modforms_cloneform($id, $forms_id_handler);
	break;
case "renform":
	xquiz_modforms_renform($id, $forms_id_handler);
	break;
case "modform":
	xquiz_modforms_modform($id, $forms_id_handler);
	break;
case "delform":
	xquiz_modforms_delform($id);
	break;
case "showform":
	xquiz_modforms_showform($id, $data, $forms_forms_handler);
	break;
case "permform":
	forms_adminMenu(11, _AM_XQUIZ_PERCR);
	$GLOBALS['xquizTpl']->assign('form', xquiz_modforms_permform($forms_id_handler));
	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_permission_modform.html');
	break;
case "main":
default:
	forms_adminMenu(3, _AM_XQUIZ_INDEX);
	$warning='';
	if (!$data) $warning = "<br><div style='color: red; font-weight: bold; text-decoration: blink ; font-size: x-large; text-align:center'>"._AM_XQUIZ_NOFORM."</div>";
	if ($data) {
    	forms_collapsableBar('toptable','toptableicon', $GLOBALS['xquizTpl']);

		$GLOBALS['xquizTpl']->assign('data', $data);
		$GLOBALS['xquizTpl']->assign('status', $status);
    	
	}
	$GLOBALS['xquizTpl']->assign('warning', $warning);
	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_default_modinfo.html');
	break;
}

include 'footer.php';
xoops_cp_footer();
?>