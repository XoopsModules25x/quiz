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
$scores = array();
$opt_count = 0;
if( empty($addopt) && !empty($ele_id) ){
	$keys = array_keys($value);
	for( $i=0; $i<count($keys); $i++ ){
		$r = $value[$keys[$i]] ? $opt_count : null;
		$v = $myts->makeTboxData4PreviewInForm($keys[$i]);
		$options[] = addOption('ele_value['.$opt_count.']', $opt_count, $v, 'radio', $r);
		$scores[] = addOption('ele_scores['.$opt_count.']', '', $scores[$v], 'score', '');
		$opt_count++;
	}
}else{
	while( $v = each($ele_value) ){
		$v['value'] = $myts->makeTboxData4PreviewInForm($v['value']);
		if( !empty($v['value']) ){
			$r = ($checked == $opt_count) ? $opt_count : null;
			$options[] = addOption('ele_value['.$opt_count.']', $opt_count, $v['value'], 'radio', $r);
			$scores[] = addOption('ele_scores['.$opt_count.']', '', $ele_scores[$v['value']], 'score', '');
			$opt_count++;
		}
	}
	$addopt = empty($addopt) ? 2 : $addopt;
	for( $i=0; $i<$addopt; $i++ ){
		$options[] = addOption('ele_value['.$opt_count.']', $opt_count, '', 'radio');
		$scores[] = addOption('ele_scores['.$opt_count.']', $opt_count, '', 'score');
		$opt_count++;
	}
}
$options[] = addOptionsTray();
$opt_tray = new XoopsFormElementTray(_AM_XQUIZ_ELE_OPT, '<br />');
$opt_tray->setDescription(_AM_XQUIZ_ELE_OPT_DESC2);
for( $i=0; $i<count($options); $i++ ){
	$opt_tray->addElement($options[$i]);
}
$form->addElement($opt_tray);
$opt_score_tray = new XoopsFormElementTray(_AM_XQUIZ_ELE_SCORE_OPT, '<br />');
$opt_score_tray->setDescription(_AM_XQUIZ_ELE_OPT_SCORE_DESC2);
for( $i=0; $i<count($scores); $i++ ){
	$opt_score_tray->addElement($scores[$i]);
}
$form->addElement($opt_score_tray);
?>