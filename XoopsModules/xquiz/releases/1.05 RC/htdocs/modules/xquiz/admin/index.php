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
include_once ("admin_header.php");

xoops_loadLanguage('modinfo', 'xquiz');
xoops_loadLanguage('main', 'xquiz');
xoops_loadLanguage('admin', 'xquiz');

if(!isset($_POST['op'])){
	$op = isset ($_GET['op']) ? $_GET['op'] : '';
}else {
	$op = $_POST['op'];
}
if(!isset($_POST['id'])){
	$id = isset ($_GET['id']) ? $_GET['id'] : '';
}else {
	$id = $_POST['id'];
}


$forms_id = $forms_id_handler->get($id);
if ( $forms_id ) {
  extract($forms_id->toArray());
}

if(!isset($_POST['op'])){ $_POST['op']=" ";}

if( $_POST['op'] != 'save' ){
	xoops_cp_header();

$GLOBALS['xquizTpl'] = new XoopsTpl();
$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);

$script_a = '<SCRIPT language="JavaScript1.2"  type="text/javascript">
Text[1]=["'._AM_XQUIZ_ED.'","'._AM_XQUIZ_ED_TEXT.'"]
Text[2]=["'._AM_XQUIZ_CLO.'","'._AM_XQUIZ_CLO_TEXT.'"]
Text[3]=["'._AM_XQUIZ_SUPE.'","'._AM_XQUIZ_SUPE_TEXT.'"]
Text[4]=["'._AM_XQUIZ_SEE_FORM.'","'._AM_XQUIZ_SEE_FORM_TEXT.'"]

Style[1]=["white","#F6B542","","","",,"black","#FFFFFF","","","",,,,2,"#F6C063",2,,,,,"",1,,,]

var TipId="help"
var FiltersEnabled = 0 // [for IE5.5+] if your not going to use transitions or filters in any of the tips set this to zero.
mig_clay()
</SCRIPT>';

$title = constant('_AM_XQUIZ_EDIT_ELEMENTS');

$GLOBALS['xquizTpl']->assign('script_a', $script_a);
$GLOBALS['xquizTpl']->assign('id', $id);
$GLOBALS['xquizTpl']->assign('title', $title);
$GLOBALS['xquizTpl']->assign('qcm', $qcm);

	forms_adminMenu(1, _AM_XQUIZ_FORMS);

	$criteria = new Criteria(1,1);
	$criteria->setSort('ele_order');
	$criteria->setOrder('ASC');
	$elements =& $forms_handler->getObjects($criteria,$id);

	foreach( $elements as $i ){
		$ide = $i->getVar('ele_id');
		$ele_value = $i->getVar('ele_value');
		$renderer =& new XQuizFormsRenderer($i);
		$ele_value =& $renderer->constructElement('ele_value['.$ide.']', true, '0');
   		$ele_type = $i->getVar('ele_type');
		$req = $i->getVar('ele_req');
		$check_req = new XoopsFormCheckBox('', 'ele_req['.$ide.']', $req);
		$check_req->addOption(1, ' ');
		if( $ele_type == 'checkbox' || $ele_type == 'radio' || $ele_type == 'yn' || $ele_type == 'select' || $ele_type == 'date' || $ele_type== 'areamodif' || $ele_type == 'upload' || $ele_type == 'areamodif' || $ele_type == 'sep'){
			$check_req->setExtra('disabled="disabled"');
		}

		$order = $i->getVar('ele_order');
		$text_order = new XoopsFormText('', 'ele_order['.$ide.']', 2, 2, $order);
		$display = $i->getVar('ele_display');
		$check_display = new XoopsFormCheckBox('', 'ele_display['.$ide.']', $display);
		$check_display->addOption(1, ' ');
		$hidden_id = new XoopsFormHidden('ele_id[]', $ide);
		if(is_array($ele_value))$ele_value[0] = addslashes ($ele_value[0]);

		$data[] = '<tr>';
		$data[] = '<td class="even">'.$i->getVar('ele_caption')."</td>\n";
		$data[] = '<td class="even">'.$ele_value->render()."</td>\n";
		$data[] = '<td class="even" align="center">'.$check_req->render()."</td>\n";
        if ($order != 0) {
        	$data[] = "<td class='even' align='center' title='".$order."'><a href=updown.php?id=".$id."&ide=".$ide."&pos=".$order."&op=ele_up><img src=".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/up.gif /></a>&nbsp;"; }
        else $data[] = "<td class='even' align='center' title='".$order."'>";
		$data[] = "<a href=updown.php?id=".$id."&ide=".$ide."&pos=".$order."&op=ele_down><img src=".XOOPS_URL."/modules/".$xoopsModule->dirname()."/images/down.gif /></a></td><td class='even' align='center'>".$text_order->render()."</td>";
		$data[] = "</td>";
		$data[] = '<td class="even" align="center">'.$check_display->render().$hidden_id->render()."</td>\n";
		$data[] = '<td class="even" align="center"><a href="elements.php?id='.$id.'&op=edit&amp;ele_id='.$ide.'"><img src='.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/edit.gif alt="" onMouseOver="stm(Text[1],Style[1])" onMouseOut="htm()" /></a></td>';
		$data[] = '<td class="even" align="center"><a href="elements.php?id='.$id.'&op=edit&amp;ele_id='.$ide.'&clone=1"><img src='.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/cloner.gif alt="" onMouseOver="stm(Text[2],Style[1])" onMouseOut="htm()"/></a></td>';
		$data[] = '<td class="even" align="center"><a href="elements.php?id='.$id.'&op=delete&amp;ele_id='.$ide.'"><img src='.XOOPS_URL.'/modules/'.$xoopsModule->dirname().'/images/delete.gif alt="" onMouseOver="stm(Text[3],Style[1])" onMouseOut="htm()"/></a></td>';
		$data[] = '</tr>';
	}
	$GLOBALS['xquizTpl']->assign('data', $data);
	$submit = new XoopsFormButton('', 'submit', _AM_XQUIZ_REORD, 'submit');
	$GLOBALS['xquizTpl']->assign('button', $submit->render());
	$hidden_op = new XoopsFormHidden('op', 'save');
	$GLOBALS['xquizTpl']->assign('op', $hidden_op->render());
	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_default_index.html');
	
}else{
        xoops_cp_header();
forms_adminMenu(1, _AM_XQUIZ_FORMS);
	extract($_POST);
	$error = '';
	foreach( $ele_id as $ide ){
		$element =& $forms_handler->get($ide);
		$req = !empty($ele_req[$ide]) ? 1 : 0;
		$element->setVar('ele_req', $req);
		$order = !empty($ele_order[$ide]) ? intval($ele_order[$ide]) : 0;
		$element->setVar('ele_order', $order);
		$display = !empty($ele_display[$ide]) ? 1 : 0;
		$element->setVar('ele_display', $display);
		$type = $element->getVar('ele_type');
		$value = $element->getVar('ele_value');
		if ($type == 'areamodif') $ele_value = $element->getVar('ele_value');
		$ele_value[0] = eregi_replace("'", "`", $ele_value[0]);
		$ele_value[0] = stripslashes($ele_value[0]);

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

		switch($type){
			case 'twitter':
			case 'facebook':
			case 'name':
			case 'email':
			case 'text':
				$value[2] = $ele_value[$ide];
			break;
			case 'textarea':
				$value[0] = $ele_value[$ide];
			break;
			case 'select':
				$new_vars = array();
				$opt_count = 1;
				if( is_array($ele_value[$ide]) ){
					while( $j = each($value[2]) ){
						if( in_array($opt_count, $ele_value[$ide]) ){
							$new_vars[$j['key']] = 1;
						}else{
							$new_vars[$j['key']] = 0;
						}
					$opt_count++;
					}
				}else{
					if( count($value[2]) > 1 ){
						while( $j = each($value[2]) ){
							if( $opt_count == $ele_value[$ide] ){
								$new_vars[$j['key']] = 1;
							}else{
								$new_vars[$j['key']] = 0;
							}
						$opt_count++;
						}
					}else{
						while( $j = each($value[2]) ){
							if( !empty($ele_value[$ide]) ){
								$new_vars = array($j['key']=>1);
							}else{
								$new_vars = array($j['key']=>0);
							}
						}
					}
				}

				$value[2] = $new_vars;
			break;
			case 'checkbox':
				$new_vars = array();
				$opt_count = 1;
				if( is_array($ele_value[$ide]) ){
					while( $j = each($value) ){
						if( in_array($opt_count, $ele_value[$ide]) ){
							$new_vars[$j['key']] = 1;
						}else{
							$new_vars[$j['key']] = 0;
						}
					$opt_count++;
					}
				}else{
					if( count($value) > 1 ){
						while( $j = each($value) ){
							$new_vars[$j['key']] = 0;
						}
					}else{
						while( $j = each($value) ){
							if( !empty($ele_value[$ide]) ){
								$new_vars = array($j['key']=>1);
							}else{
								$new_vars = array($j['key']=>0);
							}
						}
					}
				}
				$value = $new_vars;
			break;
			case 'mail':
				$new_vars = array();
				$opt_count = 1;
				if( is_array($ele_value[$ide]) ){
					while( $j = each($value) ){
						if( in_array($opt_count, $ele_value[$ide]) ){
							$new_vars[$j['key']] = 1;
						}else{
							$new_vars[$j['key']] = 0;
						}
					$opt_count++;
					}
				}else{
					if( count($value) > 1 ){
						while( $j = each($value) ){
							$new_vars[$j['key']] = 0;
						}
					}else{
						while( $j = each($value) ){
							if( !empty($ele_value[$ide]) ){
								$new_vars = array($j['key']=>1);
							}else{
								$new_vars = array($j['key']=>0);
							}
						}
					}
				}
				$value = $new_vars;
			break;
			case 'radio':
			case 'yn':
				$new_vars = array();
				$i = 1;
				while( $j = each($value) ){
					if( $ele_value[$ide] == $i ){
						$new_vars[$j['key']] = 1;
					}else{
						$new_vars[$j['key']] = 0;
					}
					$i++;
				}
				$value = $new_vars;
			break;
			case 'date':
				$value[0] = $ele_value[$ide];
			break;
			case 'areamodif':
				$value[0] = $ele_value[0];
			break;
			case 'sep':
				$value[2] = $ele_value[$ide];
			break;
			case 'upload':
				$value[0] = $ele_value[$ide];
				$value[1] = $ele_value[$ide+1];
				$value[2] = $ele_value[$ide+2];
			break;
			default:
			break;
		}
		$element->setVar('ele_value', $value);
		$element->setVar('id_form', $id);
		if( !$forms_handler->insert($element) ){
			$error .= $element->getHtmlErrors();
		}
	}
	if( empty($error) ){
		$url = "index.php?id=$id";
		Header("Location: $url");
	}else{
		xoops_cp_header();
		forms_adminMenu(1, _AM_XQUIZ_FORMS);
		echo $error;
	}
}

include 'footer.php';
xoops_cp_footer();
?>