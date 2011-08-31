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
if (!function_exists("xquiz_getuser_id")) {
	function xquiz_getuser_id()
	{
		if (is_object($GLOBALS['xoopsUser']))
			$ret['uid'] = $GLOBALS['xoopsUser']->getVar('uid');
		else 
			$ret['uid'] = 0;
	
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$ret['ip']  = $_SERVER["HTTP_X_FORWARDED_FOR"];
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"].':'.$_SERVER["REMOTE_ADDR"];
			$net = gethostbyaddr($_SERVER["HTTP_X_FORWARDED_FOR"]);
		} else {
			$ret['ip']  =  $_SERVER["REMOTE_ADDR"];
			$ip = $_SERVER["REMOTE_ADDR"];
			$net = gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		}
		$ret['netbios'] = $net;
		$ret['md5'] = md5($GLOBALS['xoopsModuleConfig']['salt'] . $ip . $net);	
		return $ret;
	}
}

if (!function_exists("xquiz_object2array")) {
	function xquiz_object2array($objects) {
		$ret = array();
		foreach((array)$objects as $key => $value) {
			if (is_object($value)) {
				$ret[$key] = xquiz_object2array($value);
			} elseif (is_array($value)) {
				$ret[$key] = xquiz_object2array($value);
			} else {
				$ret[$key] = $value;
			}
		}
		return $ret;
	}
}

if (!function_exists('xquiz_getFilterElement')) {
	function xquiz_getFilterElement($filter, $field, $sort='title', $fct = 'forms_answers') {
		$components = xquiz_getFilterURLComponents($filter, $field, $sort);
		include_once('objects.xshop.php');
		switch ($field) {
			case 'id_form':
				$ele = new XQuizFormSelectForm('', 'filter_'.$field.'', $components['value'], 1, false, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
			case 'id_ele':
				$ele = new XQuizFormSelectElement('', 'filter_'.$field.'', $components['value'], 1, false, 0, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;		    	
			case 'id_user':
				$ele = new XQuizFormSelectUsers('', 'filter_'.$field.'', $components['value'], 1, false, 0, true);
		    	$ele->setExtra('onchange="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+this.options[this.selectedIndex].value'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	break;
		    case 'value_ele':		    	
		    case 'value_score':
		    case 'value_answers':
		    case 'name':
		    case 'twitter':
		    case 'facebook':
		    case 'score':
		    case 'questions':
		    case 'answers':
		    case 'email':
			case 'title':
		    case 'html':
		    case 'minimum':
		    case 'maximum':
		    	$ele = new XoopsFormElementTray('');
				$ele->addElement(new XoopsFormText('', 'filter_'.$field.'', 8, 40, $components['value']));
				$button = new XoopsFormButton('', 'button_'.$field.'', '[+]');
		    	$button->setExtra('onclick="window.open(\''.$_SERVER['PHP_SELF'].'?'.$components['extra'].'&filter='.$components['filter'].(!empty($components['filter'])?'|':'').$field.',\'+$(\'#filter_'.$field.'\').val()'.(!empty($components['operator'])?'+\','.$components['operator'].'\'':'').',\'_self\')"');
		    	$ele->addElement($button);
		    	break;
		}
		return $ele;
	}
}

if (!function_exists('xquiz_getFilterComponents')) {
	function xquiz_getFilterURLComponents($filter, $field, $sort='created') {
		$parts = explode('|', $filter);
		$ret = array();
		$value = '';
    	foreach($parts as $part) {
    		$var = explode(',', $part);
    		if (count($var)>1) {
	    		if ($var[0]==$field) {
	    			$ele_value = $var[1];
	    			if (isset($var[2]))
	    				$operator = $var[2];
	    		} elseif ($var[0]!=1) {
	    			$ret[] = implode(',', $var);
	    		}
    		}
    	}
    	$pagenav = array();
    	$pagenav['op'] = isset($_REQUEST['op'])?$_REQUEST['op']:"shops";
		$pagenav['fct'] = isset($_REQUEST['fct'])?$_REQUEST['fct']:"list";
		$pagenav['limit'] = !empty($_REQUEST['limit'])?intval($_REQUEST['limit']):30;
		$pagenav['start'] = 0;
		$pagenav['order'] = !empty($_REQUEST['order'])?$_REQUEST['order']:'DESC';
		$pagenav['sort'] = !empty($_REQUEST['sort'])?''.$_REQUEST['sort'].'':$sort;
    	$retb = array();
		foreach($pagenav as $key=>$value) {
			$retb[] = "$key=$value";
		}
		return array('value'=>$ele_value, 'field'=>$field, 'operator'=>$operator, 'filter'=>implode('|', $ret), 'extra'=>implode('&', $retb));
	}
}

if (!function_exists('forms_adminMenu')) {
	function forms_adminMenu ($currentoption = 0, $breadcrumb = '')
	{
	
		$module_handler = xoops_gethandler('module');
		$xoModule = $module_handler->getByDirname('xquiz');

	  /* Nice buttons styles */
	    echo "
    	<style type='text/css'>
		#form {float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-bottom: 1px solid black; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black;}
		    	#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
    	#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/bg.gif') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 0px; border-bottom: 1px solid black; }
    	#buttonbar ul { margin:0; margin-top: 15px; padding:10px 10px 0; list-style:none; }
		  #buttonbar li { display:inline; margin:0; padding:0; }
		  #buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/left_both.gif') no-repeat left top; margin:0; padding:0 0 0 9px;  text-decoration:none; }
		  #buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/images/right_both.gif') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
		  /* Commented Backslash Hack hides rule from IE5-Mac \*/
		  #buttonbar a span {float:none;}
		  /* End IE5-Mac hack */
		  #buttonbar a:hover span { color:#333; }
		  #buttonbar #current a { background-position:0 -150px; border-width:0; }
		  #buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
		  #buttonbar a:hover { background-position:0% -150px; }
		  #buttonbar a:hover span { background-position:100% -150px; }
		  </style>";
	
	   // global $xoopsDB, $xoModule, $xoopsConfig, $xoModuleConfig;
	
	   $myts = &MyTextSanitizer::getInstance();
	
	   $tblColors = Array();
	   xoops_loadLanguage('modinfo', 'xquiz');
	   $adminmenu=array();	   
	   include XOOPS_ROOT_PATH . '/modules/'.$xoModule->getVar('dirname').'/admin/menu.php';
	   
	   echo "<table width=\"100%\" border='0'><tr><td>";
	   echo "<div id='buttontop'>";
	   echo "<table style=\"width: 100%; padding: 0; \" cellspacing=\"0\"><tr>";
	   echo "<td style=\"width: 45%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;\"><a class=\"nobutton\" href=\"".XOOPS_URL."/modules/system/admin.php?fct=preferences&amp;op=showmod&amp;mod=" . $xoModule->getVar('mid') . "\">" . _PREFERENCES . "</a></td>";
	   echo "<td style='font-size: 10px; text-align: right; color: #2F5376; padding: 0 6px; line-height: 18px;'><b>" . $myts->displayTarea($xoModule->name()) ."</td>";
	   echo "</tr></table>";
	   echo "</div>";
	   echo "<div id='buttonbar'>";
	   echo "<ul>";
		 foreach ($adminmenu as $key => $value) {
		   $tblColors[$key] = '';
		   $tblColors[$currentoption] = 'current';
	     echo "<li id='" . $tblColors[$key] . "'><a href=\"" . XOOPS_URL . "/modules/".$xoModule->getVar('dirname')."/".$value['link']."\"><span>" . $value['title'] . "</span></a></li>";
		 }
		 
	   echo "</ul></div>";
	}
}

if (!function_exists('forms_collapsableBar')) {
	function forms_collapsableBar($tablename = '', $iconname = '', $tpl)
	{
		
	    $tpl->assign('collpasebar_script', '<script type="text/javascript"><!--
		function goto_URL(object)
		{
			window.location.href = object.options[object.selectedIndex].value;
		}
		
		function toggle(id)
		{
			if (document.getElementById) { obj = document.getElementById(id); }
			if (document.all) { obj = document.all[id]; }
			if (document.layers) { obj = document.layers[id]; }
			if (obj) {
				if (obj.style.display == "none") {
					obj.style.display = "";
				} else {
					obj.style.display = "none";
				}
			}
			return false;
		}
		
		var iconClose = new Image();
		iconClose.src = "'.XOOPS_URL.'/modules/xquiz/images/close12.gif";
		var iconOpen = new Image();
		iconOpen.src = "'.XOOPS_URL.'/modules/xquiz/images/open12.gif";
		
		function toggleIcon ( iconName )
		{
			if ( document.images[iconName].src == window.iconOpen.src ) {
				document.images[iconName].src = window.iconClose.src;
			} else if ( document.images[iconName].src == window.iconClose.src ) {
				document.images[iconName].src = window.iconOpen.src;
			}
			return;
		}
		
		//-->
		</script>');
		$tpl->assign('collpasebar', "<h3 style=\"color: #2F5376; margin: 6px 0 0 0; \"><a href='#' onClick=\"toggle('" . $tablename . "'); toggleIcon('" . $iconname . "');\">");
	}
}

if (!function_exists('list_form')) {
	function list_form($qcm)
	{
	global $xoopsDB, $myts, $xoopsUser, $xoopsModule, $xoopsConfig;
	
	$myts =& MyTextSanitizer::getInstance();
	$menuid=0;
	$block = array();
	$groupuser = array();
	$p = 0;
	
	if(!isset($block['content'])){ $block['content']="";}
	
	    
	$module_handler =& xoops_gethandler('module');     
	$xquizModule =& $module_handler->getByDirname('xquiz');
	if ($qcm =="") {
		if ( $xoopsUser ){
			if ( $xoopsUser->isAdmin($xquizModule) ) {
	 				$block['content'].= "<a href=".XOOPS_URL."/modules/xquiz/admin/modform.php><img src='".XOOPS_URL."/modules/xquiz/images/key.gif'></a>";
					}
	}
	}
	
	
	//03/04/2006
	//Probleme de tri en fonction de l'ordre defini dans le menu
	//Ajout de la jointure avec la table menu qui contient les positions
	$sql=sprintf("SELECT id_form,desc_form,admin,groupe,email,expe,url,help,send,msend,msub,mip,mnav,cod FROM ".$xoopsDB->prefix("forms_id")." INNER JOIN ".$xoopsDB->prefix("forms_menu")." ON ".$xoopsDB->prefix("forms_id").".id_form = ".$xoopsDB->prefix("forms_menu").".menuid WHERE qcm = '".$qcm."' order by ".$xoopsDB->prefix("forms_menu").".position");
	//$sql=sprintf("SELECT id_form,desc_form,admin,groupe,email,expe,url,help,send,msend,msub,mip,mnav,cod FROM ".$xoopsDB->prefix("forms_id")." WHERE qcm = '".$qcm."'");
	
	$res = $xoopsDB->query($sql) or die('Erreur SQL !<br />'.$sql.'<br />'.$xoopsDB->error());
	if ($res)
	{
		while ($row= $xoopsDB->fetchArray($res))
		{
		$id_form = $row['id_form'];
		$admin = $row['admin'];
		$groupe = $row['groupe'];
		$email = $row['email'];
		$expe = $row['expe'];
		$title = $myts->makeTboxData4Show($row['desc_form']);
		$url = $row['url'];
		$help = $row['help'];
		$help = $myts->displayTarea($help);
		$send = $row['send'];
		$msend = $row['msend'];
		$msub = $row['msub'];
		$mip = $row['mip'];
		$mnav = $row['mnav'];
		$cod = $row['cod'];
		if ( $qcm == "" && !empty($id_form) && $p==0) {$block['content'].="<fieldset><legend>XQuiz</legend>";} else if ( $qcm == "1" && !empty($id_form) && $p==0) {$block['content'].="<fieldset><legend>QCM</legend>";}
		$p = 1;
	//  	}
	//}
	$result_form = $xoopsDB->query("SELECT menuid, indent, margintop, marginbottom, itemurl, bold, status FROM ".$xoopsDB->prefix("forms_menu")." WHERE menuid=".$id_form." ORDER BY position");
	
	//attention, changer le dirname suivant en cas de renommage du module
	//warning, change the following dirname if you change the module's name
	$res_mod = $xoopsDB->query("SELECT mid FROM ".$xoopsDB->prefix("modules")." WHERE dirname='xquiz'");
	if ($res_mod) {
		while ($row = $xoopsDB->fetchRow($res_mod))
			$module_id = $row[0];
	}
	
	$perm_name = 'Permission des catégories';
	if (is_object($xoopsUser)) {
		$uid = $xoopsUser->getVar("uid");
	} else {
		$groupuser[0] = 3;
		$uid=XOOPS_GROUP_ANONYMOUS;
	}
	
	$res_gp = $xoopsDB->query("SELECT groupid FROM ".$xoopsDB->prefix("groups_users_link")." WHERE uid= ".$uid);
	if ( $res_gp ) {
	  while ( $row = $xoopsDB->fetchRow($res_gp)) {
		$groupuser[] = $row[0];
	  }
	}
	
	$gperm_handler =& xoops_gethandler('groupperm');
	
	if ($result_form) {
		while ($row =$xoopsDB->fetchRow($result_form)) {
			$menuid = $row[0];
			$indent = $row[1];
			$margintop = $row[2];
			$marginbottom = $row[3];
			$itemurl = $row[4];
			$bold = $row[5];
			$status = $row[6];
		}
	}
	else
	{
		$status = 0;
	}
	
	if ( $status == 1 ) {
		$groupid = array();
	        $res2 = $xoopsDB->query("SELECT gperm_groupid,gperm_itemid FROM ".$xoopsDB->prefix("group_permission")." WHERE gperm_itemid= ".$menuid." AND gperm_modid=".$module_id);
		if ( $res2 ) {
		  while ( $row = $xoopsDB->fetchRow($res2 ) ) {
			$groupid[] = $row[0];
		  }
		}
	
	$block['content'] .="<style type='text/css'>
	
	#dhtmltooltip{
	position: absolute;
	width: 150px;
	border: 2px solid black;
	padding: 2px;
	background-color: lightyellow;
	visibility: hidden;
	z-index: 100;
	/*Remove below line to remove shadow. Below line should always appear last within this CSS*/
	filter: progid:DXImageTransform.Microsoft.Shadow(color=gray,direction=135);
	}
	
	</style>
	";
	
	
	$block['content'] .='<div id="dhtmltooltip"></div>
	
	<script type="text/javascript">
	
	/***********************************************
	* Cool DHTML tooltip script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
	* This notice MUST stay intact for legal use
	* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
	***********************************************/
	
	var offsetxpoint=-60 //Customize x offset of tooltip
	var offsetypoint=20 //Customize y offset of tooltip
	var ie=document.all
	var ns6=document.getElementById && !document.all
	var enabletip=false
	if (ie||ns6)
	var tipobj=document.all? document.all["dhtmltooltip"] : document.getElementById? document.getElementById("dhtmltooltip") : ""
	
	function ietruebody(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
	}
	
	function ddrivetip(thetext, thecolor, thewidth){
	if (ns6||ie){
	if (typeof thewidth!="undefined") tipobj.style.width=thewidth+"px"
	if (typeof thecolor!="undefined" && thecolor!="") tipobj.style.backgroundColor=thecolor
	tipobj.innerHTML=thetext
	enabletip=true
	return false
	}
	}
	
	function positiontip(e){
	if (enabletip){
	var curX=(ns6)?e.pageX : event.x+ietruebody().scrollLeft;
	var curY=(ns6)?e.pageY : event.y+ietruebody().scrollTop;
	//Find out how close the mouse is to the corner of the window
	var rightedge=ie&&!window.opera? ietruebody().clientWidth-event.clientX-offsetxpoint : window.innerWidth-e.clientX-offsetxpoint-20
	var bottomedge=ie&&!window.opera? ietruebody().clientHeight-event.clientY-offsetypoint : window.innerHeight-e.clientY-offsetypoint-20
	
	var leftedge=(offsetxpoint<0)? offsetxpoint*(-1) : -1000
	
	//if the horizontal distance isnt enough to accomodate the width of the context menu
	if (rightedge<tipobj.offsetWidth)
	//move the horizontal position of the menu to the left by its width
	tipobj.style.left=ie? ietruebody().scrollLeft+event.clientX-tipobj.offsetWidth+"px" : window.pageXOffset+e.clientX-tipobj.offsetWidth+"px"
	else if (curX<leftedge)
	tipobj.style.left="5px"
	else
	//position the horizontal position of the menu where the mouse is positioned
	tipobj.style.left=curX+offsetxpoint+"px"
	
	//same concept with the vertical position
	if (bottomedge<tipobj.offsetHeight)
	tipobj.style.top=ie? ietruebody().scrollTop+event.clientY-tipobj.offsetHeight-offsetypoint+"px" : window.pageYOffset+e.clientY-tipobj.offsetHeight-offsetypoint+"px"
	else
	tipobj.style.top=curY+offsetypoint+"px"
	tipobj.style.visibility="visible"
	}
	}
	
	function hideddrivetip(){
	if (ns6||ie){
	enabletip=false
	tipobj.style.visibility="hidden"
	tipobj.style.left="-1000px"
	tipobj.style.backgroundColor=""
	tipobj.style.width=""
	}
	}
	
	document.onmousemove=positiontip
	
	</script>';
	
		$block['content'] .= "<ul>";
	
	    $display = 0;
		$perm_itemid = $menuid; //intval($_GET['category_id']);
	        foreach ($groupid as $gr){
	               	if ( in_array ($gr, $groupuser) && $display != 1) {
				if (!empty($help))
					{
		                		if ($bold == 1)
		                		$block['content'] .= "<table cellspacing='0' border='0'><div style='margin-left: ".$indent."px; margin-right: 0px; margin-top:".$margintop."px; margin-bottom:".$marginbottom."px; '><LI><a style='font-weight: bold' href='$itemurl' alt='' onMouseOver=\"ddrivetip('$help')\"; onMouseOut=\"hideddrivetip()\">".$title."</a></LI></table>";
		                		else
		                		$block['content'] .= "<table cellspacing='0' border='0'><div style='margin-left: ".$indent."px; margin-right: 0px; margin-top:".$margintop."px; margin-bottom:".$marginbottom."px; '><LI><a style='font-weight: normal' href='$itemurl' alt='' onMouseover=\"ddrivetip('$help')\"; onMouseout=\"hideddrivetip()\">".$title."</a></LI></table>";
					}
		         	else {	if ($bold == 1)
		                		$block['content'] .= "<table cellspacing='0' border='0'><div style='margin-left: ".$indent."px; margin-right: 0px; margin-top:".$margintop."px; margin-bottom:".$marginbottom."px; '><LI><a style='font-weight: bold' href='$itemurl'>".$title."</a></LI></table>";
		                		else
		                		$block['content'] .= "<table cellspacing='0' border='0'><div style='margin-left: ".$indent."px; margin-right: 0px; margin-top:".$margintop."px; margin-bottom:".$marginbottom."px; '><LI><a style='font-weight: normal' href='$itemurl'>".$title."</a></LI></table>";
				     }	
		                		$display = 1;
	               	}
	        }
	        $block['content'] .= "</ul>";
	    }
	}
	}
	        $block['content'] .= "</fieldset>";
	        echo $block['content'];
	}
}

?>