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
if( !defined("XQUIZ_URL") ){
	define("XQUIZ_URL", XOOPS_URL."/modules/xquiz/");
}

function xquiz_updown_ele_up($id, $ide, $pos)
{
	$pos2 = $pos -1;
	$sql = sprintf("UPDATE %s SET ele_order='%s' WHERE ele_id='%s'",$GLOBALS['xoopsDB']->prefix("form"),$pos2,$ide);
	$GLOBALS['xoopsDB']->queryF($sql) or $eh->show("error");
	$url = "index.php?id=".$id;
	Header("Location: $url");
}

function xquiz_updown_ele_down($id, $ide, $pos)
{
	$pos2 = $pos +1;
	$sql = sprintf("UPDATE %s SET ele_order='%s' WHERE ele_id='%s'",$GLOBALS['xoopsDB']->prefix("form"),$pos2,$ide);
	$GLOBALS['xoopsDB']->queryF($sql) or $eh->show("error");
	$url = "index.php?id=".$id;
	Header("Location: $url");
}

function xquiz_menu_index_MyMenuAdmin($handler, $tpl) {
	
	forms_collapsableBar('toptable', 'toptableicon', $tpl);
	$script_a = '<SCRIPT language="JavaScript1.2"  type="text/javascript">
Text[10]=["'._AM_XQUIZ_CHANGE_STATUS.'","'._AM_XQUIZ_CHANGE_STATUS_TEXT.'"]
Text[11]=["'._AM_XQUIZ_EDIT_MENU.'","'._AM_XQUIZ_EDIT_MENU_TEXT.'"]

Style[1]=["white","#F6B542","","","",,"black","#FFFFFF","","","",,,,2,"#F6C063",2,,,,,"",1,,,]

var TipId="help"
var FiltersEnabled = 0 // [for IE5.5+] if your not going to use transitions or filters in any of the tips set this to zero.
mig_clay()

</SCRIPT>'; 

	$tpl->assign('script_a', $script_a);
	
	$criteria = new Criteria('1','1');
	$criteria->setSort('`position`');
	$menus = $handler->getObjects($criteria, true);
	foreach($menus as $menuid => $menu) {

		extract($menu->toArray());
		
		$itemname = $GLOBALS['myts']->makeTboxData4Show($menu->getVar('itemname'));
        $itemurl = $GLOBALS['myts']->makeTboxData4Show($menu->getVar('itemurl'));
        
        if ($menu->getVar('position') != 0) {
			$data[] = "<tr class='odd'><td align='center' title='".$menu->getVar('position')."'><a href=menu_index.php?id=".$menuid."&pos=".$menu->getVar('position')."&op=ele_up><img src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/up.gif /></a>&nbsp;<a href=menu_index.php?id=".$menuid."&pos=".$position."&op=ele_down><img src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/down.gif /></a></td>";
        } else {
        	$data[] = "<tr class='odd'><td align='center' title='".$menu->getVar('position')."'><a href=menu_index.php?id=".$menuid."&pos=".$position."&op=ele_down><img src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/down.gif /></a></td>";
        }
        if ($menu->getVar('bold') == 1) {
        	$data[] = "<td><b>$itemname</b></td>";
        } else {
            $data[] = "<td>$itemname</td>";
        }
        $data[] = "<td>$indent px</td>";
        $data[] = "<td>$margintop px</td>";
        $data[] = "<td>$marginbottom px</td>";
        $data[] = "<td><a href=".$itemurl.">$itemurl</a></td>";
   	   if ($status == 1)  {
	   		$data[] = '<td class="odd" width="5%"><center><a href="active.php?id='.$menuid.'&status='.$status.'&url=menu_index.php"><img src="../images/on.gif" alt="" onMouseOver="stm(Text[10],Style[1])" onMouseOut="htm()"></a></td>';
   	   } else {
   	   		$data[] = '<td class="odd" width="5%"><center><a href="active.php?id='.$menuid.'&status='.$status.'&url=menu_index.php"><img src="../images/off.gif" alt="" onMouseOver="stm(Text[10],Style[1])" onMouseOut="htm()"></a></td>';
   	   }

       $data[] = "<td align='center'><a href='menu_index.php?op=MyMenuEdit&amp;menuid=$menuid'><img src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/edit.gif alt='' onMouseOver='stm(Text[11],Style[1])' onMouseOut='htm()' /></a></td></tr>";
    }
	$tpl->assign('data', $data);
	$tpl->display('db:xquiz_cpanel_index_modify_menu.html');
}

function xquiz_menu_index_MyMenuEdit($menuid, $handler, $tpl) {

		forms_collapsableBar('toptable', 'toptableicon', $tpl);
	$script_a = '<SCRIPT language="JavaScript1.2"  type="text/javascript">
Text[10]=["'._AM_XQUIZ_CHANGE_STATUS.'","'._AM_XQUIZ_CHANGE_STATUS_TEXT.'"]
Text[11]=["'._AM_XQUIZ_EDIT_MENU.'","'._AM_XQUIZ_EDIT_MENU_TEXT.'"]

Style[1]=["white","#F6B542","","","",,"black","#FFFFFF","","","",,,,2,"#F6C063",2,,,,,"",1,,,]

var TipId="help"
var FiltersEnabled = 0 // [for IE5.5+] if your not going to use transitions or filters in any of the tips set this to zero.
mig_clay()

</SCRIPT>'; 

	$tpl->assign('script_a', $script_a);
	
	$criteria = new Criteria('1','1');
	$criteria->setSort('`position`');
	$menus = $handler->getObjects($criteria, true);
	foreach($menus as $menuid => $menu) {
		extract($menu->toArray());
		$itemname = $GLOBALS['myts']->makeTboxData4Show($menu->getVar('itemname'));
        $itemurl = $GLOBALS['myts']->makeTboxData4Show($menu->getVar('itemurl'));
        
    	if ($position != 0) {
        	$data[] = "<tr class='odd'><td align='center'><a href=menu_index.php?id=".$menuid."&pos=".$position."&op=ele_up><img src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/up.gif /></a>&nbsp;"; }
		else $data[] = "<tr class='odd'><td align='center'>";
		$data[] =  "<a href=menu_index.php?id=".$menuid."&pos=".$position."&op=ele_down><img src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/down.gif /></a></td>";

                        if ($bold == 1) {
                                 $data[] = "<td><b>$itemname</b></td>";
                        } else {
                                 $data[] = "<td>$itemname</td>";
                        }
                        $data[] = "<td>$indent px</td>";
                        $data[] = "<td>$margintop px</td>";
                        $data[] = "<td>$marginbottom px</td>";
                        $data[] = "<td><a href=".$itemurl.">$itemurl</a></td>";

       	   if ($status == 1)
	   {
	   		$data[] = '<td class="odd" width="5%"><center><a href="active.php?id='.$menuid.'&status='.$status.'&url=menu_index.php"><img src="../images/on.gif" alt="" onMouseOver="stm(Text[10],Style[1])" onMouseOut="htm()"></a></td>';
	   }
	   else $data[] = '<td class="odd" width="5%"><center><a href="active.php?id='.$menuid.'&status='.$status.'&url=menu_index.php"><img src="../images/off.gif" alt="" onMouseOver="stm(Text[10],Style[1])" onMouseOut="htm()"></a></td>';
       $data[] = "<td align='center'><a href='menu_index.php?op=MyMenuEdit&amp;menuid=$menuid'><img src=".XOOPS_URL."/modules/".$GLOBALS['xoopsModule']->dirname()."/images/edit.gif  alt='' onMouseOver='stm(Text[11],Style[1])' onMouseOut='htm()'/></a></td></tr>";
    }
	$tpl->assign('data', $data);
	$tpl->display('db:xquiz_cpanel_index_modify_menu.html');
}

function xquiz_menu_index_edit($menuid, $handler, $tpl) {

    $menu = $handler->get($menuid);
    $tpl->assign('form', $menu->getForm());
	$tpl->display('db:xquiz_cpanel_edit_modify_menu.html'); 
}

function xquiz_menu_index_MyMenuSave($menuid, $handler, $tpl) {
    $menu = $handler->get($menuid);
    $menu->setVars($_POST);
    $handler->insert($menu);
	$url = "menu_index.php?op=MyMenuAdmin";
	Header("Location: $url");
    exit();
}

function xquiz_menu_index_MyMenuAdd($handler, $tpl) {
    $menu = $handler->create();
    $menu->setVars($_POST);
    $handler->insert($menu);
	$url = "menu_index.php?op=MyMenuAdmin";
	Header("Location: $url");
    exit();
}

function xquiz_menu_index_ele_up($id, $pos)
{
	$pos2 = $pos -1;

	$sql = sprintf("UPDATE %s SET position='%s' WHERE menuid='%s'",$GLOBALS['xoopsDB']->prefix("forms_menu"),$pos2,$id);
	$GLOBALS['xoopsDB']->queryF($sql);
	$url = "menu_index.php";
	Header("Location: $url");
}

function xquiz_menu_index_ele_down($id, $pos)
{
	$pos2 = $pos +1;

	$sql = sprintf("UPDATE %s SET position='%s' WHERE menuid='%s'",$GLOBALS['xoopsDB']->prefix("forms_menu"),$pos2,$id);
	$GLOBALS['xoopsDB']->queryF($sql);
	$url = "menu_index.php";
	Header("Location: $url");
}

function addOption($id1, $id2, $text, $type='check', $checked=null){
if(!isset($text)){ $text="";}
	$d = new XoopsFormText('', $id1, 40, 255, $text);
	if( $type == 'check' ){
		$c = new XoopsFormCheckBox('', $id2, $checked);
		$c->addOption(1, ' ');
		$t = new XoopsFormElementTray('');
		$t->addElement($c);
		$t->addElement($d);
	} elseif ($type == 'score') {
		$t = new XoopsFormElementTray('');
		$t->addElement($d);
	}
	else{
		$c = new XoopsFormRadio('', 'checked', $checked);
		$c->addOption($id2, ' ');
		$t = new XoopsFormElementTray('');
		$t->addElement($c);
		$t->addElement($d);
	}
	return $t;
}

function addOptionsTray(){
	$t = new XoopsFormText('', 'addopt', 3, 2);
	$l = new XoopsFormLabel('', sprintf(_AM_XQUIZ_ELE_ADD_OPT, $t->render()));
	$b = new XoopsFormButton('', 'submit', _AM_XQUIZ_ELE_ADD_OPT_SUBMIT, 'submit');
	$r = new XoopsFormElementTray('');
	$r->addElement($l);
	$r->addElement($b);
	return $r;
}

function xquiz_mailindex_upform($id, $handler)
{
	$object = $handler->get($id);
	
	$title2 = $GLOBALS['myts']->makeTboxData4Save($_POST["newtitle2"]);
	$email = $GLOBALS['myts']->makeTboxData4Save($_POST["email"]);

	if((!empty($email)) && (!eregi("^[_a-z0-9.-]+@[a-z0-9.-]{2,}[.][a-z]{2,4}$",$email))){
		redirect_header("mailindex.php?id=$id", 2, _ERR_XQUIZ_ERROREMAIL);
		exit(0);
	}
	if (empty($email) && empty($admin) && $groupe=="0" && empty($expe)) {
		redirect_header("mailindex.php?id=$id", 2, _ERR_XQUIZ_ERRORMAIL);
		exit(0);
	}

	if (empty($_POST['url'])) {
		$object->setVar('url',  $object->getURL());
	}
	
	if (empty($_POST['send'])) {
		$object->setVar('send',  _BUTTON_SEND);
	}

	if (empty($_POST['cod'])) {
		$object->setVar('cod',  "UTF8");
	}
		
	$object->setVars($_POST);
	if ($object->getVar('title')!=$title2&&strlen($title2)>0)
		$object->setVar('title', $title2);

	$handler->insert($object);
	
	$forms_menu_handler = xoops_getmodulehandler('forms_menu', 'xquiz');
	$forms_menu = $forms_menu_handler->get($id);
	if (is_object($forms_menu)) {
		$forms_menu->setVar('itemname', $title2);
		$forms_menu_handler->insert($forms_menu);
	}

	redirect_header(XOOPS_URL.'/modules/xquiz/admin/modform.php',1,_XQUIZ_FORMTITRE);
	exit(0);
}

function xquiz_mailindex_addform($handler)
{
	
	$object = $handler->create();
	
	$title = $GLOBALS['myts']->makeTboxData4Save($_POST["newtitle"]);
	$email = $GLOBALS['myts']->makeTboxData4Save($_POST["email"]);
		
	if (empty($title)) {
		redirect_header("mailindex.php", 2, _ERR_XQUIZ_ERRORTITLE);
		exit(0);
	}
	if((!empty($email)) && (!eregi("^[_a-z0-9.-]+@[a-z0-9.-]{2,}[.][a-z]{2,3}$",$email))){
		redirect_header("mailindex.php", 2, _ERR_XQUIZ_ERROREMAIL);
		exit(0);
	}
	if (empty($email) && empty($admin) && $groupe=="0" && empty($expe)) {
		redirect_header("mailindex.php", 2, _ERR_XQUIZ_ERRORMAIL);
		exit(0);
	}

	if (empty($_POST['url'])) {
		$object->setVar('url',  XOOPS_URL);
	}
	
	if (empty($_POST['send'])) {
		$object->setVar('send',  _BUTTON_SEND);
	}

	if (empty($_POST['cod'])) {
		$object->setVar('cod',  "UTF8");
	}
		
	$object->setVars($_POST);
	if ($object->getVar('title')!=$title&&strlen($title)>0)
		$object->setVar('title', $title);
		

	$id = $handler->insert($object, true);
	$object = $handler->get($id);
	
	$sql4 = $GLOBALS['xoopsDB']->query("SELECT MAX(position) from ".$GLOBALS['xoopsDB']->prefix("forms_menu"));
	if ($sql4) {
		while ( $p = $GLOBALS['xoopsDB']->fetchRow( $sql4 ) ) {
			$pos = $p[0]; 
			}
		}
	if ($pos != '') $pos++;
	
	$forms_menu_handler = xoops_getmodulehandler('forms_menu', 'xquiz');
	$forms_menu = $forms_menu_handler->create();
	if (is_object($forms_menu)) {
		$forms_menu->setVar('itemname', $title);
		$forms_menu->setVar('itemurl', $object->getURL());
		$forms_menu->setVar('position', $pos);
		$forms_menu_handler->insert($forms_menu);
	}
	
	if ($GLOBALS['xoopsModuleConfig']['tag']) {
		$tag_handler = xoops_getmodulehandler('tag', 'tag');
		$tag_handler->updateByItem($_POST["tag"], $id, $GLOBALS['xoopsModule']->getVar("dirname"), $catid = 0);
	}

	redirect_header(XOOPS_URL.'/modules/xquiz/admin/modform.php',1,_XQUIZ_FORMCREA);
	exit(0);
}

function xquiz_modforms_addform($handler)
{
	$object = $handler->create();
		
	$title = $GLOBALS['myts']->makeTboxData4Save($_POST["newtitle"]);
	$email = $GLOBALS['myts']->makeTboxData4Save($_POST["email"]);
		
	if (empty($title)) {
		redirect_header("modform.php", 2, _ERR_XQUIZ_ERRORTITLE);
		exit(0);
	}
	if((!empty($email)) && (!eregi("^[_a-z0-9.-]+@[a-z0-9.-]{2,}[.][a-z]{2,3}$",$email))){
		redirect_header("modform.php", 2, _ERR_XQUIZ_ERROREMAIL);
		exit(0);
	}
	if (empty($email) && empty($admin) && $groupe=="0" && empty($expe)) {
		redirect_header("modform.php", 2, _ERR_XQUIZ_ERRORMAIL);
		exit(0);
	}

	if (empty($_POST['url'])) {
		$object->setVar('url',  XOOPS_URL);
	}
	
	if (empty($_POST['send'])) {
		$object->setVar('send',  _BUTTON_SEND);
	}

	if (empty($_POST['cod'])) {
		$object->setVar('cod',  "UTF8");
	}
		
	$object->setVars($_POST);
	if ($object->getVar('title')!=$title&&strlen($title)>0)
		$object->setVar('title', $title);
		

	$id = $handler->insert($object, true);
	$object = $handler->get($id);
	
	$sql4 = $GLOBALS['xoopsDB']->query("SELECT MAX(position) from ".$GLOBALS['xoopsDB']->prefix("forms_menu"));
	if ($sql4) {
		while ( $p = $GLOBALS['xoopsDB']->fetchRow( $sql4 ) ) {
			$pos = $p[0]; 
			}
		}
	if ($pos != '') $pos++;
	
	$forms_menu_handler = xoops_getmodulehandler('forms_menu', 'xquiz');
	$forms_menu = $forms_menu_handler->create();
	if (is_object($forms_menu)) {
		$forms_menu->setVar('itemname', $title);
		$forms_menu->setVar('itemurl', $object->getURL());
		$forms_menu->setVar('position', $pos);
		$forms_menu_handler->insert($forms_menu);
	}

	if ($GLOBALS['xoopsModuleConfig']['tag']) {
		$tag_handler = xoops_getmodulehandler('tag', 'tag');
		$tag_handler->updateByItem($_POST["tag"], $id, $GLOBALS['xoopsModule']->getVar("dirname"), $catid = 0);
	}
	
	redirect_header(XOOPS_URL.'/modules/xquiz/admin/modform.php',1,_XQUIZ_FORMCREA);
	exit(0);

}

/**
* This function xquiz_modforms_clone a form
*
* @param varchar $id	id of the original form
*
*/
function xquiz_modforms_cloneform($id, $handler)
{
	
	if (empty($id)) {
		redirect_header("modform.php", 2, _NOPERM);
	}
	
	$forms_id = $handler->get($id);
	$clone_form = $handler->create();
	$clone_form->setVars($forms_id->toArray());
	$clone_form->setVar('id_form', 0);
	$clone_forms_id = $handler->insert($clone_form, true);
	
	$forms_handler = xoops_getmodulehandler('form', 'xquiz');
	$criteria = New Criteria('id_form', $id);
	$forms = $forms_handler->getObjects($criteria);
	foreach($forms as $ele_id => $form) {
		$newform = $forms_handler->create();
		$newform->setVars($form->toArray());
		$newform->setVar('id_form', $clone_forms_id);
		$newform->setVar('ele_id', 0);
		$forms_handler->insert($newform, true);
	}

	$sql4 = $GLOBALS['xoopsDB']->query("SELECT MAX(position) from ".$GLOBALS['xoopsDB']->prefix("forms_menu"));
	if ($sql4) {
		while ( $p = $GLOBALS['xoopsDB']->fetchRow( $sql4 ) ) {
			$pos = $p[0]; 
			}
		}
	if ($pos != '') $pos++;
	
	
	$forms_menu_handler = xoops_getmodulehandler('forms_menu', 'xquiz');
	$forms_menu = $forms_menu_handler->get($id);
	$new_forms_menu = $forms_menu_handler->create();
	if (is_object($forms_menu)) {
		$new_forms_menu->setVars($forms_menu->toArray());
		$new_forms_menu->setVar('itemurl', $clone_form->getURL());
		$new_forms_menu->setVar('position', $pos);
		$forms_menu_handler->insert($new_forms_menu);
	}
	
	if ($GLOBALS['xoopsModuleConfig']['tag']) {
		$tag_handler = xoops_getmodulehandler('tag', 'tag');
		$tag_handler->updateByItem($clone_form->getVar("tag"), $clone_forms_id, $GLOBALS['xoopsModule']->getVar("dirname"), $catid = 0);
	}
	
	redirect_header(XOOPS_URL.'/modules/xquiz/admin/modform.php',1,_XQUIZ_FORMCLONED);
	exit(0);
}


/**
* This function xquiz_modforms_rename the form in the database
*
* @param string $op 		type of action : renform
* @param int    $id		  id of the form
* @param string $title  old title to replace
* @param string $title2 new title
*
* @todo change the way to manage the ' in the title of the form

*/
function xquiz_modforms_renform($id, $handler)
{
	
	$title = $GLOBALS['myts']->makeTboxData4Save($_POST["title2"]);

	if (empty($id)) {
		redirect_header("modform.php", 2, _ERR_XQUIZ_ERRORTITLE);
		exit(0);
	}
	
	$forms_id = $handler->get($id);
	$forms_id->setVar('title', $title);
	$handler->insert($forms_id);
	
	$forms_menu_handler = xoops_getmodulehandler('forms_menu', 'xquiz');
	$forms_menu = $forms_menu_handler->get($id);
	if ($forms_menu) {
		$forms_menu->setVar('itemname', $title);
		$forms_menu->setVar('itemurl', $forms_id->getURL());
		$forms_menu_handler->insert($forms_menu);
	}
	
	redirect_header(XOOPS_URL.'/modules/xquiz/admin/modform.php',1,_XQUIZ_FORMRENAMED);
	exit(0);
}

/**
* This function........ I don't remember the goal of this function xquiz_modforms_!!!!!!
* @param string $op type of action : modform

*/
function xquiz_modforms_modform($id)
{
	if (empty($id)) {
		redirect_header("modform.php", 2, _ERR_XQUIZ_ERRORTITLE);
	}
	$url = XOOPS_URL.'/modules/xquiz/admin/index.php?id='.$id;
 	redirect_header($url,0,'');

}

/**
* This function xquiz_modforms_delete the form in the tables
*
* @param int    $id id of the form
* @param string $op type of action : delform
* @param string $ok validation

*/
function xquiz_modforms_delform($id)
{
    if (!isset($_POST['ok'])) {

		forms_adminMenu(2, _AM_XQUIZ_FORMS);
		echo '<table class="outer" width="100%"><th><center>'._AM_XQUIZ_DELETE.'</center></th></table>';
        xoops_confirm(array( 'op' => 'delform', 'id' => $_GET['id'], 'ok' => 1), 'modform.php', _AM_XQUIZ_DELETE_FORM );
	} else {
		$sql=sprintf("SELECT desc_form FROM ".$GLOBALS['xoopsDB']->prefix("forms_id")." WHERE id_form='%s'",$id);
		$res = $GLOBALS['xoopsDB']->query ( $sql ) or die('Erreur SQL !<br>'.$requete.'<br>'.$XoopsDB->error());
		if ( $res ) {
  			while ( $row = $GLOBALS['xoopsDB']->fetchRow( $res ) ) {
    			$title = $row[0];
  			}
		}
		$sql = sprintf("DELETE FROM %s WHERE id_form = '%s'", $GLOBALS['xoopsDB']->prefix("forms_id"), $id);
		$GLOBALS['xoopsDB']->queryF($sql) or $eh->show("error : cannot delete the form in the forms_id table (modform.php / delform())");

		$sql = sprintf("DELETE FROM %s WHERE id_form = '%u'", $GLOBALS['xoopsDB']->prefix("form"), $id);
		$GLOBALS['xoopsDB']->queryF($sql) or $eh->show("error : cannot delete the form in the form table (modform.php / delform())");

		$sql = sprintf("DELETE FROM %s WHERE menuid = '%s'", $GLOBALS['xoopsDB']->prefix("forms_menu"), $id);
		$GLOBALS['xoopsDB']->queryF($sql) or $eh->show("error : cannot delete the form in the forms_menu table (modform.php / delform())");

		$sql = sprintf("DELETE FROM %s WHERE id_form = '%u'", $GLOBALS['xoopsDB']->prefix("forms_form"), $id);
		$GLOBALS['xoopsDB']->queryF($sql) or $eh->show("error : cannot delete the form in the forms_form table (modform.php / delform())");

		$url = XOOPS_URL.'/modules/xquiz/admin/modform.php';
		Header("Location: $url");

	}
}

function xquiz_modforms_showform($id, $data, $handler)
{
	if (empty($id)) {
		redirect_header("modform.php", 2, _ERR_XQUIZ_ERRORTITLE);
	}

	$criteria = new Criteria('id_form', $id);
	if ($handler->getCount($criteria) == 0)
	{
		redirect_header("consult.php",2,_XQUIZ_NOTSHOW.$data[$id]._XQUIZ_NOTSHOW2);
		exit(0);
	} else {
		$url = XOOPS_URL.'/modules/xquiz/admin/consult.php?id='.$id;
		redirect_header($url,2,'');
	}
}

function xquiz_modforms_permform($handler)
{
	$module_id = $GLOBALS['xoopsModule']->getVar('mid');
	$GLOBALS['myts'] =& MyTextSanitizer::getInstance();


	$forms_ids = $handler->getObjects(NULL, true);
	foreach($forms_ids as $key => $item) {
		$tab[$key] = $item->getVar('title')." (".$key.")";
	}

	$title_of_form = _AM_XQUIZ_TITPERM;
	$perm_name = 'view_form';
	$perm_desc = '';
	$form = new XoopsGroupPermForm('<table class="outer" cellspacing="1" width="100%"><th><font size="2">'.$title_of_form.'</font></th></table>', $module_id, $perm_name, $perm_desc);
	foreach($tab as $item_id => $item_name) {
		if($item_name != "") $form->addItem($item_id, $item_name);
	}
	return $form->render();
}

function xquiz_elements_permform($handler)
{
	$module_id = $GLOBALS['xoopsModule']->getVar('mid');
	
	$elements = $handler->getObjects(NULL, true);
	foreach($elements as $key => $element) {
		$tab[$key] = $element->getVar('ele_caption')." (".$key.")";
	}

	$title_of_form = _AM_XQUIZ_ELE_PERM;
	$perm_name = 'view_element';
	$perm_desc = '';
	$form = new XoopsGroupPermForm('<table class="outer" cellspacing="1" width="100%"><th><font size="2">'.$title_of_form.'</font></th></table>', $module_id, $perm_name, $perm_desc);
	foreach($tab as $item_id => $item_name) {
		if($item_name != "") $form->addItem($item_id, $item_name);
	}
	return $form->render();
}
?>