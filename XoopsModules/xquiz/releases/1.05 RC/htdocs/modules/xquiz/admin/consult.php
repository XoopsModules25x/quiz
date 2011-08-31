<?php
include("admin_header.php");

xoops_loadLanguage('modinfo', 'xquiz');
xoops_loadLanguage('main', 'xquiz');
xoops_loadLanguage('admin', 'xquiz');

xoops_cp_header();
forms_adminMenu(4, _AM_XQUIZ_FORMS);

if(!isset($_POST['form'])){
	$id = isset ($_GET['id']) ? $_GET['id'] : '0';
}else {
	$id = $_POST['id'];
}
if(!isset($_POST['req'])){
	$req = isset ($_GET['req']) ? $_GET['req'] : '';
}else {
	$req = $_POST['req'];
}
if(!isset($_POST['op'])){
	$op = isset ($_GET['op']) ? $_GET['op'] : '';
}else {
	$op = $_POST['op'];
}

if(!isset($_POST['ordre'])){
	$ordre = isset ($_GET['ordre']) ? $_GET['ordre'] : '';
}else {
	$ordre = $_POST['ordre'];
}


$GLOBALS['xquizTpl'] = new XoopsTpl();
$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);

$script_a = '<SCRIPT language="JavaScript1.2"  type="text/javascript">
Text[1]=["'._AM_XQUIZ_SUP.'","'._AM_XQUIZ_SUP_ONE.'"]
Text[2]=["'._AM_XQUIZ_SUP.'","'._AM_XQUIZ_SUP_ALL.'"]
Text[3]=["'._AM_XQUIZ_STATIS.'","'._AM_XQUIZ_STAT_TEXT.'"]

Style[1]=["white","#F6B542","","","",,"black","#FFFFFF","","","",,,,2,"#F6C063",2,,,,,"",1,,,]

var TipId="help"
var FiltersEnabled = 0 // [for IE5.5+] if your not going to use transitions or filters in any of the tips set this to zero.
mig_clay()

</SCRIPT>';
$GLOBALS['xquizTpl']->assign('script_a', $script_a);

/************* Affichage de tous les enregistrements *************/

if ($id == '0' && $req == null && $op == null)
{
	$forms_ids = $forms_id_handler->getObjects(NULL, true);
	foreach($forms_ids as $key => $forms_id) {
    	$data[$key] = $forms_id->getVar('title');
    	$qcm[$nbq] = $forms_id->getVar('qcm');
    	$nbq++;
	}
	
	
	$nbe = 0;
	$maxrep = array();
	$ij = 0;
	$somme = 0;
	$nbq=0;
	
	foreach($data as $id => $titre) {
		
		$compte=$xoopsDB->query("SELECT COUNT(DISTINCT id_req) FROM ".$xoopsDB->prefix("forms_form")." WHERE id_form=".$id);
		list($compte_form) = $xoopsDB->fetchRow($compte);
	
		if ($qcm[$nbq] == '1') {
			$sql3="SELECT MAX(nbrep), MAX(nbtot) FROM ".$xoopsDB->prefix("forms_form")." WHERE id_form=".$id." GROUP BY id_req";
			$res3 = $xoopsDB->query($sql3) or die('Erreur SQL consult.php ligne 93<br />'.$sql3.'<br />'.$xoopsDB->error());
	
			if ( $res3 ) {
		  		while ( $row = $xoopsDB->fetchArray($res3)) {
					$nbe++;
					$maxrep[$nbe] = $row['MAX(nbrep)'];
					$nbtot = $row['MAX(nbtot)'];
		  		}
			}
	
			for ($ij=1;$ij<=$nbe;$ij++){
				$somme = $somme + $maxrep[$ij];
			}
	
	        $titre = $myts->displayTarea($titre);
	
			if ($nbe > 0) {
				$moyenne = $somme / $nbe;
				   $GLOBALS['xquizTpl']->append('tablea', '<tr><td class="head"><a href="modform.php?id='.$id.'&op=showform">'.$titre.'&nbsp;&nbsp;('.$compte_form.')</td><td class="head" width="15%">&nbsp;&nbsp;('._AM_XQUIZ_AVG.$moyenne.' / '.$nbtot.')</a></td><td class="head" align="center" width="15%"><a href="stat.php?id='.$id.'"><img src="../images/stats.gif" alt="" onMouseOver="stm(Text[3],Style[1])" onMouseOut="htm()" width="30"></a></td><td class="head" align="center" width="15%"><a href="consult.php?id='.$id.'&op=supall"><img src="../images/poubelle.gif" alt="" onMouseOver="stm(Text[2],Style[1])" onMouseOut="htm()"></a></td></tr>');
			} else {
				   $GLOBALS['xquizTpl']->append('tablea', '<tr><td class="head"><a href="modform.php?id='.$id.'&op=showform">'.$titre.'&nbsp;&nbsp;('.$compte_form.')</td><td class="head" width="15%">&nbsp;&nbsp;('._AM_XQUIZ_AVG.' - )</a></td><td class="head" align="center" width="15%"><a href="stat.php?id='.$id.'"><img src="../images/stats.gif" alt="" onMouseOver="stm(Text[3],Style[1])" onMouseOut="htm()" width="30"></a></td><td class="head" align="center" width="15%"><a href="consult.php?id='.$id.'&op=supall"><img src="../images/poubelle.gif" alt="" onMouseOver="stm(Text[2],Style[1])" onMouseOut="htm()"></a></td></tr>');
			}
		} else {
			$GLOBALS['xquizTpl']->append('tablea', '<tr><td class="head" colspan="2"><a href="modform.php?id='.$id.'&op=showform">'.$titre.'&nbsp;&nbsp;('.$compte_form.')</a></td><td class="head" align="center" width="15%"><a href="stat.php?id='.$id.'"><img src="../images/stats.gif" alt="" onMouseOver="stm(Text[3],Style[1])" onMouseOut="htm()" width="30"></a></td><td class="head" align="center" width="15%"><a href="consult.php?id='.$id.'&op=supall"><img src="../images/poubelle.gif" alt="" onMouseOver="stm(Text[2],Style[1])" onMouseOut="htm()"></a></td></tr>');
		}
		$nbq++;
	}
	
	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_default_consult.html');
	
} else if ($req == null && $op== null) {
	$req = array();
	$date = array();
	$desc_form = array();

	if (empty($ordre)){
		$sql = "SELECT id_req, uid, date FROM " . $xoopsDB->prefix("forms_form") . " WHERE id_form= ".$id." GROUP BY id_req" ;
	} else if ($ordre == 'dat'){
		$sql = "SELECT id_req, uid, date FROM " . $xoopsDB->prefix("forms_form") . " WHERE id_form= ".$id." ORDER BY date" ;
	} elseif ($ordre == 'use'){
		$sql = "SELECT id_req, uid, date FROM " . $xoopsDB->prefix("forms_form") . " WHERE id_form= ".$id." ORDER BY uid" ;
	}

	$result = $xoopsDB->query($sql) or die("Requete SQL ligne 52");
	if ($result) {
		while ($row = $xoopsDB->fetchArray($result)) {
	       		$req[$row["id_req"]] = $row["uid"];
          		$date[$row["id_req"]] = $row["date"];
          	}
	}

	//Selection du nom du xquiz
	$sql = "SELECT title, qcm FROM " . $xoopsDB->prefix("forms_id") . " WHERE id_form=".$id;
	$result = $xoopsDB->query($sql) or die("Requete SQL ligne 59");
	if ($result) {
		while ($row = $xoopsDB->fetchArray($result)){
			$title = $row['title'];
		    $title = $myts->displayTarea($desc_form);
			$qcm = $row['qcm'];
		}
	}
	//$desc_form = $desc_form[0];

	foreach ($date as $idd => $d) {
		$a = substr ($d, 0, 4);
		$m = substr ($d, 5, 2);
		$j = substr ($d, 8, 2);
		$date[$idd] = $j.'/'.$m.'/'.$a;
	}


	$GLOBALS['xquizTpl']->assign('id', $id);
	$GLOBALS['xquizTpl']->assign('title', $title);
	$GLOBALS['xquizTpl']->assign('qcm', $qcm);

	foreach ($req as $id_req => $uid) {
		$sql3= "SELECT MAX(nbrep), MAX(nbtot) FROM ".$xoopsDB->prefix("forms_form")." WHERE id_form=".$id." and id_req=".$id_req." GROUP BY id_req";
		$res3 = $xoopsDB->query($sql3) or die('Erreur SQL consult.php ligne 93<br />'.$sql3.'<br />'.$xoopsDB->error());

		if ( $res3 ) {
	  		while ( $row = $xoopsDB->fetchArray($res3)) {
				$nbrep = $row['MAX(nbrep)'];
				$nbtot = $row['MAX(nbtot)'];
	  		}
		}
		if ($qcm == '1') {
			$GLOBALS['xquizTpl']->append('tablea', '<tr><td class="even"><li><a href="consult.php?id='.$id.'&req='.$id_req.'">'._AM_XQUIZ_FORM_REQ.XoopsUser::getUnameFromId($uid)." le ".$date[$id_req].'</a></td><td class="even" align="center"><b>'.$nbrep.' / '.$nbtot.'</b><td class="even" align="center"><a href="consult.php?id='.$id.'&req='.$id_req.'&op=sup"><img src="../images/delete.gif" alt="" onMouseOver="stm(Text[1],Style[1])" onMouseOut="htm()"></a></td></tr>');
		} else {
			$GLOBALS['xquizTpl']->append('tablea', '<tr><td class="even"><li><a href="consult.php?id='.$id.'&req='.$id_req.'">'._AM_XQUIZ_FORM_REQ.XoopsUser::getUnameFromId($uid)." le ".$date[$id_req].'</a></td><td class="even" align="center"><a href="consult.php?id='.$id.'&req='.$id_req.'&op=sup"><img src="../images/delete.gif" alt="" onMouseOver="stm(Text[1],Style[1])" onMouseOut="htm()"></a></td></tr>');
		}
	}
	
	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_item_consult.html');
	
} else if ($op == null){

	$m=0;

	$sql= "SELECT id_form,admin,groupe,email,expe,qcm FROM ".$xoopsDB->prefix("forms_id")." WHERE id_form=".$id;
	$res = $xoopsDB->query($sql) or die('Erreur SQL consult.php ligne 90!<br />'.$sql.'<br />'.$xoopsDB->error());

	$sql2= "SELECT ele_caption, ele_value, ele_type, uid, rep FROM ".$xoopsDB->prefix("forms_form")." WHERE id_form=".$id." AND id_req= ".$req." ORDER BY pos";
	$res2 = $xoopsDB->query($sql2) or die('Erreur SQL consult.php ligne 93<br />'.$sql2.'<br />'.$xoopsDB->error());

	$sql3= "SELECT MAX(nbrep), MAX(nbtot) FROM ".$xoopsDB->prefix("forms_form")." WHERE id_form=".$id." AND id_req= ".$req." GROUP BY id_req";
	$res3 = $xoopsDB->query($sql3) or die('Erreur SQL consult.php ligne 93<br />'.$sql3.'<br />'.$xoopsDB->error());

	if ( $res ) {
	  while ( $row = $xoopsDB->fetchArray($res)) {
	    $id_form = $row['id_form'];
	    $admin = $row['admin'];
	    $groupe = $row['groupe'];
	    $email = $row['email'];
	    $expe = $row['expe'];
	    $qcm = $row['qcm'];
	  }
	}
	$requete = array();
	$type = array();
	$reqrep = array();
	$nb=0;
	
	if ($res2) {
		while ($row = $xoopsDB->fetchArray($res2)) {
			$row['ele_value'] = nl2br ($row['ele_value']);
			$requete[$row['ele_caption']] = $row['ele_value'];
			$type[$row['ele_caption']] = $row['ele_type'];
			$uid = $row['uid'];
			$reqrep[$nb] = nl2br ($row['rep']);
			$nb++;
		}
	}
	
	if ( $res3 ) {
		while ( $row = $xoopsDB->fetchArray($res3)) {
			$nbrep = $row['MAX(nbrep)'];
			$nbtot = $row['MAX(nbtot)'];
		}
	}
	
	$uname_submitter = XoopsUser::getUnameFromId($uid);
	$nb = 0;
	
	$sql =  $xoopsDB->query("SELECT desc_form FROM " . $xoopsDB->prefix("forms_id") . " WHERE id_form= ".$id);
	$desc_form = $xoopsDB->fetchRow($sql);
	$desc_form[0] = $myts->displayTarea($desc_form[0]);
	if ($uid != 0){
		$sub = _AM_XQUIZ_SUBMITBY.$uname_submitter." <a href=".XOOPS_URL."/userinfo.php?uid=".$uid."><img src='../images/profil.gif' width='3%'></a>";
	} else {
		$sub = "";
	}
		
	$GLOBALS['xquizTpl']->assign('sub', $sub);
	$GLOBALS['xquizTpl']->assign('desc_form', $desc_form);
	
	foreach( $requete as $k => $v ){
		if (substr ($v, 0, 1) == ':') {
			$selected = array();
			$v = substr ($v, 1);
			$selected = split (':', $v);
			$v = implode (',', $selected);
		}
		foreach ($type as $tk => $t) {
			if ($t == 'yn' && $tk == $k){
				if ($v == '1') $v = _YES;
				if ($v == '2') $v = _NO;
				if ($qcm == '1') {
					if ($reqrep[$nb] == '1') $reqrep[$nb] = _YES;
					if ($reqrep[$nb] == '2') $reqrep[$nb] = _NO;
				}
			}
		}
	
		if ($qcm == '1') {
			if (substr ($reqrep[$nb], 0, 1) == ':') {
				$selected = array();
				$reqrep[$nb] = substr ($reqrep[$nb], 1);
				$selected = split (':', $reqrep[$nb]);
				$reqrep[$nb] = implode (',', $selected);
			}
		
			if (!empty ($reqrep[$nb])) {
				if ($v == $reqrep[$nb]) {
					$v = '<font color="green">'.$v.'</font>';
				} else {
					$v = '<font color="red">'.$v.'</font>';
				}
			}
		}
	
		if ($qcm == '1') {
			$GLOBALS['xquizTpl']->append('tablea', '<tr><td class="even"><li>'.$k.'</td><td class="even">'.$v.'</td><td class="even"><font color="blue">'.$reqrep[$nb].'</font></td></tr>');
			$nb++;
		} else {
			$GLOBALS['xquizTpl']->append('tablea', '<tr><td class="even"><li>'.$k.'</td><td class="even">'.$v.'</td></tr>');
		}
	}
	$GLOBALS['xquizTpl']->assign('qcm', $qcm);
	$GLOBALS['xquizTpl']->assign('id', $id);
	$GLOBALS['xquizTpl']->assign('req', $req);
	$GLOBALS['xquizTpl']->assign('nbreq', $nbreq);
	$GLOBALS['xquizTpl']->assign('nbtot', $nbtot);
	
	$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_forms_consult.html');
	
} elseif ($op == 'sup') {

	$sql123=sprintf("DELETE FROM %s WHERE id_form = %s AND id_req = %s", $xoopsDB->prefix("forms_form"), $id, $req);
	$xoopsDB->queryF($sql123) or die('Erreur SQL consult.php delete!');

	$url = "consult.php?id=$id";
    Header("Location: $url");
} elseif ($op == 'supall') {
	$sql456=sprintf("DELETE FROM %s WHERE id_form = %s", $xoopsDB->prefix("forms_form"), $id);
	$xoopsDB->queryF($sql456) or die('Erreur SQL consult.php delete!');
	$url = "consult.php";
	Header("Location: $url");
}

include 'footer.php';
xoops_cp_footer();

?>