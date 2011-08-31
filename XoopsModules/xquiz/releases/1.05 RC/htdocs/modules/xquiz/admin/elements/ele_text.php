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

$size = !empty($value[0]) ? intval($value[0]) : $xoopsModuleConfig['t_width'];
$max = !empty($value[1]) ? intval($value[1]) : $xoopsModuleConfig['t_max'];
$size = new XoopsFormText(_AM_XQUIZ_ELE_SIZE, 'ele_value[0]', 3, 3, $size);
$max = new XoopsFormText(_AM_XQUIZ_ELE_MAX_LENGTH, 'ele_value[1]', 3, 3, $max);
//the &#146 is a simple quote, it replace the quote witch cause crash in rendering the form
//not really good :-(
	$value[2] = eregi_replace ("'", "&#146;", $value[2]);
//
$default = new XoopsFormText(_AM_XQUIZ_ELE_DEFAULT, 'ele_value[2]', 50, 255, $value[2]);
$default->setDescription(_AM_XQUIZ_ELE_TEXT_DESC);
$form->addElement($size, 1);
$form->addElement($max, 1);
$form->addElement($default);

?>