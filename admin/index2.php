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
include 'admin_header.php';
xoops_cp_header();
try {
    $option = (isset($_GET ['op'])) ? $_GET ['op'] : '';
    $action = (isset($_GET ['act'])) ? $_GET ['act'] : '';
    $answerType = (isset($_GET ['type'])) ? htmlentities(strtoupper($_GET ['type'])) : '';
    
    if (isset($_GET ['Id'])) {
        if (! is_numeric($_GET ['Id'])) {
            throw new Exception("id must be a number.");
        }
        $id = $_GET ['Id'];
    }
    
    if (isset($_GET ['qId'])) {
        if (! is_numeric($_GET ['qId'])) {
            throw new Exception("qid must be a number.");
        }
        $qid = $_GET ['qId'];
    }
    
    if (isset($_GET ['start'])) {
        if (! is_numeric($_GET ['start'])) {
            throw new Exception("start must be a number.");
        }
        $start = $_GET ['start'];
    } else {
        $start = 0;
    }
    global $xoopsModuleConfig;
    $limitQuiz = $xoopsModuleConfig ['quizList']; // No of records to be shown per page.
    $limitQuest = $xoopsModuleConfig ['questionList']; // No of records to be shown per page.
    $limitUser = $xoopsModuleConfig ['userList']; // No of records to be shown per page.
    $limitCategory = $xoopsModuleConfig ['categoryList'];
    $dateformat = $xoopsModuleConfig ['dateformat'];
    
    switch ($option) {
        case 'Quiz':
            QuizzadminMenu(1, _XQUIZ_QUIZS);
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
                    $cid = - 1;
                    if (isset($_GET ['Id'])) {
                        $cid = $id;
                    }
                    Quiz::showQuizs($start, $limitQuiz, $cid);
            }
            break;
        
        case 'Quest':
            if (0 == Quiz::quiz_numQuizLoader()) {
                throw new Exception(_AM_NO_QUIZ);
            }
            QuizzadminMenu(2, _XQUIZ_QUIZS);
            switch ($action) {
                case 'add':
                    if (! Quiz::quiz_checkExpireQuiz($id)) {
                        throw new Exception(_QUEST_ADD_RULE);
                    }
                    if (Quiz::quiz_checkActiveQuiz($id)) {
                        throw new Exception(_QUEST_ADD_RULE);
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
                throw new Exception(_AM_NO_QUIZ);
            }
            QuizzadminMenu(3, _XQUIZ_QUIZS);
            statQuizsSelectForm();
            ////////////////////////////////////////////////////////////////
            if (isset($_GET ['uid']) && is_numeric($_GET ['uid']) && isset($id)) {
                $uid = $_GET ['uid'];
                $arr = showUserQuest($id, $uid);
                break;
            }
            /////////////////////////////////////////////////////////////////
            if (isset($id)) {
                $qname = Quiz::quiz_quizName($id);
                $nume = numUserScore($id);
                ////////////////////////////////////////
                $listQuiz = [];
                $q = 1;
                $eu = ($start - 0);
                $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . ' WHERE id = ' . $id . ' ORDER BY score DESC LIMIT ' . $eu . ' , ' . $limitUser);
                while ($myrow = $xoopsDB->fetchArray($query)) {
                    $listQuiz [$q] ['id'] = $myrow ['id'];
                    $listQuiz [$q] ['userid'] = $myrow ['userid'];
                    $thisUser = & $member_handler->getUser($myrow ['userid']);
                    $listQuiz [$q] ['uname'] = $thisUser->getVar('uname');
                    $listQuiz [$q] ['name'] = $thisUser->getVar('name');
                    $listQuiz [$q] ['score'] = $myrow ['score'];
                    $listQuiz [$q] ['date'] = formatTimestamp(strtotime($myrow ['date']), $dateformat);
                    $q ++;
                }
                ////////////////////////////////////////
                if (isset($_GET ['exp']) && 'on' == $_GET ['exp']) {
                    $exportQuiz = [];
                    $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . ' WHERE id = ' . $id);
                    $q = 1;
                    while ($myrow = $xoopsDB->fetchArray($query)) {
                        $exportQuiz [$q] ['id'] = $myrow ['id'];
                        $exportQuiz [$q] ['userid'] = $myrow ['userid'];
                        $thisUser = & $member_handler->getUser($myrow ['userid']);
                        $exportQuiz [$q] ['uname'] = $thisUser->getVar('uname');
                        $exportQuiz [$q] ['name'] = $thisUser->getVar('name');
                        $exportQuiz [$q] ['score'] = $myrow ['score'];
                        $exportQuiz [$q] ['date'] = formatTimestamp(strtotime($myrow ['date']), $dateformat);
                        $q ++;
                    }
                    $fp = fopen('../../../uploads/quiz.csv', 'w+b') or redirect_header(XOOPS_URL . '/modules/xquiz/admin/index.php?op=Statistics', 3, '_XQUIZ_OPEN_CSV_ERR');
                    $msg = _XQUIZ_USER . ',' . _XQUIZ_USER_NAME . ',' . _XQUIZ_DATE . ',' . _XQUIZ_SCORE . '
';
                    foreach ($exportQuiz as $key) {
                        $msg .= $key ['uname'] . ',' . $key ['name'] . ',' . $key ['date'] . ',' . $key ['score'] . '
';
                    }
                    #region for csv utf-8 language support
                    $msg = html_entity_decode($msg, ENT_NOQUOTES, 'utf-8');
                    $msg = chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE", $msg);
                    #end region
                    fwrite($fp, $msg) or redirect_header(XOOPS_URL . '/modules/xquiz/admin/index.php?op=Statistics', 3, '_XQUIZ_OPEN_CSV_ERR');
                    ;
                    fclose($fp);
                    echo "
						<div id='newsel' style='text-align: left;'>
						<table width='100%' cellspacing='0' cellpadding='3' border='0' class='outer'>
						<tr class='even'>
							<td width='40%'>
							</td>
							<td width='3%'>
								<img src='" . XOOPS_URL . "/modules/xquiz/assets/images/xls.gif' />
							</td>
							<td>
								<a href='" . XOOPS_URL . "/uploads/quiz.csv'>
									" . _XQUIZ_CSV_DOWNLOAD . "
								</a>
							</td>
							<td width='40%'>
							</td>
						</tr>	
						</table>
						</div>";
                }
                ///////////////////////////////////////
                quiz_collapsableBar('newsub', 'topnewsubicon');
                $temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt='' />
				 	</a>&nbsp;" . _XQUIZ_STATISTICS . "</h4><br/>
						<div id='newsub' style='text-align: left;'>
						<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='bg3'>
							<th>
								" . _XQUIZ_USER . "
							</th>
							<th>
								" . _XQUIZ_USER_NAME . "
							</th>
							<th>
								" . _XQUIZ_SCORE . "
							</th>
							<th>
								" . _XQUIZ_DATE . "
							</th>
							<th>
								" . _XQUIZ_DESC . "
							</th>
						</tr>";
                
                $class = 'even';
                $detImage = "<img src= \"" . XOOPS_URL . "/modules/xquiz/assets/images/detail.gif \" >";
                
                foreach ($listQuiz as $key) {
                    $class = ('even' == $class) ? 'odd' : 'even';
                    
                    $temp = $temp . "
						<tr class='" . $class . "'>
							<td>
								<a href=\"" . XOOPS_URL . "/userinfo.php?uid=" . $key ['userid'] . "\">" . $key ['uname'] . "</a>
							</td>
							<td>
								" . $key ['name'] . "
							</td>
							<td>
							" . $key ['score'] . "
							</td>
							<td>
							" . $key ['date'] . "
							</td>
							<td>
							<a href=\"" . XOOPS_URL . "/modules/xquiz/admin/index.php?op=Statistics&Id=" . $key ['id'] . "&uid=" . $key ['userid'] . "\">" . $detImage . "</a>
							</td>
						</tr>";
                }
                $temp = $temp . "</table></div>";
                echo $temp;
                
                $nav = new XoopsPageNav($nume, $limitUser, $start, 'start', "op=Statistics&Id=$id");
                echo "<div align='left'>" . $nav->renderImageNav() . '</div><br />';
            }
            
            //	///////////////////////////////////////////////////////////////
            break;
        
        case 'Permission':
            $xt = new Category($xoopsDB->prefix('xquiz_categories'), 'cid', 'pid');
            if (! $xt->getChildTreeArray(0)) {
                throw new Exception(_XQUIZ_NO_CATEGORY);
            }
            QuizzadminMenu(4, _XQUIZ_PERMISSIONS);
            Category::category_permissionForm();
            break;
        
        case 'Category':
            QuizzadminMenu(5, _XQUIZ_CATEGORIES);
            switch ($action) {
                case 'add':
                    CategoryForm('add');
                    break;
                
                case 'edit':
                    if (isset($_GET ['Id'])) {
                        CategoryForm('edit', $id);
                    } else {
                        showCategories($start, $limitCategory);
                    }
                    break;
                
                case 'del':
                    if (isset($_GET ['Id'])) {
                        confirmForm($id);
                    } else {
                        showCategories($start, $limitCategory);
                    }
                    break;
                
                default:
                    showCategories($start, $limitCategory);
            }
            
            break;
        
        //////////////////////////////////////////////////////////////////////////////
        

        case 'Question':
            if (0 == Quiz::quiz_numQuizLoader()) {
                throw new Exception(_AM_NO_QUIZ);
            }
            QuizzadminMenu(6, _XQUIZ_QUIZS);
            switch ($action) {
                case 'add':
                    if (! Quiz::quiz_checkExpireQuiz($id)) {
                        throw new Exception(_QUEST_ADD_RULE);
                    }
                    if (Quiz::quiz_checkActiveQuiz($id)) {
                        throw new Exception(_QUEST_ADD_RULE);
                    }
                    
                    questions::showQuizSelectForm();
                    if (isset($id)) {
                        questions::QuestAddForm($id, $answerType);
                    }
                    break;
                
                case 'edit':
                    questions::showQuizSelectForm();
                    if (isset($id)) {
                        $questionObj = new questions();
                        $questionObj->QuestEditForm($id);
                    }
                    break;
                
                case 'del':
                    questions::showQuizSelectForm();
                    if (isset($id)) {
                        questions::confirmForm($id);
                    }
                    break;
                
                default:
                    questions::showQuizSelectForm();
                    if (isset($id)) {
                        questions::showQuestions($start, $limitQuest, $id);
                    }
            }
            break;
        
        //////////////////////////////////////////////////////////////////////////////////
        

        default:
            QuizzadminMenu(0, _XQUIZ_INDEX);
            $menu = new QuizMenu();
            $menu->addItem('Categories', 'index.php?op=Category', '../assets/images/menus/categories.png', _XQUIZ_CATEGORIES);
            $menu->addItem('Quizzes', 'index.php?op=Quiz', '../assets/images/menus/quizzes.png', _XQUIZ_QUIZS);
            $menu->addItem('Questions', 'index.php?op=Question', '../assets/images/menus/questions.png', _XQUIZ_QUESTIONS);
            $menu->addItem('Statistics', 'index.php?op=Statistics', '../assets/images/menus/statistic.png', _XQUIZ_STATISTICS);
			$menu->addItem('Permissions', 'index.php?op=Permission', '../assets/images/menus/permmision.png', _XQUIZ_PERMISSIONS);
            $menu->addItem('Preference', '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid') . '&amp;&confcat_id=1', '../assets/images/menus/config.png', _XQUIZ_PREFERENCE);
            
            if (! class_exists('XoopsTpl')) {
                include_once XOOPS_ROOT_PATH . '/class/template.php';
            }
            if (isset($xoopsTpl)) {
                $tpl = & $xoopsTpl;
            } else {
                $tpl = new XoopsTpl();
            }
            $tpl->assign('menu_css', $menu->getCSS());
            $tpl->assign('menu', $menu->render());
            $tpl->assign('quiz_version', sprintf(_XQUIZ_VERSION, $xoopsModule->getInfo('version') . '(' . $xoopsModule->getInfo('module_status') . ')', $xoopsModule->getInfo('name')));
            //$tpl->assign('xoops_version', sprintf(_XOOPS_VERSION, XOOPS_VERSION));
            $tpl->assign('php_version', sprintf(_PHP_VERSION, phpversion()));
            //$tpl->assign('mysql_version', sprintf(_MYSQL_VERSION, mysqli_get_server_info()));
            echo $tpl->fetch(XOOPS_ROOT_PATH . '/modules/xquiz/templates/admin/xquiz_adminindex.tpl');
            break;
			
			$mysql_version = substr(trim(mysql_get_server_info()), 0, 3);
    }
} catch (Exception $e) {
    redirect_header('index.php', 3, $e->getMessage());
    exit();
}

xoops_cp_footer();
