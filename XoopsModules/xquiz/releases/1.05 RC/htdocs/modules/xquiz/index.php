<?php
###############################################################################
##             XQuiz - Quiz/Questionair submitting module for XOOPS          ##
##                    Copyright (c) 2005 simon@chronolabs.coop                    ##
##                       <http://chronolabs.coop/>                           ##
###############################################################################
##                    XOOPS - PHP Content Management System                  ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <http://www.xoops.org/>                          ##
###############################################################################
##  This program is free software; you can redistribute it and/or modify     ##
##  it under the terms of the GNU General Public License as published by     ##
##  the Free Software Foundation; either version 2 of the License, or        ##
##  (at your option) any later version.                                      ##
##                                                                           ##
##  You may not change or alter any portion of this comment or credits       ##
##  of supporting developers from this source code or any supporting         ##
##  source code which is considered copyrighted (c) material of the          ##
##  original comment or credit authors.                                      ##
##                                                                           ##
##  This program is distributed in the hope that it will be useful,          ##
##  but WITHOUT ANY WARRANTY; without even the implied warranty of           ##
##  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################
##  URL: http://chronolabs.coop/                                             ##
##  Project: XQuiz                                                      ##
###############################################################################

include 'header.php';

if (!empty($_GET['answer'])) {
	
	$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/answer,'.$_GET['answer'].$GLOBALS['xoopsModuleConfig']['endofurl'];
	if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']==true&&empty($_POST)) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.$url);
		exit(0);
	}
	
	$xoopsOption['template_main'] = 'xquiz_answer.html';
	include_once XOOPS_ROOT_PATH.'/header.php';
	
	$sql = "SELECT * FROM " . $xoopsDB->prefix("form_answers") . " WHERE md5(concat(`id_score`, '".XOOPS_LICENSE_KEY."', '".$GLOBALS['user_details']['ip']."')) = '".$_GET['answer']."'";
	$res = $xoopsDB->query($sql);
	if ($row = $xoopsDB->fetchArray($res)) {
		$xoopsTpl->assign( 'title', $row['title'] );
		$xoopsTpl->assign( 'html', $row['html'] );
	}
	
} else {

	$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/index'.$GLOBALS['xoopsModuleConfig']['endofurl'];
	if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']==true&&empty($_POST)) {
		header( "HTTP/1.1 301 Moved Permanently" ); 
		header('Location: '.$url);
		exit(0);
	}
	
	$xoopsOption['template_main'] = 'xquiz_index.html';
	include_once XOOPS_ROOT_PATH.'/header.php';
	
	$perm_name = 'view_form';
		
	$myts =& MyTextSanitizer::getInstance();
	
	$form = array();
	$qcm = array();
	
	$menu_handler = xoops_getmodulehandler('form_menu', 'xquiz');
	$forms = $menu_handler->getIndex();
	foreach ( $forms as $key => $array ) {
		if ( $gperm_handler -> checkRight( $perm_name, $array['form']->getVar('id_form'), $groups, $xquizModule->getVar('mid') ) ) {
	
			$temp = array();
			$temp['id_form'] = $array['form']->getVar('id_form');
			$temp['title'] = $myts->displayTarea( $array['form']->getVar('title') );
			$temp['help'] = $myts->displayTarea( $array['form']->getVar('help') );
	
			$temp['indent'] = $array['menu']->getVar('indent');
			$temp['margintop'] = $array['menu']->getVar('margintop');
			$temp['marginbottom'] = $array['menu']->getVar('marginbottom');
			$temp['itemurl'] = $array['form']->getURL();
			$temp['bold'] = $array['menu']->getVar('bold');
	
	
			if (empty($array['form']->getVar('qcm'))) {
				$form[] = $temp;
		    } elseif ($array['form']->getVar('qcm')="1") {
				$qcm[] = $temp;
		    }
	    }
	}
	
	$xoopsTpl->assign( 'form_title', _AM_XQUIZ_FORMUL );
	$xoopsTpl->assign( 'form_form', $form );
	
	$xoopsTpl->assign( 'qcm_title' , _FORM_QCM );
	$xoopsTpl->assign( 'qcm_qcm' , $qcm );
	
	$xoopsTpl->assign( 'admin_module' , 0 );
	$block['admin_module'] = 0;
	if ( $xoopsUser ){
		if ( $xoopsUser->isAdmin($xquizModule) ) {
			$xoopsTpl->assign( 'admin_module' , 1 );
		}
	}
}	

include_once XOOPS_ROOT_PATH.'/footer.php';

?>