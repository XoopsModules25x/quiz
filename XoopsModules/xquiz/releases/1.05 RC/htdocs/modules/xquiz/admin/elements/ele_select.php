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
if( empty($addopt) && !empty($ele_id) ){
	$ele_value = $element->getVar('ele_value');
}
$ele_size = !empty($ele_value[0]) ? $ele_value[0] : 1;
$size = new XoopsFormText(_AM_XQUIZ_ELE_SIZE, 'ele_value[0]', 3, 2, $ele_size);
$allow_multi = empty($ele_value[1]) ? 0 : 1;
$multiple = new XoopsFormRadioYN(_AM_XQUIZ_ELE_MULTIPLE, 'ele_value[1]', $allow_multi);

$options = array();
$scores = array();
$opt_count = 0;
if( empty($addopt) && !empty($ele_id) ){
	$keys = array_keys($ele_value[2]);
	for( $i=0; $i<count($keys); $i++ ){
		$v = $myts->makeTboxData4PreviewInForm($keys[$i]);
		$options[] = addOption('ele_value[2]['.$opt_count.']', 'checked['.$opt_count.']', $v, 'check', $ele_value[2][$keys[$i]]);
		$scores[] = addOption('ele_scores[2]['.$opt_count.']', '', $ele_scores[2][$v], 'score', '');
		$opt_count++;
	}
}else{
	if( !empty($ele_value[2]) ){
		while( $v = each($ele_value[2]) ){
			$v['value'] = $myts->makeTboxData4PreviewInForm($v['value']);
			if( !empty($v['value']) ){
				$options[] = addOption('ele_value[2]['.$opt_count.']', 'checked['.$opt_count.']', $v['value'], 'check', $checked[$v['key']]);
				$scores[] = addOption('ele_scores[2]['.$opt_count.']', '', $ele_scores[2][$v['value']], 'score', '');
				$opt_count++;
			}
		}
	}
	$addopt = empty($addopt) ? 2 : $addopt;
	for( $i=0; $i<$addopt; $i++ ){
		$options[] = addOption('ele_value[2]['.$opt_count.']', 'checked['.$opt_count.']');
		$scores[] = addOption('ele_scores[2]['.$opt_count.']', '', '', 'score', '');
		$opt_count++;
	}
}

$add_opt = addOptionsTray();
$options[] = $add_opt;

$opt_tray = new XoopsFormElementTray(_AM_XQUIZ_ELE_OPT, '<br />');
$opt_tray->setDescription(_AM_XQUIZ_ELE_OPT_DESC._AM_XQUIZ_ELE_OPT_DESC1);
for( $i=0; $i<count($options); $i++ ){
	$opt_tray->addElement($options[$i]);
}
$opt_scores_tray = new XoopsFormElementTray(_AM_XQUIZ_ELE_SCORE_OPT, '<br />');
$opt_scores_tray->setDescription(_AM_XQUIZ_ELE_OPT_SCORE_DESC._AM_XQUIZ_ELE_OPT_SCORE_DESC1);
for( $i=0; $i<count($scores); $i++ ){
	$opt_scores_tray->addElement($scores[$i]);
}
$form->addElement($size, 1);
$form->addElement($multiple);
$form->addElement($opt_tray);
$form->addElement($opt_scores_tray);
?>