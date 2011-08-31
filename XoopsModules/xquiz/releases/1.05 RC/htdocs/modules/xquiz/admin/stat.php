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
require("admin_header.php");

$GLOBALS['myts'] =& MyTextSanitizer::getInstance();

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

$file = "images.txt";
$fp = file($file);
srand((double)microtime()*1000000);

/************* Affichage de tous les enregistrements *************/

$sql= "SELECT id_form,admin,groupe,email,expe,qcm FROM ".$GLOBALS['xoopsDB']->prefix("forms_id")." WHERE id_form=".$id;
$res = $GLOBALS['xoopsDB']->query($sql) or die('Erreur SQL consult.php ligne 90!<br />'.$sql.'<br />'.$GLOBALS['xoopsDB']->error());

$sql2= "SELECT ele_caption, ele_value, ele_type, uid, rep FROM ".$GLOBALS['xoopsDB']->prefix("forms_form")." WHERE id_form=".$id." and ele_type IN ('yn', 'select', 'checkbox', 'radio') ORDER BY ele_id";
$res2 = $GLOBALS['xoopsDB']->query($sql2) or die('Erreur SQL consult.php ligne 93<br />'.$sql2.'<br />'.$GLOBALS['xoopsDB']->error());

if ( $res ) {
  while ( $row = $GLOBALS['xoopsDB']->fetchArray($res)) {
    $id_form = $row['id_form'];
    $admin = $row['admin'];
    $groupe = $row['groupe'];
    $email = $row['email'];
    $expe = $row['expe'];
    $qcm = $row['qcm'];
  }
}
$m=0;
$p=0;
$nb=0;
$reqrep = array();

$requete = array();
$type = array();
if ($res2) {
	while ($row = $GLOBALS['xoopsDB']->fetchArray($res2)) {
			$row['ele_value'] = nl2br ($row['ele_value']);
			$requete[$row['ele_caption']] = $row['ele_value'];
			$type[$row['ele_caption']] = $row['ele_type'];
			$uid = $row['uid'];
			$reqrep[$nb] = nl2br ($row['rep']);
			$nb++;
			$p=1;
	}
}

$nb = 0;
$html= array();
if ($p==0) {
	$html[] = "<div style='color: red; font-weight: bold; text-decoration: blink; font-size: x-large; text-align:center'>"._AM_XQUIZ_NOSTAT."</div>";
} else {
	$sql =  $GLOBALS['xoopsDB']->query("SELECT title FROM " . $GLOBALS['xoopsDB']->prefix("forms_id") . " WHERE id_form= ".$id);
	$desc_form = $GLOBALS['xoopsDB']->fetchRow($sql);
	$desc_form[0] = $GLOBALS['myts']->displayTarea($desc_form[0]);
	$title = "<center><font size=3>"._AM_XQUIZ_FORMU."</font></center>";
	
	$html[] = '<table class="outer" cellspacing="1" width="100%"><th>'._AM_XQUIZ_STATISTICS.$desc_form[0].'</th></table>';
	
	$html[] = '<table class="outer" cellspacing="1" width="100%">';
	
	foreach( $requete as $k => $v ){
	
		foreach ($type as $tk => $t) {
	
			if ($t == 'yn' && $tk == $k){
				if ($qcm == '1') {
					$sql2 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_value = '".$reqrep[$nb]."' and ele_type='yn' and ele_caption='".$k."' and id_form=".$id);
					$qno = $GLOBALS['xoopsDB']->fetchRow($sql2);
				} else {
					$sql1 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_value = '1' and ele_type='yn' and ele_caption='".$k."' and id_form=".$id);
					$qyes = $GLOBALS['xoopsDB']->fetchRow($sql1);
					
					$sql2 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_value = '2' and ele_type='yn' and ele_caption='".$k."' and id_form=".$id);
					$qno = $GLOBALS['xoopsDB']->fetchRow($sql2);
				}
			
				$sql3 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='yn' and id_form=".$id." and ele_caption='".$k."'");
				$qtot = $GLOBALS['xoopsDB']->fetchRow($sql3);
	
	
			$html[] = "<table width='100%' border='0' cellpadding='4' cellspacing='0'>";
	
			if ($qcm == '1') {
					$random_image = $fp[array_rand($fp)];
					if ( $qtot[0] > 0 ) {
						$percentn = 100 * $qno[0]/ $qtot[0];
					} else {
						$percentn = 0;
					}
					if ($reqrep[$nb] == '1') {
						$html[] = "<tr><td width='30%' align='left'>"._YES."</td><td width='30%' align='left'>";
					}
					else if ($reqrep[$nb] == '2') {
						$html[] = "<tr><td width='30%' align='left'>"._NO."</td><td width='30%' align='left'>";
					}
					if ( $percentn > 0 ) {
						$width = intval($percentn)*1;
						$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percentn)." %' />&nbsp;";
					}
					$html[] =  "</td><td align='left' width='15%'>".round($percentn,1)." % (".$qno[0].")";
					$html[] =  "</td>";
			} else {
				$random_image = $fp[array_rand($fp)];
				if ( $qtot[0] > 0 ) {
					$percenty = 100 * $qyes[0]/ $qtot[0];
				} else {
					$percenty = 0;
				}
				$html[] = "<tr><td width='30%' align='left'>"._YES."</td><td width='30%' align='left'>";
				if ( $percenty > 0 ) {
					$width = intval($percenty)*1;
					$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percenty)." %' />&nbsp;";
				}
				$html[] =  "</td><td align='left' width='15%'>".round($percenty,1)." % (".$qyes[0].")";
				$html[] =  "</td>";
				
				$random_image = $fp[array_rand($fp)];
				if ( $qtot[0] > 0 ) {
					$percentn = 100 * $qno[0]/ $qtot[0];
				} else {
					$percentn = 0;
				}
				$html[] = "<tr><td width='30%' align='left'>"._NO."</td><td width='30%' align='left'>";
				if ( $percentn > 0 ) {
					$width = intval($percentn)*1;
					$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percentn)." %' />&nbsp;";
				}
				$html[] =  "</td><td align='left' width='15%'>".round($percentn,1)." % (".$qno[0].")";
				$html[] =  "</td>";
			}	
			$html[] = "<td align='right' width='15%'>Total : ".$qtot[0]."</td></tr></table>";
			$nb++;
		}
	
	
		if ($t == 'checkbox' && $tk == $k){
	
			$html = array();		
			$v = '';
			$i = 0;
			$j = 0;
			$m = 0;
			$n = 0;
			if ($qcm == '1') {
				$sql222 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_value = '".$reqrep[$nb]."' and ele_type='checkbox' and ele_caption='".$k."' and id_form=".$id);
				$qcbox = $GLOBALS['xoopsDB']->fetchRow($sql222);
		
				$sql5 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='checkbox' and id_form=".$id." and ele_caption='".$k."'");
				$qtot1 = $GLOBALS['xoopsDB']->fetchRow($sql5);
		
				if (substr ($reqrep[$nb], 0, 1) == ':') {
					$selected = array();
					$reqrep[$nb] = substr ($reqrep[$nb], 1);
					$selected = split (':', $reqrep[$nb]);
					$reqrep[$nb] = implode (',', $selected);
				}
		
				$html[] = "<table width='100%' border='0' cellpadding='4' cellspacing='0'>";
	
				$random_image = $fp[array_rand($fp)];
		        if ( $qtot1[0] > 0 ) {
					$percent = 100 * $qcbox[0]/ $qtot1[0];
				} else {
					$percent = 0;
				}
				$html[] = "<tr><td width='30%' align='left'>".$reqrep[$nb]."</td><td width='30%' align='left'>";
				if ( $percent > 0 ) {
					$width = intval($percent)*1;
					$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percent)." %' />&nbsp;";
				}
				$html[] =  "</td><td align='left' width='15%'>".round($percent,1)." % (".$qcbox[0].")";
				$html[] =  "</td>";
			} else {
				$sql="SELECT ele_value FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='checkbox' and ele_caption='".$k."' and id_form=".$id;
				$res = $GLOBALS['xoopsDB']->query($sql);
		
				$html[] = "<table width='100%' border='0' cellpadding='4' cellspacing='0'>";
				$ele[$i] = array();
		
				if ( $res ) {
		  		   while ( $row = $GLOBALS['xoopsDB']->fetchRow( $res ) ) {
		    		   	$html[$row[0]] = $row[0];
						$ele[$i] = split(':',$html[$row[0]]);
						$i++;
					}
				}
		
				$cbox[$n] = array();
		
				foreach ($ele as $dk => $d){
					foreach ($d as $ck => $c) {
						$g = 0;
		
						for($j=0;$j<=$n;$j++)
						{
							if (empty($cbox[$j][1])) 
							{					
								$cbox[$j][1]='';
								$cbox[$j][2]='';
							}
							if ($c == $cbox[$j][1])
							{
								$cbox[$j][2]++;
								$g=1;
							}
						}
						if ($g == 0) 
						{ 
							$cbox[$n][1] = $c;
							$cbox[$n][2]=1;
							$n++;
						}
					}
				}
				for($y=0;$y<=($n-1);$y++){
		
					$e = $cbox[$y][1];
				
					$sql5 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='checkbox' and id_form=".$id." and ele_caption='".$k."'");
					$qtot1 = $GLOBALS['xoopsDB']->fetchRow($sql5);
		
					$random_image = $fp[array_rand($fp)];
			        if ( $qtot1[0] > 0 ) {
						$percent = 100 * $cbox[$y][2]/ $qtot1[0];
					} else {
						$percent = 0;
					}
					$html[] = "<tr><td width='30%' align='left'>".$e."</td><td width='30%' align='left'>";
					if ( $percent > 0 ) {
						$width = intval($percent)*1;
						$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percent)." %' />&nbsp;";
					}
					$html[] = "</td><td align='left' width='15%'>".round($percent,1)." % (".$cbox[$y][2].")";
					$html[] = "</td>";
					}
				}
				$html[] = "<td align='right' width='15%'>Total : ".$qtot1[0]."</td></tr></table>";
				$nb++;
			}
	
			if ($t == 'radio' && $tk == $k){
	
				$html1 = array();		
				$v = '';
		
			if ($qcm != '1') {
				$sql11="SELECT DISTINCT ele_value FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='radio' and ele_caption='".$k."' and id_form=".$id;
				$res11 = $GLOBALS['xoopsDB']->query($sql11);
		
				if ( $res11 ) {
		  		   while ( $row = $GLOBALS['xoopsDB']->fetchRow( $res11 ) ) {
		    		   $html1[$row[0]] = $row[0];
					}	
				}
		
				$html[] = "<table width='100%' border='0' cellpadding='4' cellspacing='0'>";
				foreach($html1 as $rk => $r) {
		
				$sql6 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_value = '".$r."' and ele_type='radio' and ele_caption='".$k."' and id_form=".$id);
				$qradio = $GLOBALS['xoopsDB']->fetchRow($sql6);
		
				$sql7 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='radio' and id_form=".$id." and ele_caption='".$k."'");
				$qtot2 = $GLOBALS['xoopsDB']->fetchRow($sql7);
		
				$random_image = $fp[array_rand($fp)];
			    if ( $qtot2[0] > 0 ) {
					$percent = 100 * $qradio[0]/ $qtot2[0];
				} else {
					$percent = 0;
				}
				$html[] = "<tr><td width='30%' align='left'>".$r."</td><td width='30%' align='left'>";
				if ( $percent > 0 ) {
					$width = intval($percent)*1;
					$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percent)." %' />&nbsp;";
				}
				$html[] = "</td><td align='left' width='15%'>".round($percent,1)." % (".$qradio[0].")";
				$html[] = "</td>";
				}
			} else if ($qcm == '1') {
				$html[] =  "<table width='100%' border='0' cellpadding='4' cellspacing='0'>";
		
				$sql6 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_value = '".$reqrep[$nb]."' and ele_type='radio' and ele_caption='".$k."' and id_form=".$id);
				$qradio = $GLOBALS['xoopsDB']->fetchRow($sql6);
				
				$sql7 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='radio' and id_form=".$id." and ele_caption='".$k."'");
				$qtot2 = $GLOBALS['xoopsDB']->fetchRow($sql7);
		
				$random_image = $fp[array_rand($fp)];
			    if ( $qtot2[0] > 0 ) {
					$percent = 100 * $qradio[0]/ $qtot2[0];
				} else {
					$percent = 0;
				}
				$html[] = "<tr><td width='30%' align='left'>".$reqrep[$nb]."</td><td width='30%' align='left'>";
				if ( $percent > 0 ) {
					$width = intval($percent)*1;
					$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percent)." %' />&nbsp;";
				}
				$html[] = "</td><td align='left' width='15%'>".round($percent,1)." % (".$qradio[0].")";
				$html[] = "</td>";
			}
		
			$html[] = "<td align='right' width='15%'>Total : ".$qtot2[0]."</td></tr></table>";
			$nb++;
		}
	
	
		if ($t == 'select' && $tk == $k){
	
			$html2 = array();		
			$v = '';
			$i = 0;
			$j = 0;
			$m = 0;
			$n = 0;
			$x = 0;
			if ($qcm == '1') {
				$sql333 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_value = '".$reqrep[$nb]."' and ele_type='select' and ele_caption='".$k."' and id_form=".$id);
				$qselect = $GLOBALS['xoopsDB']->fetchRow($sql333);
		
				$sql334 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='select' and id_form=".$id." and ele_caption='".$k."'");
				$qtot3 = $GLOBALS['xoopsDB']->fetchRow($sql334);
		
				$html[] = "<table width='100%' border='0' cellpadding='4' cellspacing='0'>";
		
				if (substr ($reqrep[$nb], 0, 1) == ':') {
					$selected = array();
					$reqrep[$nb] = substr ($reqrep[$nb], 1);
					$selected = split (':', $reqrep[$nb]);
					$reqrep[$nb] = implode (',', $selected);
				}
		
				$random_image = $fp[array_rand($fp)];
		        if ( $qtot3[0] > 0 ) {
					$percent = 100 * $qselect[0]/ $qtot3[0];
				} else {
					$percent = 0;
				}
				$html[] = "<tr><td width='30%' align='left'>".$reqrep[$nb]."</td><td width='30%' align='left'>";
				if ( $percent > 0 ) {
					$width = intval($percent)*1;
					$html[] = "<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percent)." %' />&nbsp;";
				}
				$html[] = "</td><td align='left' width='15%'>".round($percent,1)." % (".$qselect[0].")";
				$html[] = "</td>";
			} else {
				$sql12="SELECT ele_value FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='select' and ele_caption='".$k."' and id_form=".$id;
				$res12 = $GLOBALS['xoopsDB']->query($sql12);
		
				$html[] = "<table width='100%' border='0' cellpadding='4' cellspacing='0'>";
				$ele2[$i] = array();
		
				if ( $res12 ) {
		  		   while ( $row = $GLOBALS['xoopsDB']->fetchRow( $res12 ) ) {
		    		   $html2[$row[0]] = $row[0];
						$ele2[$i] = split(':',$html2[$row[0]]);
						$i++;
					}
				}
				$csel[$n] = array();
		
				foreach ($ele2 as $tk => $t){
					foreach ($t as $uk => $u) {
						$g = 0;
						for($j=0;$j<=$n;$j++)
						{
							if (empty($csel[$j][1])) 
							{					
								$csel[$j][1]='';
								$csel[$j][2]='';
							}
							if ($u == $csel[$j][1])
							{
								$csel[$j][2]++;
								$g=1;
							}
								
						}
						if ($g == 0) 
						{ 
							$csel[$n][1] = $u;
							$csel[$n][2]=1;
							$n++;
							$csel[$n+1][1]='';
							$csel[$n+1][2]='';
						}
					}
				}
			
				for($y=0;$y<=($n-1);$y++){
		
					$s = $csel[$y][1];
					$sql9 =  $GLOBALS['xoopsDB']->query("SELECT count(ele_value) FROM " . $GLOBALS['xoopsDB']->prefix("forms_form") . " WHERE ele_type='select' and id_form=".$id." and ele_caption='".$k."'");
					$qtot3 = $GLOBALS['xoopsDB']->fetchRow($sql9);
			
					$random_image = $fp[array_rand($fp)];
			        if ( $qtot3[0] > 0 ) {
						$percent = 100 * $csel[$y][2]/ $qtot3[0];
					} else {
						$percent = 0;
					}
					$html[] = "<tr><td width='30%' align='left'>".$s."</td><td width='30%' align='left'>";
					if ( $percent > 0 ) {
						$width = intval($percent)*1;
						$v .="<img src='$random_image' height='14' width='".$width."' align='middle' title='".intval($percent)." %' />&nbsp;";
					}
					$html[] = "</td><td align='left' width='15%'>".round($percent,1)." % (".$csel[$y][2].")";
					$html[] = "</td>";
					}
				}
				$html[] = "<td align='right' width='15%'>Total : ".$qtot3[0]."</td></tr></table>";
				$nb++;
				}
		     }
			$html[] = '<tr><td class="even" width="25%"><li>'.$k.'</td><td class="even">'.$v.'</td></tr>';
		
		}
		
		$html[] = '</table>';
	
		if ($qcm == '1') {
			$nbe = 0;
			$maxrep = array();
			$ij = 0;
			$somme = 0;
		
			$sql512= "SELECT MAX(nbrep), MAX(nbtot) FROM ".$GLOBALS['xoopsDB']->prefix("forms_form")." WHERE id_form=".$id." GROUP BY id_req";
			$res512 = $GLOBALS['xoopsDB']->query($sql512) or die('Erreur SQL consult.php ligne 93<br />'.$sql2.'<br />'.$GLOBALS['xoopsDB']->error());
		
			if ( $res512 ) {
		  		while ( $row = $GLOBALS['xoopsDB']->fetchArray($res512)) {
					$nbe++;
					$maxrep[$nbe] = $row['MAX(nbrep)'];
					$nbtot = $row['MAX(nbtot)'];
		  		}
			}
		
			for ($ij=1;$ij<=$nbe;$ij++){
				$somme = $somme + $maxrep[$ij];
			}
			
			$moyenne = $somme / $nbe;
			$perc = ($moyenne / $nbtot)*100;
		
			$html[] = '<br /><table class="outer" width="100%"><tr><td class="even"><center><b>'._AM_XQUIZ_PERCR.$perc.' %</b></center></td></tr></table>';
		}
		$html[] = '<br /><table class="outer" width="100%"><tr><th><center>'._AM_XQUIZ_PRINT.'</center></th></tr><tr><td class="even"><center><a href="stati.php?id='.$id.'" target="_blank"><img src="../images/print.gif"></a></center></td></tr></table>';
}

$GLOBALS['xquizTpl'] = new XoopsTpl();
$GLOBALS['xquizTpl']->assign('php_self', $_SERVER['PHP_SELF']);
$GLOBALS['xquizTpl']->assign('html', $html);
$GLOBALS['xquizTpl']->assign('title', $title);
$GLOBALS['xquizTpl']->display('db:xquiz_cpanel_default_statistics.html');

include 'footer.php';
xoops_cp_footer();
	
?>