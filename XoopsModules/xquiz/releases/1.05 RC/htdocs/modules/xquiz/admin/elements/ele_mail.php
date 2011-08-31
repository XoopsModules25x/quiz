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

$options = array();
$opt_count = 0;

if( empty($addopt) && !empty($ele_id) ){
	$keys = array_keys($value);
	for( $i=0; $i<count($keys); $i++ ){
		$v = $myts->makeTboxData4PreviewInForm($keys[$i]);
		$options[] = addOption('ele_value['.$opt_count.']', 'checked['.$opt_count.']', $v, 'check', $value[$keys[$i]]);
		$opt_count++;
	}
}else{
	while( $v = each($ele_value) ){
		$v['value'] = $myts->makeTboxData4PreviewInForm($v['value']);
		if( !empty($v['value']) ){
			if(!isset($checked[$opt_count])){ $checked[$opt_count]="";}
			$options[] = addOption('ele_value['.$opt_count.']', 'checked['.$opt_count.']', $v['value'], 'check', $checked[$v['key']]);
			$opt_count++;
		}
	}
	$addopt = empty($addopt) ? 2 : $addopt;
	for( $i=0; $i<$addopt; $i++ ){
		$options[] = addOption('ele_value['.$opt_count.']', 'checked['.$opt_count.']', '', 'check', '');
		$opt_count++;
	}
}
$add_opt = addOptionsTray();
$options[] = $add_opt;
$opt_tray = new XoopsFormElementTray(_AM_XQUIZ_ELE_OPT, '<br />');
$opt_tray->setDescription(_AM_XQUIZ_ELE_OPT_DESC);
for( $i=0; $i<count($options); $i++ ){
	$opt_tray->addElement($options[$i]);
}
$form->insertBreak('<center><font color="red">'._AM_XQUIZ_WARNMAIL.'</font></center>', "head");
$form->addElement($opt_tray);
?>