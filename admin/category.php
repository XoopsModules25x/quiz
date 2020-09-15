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

$op = xquiz_CleanVars($_REQUEST, 'op', '', 'string');

$xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

switch ($op) {
    case 'new_category':
        $obj = $category_handler->create();
        $obj->getCategoryForm();
        break;
    case 'edit_category':
        $category_id = xquiz_CleanVars($_REQUEST, 'category_id', 0, 'int');
        if ($category_id > 0) {
            $obj = $category_handler->get($category_id);

            $obj->getCategoryForm();
        } else {
            redirect_header('category.php', 1, _AM_XQUIZ_MSG_EDIT_ERROR);
        }
        break;
    case 'delete_category':
        $category_id = xquiz_CleanVars($_REQUEST, 'category_id', 0, 'int');
        if ($category_id > 0) {
            // Prompt message

            xoops_confirm(['category_id' => $category_id], 'backend.php?op=deletecategory', _AM_XQUIZ_MSG_DELETE);

            xoops_cp_footer();
        }
        break;
    default:
        $info = [];
        $info['category_sort'] = 'category_id';
        $info['category_order'] = 'DESC';
        // get limited information
        if (isset($_REQUEST['limit'])) {
            $info['category_limit'] = xquiz_CleanVars($_REQUEST, 'limit', 0, 'int');
        } else {
            $info['category_limit'] = 15;
        }

        // get start information
        if (isset($_REQUEST['start'])) {
            $info['category_start'] = xquiz_CleanVars($_REQUEST, 'start', 0, 'int');
        } else {
            $info['category_start'] = 0;
        }

        $categories = $category_handler->categoryList($info);
        $category_numrows = $category_handler->categoryCount();

        if ($category_numrows > $info['category_limit']) {
            $category_pagenav = new XoopsPageNav($category_numrows, $info['category_limit'], $info['category_start'], 'start', 'limit=' . $info['category_limit']);

            $category_pagenav = $category_pagenav->renderNav(4);
        } else {
            $category_pagenav = '';
        }

        $xoopsTpl->assign('categories', $categories);
        $xoopsTpl->assign('category_pagenav', $category_pagenav);

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/xquiz/templates/admin/xquiz_category.tpl');
        break;
}

// footer
xoops_cp_footer();
