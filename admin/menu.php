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
 * @copyright          XOOPS Project (https://xoops.org)
 * @license            http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package            xquiz
 * @author             Mojtaba Jamali(jamali.mojtaba@gmail.com)
 * @version            $Id$
 *
 * ****************************************************************************
 */

use Xmf\Module\Admin;
use XoopsModules\Xquiz\{
    Helper
};
/** @var Admin $adminObject */
/** @var Helper $helper */


include dirname(__DIR__) . '/preloads/autoloader.php';

$moduleDirName = basename(dirname(__DIR__));
$moduleDirNameUpper = mb_strtoupper($moduleDirName);
$helper = Helper::getInstance();
$helper->loadLanguage('common');
$helper->loadLanguage('feedback');

$pathIcon32 = Admin::menuIconPath('');
if (is_object($helper->getModule())) {
    //    $pathModIcon32 = $helper->getModule()->getInfo('modicons32');
    $pathModIcon32 = $helper->url($helper->getModule()->getInfo('modicons32'));
}

$adminmenu[] = [
    'title' => _MI_XQUIZ_INDEX,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png',
];

$adminmenu[] = [
    'title' => _MI_XQUIZ_MENU_01,
    'link'  => 'admin/main.php',
    'icon' => $pathIcon32 . '/manage.png',
];

$adminmenu[] = [
    'title' => _MI_XQUIZ_CATEGORY,
    'link'  => 'admin/main.php?op=Category',
    'icon' => $pathIcon32 . '/category.png',
];

$adminmenu[] = [
    'title' => _MI_XQUIZ_QUIZS,
    'link'  => 'admin/main.php?op=Quiz',
    'icon'  => 'assets/images/menus/tquizzes.png',
];

//$adminmenu[] = [
//'title' => _MI_XQUIZ_QUESTIONS . "",
//'link' => 'admin/main.php?op=Quest',
//'icon' => 'assets/images/menus/tquestions.png',
//];

$adminmenu[] = [
    'title' => _MI_XQUIZ_QUESTIONS . '',
    'link'  => 'admin/main.php?op=Question',
    'icon'  => 'assets/images/menus/tquestions.png',
];

$adminmenu[] = [
    'title' => _MI_XQUIZ_STATISTICS,
    'link'  => 'admin/main.php?op=Statistics',
    'icon'  => 'assets/images/menus/tstatistic.png',
];

$adminmenu[] = [
    'title' => _MI_MD_XQUIZ_PERMISSIONS,
    'link'  => 'admin/main.php?op=Permission',
    'icon'  => 'assets/images/menus/tpermmision.png',
];


// Blocks Admin
$adminmenu[] = [
    'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'BLOCKS'),
    'link' => 'admin/blocksadmin.php',
    'icon' => $pathIcon32 . '/block.png',
];

if (is_object($helper->getModule()) && $helper->getConfig('displayDeveloperTools')) {
    $adminmenu[] = [
        'title' => constant('CO_' . $moduleDirNameUpper . '_' . 'ADMENU_MIGRATE'),
        'link' => 'admin/migrate.php',
        'icon' => $pathIcon32 . '/database_go.png',
    ];
}

$adminmenu[] = [
    'title' => _MI_XQUIZ_MENU_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png',
];
  
    
    
    
	

