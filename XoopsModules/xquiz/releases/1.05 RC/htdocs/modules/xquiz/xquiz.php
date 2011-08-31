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
include 'header.php';

xoops_loadLanguage('modinfo', 'xquiz');
xoops_loadLanguage('errors', 'xquiz');
xoops_loadLanguage('admin', 'xquiz');

$GLOBALS['myts'] =& MyTextSanitizer::getInstance();

$menuid=0;
$block = array();
$groupuser = array();

if(!isset($_POST['id'])){
	$id = isset ($_GET['id']) ? intval($_GET['id']) : 0;
} else {
	$id = intval($_POST['id']);
}

if(!isset($_POST['qcm'])){
	$qcm = isset ($_GET['qcm']) ? intval($_GET['qcm']) : 0;
} else {
	$qcm = intval($_POST['qcm']);
}

if(!isset($num_id)){ $num_id=0;}
if(!isset($path)){ $path="";}
if(!isset($header)){ $header="";}
$position=0;



$forms_id = $forms_id_handler->get($id); 

if (!is_object($forms_id)) {
	redirect_header(XOOPS_URL.'/modules/xquiz/', 10, _NOPERM);
	exit(0);
}

extract($forms_id->toArray());

$url = XOOPS_URL.'/'.$GLOBALS['xoopsModuleConfig']['baseurl'].'/'.urlencode(str_replace(array(' ', '_'), '-', $title)).'/'.$id.$GLOBALS['xoopsModuleConfig']['endofurl'];
if (!strpos($url, $_SERVER['REQUEST_URI'])&&$GLOBALS['xoopsModuleConfig']['htaccess']==true&&empty($_POST)) {
	header( "HTTP/1.1 301 Moved Permanently" ); 
	header('Location: '.$url);
	exit(0);
}
if ($onlyone == '1') {
	if (is_object($GLOBALS['xoopsUser'])) {
		$tab= $GLOBALS['xoopsUser']->getGroups();
		if ($tab[0] != 1) {
			$usage = $forms_form_handler->getUsage($id, $GLOBALS['xoopsUser']->getVar('uid'), $GLOBALS['user_details']['ip']);
			if ($usage) {
				foreach ($usage as $key => $use) {
					$id_req2 = $use->getVar('id_req');
					$time2 = $use->getVar('time');
				}
			}
			if (!empty($time2)) {
				if ($nbjours != 0) {
					if (((mktime(0 , 0 , 0 , date("m") , date("d") , date("Y")) - strtotime($time2))/86400) < $nbjours) {
						 $jours = ($nbjours - ((mktime(0 , 0 , 0 , date("m") , date("d") , date("Y")) - strtotime($time2))/86400));
						 redirect_header(XOOPS_URL,1,_XQUIZ_WAIT1.$jours._XQUIZ_WAIT2);
					}
				} else {
					if (!empty($id_req2)) {
						redirect_header(XOOPS_URL,1,_XQUIZ_ONLYONE);
 	 	 			}
				}
			}
		}
	} else {
		$usage = $forms_form_handler->getUsage($id, 0, $GLOBALS['user_details']['ip']);
		if ($usage) {
			foreach ($usage as $key => $use) {
				$id_req2 = $use->getVar('id_req');
				$time2 = $use->getVar('time');
			}
		}
		if (!empty($time2)) {
			if ($nbjours != 0) {
				if (((mktime(0 , 0 , 0 , date("m") , date("d") , date("Y")) - strtotime($time2))/86400) < $nbjours) {
					 $jours = ($nbjours - ((mktime(0 , 0 , 0 , date("m") , date("d") , date("Y")) - strtotime($time2))/86400));
					 redirect_header(XOOPS_URL,1,_XQUIZ_WAIT1.$jours._XQUIZ_WAIT2);
				}
			} else {
				if (!empty($id_req2)) {
					redirect_header(XOOPS_URL,1,_XQUIZ_ONLYONE);
				}
   			}
   		}
	}
}

$forms_menu = $forms_menu_handler->get($id);

if ($ordre=='tit') {
	if ($afftit=='1') {
		$header = "<center><font size=4>".$title."</font></center>";
	} else {
		$header = '';
	}
	if ($affimg=='1') {
		$header .= "<br /><center><img src=".XOOPS_URL."/uploads/xquiz/imgform/".$image."></center><br />";
	} else {
		$header .= '';
	}
} else if ($ordre=='img') {
	if ($affimg=='1') {
		$header = "<center><img src=".XOOPS_URL."/uploads/xquiz/imgform/".$image."></center>";
	} else {
		$header = '';
	}
	if ($afftit=='1') {
		$header .= "<br /><center><font size=4>".$title."</font></center><br />";
	} else {
		$header .= '';
	}
}

if( empty($_POST['submit']) ) {
	$j = 0;
	
	$xoopsOption['template_main'] = 'xquiz_questionair.html';
	
	include_once ($GLOBALS['xoops']->path("/header.php"));
	
	$xoTheme->addScript(XOOPS_URL.'/modules/xquiz/js/xquiz.js', array('type'=>'text/javascript'));
	$xoTheme->addScript(XOOPS_URL.'/modules/xquiz/js/main15.js', array('type'=>'text/javascript'));
	$xoTheme->addStylesheet(XOOPS_URL.'/modules/xquiz/language/'.$GLOBALS['xoopsConfig']['language'].'/xquiz.css');
	
	$GLOBALS['xoopsTpl']->assign('header', $header);
	
	$criteria = new Criteria('ele_display', 1);
	$criteria->setSort('ele_order');
	$criteria->setOrder('ASC');
	
	$elements =& $forms_handler->getObjects2($criteria,$id);

    $urlsuite = $forms_id->getURL();
	
	$form = new XoopsThemeForm($header, 'xquiz', $urlsuite);

	$form->setExtra("enctype='multipart/form-data'") ; // impératif !
	
	$perm_name = 'view_element';
	$count = 0;
	$tabval = array();
	foreach( $elements as $i ) {
		if ( $gperm_handler -> checkRight( $perm_name, $i->getVar('ele_id'), $groups, $xquizModule->getVar('mid') ) ) {
			$ele_value = $i->getVar('ele_value');
			if (isset ($ele_value[0])) {
				$ele_value[0] = eregi_replace("'", "`", $ele_value[0]);
				$ele_value[0] = stripslashes($ele_value[0]);
			}
			if ($qcm == '1') {
				if ($i->getVar('ele_type') == 'select') {
					$opt_count=0;
					$tabval[$j] = '';
					while( $k = each($ele_value[2]) ){
						$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($k['key']);
						if( $k['value'] > 0 ){
							$tabval[$j] .= ":".$k['key'];
						}
						$opt_count++;
					}
				} else if ($i->getVar('ele_type') == 'checkbox') {
					$opt_count=0;
					$tabval[$j] = '';
					while( $k = each($ele_value) ){
						$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($k['key']);
						if( $k['value'] > 0 ){
							$tabval[$j] .= ":".$k['key'];
						}
						$opt_count++;
					}
				} else if ($i->getVar('ele_type') == 'yn') {
					$opt_count=0;
					$tabval[$j] = '';
					while( $k = each($ele_value) ){
						$options[$opt_count] = constant($k['key']);
						$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($options[$opt_count]);
						if( $k['value'] > 0 ){
							if ($k['key'] == '_YES') {
								$tabval[$j] = 1;
	                        } else if ($k['key'] == '_NO') {
								$tabval[$j] = 2;
	                        }
						}
						$opt_count++;
					}
				} else if ($i->getVar('ele_type') == 'radio') {
					$opt_count=0;
					$tabval[$j] = '';
					while( $k = each($ele_value) ){
						$options[$opt_count] = $GLOBALS['myts']->stripSlashesGPC($k['key']);
	      				$options[$opt_count] = $GLOBALS['myts']->displayTarea($options[$opt_count]);
						if( $k['value'] > 0 ){
							$tabval[$j] .= $k['key'];
						}
						$opt_count++;
					}
				}
	            $j++;
			}
	
			//compatibility php 4.4
			unset($forms_ele);
	
			$renderer = new XQuizFormsRenderer($i);
			if ($qcm == '1') {
				$forms_ele =& $renderer->constructElement('ele_'.$i->getVar('ele_id'),'','1');
			} else {
	        	$forms_ele = $renderer->constructElement('ele_'.$i->getVar('ele_id'),'','0');
	        }
	
			if ($i->getVar('ele_type') == 'sep') {
				$ele_value[0] = eregi_replace('@font','',$ele_value[0]);
				$ele_value = split ('<*>', $ele_value[0]);
				foreach ($ele_value as $t){
					if (strpos($t, '<')!=false) {
						$ele_value[0] = $t;
	                }
	            }
				$ele_value = split ('</', $ele_value[0]);
	
				$hid = new XoopsFormHidden('ele_'.$i->getVar('ele_id'), $ele_value[0]);
				$form->addElement ($hid);
	
			}
			if ($i->getVar('ele_type') == 'areamodif'){
				$hid2 = new XoopsFormHidden('ele_'.$i->getVar('ele_id'), $ele_value[0]);
				$form->addElement ($hid2);
			}
	
	        if ($i->getVar('ele_type') == 'upload'){
				$hid3 = new XoopsFormHidden($ele_value[1], $ele_value[1]);
				$form->addElement ($hid3);
			}
	
	        $req = intval($i->getVar('ele_req'));
			$form->addElement($forms_ele, $req);
			$count++;
			unset($hidden);
		}
	}

    if ($qcm == '1') {
		$tabtemp=implode("_", $tabval);
		$testtabtemp = new XoopsFormHidden('tab',$tabtemp);
		$form -> addElement($testtabtemp);
	}

	$form->addElement (new XoopsFormHidden ('counter', $count));

    if ($elements) {
    	$send = $GLOBALS['myts']->displayTarea($send);

		// SecurityImage by DuGris
		if (!is_object($GLOBALS['xoopsUser'])) {
    		$security_image = new XoopsCaptcha( _MN_XQUIZ_ANSWER_PUZZEL );
			if ($security_image->render()) {
        		$form->addElement($security_image, true);
			}
    	}
	    // SecurityImage by DuGris

		$form->addElement(new XoopsFormButton('', 'submit', $send, 'submit'));
		
		$GLOBALS['xoopsTpl']->assign('form', $form->render());
		$GLOBALS['xoopsTpl']->assign('warning', _AM_XQUIZ_WARN);
	} else {
		$GLOBALS['xoopsTpl']->assign('error', xoops_error(_AM_XQUIZ_NOELE, _AM_XQUIZ_NOELE_TITLE));
	}
	
	if ($GLOBALS['xoopsModuleConfig']['tag']) {
		include_once XOOPS_ROOT_PATH."/modules/tag/include/tagbar.php";
		$xoopsTpl->assign('tagbar', tagBar($id, $catid = 0));
	}
	
	include_once ($GLOBALS['xoops']->path("/footer.php"));
	
} else {

	if (!is_object($GLOBALS['xoopsUser'])) {
		$xoopsCaptcha = XoopsCaptcha::getInstance();
		if (!$xoopsCaptcha->verify()) {
			redirect_header($forms_id->getURL(), 10, $xoopsCaptcha->getMessage());
			exit(0);
		}
	}
	
	if ($qcm == '1') {
		$h = 0;
		$tabtemp = $GLOBALS['myts']->makeTboxData4Save($_POST["tab"]);
		$tabval = array();
		$tabval = explode("_", $tabtemp);
	}
	$msg = "";
	$i=0;

	unset($_POST['submit']);
	
	foreach( $_POST as $k => $v ){
		if( preg_match('/ele_/', $k)){
			$n = explode("_", $k);
			$ele[$n[1]] = $v;
			$ide[$n[1]] = $n[1];
		}
		if($k == 'xoops_upload_file'){
			$tmp = $k;
			$k = $v[0];
			$v = $tmp;
			$n = explode("_", $k);
			$ele[$n[1]] = $v;
			$ide[$n[1]] = $n[1];
		}
	}
	$criteria = new Criteria('1', '1');
	$criteria->setSort('`id_req`');
	$criteria->setOrder('DESC');
	$forms_forms = $forms_form_handler->getObjects($criteria, false);
	if (is_object($forms_forms[0])) {
		$id_req = $forms_forms[0]->getVar('id_req');
	} else { 
		$id_req = 0;
	}
	if ($id_req == 0) {
    	$num_id = 1;
    } else if (
    	$num_id <= $id_req
    )
    $num_id = $id_req + 1;

	$up = array();
	$value = null;
	$nbok = 0;
	$nbtot = 0;
	$mailing = '';
	$users_handler = xoops_getmodulehandler('forms_users', 'xquiz');
	$responses_handler = xoops_getmodulehandler('forms_responses', 'xquiz');
	
	$user = $users_handler->create();
	$user = $users_handler->get($users_handler->insert($user, true));
	
	foreach( $ide as $i ){
		$element =& $forms_handler->get($i);
		if( !empty($ele[$i]) ) {
			$id_form = $element->getVar('id_form');
			$ele_id = $element->getVar('ele_id');
			$ele_type = $element->getVar('ele_type');
			$ele_value = $element->getVar('ele_value');
			$ele_scores = $element->getVar('ele_scores');
			$ele_caption = $element->getVar('ele_caption');
			$ele_caption = stripslashes($ele_caption);
			$ele_caption = eregi_replace ("&#039;", "`", $ele_caption);
			$ele_caption = eregi_replace ("&quot;", "`", $ele_caption);

			$user->setVar('id_form', $id_form);
			$user->setVar('questions', $user->getVar('questions')+1);
			$score=0;
			switch($ele_type){
				case 'twitter':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$msg.= $GLOBALS['myts']->stripSlashesGPC($ele[$i])."<br /></td></table><br />";
					$value = $ele[$i];
					$user->setVar('twitter', $value);
					break;
				case 'facebook':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$msg.= $GLOBALS['myts']->stripSlashesGPC($ele[$i])."<br /></td></table><br />";
					$value = $ele[$i];
					$user->setVar('facebook', $value);
					break;
				case 'name':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$msg.= $GLOBALS['myts']->stripSlashesGPC($ele[$i])."<br /></td></table><br />";
					$value = $ele[$i];
					$user->setVar('name', $value);
					break;
				case 'email':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$msg.= $GLOBALS['myts']->stripSlashesGPC($ele[$i])."<br /></td></table><br />";
					$value = $ele[$i];
					$user->setVar('email', $value);
					break;
				case 'text':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$msg.= $GLOBALS['myts']->stripSlashesGPC($ele[$i])."<br /></td></table><br />";
					$value = $ele[$i];
				break;
				case 'textarea':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$msg.= $GLOBALS['myts']->stripSlashesGPC($ele[$i])."<br /></td></table><br />";
					$value = $ele[$i];
				break;

				case 'radio':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$value = '';
					$score = 0;
					$opt_count = 1;
					while( $v = each($ele_value) ){
						if( $opt_count == $ele[$i] ){
							$msg.= $GLOBALS['myts']->stripSlashesGPC($v['key']).'<br />';
							$value = $v['key'];
							$score = $score + $ele_scores[$value]; 
						}
						$opt_count++;
					}
					if ($qcm == '1') {
						if ($affrep == '1') {
							$msg .= "<br /><b>&nbsp;&nbsp;"._ANSWERS."</b><br />&nbsp;&nbsp;";
							$msg .= $GLOBALS['myts']->stripSlashesGPC($tabval[$h]);
						}
					}
		 			$msg.= $GLOBALS['myts']->stripSlashesGPC("</td></table><br />");
				break;

				case 'yn':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$v = ($ele[$i]==2) ? _NO : _YES;
					$msg.= $GLOBALS['myts']->stripSlashesGPC($v)."<br />";
					if ($qcm == '1') {
						if ($affrep == '1') {
							$msg .= "<br /><b>&nbsp;&nbsp;"._ANSWERS."</b><br />&nbsp;&nbsp;";
							if ($tabval[$h] == '1') {
							$msg .= $GLOBALS['myts']->stripSlashesGPC(_YES);}
							else if ($tabval[$h] == '2') {
							$msg .= $GLOBALS['myts']->stripSlashesGPC(_NO);}
						}
					}
					$msg.= "</td></table><br />";
					$value = $ele[$i];
				break;

				case 'checkbox':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$value = '';
					$opt_count = 1;
					while( $v = each($ele_value) ){
						if( is_array($ele[$i]) ){
							if( in_array($opt_count, $ele[$i]) ){
								$msg.= $GLOBALS['myts']->stripSlashesGPC($v['key']).'<br />';
								$score = $score + $ele_scores[$v['key']];
								$value = $value.':'.$v['key'];
							}
							$opt_count++;
						}else{
							if( !empty($ele[$i]) ){
								$msg.= $GLOBALS['myts']->stripSlashesGPC($v['key']).'<br />';
								$score = $score + $ele_scores[$v['key']];
								$value = $v['key'];
							}
						}
					}
					if ($qcm == '1') {
						if ($affrep == '1') {
							$msg .= "<br /><b>&nbsp;&nbsp;"._ANSWERS."</b>";
							$rep= split(':', $tabval[$h]);
							foreach( $rep as $w ){
								$msg.= '&nbsp;&nbsp;'.$GLOBALS['myts']->stripSlashesGPC($w).'<br />';
							}
						}
					}
					$msg.= $GLOBALS['myts']->stripSlashesGPC("</td></table><br />");
				break;

				case 'mail':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>";
					$mailing = '';
					$value = '';
					$opt_count = 1;
					while( $v = each($ele_value) ){
						if( is_array($ele[$i]) ){
							if( in_array($opt_count, $ele[$i]) ){
								$v['key'] = split(" - ", $v['key']);
								$msg.= $GLOBALS['myts']->stripSlashesGPC('<li>'.$v['key'][0]).'</li>';
								$mailing = $mailing.$v['key'][1].';';
							}
							$opt_count++;
						}else{
							if( !empty($ele[$i]) ){
								$v['key'] = split(" - ", $v['key']);
								$msg.= $GLOBALS['myts']->stripSlashesGPC('<li>'.$v['key'][0]).'</li>';
								$mailing = $v['key'][1];
							}
						}
					}
					$value = $mailing;
					$msg.= $GLOBALS['myts']->stripSlashesGPC("</td></table><br />");
				break;

				case 'mailunique':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>";
					$mailing = '';
					$value = '';
					$opt_count = 1;
					while( $v = each($ele_value) ){
						if( is_array($ele[$i]) ){
							if( in_array($opt_count, $ele[$i]) ){
								$v['key'] = split(" - ", $v['key']);
								$msg.= $GLOBALS['myts']->stripSlashesGPC('<li>'.$v['key'][0]).'</li>';
								$mailing = $mailing.$v['key'][1].';';
							}
							$opt_count++;
						}else{
							if( !empty($ele[$i]) ){
								$v['key'] = split(" - ", $v['key']);
								$msg.= $GLOBALS['myts']->stripSlashesGPC('<li>'.$v['key'][0]).'</li>';
								$mailing = $v['key'][1];
							}
						}
					}
					$value = $mailing;
					$msg.= $GLOBALS['myts']->stripSlashesGPC("</td></table><br />");
				break;

				case 'select':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$value = '';
					$score=0;
					$opt_count = 1;
					if( is_array($ele[$i]) ){
						while( $v = each($ele_value[2]) ){
							if( in_array($opt_count, $ele[$i]) ){
									$msg.= $GLOBALS['myts']->stripSlashesGPC($v['key']).'<br />';
									$score = $score + $ele_scores[2][$v['key']];
									$value = $value.':'.$v['key'];
							}
							$opt_count++;
						}
					}else{
						while( $j = each($ele_value[2]) ){
							if( $opt_count == $ele[$i] ){
										$msg.= $GLOBALS['myts']->stripSlashesGPC($j['key']).'<br />';
										$score = $score + $ele_scores[2][$j['key']];
										$value = ':'.$j['key'];
							}
							$opt_count++;
						}
					}
	
	                if ($qcm == '1') {
						if ($affrep == '1') {
							$msg .= "<br /><b>&nbsp;&nbsp;"._ANSWERS."</b>";
							$rep= split(':', $tabval[$h]);
							foreach( $rep as $w ){
								$msg.= '&nbsp;&nbsp;'.$GLOBALS['myts']->stripSlashesGPC($w).'<br />';
							}
						}
					}
					$msg.= $GLOBALS['myts']->stripSlashesGPC("</td></table><br />");
					break;
	
                case 'areamodif':
					$value = $ele[$i];
					break;

                case 'date':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";
					$msg.= $GLOBALS['myts']->stripSlashesGPC($ele[$i])."<br /></td></table><br />";
					$value = ''.$ele[$i];
					break;

                case 'sep':
					$value = $GLOBALS['myts']->stripSlashesGPC($ele[$i]);
					break;

                case 'upload':
					$msg.= "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;".$ele_caption."</font></I></b></td></tr><tr><td bgcolor='#efefef'>&nbsp;&nbsp;";

                    /************* UPLOAD *************/
					$img_dir = XOOPS_ROOT_PATH . DS . "uploads" . DS . $modversion['dirname'] ;
					if (!is_dir($img_dir)) {
						foreach(explode(DS, $img_dir) as $folder) {
							$path .= DS.$folder;
							mkdir($path, 0777);
						}
					}
					$allowed_mimetypes = array();
					foreach ($ele_value[2] as $v) {
                    	$allowed_mimetypes[] = 'image/'.$v[1];
					}
					// allowed mime types : pdf, doc, txt, gif, mpeg, jpeg, rar, zip

					$max_imgsize = $ele_value[1];
					$max_imgwidth = 12000;
					$max_imgheight = 12000;

					$fichier = $_POST["xoops_upload_file"][0] ;

                    // is the field filed ?
					if( !empty( $fichier ) || $fichier != "") {
						// test si aucun fichier n'a été joint
						if($_FILES[$fichier]['error'] == '2' || $_FILES[$fichier]['error'] == '1') {
							$error = sprintf(_MSG_XQUIZ_BIG, $GLOBALS['xoopsConfig']['sitename'])._MSG_XQUIZ_THANK;
							redirect_header(XOOPS_URL."/modules/".$modversion['dirname']."/index.php?id=".$id, 3, $error);
						}
						if(filesize($_FILES[$fichier]['tmp_name']) ==null) {
							$value = $path = '';
							$filename = '';
							$msg.= $filename.'</TD></table><br />';
							break;
						}

                	    if($_FILES[$fichier]['size'] > $max_imgsize) {
							$error = sprintf(_MSG_XQUIZ_UNSENT.$max_imgsize.' octets', $GLOBALS['xoopsConfig']['sitename'])._MSG_XQUIZ_THANK;
							redirect_header(XOOPS_URL."/modules/".$modversion['dirname']."/index.php?id=".$id, 3, $error);
						}

    	                // teste si le fichier a été uploadé dans le répertoire temporaire:
						if( ! is_readable( $_FILES[$fichier]['tmp_name'])  || $_FILES[$fichier]['tmp_name'] == "" ) {
							$path = '';
							$filename = '';
							$error = sprintf(_MSG_XQUIZ_UNSENT.$max_imgsize.' octets', $GLOBALS['xoopsConfig']['sitename'])._MSG_XQUIZ_THANK;
							redirect_header(XOOPS_URL."/modules/".$modversion['dirname']."/index.php?id=".$id, 3, $error);
							//	exit ;
						}

        	            // création de l'objet uploader
						$uploader = new XoopsMediaUploader_FA($img_dir, $allowed_mimetypes, $max_imgsize, $max_imgwidth, $max_imgheight);
						// fichier uploadé conforme en dimension et taille, bien copié du répertoire temporaire au répertoire indiqué ??
						if( $uploader->fetchMedia( $fichier ) && $uploader->upload() ) {
							$pos = strrpos($uploader->getSavedFileName(), '.');
							$type = 'image/'.substr($uploader->getSavedFileName(), $pos+1);
							if (!in_array ($type, $allowed_mimetypes)) {	//si ce type est autorisé
								$path = '';
								$filename = '';
								$error = sprintf(_MSG_XQUIZ_UNTYPE.implode(', ',$allowed_mimetypes))._MSG_XQUIZ_THANK;
								redirect_header(XOOPS_URL."/modules/".$modversion['dirname']."/index.php?id=".$id, 3, $error);
							}
							// L'upload a réussi
							$path = $uploader->getSavedDestination();
							$filename = $uploader->getSavedFileName();
							$up[$path] = $filename;
							$value = $path;
							$msg.= $filename.'</TD></table><br />';
							// sinon l''upload a échoué : message d'erreur
						}
					} else {
						$value = $path = '';
						$filename = '';
						$msg.= $filename.'</TD></table><br />';
					}
				break;

                default:
				break;
			}

			$user->setVar('answers', $user->getVar('answers')+count(explode(':', $value)));
			$user->setVar('score', $user->getVar('score')+$score);
			$user = $users_handler->get($users_handler->insert($user, true));
			
			$response = $responses_handler->create();
			$response->setVar('id_form', $user->getVar('id_form'));
			$response->setVar('id_ele', $ele_id);
			$response->setVar('id_user', $user->getVar('id_user'));
			$response->setVar('value_ele', explode(':', $value));
			$response->setVar('value_score', $score);
			$response->setVar('value_answers', count(explode(':', $value)));
			$response->setVar('response', time());
			$responses_handler->insert($response, true);
			
			if( is_object($GLOBALS['xoopsUser']) ) {
		  		$uid = $GLOBALS['xoopsUser']->getVar("uid");
			} else {
				$uid =0;
			}

            if ($qcm == '1') {
				if ($ele_type == 'select' || $ele_type == 'checkbox' || $ele_type == 'radio' || $ele_type == 'yn') {
					if ($value == $tabval[$h]) {
						$nbok++;
					}
					$nbtot++;
				}
			}

			if ($save == 1) {
				$date = date ("Y-m-d");
				$value = str_replace(":","",$value);

				$value = addslashes ($value);
				if ($qcm == '1') {
					if ($ele_type == 'select' || $ele_type == 'checkbox' || $ele_type == 'radio' || $ele_type == 'yn') {
						$formform = $forms_form_handler->create();
						$formform->setVar('id_form', $id);
						$formform->setVar('id_req', $num_id);
						$formform->setVar('ele_id', $ele_id);
						$formform->setVar('ele_type', $ele_type);
						$formform->setVar('ele_caption', $ele_caption);
						$formform->setVar('ele_value', $value);
						$formform->setVar('uid', $uid);
						$formform->setVar('date', $date);
						$formform->setVar('ip', $GLOBALS['user_details']['ip']);
						$formform->setVar('rep', $tabval[$h]);
						$formform->setVar('nbrep', $nbok);
						$formform->setVar('nbtot', $nbtot);
						$formform->setVar('pos', $position);
						$position++;
					} else {
						$formform = $forms_form_handler->create();
						$formform->setVar('id_form', $id);
						$formform->setVar('id_req', $num_id);
						$formform->setVar('ele_id', $ele_id);
						$formform->setVar('ele_type', $ele_type);
						$formform->setVar('ele_caption', $ele_caption);
						$formform->setVar('ele_value', $value);
						$formform->setVar('uid', $uid);
						$formform->setVar('date', $date);
						$formform->setVar('ip', $GLOBALS['user_details']['ip']);
						$formform->setVar('pos', $position);
						$position++;
					}
				} else {
					$formform = $forms_form_handler->create();
					$formform->setVar('id_form', $id);
					$formform->setVar('id_req', $num_id);
					$formform->setVar('ele_id', $ele_id);
					$formform->setVar('ele_type', $ele_type);
					$formform->setVar('ele_caption', $ele_caption);
					$formform->setVar('ele_value', $value);
					$formform->setVar('uid', $uid);
					$formform->setVar('date', $date);
					$formform->setVar('ip', $GLOBALS['user_details']['ip']);
					$formform->setVar('pos', $position);
					$position++;
				}
				if (!$formform_handler->insert($formform, true)) {
					xoops_error(sprintf(_MN_XQUIZ_ERROR_INSERTING, $formform->getErrorHTML()), _MN_XQUIZ_ERROR_INSERTING_TITLE);
				}
			}

            if ($qcm == '1') {
				if ($ele_type == 'select' || $ele_type == 'checkbox' || $ele_type == 'radio' || $ele_type == 'yn') {
					$h++;
				}
			}
		}
	}
	$msg = nl2br($msg);

	xoops_load('xoopsmailer');
	
	$xoopsMailer =&getMailer();
	$xoopsMailer->multimailer->isHTML(true);
	$xoopsMailer->setTemplateDir($template_dir);
	$xoopsMailer->setTemplate('xquiz.tpl');
	$xoopsMailer->setSubject(_MSG_XQUIZ_SUBJECT._MSG_XQUIZ_FORM.$title);

	if ($qcm=='1'){
		if ($affres == '1') {
			$nb_ans = "<table border=1 bordercolordark=black bordercolorlight=#C0C0C0 width=500><tr><td bgcolor='#6C87B0'><b><I><font color='white'>&nbsp;&nbsp;"._FORM_NBANSWER."</I></b>  ".$nbok." / ".$nbtot."</font></td></table><br />";
			$xoopsMailer->assign("NBANS", $nb_ans);
		} else {
			$xoopsMailer->assign("NBANS", '');
		}
	} else {
		$xoopsMailer->assign("NBANS", '');
	}

	if( is_object($GLOBALS['xoopsUser']) ) {
		$xoopsMailer->setFromEmail($GLOBALS['xoopsUser']->getVar("email"));
	}
	
	$xoopsMailer->assign("MSG", $msg);
	$xoopsMailer->assign("TITLE", $title);

	foreach ($up as $k => $v ) {
		$path = $k;
		$filename = $v;
		if ($xoopsMailer->multimailer->AddAttachment($path,$filename,"base64","application/octet-stream")) {
        } else {
        	echo $xoopsMailer->getErrors();
        }
	}

	$xoopsMailer->useMail();

	if ( isset($_POST['user_email']) ) 
	{
		if ($_POST['user_email'] != '' && !preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+([\.][a-z0-9-]+)+$/i", $_POST['user_email'])) {
			$error = sprintf(_MSG_XQUIZ_USEREMAIL, $_POST['user_email']);
			redirect_header(XOOPS_URL."/modules/".$modversion['dirname']."/index.php?id=".$id, 3, $error);        
			exit(0);
		} else {
			$xoopsMailer->setToEmails($_POST['user_email']);
		}
	}

	if ($mailing != '') {
		$rec = split(";",$mailing);
		foreach ($rec as $k) {
			$xoopsMailer->setToEmails($k);
        }
	} else {
		if( $expe == 1 && is_object($GLOBALS['xoopsUser'])){
			$email_expe   = $GLOBALS['xoopsUser']->getVar("email");
			$xoopsMailer->setToEmails($email_expe);
		}

		if( $admin == 1 ){
			$xoopsMailer->setToEmails($GLOBALS['xoopsConfig']['adminmail']);
		} else {
			$xoopsMailer->setToEmails($email);

			if (!empty($groupe) && ($groupe != "0")){
				$sql=sprintf("SELECT name FROM ".$GLOBALS['xoopsDB']->prefix("groups")." WHERE groupid='%s'",$groupe);
				$res = $GLOBALS['xoopsDB']->query( $sql ) or die('Erreur SQL !<br />'.$sql.'<br />'.$GLOBALS['xoopsDB']->error());
				if ( $res ) {
				  	while ( $row = $GLOBALS['xoopsDB']->fetchRow($res) ) {
				    	$gr = $row[0];
	  				}
				}
			}

			$sqlstr = 'SELECT '.$GLOBALS['xoopsDB']->prefix('users').'.uname AS UserName, '.$GLOBALS['xoopsDB']->prefix('users').'.email AS UserEmail, '.$GLOBALS['xoopsDB']->prefix('users').'.uid AS UserID FROM '
					.$GLOBALS['xoopsDB']->prefix("groups").", ".$GLOBALS['xoopsDB']->prefix("groups_users_link").", ".$GLOBALS['xoopsDB']->prefix("users")." WHERE ".$GLOBALS['xoopsDB']->prefix('users').'.uid = '.$GLOBALS['xoopsDB']->prefix('groups_users_link').'.uid '
					.' AND '.$GLOBALS['xoopsDB']->prefix('groups_users_link').'.groupid = '.$GLOBALS['xoopsDB']->prefix('groups').'.groupid AND '.$GLOBALS['xoopsDB']->prefix('groups').'.groupid = '.$groupe;

			$res = $GLOBALS['xoopsDB']->query($sqlstr);
			while (list($UserName,$UserEmail,$UserID) = $GLOBALS['xoopsDB']->fetchRow($res)) {
				$xoopsMailer->setToEmails($UserEmail);
			}
		}
	}
	$send_mail="";

	if ($msub == 1 || $mip == 1 || $mnav == 1) {
		$send_mail = "<fieldset>";
	}

	if ($msub == 1) {
		if( is_object($GLOBALS['xoopsUser']) ){
			$send_mail = $send_mail."<b>"._MAIL_SUB."</b><a href=".XOOPS_URL."/userinfo.php?uid=".$GLOBALS['xoopsUser']->getVar("uid").">".$GLOBALS['xoopsUser']->getVar("uname")."</a><br />";
		}else{
			$send_mail = $send_mail."<b>"._MAIL_SUB."</b>".$GLOBALS['xoopsConfig']['anonymous']."<br />";
		}
	}

	if ($mip == 1) {
		$send_mail = $send_mail."<b>"._MAIL_IP."</b>".$GLOBALS['user_details']['ip']."<br />";
	}

	if ($mnav == 1) {
		$send_mail = $send_mail."<b>"._MAIL_NAV."</b>".xoops_getenv('HTTP_USER_AGENT')."<br />";
	}

    if ($msub == 1 || $mip == 1 || $mnav == 1) {
		$send_mail .= "</fieldset>";
	}

	$xoopsMailer->assign("SENDMAIL", $send_mail);
    $xoopsMailer->charSet = $cod;
    $xoopsMailer->send();
	$sent = sprintf(_MSG_XQUIZ_SENT, $GLOBALS['xoopsConfig']['sitename'])._MSG_XQUIZ_THANK;

	// on veut conserver le fichier joint dans le rep upload du module xquiz
	/*	if ($path != "") {
		unlink($path);
	}
	*/
	unset ($up);
	
	$answers_handler = xoops_getmodulehandler('forms_answers', 'xquiz');
	$criteria_a = new CriteriaCompo(new Criteria('id_form', $user->getVar('id_form')), 'OR');
	$criteria_a->add(new Criteria('id_form', 0), 'OR');
	$criteria_b = new CriteriaCompo(new Criteria('minimum', $user->getVar('score'), '>='), 'AND');
	$criteria_b->add(new Criteria('maximum', $user->getVar('score'), '<='), 'AND');
	$criteria  = new CriteriaCompo($criteria_a);
	$criteria->add($criteria_b);
	$criteria->setSort('`maximum`, `id_form`');
	$criteria->setOrder('DESC');
	
	if ($answers_handler->getCount($criteria)==0) {
		redirect_header($url, 0, $sent);
		exit(0);
	}
		
	foreach($answers_handler->getObjects($criteria, true) as $id_answer => $answer) {
		redirect_header($answer->getURL(), 0, $sent);
		exit(0);
	}
}
?>