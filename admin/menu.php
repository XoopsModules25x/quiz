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
 * @copyright   	XOOPS Project (https://xoops.org)
 * @license			http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package         xquiz
 * @author 			Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version      	$Id$
 *
 * Version : $Id:
 * ****************************************************************************
 */
$adminmenu[0]['title'] = _MI_XQUIZ_INDEX;
$adminmenu[0]['link'] = 'admin/index.php';

$adminmenu[1]['title'] = _MI_XQUIZ_CATEGORY;
$adminmenu[1]['link'] = 'admin/index.php?op=Category';

$adminmenu[2]['title'] = _MI_XQUIZ_PERMISSIONS;
$adminmenu[2]['link'] = 'admin/index.php?op=Permission';

$adminmenu[3]['title'] = _MI_XQUIZ_QUIZS;
$adminmenu[3]['link'] = 'admin/index.php?op=Quiz';

$adminmenu[4]['title'] = _MI_XQUIZ_QUESTIONS . " 1";
$adminmenu[4]['link'] = 'admin/index.php?op=Quest';

$adminmenu[5]['title'] = _MI_XQUIZ_QUESTIONS . " 2";
$adminmenu[5]['link'] = 'admin/index.php?op=Question';

$adminmenu[6]['title'] = _MI_XQUIZ_STATISTICS;
$adminmenu[6]['link'] = 'admin/index.php?op=Statistics';

    $adminmenu[0]['icon'] = 'assets/images/menus/tstate.png';
    $adminmenu[1]['icon'] = 'assets/images/menus/tcategories.png';
    $adminmenu[2]['icon'] = 'assets/images/menus/tpermmision.png';
    $adminmenu[3]['icon'] = 'assets/images/menus/tquizzes.png';
    $adminmenu[4]['icon'] = 'assets/assets/images/menus/tquestions.png';
    $adminmenu[5]['icon'] = 'assets/images/menus/tquestions.png';
	$adminmenu[6]['icon'] = 'assets/images/menus/tstatistic.png';

