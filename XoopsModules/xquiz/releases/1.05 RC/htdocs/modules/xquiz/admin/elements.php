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

if(!isset($_POST['id'])){
	$id = isset ($_GET['id']) ? $_GET['id'] : '';
}else {
	$id = $_POST['id'];
}
if(!isset($_POST['ele_id'])){
	$ele_id = isset ($_GET['ele_id']) ? $_GET['ele_id'] : '';
}else {
	$ele_id = $_POST['ele_id'];
}
if(!isset($_POST['ele_type'])){
	$ele_type = isset ($_GET['ele_type']) ? $_GET['ele_type'] : '';
}else {
	$ele_type = $_POST['ele_type'];
}

$GLOBALS['xquizTpl'] = new XoopsTpl();
$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);

if(!isset($clone)){ $clone="";}
if(!isset($req)){ $req="";}
if(!isset($text)){ $text="";}
if(!isset($_POST['submit'])){ $_POST['submit']="";}

$sql=sprintf("SELECT title FROM ".$xoopsDB->prefix("forms_id")." WHERE id_form='%s'",$id);
$res = $xoopsDB->query($sql) or die('Erreur SQL !<br />'.$requete.'<br />'.$xoopsDB->error());

if ($res) {
  while ( $row = $xoopsDB->fetchRow($res)) {
    $title = $row[0];
  }
}

if( !empty($_POST) ){
	foreach( $_POST as $k => $v ){
		${$k} = $v;
	}
}elseif( !empty($_GET) ){
	foreach( $_GET as $k => $v ){
		${$k} = $v;
	}
}

$ele_id = !empty($ele_id) ? intval($ele_id) : 0;
$myts =& MyTextSanitizer::getInstance();

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

if( $_POST['submit'] == _AM_XQUIZ_ELE_ADD_OPT_SUBMIT && intval($_POST['addopt']) > 0 ){
	$op = 'edit';
}

if ($ele_type == "text") {
	$name = _AM_XQUIZ_ELE_TEXT;
} elseif  ($ele_type == "name")	{
	$name = _AM_XQUIZ_ELE_TNAME;
} elseif  ($ele_type == "email") {	
	$name = _AM_XQUIZ_ELE_TEMAIL;
} elseif  ($ele_type == "twitter") {
	$name = _AM_XQUIZ_ELE_TWITTER;
} elseif  ($ele_type == "facebook")	{
	$name = _AM_XQUIZ_ELE_FBOOK;	
} elseif  ($ele_type == "textarea")	{
	$name = _AM_XQUIZ_ELE_TAREA;
} elseif  ($ele_type == "areamodif") {
	$name = _AM_XQUIZ_ELE_MODIF;
} elseif  ($ele_type == "select") {
	$name = _AM_XQUIZ_ELE_SELECT;
} elseif  ($ele_type == "checkbox") {
	$name = _AM_XQUIZ_ELE_CHECK;
} elseif  ($ele_type == "radio") {
	$name = _AM_XQUIZ_ELE_RADIO;
} elseif  ($ele_type == "yn") {
	$name = _AM_XQUIZ_ELE_YN;
} elseif  ($ele_type == "date") {
	$name = _AM_XQUIZ_ELE_DATE;
} elseif  ($ele_type == "sep") { 
	$name = _AM_XQUIZ_ELE_SEP;
} elseif  ($ele_type == "upload") {
	$name = _AM_XQUIZ_ELE_UPLOAD;
} elseif  ($ele_type == "mail") {
	$name = _AM_XQUIZ_ELE_MAIL;
} elseif  ($ele_type == "mailunique") {
	$name = _AM_XQUIZ_ELE_MAIL;
}

switch($op){
	case 'edit':
		xoops_cp_header();
		forms_adminMenu(3);
		if( !empty($ele_id) ){
			$element =& $forms_handler->get($ele_id);
			$ele_type = $element->getVar('ele_type');
			$forms_title = $clone ? _AM_XQUIZ_ELE_CREATE : sprintf(_AM_XQUIZ_ELE_EDIT, $element->getVar('ele_caption'));
		}else{
			$element =& $forms_handler->create();
			$forms_title = _AM_XQUIZ_ELE_CREATE.$name;
		}
		$form = new XoopsThemeForm($forms_title, 'forms_ele', 'elements.php?id='.$id.'');
		if( empty($addopt) ){
			$nb_fichier = 0;
			$ele_caption = $clone ? sprintf(_AM_XQUIZ_COPIED, $element->getVar('ele_caption', 'f')) : $element->getVar('ele_caption', 'f');
			if ($ele_type=='sep' && empty($ele_id)) {
				$ele_caption = new XoopsFormText(_AM_XQUIZ_ELE_CAPTION. _AM_XQUIZ_ELE_CAPTION_DESC, 'ele_caption', 50, 255, '{null}'); }
			else if ($ele_type=='sep') {$ele_caption = new XoopsFormText(_AM_XQUIZ_ELE_CAPTION. _AM_XQUIZ_ELE_CAPTION_DESC, 'ele_caption', 50, 255, $ele_caption); }
			else { $ele_caption = new XoopsFormText(_AM_XQUIZ_ELE_CAPTION, 'ele_caption', 50, 255, $ele_caption); }
			$value = $element->getVar('ele_value', 'f');
		}else{
			$ele_caption = $myts->makeTboxData4PreviewInForm($ele_caption);
			if ($ele_type=='sep') {
				$ele_caption = new XoopsFormText(_AM_XQUIZ_ELE_CAPTION. _AM_XQUIZ_ELE_CAPTION_DESC, 'ele_caption', 50, 255, '{null}'); }
			else { $ele_caption = new XoopsFormText(_AM_XQUIZ_ELE_CAPTION, 'ele_caption', 50, 255, $ele_caption); }
		}

		$form->addElement($ele_caption, 1);

		switch($ele_type){
			case 'twitter':
			case 'facebook':
			case 'name':
			case 'email':
			case 'text':
				include 'elements/ele_text.php';
				$req = true;
			break;
			case 'textarea':
				include 'elements/ele_tarea.php';
				$req = true;
			break;
			case 'areamodif':
				include 'elements/ele_modif.php';
			break;
			case 'select':
				include 'elements/ele_select.php';
				$req = true;
			break;
			case 'checkbox':
				include 'elements/ele_check.php';
			break;
			case 'radio':
				include 'elements/ele_radio.php';
			break;
			case 'yn':
				include 'elements/ele_yn.php';
			break;
			case 'date':
				include 'elements/ele_date.php';
				$req = true;
			break;
			case 'sep':
				include 'elements/ele_sep.php';
			break;
			case 'upload':
				include 'elements/ele_upload.php';
			break;
			case 'mail':
				include 'elements/ele_mail.php';
			break;
			case 'mailunique':
				include 'elements/ele_mail_unique.php';
			break;
		}
		if( $req ){
			$ele_req = new XoopsFormCheckBox(_AM_XQUIZ_ELE_REQ, 'ele_req', $element->getVar('ele_req'));
			$ele_req->addOption(1, ' ');
		}

		$form->addElement($ele_req);
		$display = !empty($ele_id) ? $element->getVar('ele_display') : 1;
		$ele_display = new XoopsFormCheckBox(_AM_XQUIZ_ELE_DISPLAY, 'ele_display', $display);
		$ele_display->addOption(1, ' ');
		$form->addElement($ele_display);

		$order = !empty($ele_id) ? $element->getVar('ele_order') : 0;
		$ele_order = new XoopsFormText(_AM_XQUIZ_ELE_ORDER, 'ele_order', 3, 2, $order);
		$form->addElement($ele_order);

		$submit = new XoopsFormButton('', 'submit', _AM_XQUIZ_SAVE, 'submit');
		$cancel = new XoopsFormButton('', 'cancel', _CANCEL, 'button');
		$cancel->setExtra('onclick="javascript:history.go(-1);"');
		$tray = new XoopsFormElementTray('');
		$tray->addElement($submit);
		$tray->addElement($cancel);
		$form->addElement($tray);

		$hidden_op = new XoopsFormHidden('op', 'save');
		$hidden_type = new XoopsFormHidden('ele_type', $ele_type);
		$form->addElement($hidden_op);
		$form->addElement($hidden_type);
		if( !empty($ele_id) && !$clone ){
			$hidden_id = new XoopsFormHidden('ele_id', $ele_id);
			$form->addElement($hidden_id);
		}
		
		$GLOBALS['xquizTpl']->assign('form', $form->render());
		$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_default_elements.html');
		
		break;
	case 'delete':
		if( empty($ele_id) ){
			redirect_header("index.php?id=$id", 0, _AM_XQUIZ_ELE_SELECT_NONE);
		}
		if( empty($_POST['ok']) ){
			xoops_cp_header();
			xoops_confirm(array('op' => 'delete', 'ele_id' => $ele_id, 'ok' => 1), 'elements.php?id='.$id.'', _AM_XQUIZ_ELE_CONFIRM_DELETE);
		}else{
			$element =& $forms_handler->get($ele_id);
			$forms_handler->delete($element);
		$url = "index.php?id=$id";
		Header("Location: $url");

		}
		break;
	case 'perm':
		xoops_cp_header();
		forms_adminMenu(10);
		
		$GLOBALS['xquizTpl']->assign('form', xquiz_elements_permform($forms_handler));
		$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_permission_elements.html');
		
		break;
	case 'save':
		if( !empty($ele_id) ){
			$element =& $forms_handler->get($ele_id);
		}else{
			$element =& $forms_handler->create();
		}
		$element->setVar('ele_caption', $ele_caption);
		$req = !empty($ele_req) ? 1 : 0;
		$element->setVar('ele_req', $req);
		$order = empty($ele_order) ? 0 : intval($ele_order);
		$element->setVar('ele_order', $order);
		$display = !empty($ele_display) ? 1 : 0;
		$element->setVar('ele_display', $display);
		$element->setVar('ele_type', $ele_type);

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

		switch($ele_type){
			case 'twitter':
			case 'facebook':
			case 'name':
			case 'email':
			case 'text':
				$value = array();
				$scores = array();
				$value[] = !empty($ele_value[0]) ? intval($ele_value[0]) : $xoopsModuleConfig['t_width'];
				$value[] = !empty($ele_value[1]) ? intval($ele_value[1]) : $xoopsModuleConfig['t_max'];
				$value[] = $ele_value[2];
			break;
			case 'textarea':
				$value = array();
				$scores = array();
				$value[] = stripslashes($ele_value[0]);
				if( intval($ele_value[1]) != 0 ){
					$value[] = intval($ele_value[1]);
				}else{
					$value[] = $xoopsModuleConfig['ta_rows'];
				}
				if( intval($ele_value[2]) != 0 ){
					$value[] = intval($ele_value[2]);
				}else{
					$value[] = $xoopsModuleConfig['ta_cols'];
				}
			break;
			case 'areamodif':
				$value = array();
				$scores = array();
				$value[] = $ele_value[0];
				if( intval($ele_value[1]) != 0 ){
					$value[] = intval($ele_value[1]);
				}else{
					$value[] = $xoopsModuleConfig['ta_rows'];
				}
				if( intval($ele_value[2]) != 0 ){
					$value[] = intval($ele_value[2]);
				}else{
					$value[] = $xoopsModuleConfig['ta_cols'];
				}
			break;
			case 'checkbox':
				$scores = array();
				$value = array();
				while( $v = each($ele_value) ){
					if( !empty($v['value']) ){
						if( $checked[$v['key']] == 1 ){
							$check = 1;
						}else{
							$check = 0;
						}
						$value[$v['value']] = $check;
						$scores[$v['value']] = $ele_scores[$v['key']];
					}
				}
			break;
			case 'mail':
				$value = array();
				$scores = array();
				while( $v = each($ele_value) ){
					if( !empty($v['value']) ){
						if( $checked[$v['key']] == 1 ){
							$check = 1;
						}else{
							$check = 0;
						}
						$value[$v['value']] = $check;
					}
				}
			break;
			case 'mailunique':
				$value = array();
				$scores = array();
				while( $v = each($ele_value) ){
					if( !empty($v['value']) ){
						if( $checked == $v['key'] ){
							$value[$v['value']] = 1;
						}else{
							$value[$v['value']] = 0;
						}
					}
				}
			break;
			case 'radio':
				$value = array();
				$scores = array();
				while( $v = each($ele_value) ){
					if( !empty($v['value']) ){
						if( $checked == $v['key'] ){
							$value[$v['value']] = 1;
						}else{
							$value[$v['value']] = 0;
						}
						$scores[$v['value']] = $ele_scores[$v['key']];
					}
				}
			break;
			case 'yn':
				$value = array();
				$scores = array();
				if( $ele_value == '_NO' ){
					$value = array('_YES'=>0,'_NO'=>1);
				}else{
					$value = array('_YES'=>1,'_NO'=>0);
				}
			break;
			case 'date':
				$value = array();
				$scores = array();
				$value[] = $ele_value;
			break;
			case 'sep':
				$value = array();
				$scores = array();
				
				if (strstr($ele_value[0],'@font') != false){
					$a = explode("@font", $ele_value[0]);
					$ele_value[0] = $a[1];
				}
				$value[] = $ele_value[0];
				if( intval($ele_value[1]) != 0 ){
					$value[] = intval($ele_value[1]);
				}else{
					$value[] = $xoopsModuleConfig['ta_rows'];
				}
				if( intval($ele_value[2]) != 0 ){
					$value[] = intval($ele_value[2]);
				}else{
					$value[] = $xoopsModuleConfig['ta_cols'];
				}

				$value[0]='@font'.$value[0].'@font';

				$chval .= "<div style='";
				if ($option[0]=='centre') {$chval .= 'text-align:center;';}
				if ($option[0]=='souligne') {$chval .= 'text-decoration:underline;';}
				if ($option[0]=='italique') {$chval .= 'font-style:italic;';}
				if ($option[0]=='gras') {$chval .= 'font-weight:bold;';}
				if ($option[1]=='souligne') {$chval .= 'text-decoration:underline;';}
				if ($option[1]=='italique') {$chval .= 'font-style:italic;';}
				if ($option[1]=='gras') {$chval .= 'font-weight:bold;';}
				if ($option[2]=='italique') {$chval .= 'font-style:italic;';}
				if ($option[2]=='gras') {$chval .= 'font-weight:bold;';}
				if ($option[3]=='gras') {$chval .= 'font-weight:bold;';}

				if ($couleur) {$chval .= 'color:'.$couleur.';';}				
				$chval .= "'>".$value[0]."</div>";
				
				$value[0] = $chval;
				
//				$value[0] = '<font color='.$couleur.'>'.$value[0].'</font>';
			break;
			case 'select':
				$scores = array();
				$value = array();
				$value[0] = $ele_value[0]>1 ? intval($ele_value[0]) : 1;
				$value[1] = !empty($ele_value[1]) ? 1 : 0;
				$v2 = array();
				$sv2 = array();
				$multi_flag = 1;
				while( $v = each($ele_value[2]) ){
					if( !empty($v['value']) ){
						if( $value[1] == 1 || $multi_flag ){
							if( $checked[$v['key']] == 1 ){
								$check = 1;
								$multi_flag = 0;
							}else{
								$check = 0;
							}
						}else{
							$check = 0;
						}
						$v2[$v['value']] = $check;
						$sv2[$v['value']] = $ele_scores[2][$v['key']];
					}
				}
				$value[2] = $v2;
				$scores[2] = $sv2;
			break;
			case 'upload':
				$scores = array();
				$value = array();
				$v2 = array();
				$value[] = $ele_value[0];
				$ele_value[1] = $ele_value[1] *1024;
				$value[] = $ele_value[1];
				while( $v = each($ele_value[2]) ){
					if( !empty($v) ) $v2[] = $v;
				}
				$value[] = $v2;
			break;
		}
		$element->setVar('ele_value', $value);
		$element->setVar('ele_scores', $scores);
		$element->setVar('id_form', $id);
		if( !$forms_handler->insert($element) ){
			xoops_cp_header();
			echo $element->getHtmlErrors();
		}else{
			$url = "index.php?id=$id";
			Header("Location: $url");
		}
	break;

}
include 'footer.php';
xoops_cp_footer();

?>