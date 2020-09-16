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

$op = xquiz_CleanVars($_REQUEST, 'op', 'new', 'string');
// Admin header
xoops_cp_header();
// Redirect to content page
if (!isset($_REQUEST)) {
    redirect_header('quiz.php', 3, _AM_XQUIZ_MSG_NOTINFO);

    // Include footer

    xoops_cp_footer();

    exit();
}

switch ($op) {
    case 'addcategory':
        $obj = $category_handler->create();
        $obj->setVars($_REQUEST);
        $obj->setVar('category_created', time());

        if (!$category_handler->insert($obj)) {
            redirect_header('onclick="javascript:history.go(-1);"', 1, _AM_XQUIZ_MSG_ERROR);

            xoops_cp_footer();

            exit();
        }

        // Redirect page
        redirect_header('category.php', 1, _AM_XQUIZ_MSG_INSERTSUCCESS);
        xoops_cp_footer();
        exit();
        break;
    case 'editcategory':
        $category_id = xquiz_CleanVars($_REQUEST, 'category_id', 0, 'int');
        if ($category_id > 0) {
            $obj = $category_handler->get($category_id);

            $obj->setVars($_POST);

            if (!$category_handler->insert($obj)) {
                redirect_header('onclick="javascript:history.go(-1);"', 1, _AM_XQUIZ_MSG_ERROR);

                xoops_cp_footer();

                exit();
            }
        }

        // Redirect page
        redirect_header('category.php', 1, _AM_XQUIZ_MSG_EDITSUCCESS);
        xoops_cp_footer();
        exit();
        break;
    case 'deletecategory':
        $category_id = xquiz_CleanVars($_REQUEST, 'category_id', 0, 'int');
        $obj = $category_handler->get($category_id);
        if (!$category_handler->delete($obj)) {
            echo $obj->getHtmlErrors();
        }

        // Redirect page
        redirect_header('category.php', 1, _AM_XQUIZ_MSG_DELETESUCCESS);
        xoops_cp_footer();
        exit();
        break;
    case 'addquiz':
        $obj = $quiz_handler->create();
        $obj->setVars($_POST);
        $obj->setVar('quiz_create', time());
		$obj->setVar('quiz_img', $quiz_handler->uploadimg($_POST['quiz_img']));
        $obj->setVar('quiz_startdate', date('Y-m-d H:i:s', strtotime($_POST['quiz_startdate']['date']) + $_POST['quiz_startdate']['time']));
        $obj->setVar('quiz_enddate', date('Y-m-d H:i:s', strtotime($_POST['quiz_enddate']['date']) + $_POST['quiz_enddate']['time']));

        if (!$quiz_handler->insert($obj)) {
		//redirect_header('onclick="javascript:history.go(-1);"', 1, _AM_XQUIZ_MSG_ERROR);

            xoops_cp_footer();

            //exit();
        }

        // Redirect page
        redirect_header('quiz.php', 1, _AM_XQUIZ_MSG_INSERTSUCCESS);
        xoops_cp_footer();
        exit();
        break;
    case 'editquiz':
        $quiz_id = xquiz_CleanVars($_REQUEST, 'quiz_id', 0, 'int');
        if ($quiz_id > 0) {
            $obj = $quiz_handler->get($quiz_id);

            $obj->setVars($_REQUEST);

            //$obj->setVar('quiz_order', $quiz_handler->setquizorder());

            $obj->setVar('quiz_startdate', date('Y-m-d H:i:s', strtotime($_POST['quiz_startdate']['date']) + $_POST['quiz_startdate']['time']));

            $obj->setVar('quiz_enddate', date('Y-m-d H:i:s', strtotime($_POST['quiz_enddate']['date']) + $_POST['quiz_enddate']['time']));

            if (!$quiz_handler->insert($obj)) {
                //redirect_header ( 'onclick="javascript:history.go(-1);"', 1, _AM_XQUIZ_MSG_ERROR );

                xoops_cp_footer();

                exit();
            }
        }
        // Redirect page
        redirect_header('quiz.php', 1, _AM_XQUIZ_MSG_EDITSUCCESS);
        xoops_cp_footer();
        exit();
        break;
    case 'deletequiz':
        $quiz_id = xquiz_CleanVars($_REQUEST, 'quiz_id', 0, 'int');
        $obj = $quiz_handler->get($quiz_id);
        unlink(XOOPS_URL . '/uploads/xquiz/image/' . $obj->getVar('quiz_img'));
        if (!$quiz_handler->delete($obj)) {
            echo $obj->getHtmlErrors();
        }
        // Redirect page
        redirect_header('quiz.php', 1, _AM_XQUIZ_MSG_DELETESUCCESS);
        xoops_cp_footer();
        exit();
        break;
    case 'quiz_status':
        $quiz_id = xquiz_CleanVars($_REQUEST, 'quiz_id', 0, 'int');
        if ($quiz_id > 0) {
            $obj = $quiz_handler->get($quiz_id);

            $old = $obj->getVar('quiz_status');

            $obj->setVar('quiz_status', !$old);

            if ($quiz_handler->insert($obj)) {
                exit();
            }

            echo $obj->getHtmlErrors();
        }
        break;
}

// Redirect page
redirect_header('quiz.php', 3, _AM_XQUIZ_MSG_NOTINFO);
// Include footer
xoops_cp_footer();
exit();
