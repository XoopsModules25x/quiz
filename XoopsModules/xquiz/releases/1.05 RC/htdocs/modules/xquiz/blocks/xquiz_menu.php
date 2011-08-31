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
function xquiz_menu_show() {

	global $xoopsDB, $myts, $xoopsUser, $xoopsModule, $xoopsTpl, $xoopsConfig;

	$myts =& MyTextSanitizer::getInstance();
	$menuid=0;
	$block = array();
	if (file_exists(XOOPS_ROOT_PATH."/modules/xquiz/language/".$xoopsConfig['language']."/xquiz.css")) {
    	$block['css_file'] = XOOPS_URL . "/modules/xquiz/language/".$xoopsConfig['language']."/xquiz.css";
	} else { 
    	$block['css_file'] = XOOPS_URL . "/modules/xquiz/language/english/xquiz.css";
	}
	
    if ( file_exists(XOOPS_THEME_PATH.'/'.$xoopsConfig['theme_set'].'/css/xquiz.css') ) {
	    $block['css_file'] = XOOPS_URL . '/themes/' . $xoopsConfig['theme_set'] . '/css/xquiz.css';
    }

    $groups = is_object( $xoopsUser ) ? $xoopsUser -> getGroups() : XOOPS_GROUP_ANONYMOUS;
    $gperm_handler = &xoops_gethandler( 'groupperm' );

	$module_handler =& xoops_gethandler('module');
	$xquizModule =& $module_handler->getByDirname('xquiz');

	$block['admin_module'] = 0;
	if ( $xoopsUser ){
		if ( $xoopsUser->isAdmin($xquizModule) ) {
			$block['admin_module'] = 1;
		}
	}
	$forms_id_handler = xoops_getmodulehandler('forms_id', 'xquiz');
	$sql = "SELECT f.id_form, m.indent, m.margintop, m.marginbottom, m.itemurl, m.bold FROM " . $xoopsDB->prefix("forms_id") . " f LEFT JOIN " . $xoopsDB->prefix("forms_menu") . " m on f.id_form = m.menuid WHERE f.qcm = 0 and m.status =1 ORDER BY m.position";
	$res = $xoopsDB->query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.$xoopsDB->error());
	while ($row= $xoopsDB->fetchArray($res)) {
		if ( $gperm_handler -> checkRight( 'view_form', $row['id_form'], $groups, $xquizModule->getVar('mid') ) ) {
			$forms_id = $forms_id_handler->get($row['id_form']);
            $form = array();
			$form['id_form'] = $row['id_form'];
			$form['title'] = $myts->displayTarea( str_replace("<br />","", $forms_id->getVar('title')), 1 );
			$form['help'] = $myts->displayTarea( $forms_id->getVar('help') );

			$form['indent'] = $row['indent'];
			$form['margintop'] = $row['margintop'];
			$form['marginbottom'] = $row['marginbottom'];
			$form['itemurl'] = $row['itemurl'];
	        $form['itemurl'] = $forms_id->getURL();
			$form['bold'] = $row['bold'];
            $block['xquizs'][] = $form;
		}
	}
	return $block;
}
?>