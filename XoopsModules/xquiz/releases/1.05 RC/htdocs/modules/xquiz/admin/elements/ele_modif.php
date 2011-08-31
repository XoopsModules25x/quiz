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
$rows = !empty($value[0]) ? $value[1] : $xoopsModuleConfig['ta_rows'];
$cols = !empty($value[0]) ? $value[2] : $xoopsModuleConfig['ta_cols'];
$rows = new XoopsFormText(_AM_XQUIZ_ELE_ROWS, 'ele_value[1]', 3, 3, $rows);
$cols = new XoopsFormText(_AM_XQUIZ_ELE_COLS, 'ele_value[2]', 3, 3, $cols);
$default = new XoopsFormTextArea(_AM_XQUIZ_ELE_DEFAULT, 'ele_value[0]', $value[0], 5, 35);
$form->addElement($rows, 1);
$form->addElement($cols, 1);
$form->addElement($default);
?>