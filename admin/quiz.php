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

switch ($op) {
    case 'new_quiz':
        if (!$totalCategories = $category_handler->categoryCount()) {
            xoops_error(_AM_XQUIZ_CATEGORY_EMPTY);

            xoops_cp_footer();

            exit();
        }
            $obj = $quiz_handler->create();
            $obj->getQuizForm();
        break;
    case 'edit_quiz':
        $quiz_id = xquiz_CleanVars($_REQUEST, 'quiz_id', 0, 'int');
        if ($quiz_id > 0) {
            $obj = $quiz_handler->get($quiz_id);

            $obj->getQuizForm();
        } else {
            redirect_header('quiz.php', 1, _AM_XQUIZ_MSG_EDIT_ERROR);
        }
        break;
    case 'delete_quiz':
        $quiz_id = xquiz_CleanVars($_REQUEST, 'quiz_id', 0, 'int');
        if ($quiz_id > 0) {
            // Prompt message

            xoops_confirm(['quiz_id' => $quiz_id], 'backend.php?op=deletequiz', _AM_XQUIZ_MSG_DELETE);

            xoops_cp_footer();
        }
        break;
    case 'order':
        if (isset($_POST['mod'])) {
            $i = 1;

            foreach ($_POST['mod'] as $order) {
                if ($order > 0) {
                    $contentorder = $quiz_handler->get($order);

                    $contentorder->setVar('quiz_order', $i);

                    if (!$quiz_handler->insert($contentorder)) {
                        $error = true;
                    }

                    $i++;
                }
            }
        }
        exit;
        break;
    default:
        if (!$totalCategories = $category_handler->categoryCount()) {
            xoops_error(_AM_XQUIZ_CATEGORY_EMPTY);

            xoops_cp_footer();

            exit();
        }

        // Define scripts
        $xoTheme->addScript('browse.php?Frameworks/jquery/jquery.js');
        $xoTheme->addScript('browse.php?Frameworks/jquery/plugins/jquery.ui.js');
        $xoTheme->addScript(XOOPS_URL . '/modules/xquiz/assets/js/order.js');
        $xoTheme->addScript(XOOPS_URL . '/modules/xquiz/assets/js/admin.js');
        // Add module stylesheet
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/ui/' . xoops_getModuleOption('jquery_theme', 'system') . '/ui.all.css');
        $xoTheme->addStylesheet(XOOPS_URL . '/modules/system/css/admin.css');

        $info = [];
        $info['quiz_sort'] = 'quiz_order';
        $info['quiz_order'] = 'DESC';

        // get quiz from category
        if (isset($_REQUEST['category'])) {
            $info['category'] = $_REQUEST['category'];
        } else {
            $info['category'] = null;
        }

        // get limited information
        if (isset($_REQUEST['limit'])) {
            $info['quiz_limit'] = xquiz_CleanVars($_REQUEST, 'limit', 0, 'int');
        } else {
            $info['quiz_limit'] = 40;
        }

        // get start information
        if (isset($_REQUEST['start'])) {
            $info['quiz_start'] = xquiz_CleanVars($_REQUEST, 'start', 0, 'int');
        } else {
            $info['quiz_start'] = 0;
        }

        $info['type'] = 'xquiz';
        $info['allcategories'] = $category_handler->getall();
        $quizs = $quiz_handler->quizSAdminList($info);
        $quiz_numrows = $quiz_handler->quizCount($info);

        if ($quiz_numrows > $info['quiz_limit']) {
            $quiz_pagenav = new XoopsPageNav($quiz_numrows, $info['quiz_limit'], $info['quiz_start'], 'start', 'limit=' . $info['quiz_limit']);

            $quiz_pagenav = $quiz_pagenav->renderNav(4);
        } else {
            $quiz_pagenav = '';
        }

        $xoopsTpl->assign('quizs', $quizs);
        $xoopsTpl->assign('quiz_pagenav', $quiz_pagenav);

        // Call template file
        $xoopsTpl->display(XOOPS_ROOT_PATH . '/modules/xquiz/templates/admin/xquiz_quiz.tpl');
        break;
}

// footer
xoops_cp_footer();
