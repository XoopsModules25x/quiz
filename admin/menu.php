<?php
/**
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
 * @copyright       XOOPS Project (https://xoops.org)
 * @license         GNU GPL 2 (http://www.gnu.org/licenses/old-licenses/gpl-2.0.html)
 * @package         xquiz
 * @author 			Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version         $Id: $
 */
$i = 1;
$adminmenu[$i] = [
    'title' => _AM_XQUIZ_HOME,
    'link' => 'admin/index.php',
    'icon' => 'assets/images/home.png',
];
$i++;
$adminmenu[$i] = [
    'title' => _AM_XQUIZ_CATEGORY,
    'link' => 'admin/category.php',
    'icon' => 'assets/images/category.png',
];
$i++;
$adminmenu[$i] = [
    'title' => _AM_XQUIZ_XQUIZ,
    'link' => 'admin/quiz.php',
    'icon' => 'assets/images/item.png',
];
