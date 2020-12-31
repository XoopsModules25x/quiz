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
 * Version : $Id:
 * ****************************************************************************
 */

use XoopsModules\Xquiz\{
    Category,
    Files,
    Helper,
    Quiz,
    Question,
    Questions,
    Utility
};

/** @var Helper $helper */
/** @var Quiz $quiz */

require __DIR__ . '/admin_header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
xoops_cp_header();
try {
    $option     = $_GET ['op'] ?? '';
    $action     = $_GET ['act'] ?? '';
    $answerType = (isset($_GET ['type'])) ? htmlentities(strtoupper($_GET ['type']), ENT_QUOTES | ENT_HTML5) : '';

    if (isset($_GET ['Id'])) {
        if (!is_numeric($_GET ['Id'])) {
            throw new \Exception('id must be a number.');
        }
        $id = $_GET ['Id'];
    }

    if (isset($_GET ['qId'])) {
        if (!is_numeric($_GET ['qId'])) {
            throw new \Exception('qid must be a number.');
        }
        $qid = $_GET ['qId'];
    }

    if (isset($_GET ['start'])) {
        if (!is_numeric($_GET ['start'])) {
            throw new \Exception('start must be a number.');
        }
        $start = $_GET ['start'];
    } else {
        $start = 0;
    }
    global $xoopsModuleConfig;
    $limitQuiz     = $xoopsModuleConfig ['quizList']; // No of records to be shown per page.
    $limitQuest    = $xoopsModuleConfig ['questionList']; // No of records to be shown per page.
    $limitUser     = $xoopsModuleConfig ['userList']; // No of records to be shown per page.
    $limitCategory = $xoopsModuleConfig ['categoryList'];
    $dateformat    = $xoopsModuleConfig ['dateformat'];

    switch ($option) {
        case 'Quiz':
//            QuizzadminMenu(1, _AM_XQUIZ_QUIZS);
            switch ($action) {
                case 'add':
                    Quiz::QuizForm('add');
                    break;

                case 'edit':
                    if (isset($_GET ['Id'])) {
                        Quiz::QuizForm('edit', $id);
                    } else {
                        Quiz::showQuizs($start, $limitQuiz);
                    }
                    break;

                case 'del':
                    if (isset($_GET ['Id'])) {
                        Quiz::confirmForm($id);
                    } else {
                        Quiz::showQuizs($start, $limitQuiz);
                    }
                    break;

                default:
                    $cid = -1;
                    if (isset($_GET ['Id'])) {
                        $cid = $id;
                    }
                    Quiz::showQuizs($start, $limitQuiz, $cid);
            }
            break;

        case 'Quest':
            if (0 == Quiz::quiz_numQuizLoader()) {
                throw new \Exception(_AM_XQUIZ_NO_QUIZ);
            }
//            QuizzadminMenu(2, _AM_XQUIZ_QUIZS);
            switch ($action) {
                case 'add':
                    if (!Quiz::quiz_checkExpireQuiz($id)) {
                        throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE);
                    }
                    if (Quiz::quiz_checkActiveQuiz($id)) {
                        throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE);
                    }

                    Question::showQuizSelectForm();
                    if (isset($id)) {
                        Question::QuestForm($id);
                    }
                    break;

                case 'edit':
                    Question::showQuizSelectForm();
                    if ((isset($id)) && (isset($qid))) {
                        Question::QuestForm($qid, 'edit', $id);
                    }
                    break;

                case 'del':
                    Question::showQuizSelectForm();
                    if (isset($id)) {
                        Question::confirmForm($id);
                    }
                    break;

                default:
                    Question::showQuizSelectForm();
                    if (isset($id)) {
                        Question::showQuestions($start, $limitQuest, $id);
                    }
            }
            break;

        case 'Statistics':
            if (0 == Quiz::quiz_numQuizLoader()) {
                throw new \Exception(_AM_XQUIZ_NO_QUIZ);
            }
//            QuizzadminMenu(3, _AM_XQUIZ_QUIZS);
            Utility::statQuizsSelectForm();
            ////////////////////////////////////////////////////////////////
            if (isset($_GET ['uid']) && is_numeric($_GET ['uid']) && isset($id)) {
                $uid = $_GET ['uid'];
                $arr = showUserQuest($id, $uid);
                break;
            }
            /////////////////////////////////////////////////////////////////
            if (isset($id)) {
                $qname = Quiz::quiz_quizName($id);
                $nume  = Utility::numUserScore($id);
                ////////////////////////////////////////
                $listQuiz = [];
                $q        = 1;
                $eu       = ($start - 0);
                $query    = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . ' WHERE id = ' . $id . ' ORDER BY score DESC LIMIT ' . $eu . ' , ' . $limitUser);
                while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
                    $listQuiz [$q] ['id']     = $myrow ['id'];
                    $listQuiz [$q] ['userid'] = $myrow ['userid'];
                    $thisUser                 = $memberHandler->getUser($myrow ['userid']);
                    $listQuiz [$q] ['uname']  = $thisUser->getVar('uname');
                    $listQuiz [$q] ['name']   = $thisUser->getVar('name');
                    $listQuiz [$q] ['score']  = $myrow ['score'];
                    $listQuiz [$q] ['date']   = formatTimestamp(strtotime($myrow ['date']), $dateformat);
                    $q++;
                }
                ////////////////////////////////////////
                if (isset($_GET ['exp']) && 'on' == $_GET ['exp']) {
                    $exportQuiz = [];
                    $query      = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . ' WHERE id = ' . $id);
                    $q          = 1;
                    while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
                        $exportQuiz [$q] ['id']     = $myrow ['id'];
                        $exportQuiz [$q] ['userid'] = $myrow ['userid'];
                        $thisUser                   = $memberHandler->getUser($myrow ['userid']);
                        $exportQuiz [$q] ['uname']  = $thisUser->getVar('uname');
                        $exportQuiz [$q] ['name']   = $thisUser->getVar('name');
                        $exportQuiz [$q] ['score']  = $myrow ['score'];
                        $exportQuiz [$q] ['date']   = formatTimestamp(strtotime($myrow ['date']), $dateformat);
                        $q++;
                    }
                    $fp = fopen('../../../uploads/quiz.csv', 'w+b') or redirect_header(XOOPS_URL . '/modules/xquiz/admin/main.php?op=Statistics', 3, '_AM_XQUIZ_OPEN_CSV_ERR');
                    $msg = _AM_XQUIZ_USER . ',' . _AM_XQUIZ_USER_NAME . ',' . _AM_XQUIZ_DATE . ',' . _AM_XQUIZ_SCORE . '
';
                    foreach ($exportQuiz as $key) {
                        $msg .= $key ['uname'] . ',' . $key ['name'] . ',' . $key ['date'] . ',' . $key ['score'] . '
';
                    }
                    // for csv utf-8 language support
                    $msg = html_entity_decode($msg, ENT_NOQUOTES, 'utf-8');
                    $msg = chr(255) . chr(254) . iconv('UTF-8', 'UTF-16LE', $msg);
                    #end region
                    fwrite($fp, $msg) or redirect_header(XOOPS_URL . '/modules/xquiz/admin/main.php?op=Statistics', 3, '_AM_XQUIZ_OPEN_CSV_ERR');;
                    fclose($fp);
                    echo "
						<div id='newsel' style='text-align: left;'>
						<table width='100%' cellspacing='0' cellpadding='3' border='0' class='outer'>
						<tr class='even'>
							<td width='40%'>
							</td>
							<td width='3%'>
								<img src='" . XOOPS_URL . "/modules/xquiz/assets/images/xls.png'>
							</td>
							<td>
								<a href='" . XOOPS_URL . "/uploads/quiz.csv'>
									" . _AM_XQUIZ_CSV_DOWNLOAD . "
								</a>
							</td>
							<td width='40%'>
							</td>
						</tr>	
						</table>
						</div>";
                }
                ///////////////////////////////////////
                Utility::collapsableBar('newsub', 'topnewsubicon');
                $temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 	</a>&nbsp;" . _AM_XQUIZ_STATISTICS . "</h4><br>
						<div id='newsub' style='text-align: left;'>
						<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='bg3'>
							<th>
								" . _AM_XQUIZ_USER . '
							</th>
							<th>
								' . _AM_XQUIZ_USER_NAME . '
							</th>
							<th>
								' . _AM_XQUIZ_SCORE . '
							</th>
							<th>
								' . _AM_XQUIZ_DATE . '
							</th>
							<th>
								' . _AM_XQUIZ_DESC . '
							</th>
						</tr>';

                $class    = 'even';
                $detImage = '<img src= "' . XOOPS_URL . '/modules/xquiz/assets/images/detail.gif " >';

                foreach ($listQuiz as $key) {
                    $class = ('even' == $class) ? 'odd' : 'even';

                    $temp .= "
						<tr class='" . $class . "'>
							<td>
								<a href=\"" . XOOPS_URL . '/userinfo.php?uid=' . $key ['userid'] . '">' . $key ['uname'] . '</a>
							</td>
							<td>
								' . $key ['name'] . '
							</td>
							<td>
							' . $key ['score'] . '
							</td>
							<td>
							' . $key ['date'] . '
							</td>
							<td>
							<a href="' . XOOPS_URL . '/modules/xquiz/admin/main.php?op=Statistics&Id=' . $key ['id'] . '&uid=' . $key ['userid'] . '">' . $detImage . '</a>
							</td>
						</tr>';
                }
                $temp .= '</table></div>';
                echo $temp;

                $nav = new \XoopsPageNav($nume, $limitUser, $start, 'start', "op=Statistics&Id=$id");
                echo "<div align='left'>" . $nav->renderImageNav() . '</div><br>';
            }

            //	///////////////////////////////////////////////////////////////
            break;

        case 'Permission':
            $xt = new Category($xoopsDB->prefix('xquiz_categories'), 'cid', 'pid');
            if (!$xt->getChildTreeArray(0)) {
                throw new \Exception(_AM_XQUIZ_NO_CATEGORY);
            }
//            QuizzadminMenu(4, _AM_MD_XQUIZ_PERMISSIONS);
            Category::category_permissionForm();
            break;

        case 'Category':
//            QuizzadminMenu(5, _AM_XQUIZ_CATEGORIES);
            switch ($action) {
                case 'add':
                    Utility::CategoryForm('add');
                    break;

                case 'edit':
                    if (isset($_GET ['Id'])) {
                        Utility::CategoryForm('edit', $id);
                    } else {
                        Utility::showCategories($start, $limitCategory);
                    }
                    break;

                case 'del':
                    if (isset($_GET ['Id'])) {
                        Utility::confirmForm($id);
                    } else {
                        Utility::showCategories($start, $limitCategory);
                    }
                    break;

                default:
                    Utility::showCategories($start, $limitCategory);
            }

            break;

        //////////////////////////////////////////////////////////////////////////////

        case 'Question':
            if (0 == Quiz::quiz_numQuizLoader()) {
                throw new \Exception(_AM_XQUIZ_NO_QUIZ);
            }
//            QuizzadminMenu(6, _AM_XQUIZ_QUIZS);
            switch ($action) {
                case 'add':
                    if (!Quiz::quiz_checkExpireQuiz($id)) {
                        throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE);
                    }
                    if (Quiz::quiz_checkActiveQuiz($id)) {
                        throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE);
                    }

                    Questions::showQuizSelectForm();
                    if (isset($id)) {
                        Questions::QuestAddForm($id, $answerType);
                    }
                    break;

                case 'edit':
                    Questions::showQuizSelectForm();
                    if (isset($id)) {
                        $questionObj = new Questions();
                        $questionObj->QuestEditForm($id);
                    }
                    break;

                case 'del':
                    Questions::showQuizSelectForm();
                    if (isset($id)) {
                        Questions::confirmForm($id);
                    }
                    break;

                default:
                    Questions::showQuizSelectForm();
                    if (isset($id)) {
                        Questions::showQuestions($start, $limitQuest, $id);
                    }
            }
            break;

        //////////////////////////////////////////////////////////////////////////////////

        default:
//            QuizzadminMenu(0, _AM_XQUIZ_INDEX);
//            $menu = new QuizMenu();
//            $menu->addItem('Categories', 'main.php?op=Category', '../assets/images/menus/categories.png', _AM_XQUIZ_CATEGORIES);
//            $menu->addItem('Quizzes', 'main.php?op=Quiz', '../assets/images/menus/quizzes.png', _AM_XQUIZ_QUIZS);
//            $menu->addItem('Questions', 'main.php?op=Question', '../assets/images/menus/questions.png', _AM_XQUIZ_QUESTIONS);
//            $menu->addItem('Statistics', 'main.php?op=Statistics', '../assets/images/menus/statistic.png', _AM_XQUIZ_STATISTICS);
//            $menu->addItem('Permissions', 'main.php?op=Permission', '../assets/images/menus/permmision.png', _AM_MD_XQUIZ_PERMISSIONS);
//            $menu->addItem('Preference', '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid') . '&amp;&confcat_id=1', '../assets/images/menus/config.png', _AM_XQUIZ_PREFERENCE);

            if (!class_exists('XoopsTpl')) {
                require_once XOOPS_ROOT_PATH . '/class/template.php';
            }
            $tpl = $xoopsTpl ?? new \XoopsTpl();
//            $tpl->assign('menu_css', $menu->getCSS());
//            $tpl->assign('menu', $menu->render());
            $tpl->assign('quiz_version', sprintf(_AM_XQUIZ_VERSION, $xoopsModule->getInfo('version') . '(' . $xoopsModule->getInfo('status') . ')', $xoopsModule->getInfo('name')));
            echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/xquiz/templates/admin/xquiz_admin_index.tpl');
            break;
    }
} catch (Exception $e) {
    redirect_header('index.php', 3, $e->getMessage());
    exit();
}

xoops_cp_footer();
