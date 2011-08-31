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


if( !preg_match("/elements.php/", $_SERVER['PHP_SELF']) ){
	exit("Access Denied");
}
include_once XOOPS_ROOT_PATH.'/class/xoopsformloader.php';

if(!isset($ele_value[0])){ $ele_value[0]="";}
if(!isset($ele_value[1])){ $ele_value[1]="";}
if(!isset($xoopsModuleConfig['weight'])){ $xoopsModuleConfig['weight']="";}

$value[1] = $value[1] /1024;

$p = !empty($value[1]) ? $value[1] : $xoopsModuleConfig['file_weight'];

$pds = new XoopsFormElementTray (_AM_XQUIZ_ELE_TAILLEFICH, '');
$pds->addElement (new XoopsFormText ('', 'ele_value[1]', 15, 15, $p));
$pds->addElement (new XoopsFormLabel ('', ' Ko'));
$form->addElement ($pds);

$tab = array();
//$value[2] = array();

foreach ($value[2] as $t => $k) {
	foreach ($k as $c => $f){
		$tab[] = $value[2][$t]['value'];
	}
}
// here we can add more mime type.
$mime = new XoopsFormCheckBox (_AM_XQUIZ_ELE_TYPEMIME, 'ele_value[2]', $tab);
$mime->addOption('pdf',' pdf ');
$mime->addOption('doc',' doc ');
$mime->addOption('txt',' txt ');
$mime->addOption('gif',' gif ');
$mime->addOption('mpeg',' mpeg ');
$mime->addOption('jpg',' jpg ');
$mime->addOption('zip',' zip ');
$mime->addOption('rar',' rar ');
$form->addElement($mime);

$fichier = new XoopsFormFile (_AM_XQUIZ_ELE_FICH, $ele_value[0], $ele_value[1]);	
$form->addElement ($fichier);
?>