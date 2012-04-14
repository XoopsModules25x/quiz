<?php
/**
 * ****************************************************************************
 * xquiz - MODULE FOR XOOPS
 * Copyright (c) Mojtaba Jamali of persian xoops project (http://www.irxoops.org/)
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright   	The XOOPS Project http://sourceforge.net/projects/xoops/ 
 * @license			http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xquiz
 * @author 			Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version      	$Id$ 
 *
 * Version : $Id:
 * ****************************************************************************
 */
include_once XOOPS_ROOT_PATH.'/modules/quiz/class/quiz.php';
include_once XOOPS_ROOT_PATH.'/modules/quiz/class/question.php';
function quiz_listActiveQuizs($options){
$block=array();
$block = Quiz::quiz_listQuizLoader(0,$options[0]);
return $block;
}
function quiz_listActiveQuizs_edit($options){
$form = _BL_QUIZ_OPTION.": <input type='text' size='9' name='options[0]' value='$options[0]' />";
$form .= "
";
return $form;
}
?>
