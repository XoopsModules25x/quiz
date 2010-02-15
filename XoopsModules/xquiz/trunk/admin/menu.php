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
$adminmenu[0]['title'] = _AM_QUIZ_INDEX;
$adminmenu[0]['link'] = 'admin/index.php';

$adminmenu[1]['title'] = _AM_QUIZ_CATEGORY;
$adminmenu[1]['link'] = 'admin/index.php?op=Cate';

$adminmenu[2]['title'] = _AM_QUIZ_PERMISSIONS;
$adminmenu[2]['link'] = 'admin/index.php?op=Perm';

$adminmenu[3]['title'] = _AM_QUIZ_QUIZS;
$adminmenu[3]['link'] = 'admin/index.php?op=Quiz';

$adminmenu[4]['title'] = _AM_QUIZ_QUESTIONS;
$adminmenu[4]['link'] = 'admin/index.php?op=Quest';

$adminmenu[5]['title'] = _AM_QUIZ_STATISTICS;
$adminmenu[5]['link'] = 'admin/index.php?op=Stat';

$adminmenu[5]['title'] = _AM_QUIZ_QUESTIONS;
$adminmenu[5]['link'] = 'admin/index.php?op=Qst';

	$adminmenu[0]['icon'] = 'images/menus/tstate.png';
	$adminmenu[1]['icon'] = 'images/menus/tcategories.png';
	$adminmenu[2]['icon'] = 'images/menus/tpermmision.png';
	$adminmenu[3]['icon'] = 'images/menus/tquizzes.png';
	$adminmenu[4]['icon'] = 'images/menus/tquestions.png';
	$adminmenu[5]['icon'] = 'images/menus/tstatistic.png';
	$adminmenu[6]['icon'] = 'images/menus/tquestions.png';
?>