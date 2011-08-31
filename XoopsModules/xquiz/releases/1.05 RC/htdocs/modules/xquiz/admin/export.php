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

if(!isset($_POST['form'])){
	$form = isset ($_GET['form']) ? $_GET['form'] : '1';
}else {
	$form = $_POST['form'];
}
if(!isset($_POST['req'])){
	$req = isset ($_GET['req']) ? $_GET['req'] : '';
}else {
	$req = $_POST['req'];
}

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

$GLOBALS['xquizTpl'] = new XoopsTpl();
$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);

$script_a = '<SCRIPT language="JavaScript1.2"  type="text/javascript">
Text[1]=["'._AM_XQUIZ_SAVE_AS.'","'._AM_XQUIZ_SAVE_AS_TEXT.'"]

Style[1]=["white","#F6B542","","","",,"black","#FFFFFF","","","",,,,2,"#F6C063",2,,,,,"",1,,,]

var TipId="help"
var FiltersEnabled = 0 // [for IE5.5+] if your not going to use transitions or filters in any of the tips set this to zero.
mig_clay()

</SCRIPT>';

$GLOBALS['xquizTpl']->assign('script_a', $script_a);

if (!empty($id) && empty($op)) {
	
	$criteria = new Criteria('id_form', $id);
	$req = array();
	$req[] = array();
	$tmp0 = $tmp1 = 0;
	$forms_forms = $forms_form_handler->getObjects($criteria, true);
	$req[0][0] = _AM_XQUIZ_EXPORT_ID_FORM;
	$req[0][1] = _AM_XQUIZ_EXPORT_ID_REQ;
	$req[0][2] = _AM_XQUIZ_EXPORT_ELE_TYPE;
	$req[0][3] = _AM_XQUIZ_EXPORT_ELE_CAPTION;
	$req[0][4] = _AM_XQUIZ_EXPORT_ELE_VALUE;
	$req[0][6] = _AM_XQUIZ_EXPORT_UID;
	$req[0][7] = _AM_XQUIZ_EXPORT_DATE;
	$req[0][8] = _AM_XQUIZ_EXPORT_TIME;
	if ($forms_forms) {
		foreach ($forms_forms as $ele_id => $forms_form) {
	       		$req[$ele_id][0] = $forms_form->getVar("id_form");
	       		$req[$ele_id][1] = ($forms_form->getVar("id_req")==1?_YES:_NO);
	       		$req[$ele_id][2] = $forms_form->getVar("ele_type");
	       		$req[$ele_id][3] = $forms_form->getVar("ele_caption");
	       		$req[$ele_id][4] = $forms_form->getVar("ele_value");
	       		if ($forms_form->getVar("uid")==0) {
	       			$req[$ele_id][6] = $GLOBALS['xoopsConfig']['anonymous'];
	       		} else {
	       			$user = $user_handler->get($forms_form->getVar("uid"));
	       			$req[$ele_id][6] = $user->getVar('name');
	       			if (empty($req[$ele_id][6]))
	       			 	$req[$ele_id][6] = $user->getVar('uname');
	       			else 
	       				$req[$ele_id][6] .= ' ('.$user->getVar('uname').')';
	       		}
	       		$req[$ele_id][7] = $forms_form->getVar("date");
	       		$req[$ele_id][8] = $forms_form->getVar("time");
	       		$row["ele_id"] = $row["id_req"];
          	}
	}
	
	if (!is_dir(XOOPS_ROOT_PATH.DS."uploads".DS.$GLOBALS['xoopsModule']->getVar('dirname').DS)) {
		foreach(explode(DS, XOOPS_ROOT_PATH.DS."uploads".DS.$GLOBALS['xoopsModule']->getVar('dirname')) as $folder) {
			$path .= DS.$folder;
			mkdir($path, 0777);
		}
	}
	
	if ($fp = fopen (XOOPS_ROOT_PATH."/uploads/".$GLOBALS['xoopsModule']->getVar('dirname')."/forms_$id.csv", "w")) {
		foreach ($req as $ele_id => $v) {
			foreach($v as $i=>$value){
				if (!is_numeric($value))
					$msg .= '"'.$value.'"';
				else 
					$msg .= ''.$value.'';
				if ($i<sizeof($v))
					$msg.=',';
				else 
					$msg.="\n";
			}
		}

		fwrite ($fp, $msg);
		fclose ($fp);
		
	}

	header('Content-Disposition: attachment; filename="forms_'.$id.'.csv"');
	header("Content-Type: text/comma-separated-values");
	readfile(XOOPS_ROOT_PATH.'/uploads/'.$GLOBALS['xoopsModule']->getVar('dirname').'/forms_'.$id.'.csv');

	exit(0);
	
} elseif (empty($id) && (empty($op) || $op=='1')){
	xoops_cp_header();
	forms_adminMenu(6, _AM_XQUIZ_CSV);
		
	$forms_ids = $forms_id_handler->getObjects(NULL, true);
	
	if ( $forms_ids ) {
		foreach ( $forms_ids as $id_form => $forms_id ) {
	    	$data[$id_form]['title'] = $forms_id->getVar('title');
	    	$data[$id_form]['file'] = file_exists(XOOPS_ROOT_PATH.'/uploads/'.$GLOBALS['xoopsModule']->getVar('dirname').'/forms_'.$id_form.'.csv');
	    	if ($data[$id_form]['file'])
	    		$data[$id_form]['file_date'] = date(_DATESTRING, filectime(XOOPS_ROOT_PATH.'/uploads/'.$GLOBALS['xoopsModule']->getVar('dirname').'/forms_'.$id_form.'.csv'));
	 	}	
	}

	$GLOBALS['xquizTpl']->assign('data', $data);
	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_default_export.html');
	
}

include 'footer.php';
xoops_cp_footer();

?>