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
require 'header.php';
xoops_cp_header();
// Add module stylesheet
$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');
// module admin
$index_admin = new ModuleAdmin();
$folder = [
    XOOPS_ROOT_PATH . '/uploads/xquiz/',
];
$index_admin = new ModuleAdmin();
$index_admin->addInfoBox(_AM_XQUIZ_INDEX_INFO);
$index_admin->addInfoBoxLine(_AM_XQUIZ_INDEX_INFO, _AM_XQUIZ_INDEX_CATEGORIES, $category_handler->categoryCount());
$index_admin->addInfoBoxLine(_AM_XQUIZ_INDEX_INFO, _AM_XQUIZ_INDEX_ITEMS, $item_handler->itemCount());
foreach (array_keys($folder) as $i) {
    $index_admin->addConfigBoxLine($folder[$i], 'folder');

    $index_admin->addConfigBoxLine([$folder[$i], '777'], 'chmod');
}
$xoopsTpl->assign('renderindex', $index_admin->renderIndex());
// Call template file
$xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/xquiz/templates/admin/xquiz_index.tpl');
// footer
xoops_cp_footer();
