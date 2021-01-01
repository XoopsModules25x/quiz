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

use Xmf\Module\Admin;
use XoopsModules\Xquiz\{
    Category,
    Helper,
    Quiz,
    Questions,
    Utility
};
///** @var Quiz $quiz */
/** @var Helper $helper */

require dirname(__DIR__, 2) . '/mainfile.php';
$GLOBALS['xoopsOption']['template_main'] = 'xquiz_index.tpl';
require XOOPS_ROOT_PATH . '/header.php';
require_once XOOPS_ROOT_PATH . '/class/pagenav.php';
require_once XOOPS_ROOT_PATH . '/class/xoopsformloader.php';
require_once XOOPS_ROOT_PATH . '/modules/xquiz/include/common.php';
//require_once XOOPS_ROOT_PATH . '/modules/xquiz/class/quiz.php';
//require_once XOOPS_ROOT_PATH . '/modules/xquiz/class/category.php';
//require_once XOOPS_ROOT_PATH . '/modules/xquiz/class/Questions.php';

try {
    $action = $_GET ['act'] ?? '';
    if (isset($_GET ['q'])) {
        if (! is_numeric($_GET ['q'])) {
            throw new Exception(_MD_XQUIZ_NUMBER_ERROR);
        }
        $id = $_GET ['q'];
    }
    if (isset($_GET ['qi'])) {
        if (! is_numeric($_GET ['qi'])) {
            throw new Exception(_MD_XQUIZ_NUMBER_ERROR);
        }
        $pdid = $_GET ['qi'];
    }
    $start = 0;
    if (isset($_GET ['start'])) {
        if (! is_numeric($_GET ['start'])) {
            throw new Exception(_MD_XQUIZ_QUEST_SECURITY_ERROR);
        }
        $start = $_GET ['start'];
    }
    global $xoopsModuleConfig, $xoopsUser, $module_id;
    $limit = $xoopsModuleConfig ['quizUserList']; // No of records to be shown per page.
    switch ($action) {
        case 'v':
            if (isset($id)) {
                if (! Quiz::quiz_checkExistQuiz($id)) {
                    throw new Exception(_MD_XQUIZ_NOT_EXIST);
                }
                if (! Quiz::quiz_checkActiveQuiz($id)) {
                    throw new Exception(_MD_XQUIZ_NOT_STARTED);
                }
                if (! Quiz::quiz_checkExpireQuiz($id)) {
                    throw new Exception(_MD_XQUIZ_EXPIRE);
                }
                if (empty($xoopsUser)) {
                    throw new Exception(_MD_XQUIZ_REGISTER_QUIZ);
                }

                $perm_name = 'quiz_view';
                $cid = Quiz::quizCategory($id);
                if ($xoopsUser) {
                    $groups = $xoopsUser->getGroups();
                } else {
                    $groups = XOOPS_GROUP_ANONYMOUS;
                }
                $grouppermHandler = xoops_getHandler('groupperm');
                if (!$grouppermHandler->checkRight($perm_name, $cid, $groups, $module_id)) {
                    throw new Exception(_MD_XQUIZ_PERMISSION);
                }
                $ts = MyTextSanitizer::getInstance();
                $xoopsTpl->assign('showQuiz', 1);

                $qname = Quiz::quiz_quizName($id);
                $xoopsTpl->assign('quizName', $qname ['name']);
                $xoopsTpl->assign('quizDescription', $ts->previewTarea($qname ['description'], 1, 1, 1, 1, 1));

                $xoopsTpl->assign('CategoryId', $qname ['cid']);
                $xoopsTpl->assign('Category', $qname ['category']);
                /////////////////////////////////////////////////////////////
                /*
                 $listQuestion = Question::listQuestLoader ( $id );
                 if (empty ( $listQuestion ))
                    throw new Exception ( _MD_XQUIZ_NO_QUESTION );
                    $q = 0;
                    $listQuest_form = new XoopsThemeForm ( _MD_XQUIZ_QUEST_LISTQESTFORM, "listquestfrom", $_SERVER ['PHP_SELF'], 'post', true );
                    $quizId = new XoopsFormHidden ( 'quizId', $id );
                    foreach ( $listQuestion as $key ) {
                    $question_answers [$q] = new XoopsFormRadio ( $key ['qnumber'] . "-" . $ts->previewTarea ( $key ['question'], 1, 1, 1, 1, 1 ) . "" . _MD_XQUIZ_QUEST_SCORE . " = " . $key ['score'], $key ['qnumber'], null, "<hr>" );
                    $question_answers [$q]->addOption ( 1, $key ['ans1'] );
                    $question_answers [$q]->addOption ( 2, $key ['ans2'] );
                    $question_answers [$q]->addOption ( 3, $key ['ans3'] );
                    $question_answers [$q]->addOption ( 4, $key ['ans4'] );
                    $listQuest_form->addElement ( $question_answers [$q], true );
                    $q ++;
                    }
                    $quiz_token = new XoopsFormHidden ( "XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken () );
                    $submit_button = new XoopsFormButton ( "", "submit", _MD_XQUIZ_QUEST_SUBMIT, "submit" );
                    $listQuest_form->addElement ( $submit_button, true );
                    $listQuest_form->addElement ( $quizId, true );
                    $listQuest_form->addElement ( $quiz_token, true );
                    $listQuest_form->assign ( $xoopsTpl );*/
                //////////////////////////////////////////////////////////////
                $listQuestions = Questions::listQuestLoader($id);
                if (empty($listQuestions)) {
                    throw new Exception(_MD_XQUIZ_NO_QUESTION);
                }
                $q = 0;
                $listQuest_form = new XoopsThemeForm(_MD_XQUIZ_QUEST_LISTQESTFORM, 'listquestfrom', $_SERVER ['PHP_SELF'], 'post', true);
                $quizId = new XoopsFormHidden('quizId', $id);
                foreach ($listQuestions as $key) {
                    switch ($key ['question_type']) {
                        case 'MC':
                            $question_answers [$q] = new XoopsFormRadio(
                                '<b>' . $key ['qnumber'] . '.&nbsp' . $ts->previewTarea($key ['question'] . '</b>', 1, 1, 1, 1, 1) . "<span class='btn btn-primary btn-sm pull-right'>" . $key ['score'] . ' ' . _MD_XQUIZ_QUEST_MARKS . '</span>', "questAns[$q]", null, ''
                            );
                            foreach ($key ['answer'] as $ans) {
                                $question_answers [$q]->addOption($ans ['answer_id'], $ans ['answer'] . '');
                            }
                            break;

                        case 'CM':
                            $question_answers [$q] = new XoopsFormCheckBox(
                                '<b>' . $key ['qnumber'] . '.&nbsp;' . $ts->previewTarea($key ['question'] . '</b>', 1, 1, 1, 1, 1) . "<span class='btn btn-primary btn-sm pull-right'>" . $key ['score'] . ' ' . _MD_XQUIZ_QUEST_MARKS . '</span>', "questAns[$q]", null, ''
                            );
                            foreach ($key ['answer'] as $ans) {
                                $question_answers [$q]->addOption($ans ['answer_id'], $ans ['answer']);
                            }
                            break;

                        case 'FB':
                            $question_answers [$q] = new XoopsFormElementTray(
                                '<b>' . $key ['qnumber'] . '.&nbsp;' . $ts->previewTarea($key ['question'] . '</b>', 1, 1, 1, 1, 1) . "<span class='btn btn-primary btn-sm pull-right'>" . $key ['score'] . ' ' . _MD_XQUIZ_QUEST_MARKS . '</span>', '', "questAns[$q]"
                            );
                            $ansBox = [];
                            $tmp = 0;
                            foreach ($key ['answer'] as $ans) {
                                $ansBox [$tmp] = new XoopsFormText($ans ['answer'], "questAns[$q][" . $ans ['answer_id'] . ']', 15, 30);
                                $question_answers [$q]->addElement($ansBox [$tmp]);
                                $tmp ++;
                            }
                            break;
                    }
                    $questId[$q] = new XoopsFormHidden("questId[$q]", $key['question_id']);
                    $questType[$q] = new XoopsFormHidden("questType[$q]", $key['question_type']);
                    $listQuest_form->addElement($questId [$q], true);
                    $listQuest_form->addElement($questType [$q], true);
                    $listQuest_form->addElement($question_answers [$q], true);
                    $q ++;
                }
                //$quiz_token = new XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken());
                $submit_button = new XoopsFormButton('', 'submit', _MD_XQUIZ_QUEST_SUBMIT, 'submit');
                $listQuest_form->addElement($submit_button, true);
                $listQuest_form->addElement($quizId, true);
                //$listQuest_form->addElement($quiz_token, true);
                $listQuest_form->assign($xoopsTpl);

                /////////////////////////////////////////////////////////////////////////////////////////
            }
            break;

        case 's':
            $perm_name = 'quiz_view';
            $cid = Quiz::quiz_Category($id);
            if ($xoopsUser) {
                $groups = $xoopsUser->getGroups();
            } else {
                $groups = XOOPS_GROUP_ANONYMOUS;
            }
            $grouppermHandler = xoops_getHandler('groupperm');
            if (!$grouppermHandler->checkRight($perm_name, $cid, $groups, $module_id)) {
                throw new Exception(_MD_XQUIZ_PERMISSION);
            }

            if (! Quiz::quiz_checkExistQuiz($id)) {
                throw new Exception(_MD_XQUIZ_NOT_EXIST);
            }
            if (empty($xoopsUser) && (! $xoopsModuleConfig ['seeStat'])) {
                throw new Exception(_MD_XQUIZ_REGISTER_STAT);
            }

            if (Quiz::quiz_checkExpireQuiz($id)) {
                throw new Exception(_MD_XQUIZ_NOT_EXPIRE);
            }

            $perm_name = 'quiz_view';
            $cid = Quiz::quiz_Category($id);
            if ($xoopsUser) {
                $groups = $xoopsUser->getGroups();
            } else {
                $groups = XOOPS_GROUP_ANONYMOUS;
            }
            $grouppermHandler = xoops_getHandler('groupperm');
            if (!$grouppermHandler->checkRight($perm_name, $cid, $groups, $module_id)) {
                throw new Exception(_MD_XQUIZ_PERMISSION);
            }

            $xoopsTpl->assign('showQuiz', 2);
            $qname = Quiz::quiz_quizName($id);
            $xoopsTpl->assign('quizName', $qname ['name']);
            $xoopsTpl->assign('quizDescription', $qname ['description']);
            $xoopsTpl->assign('CategoryId', $qname ['cid']);
            $xoopsTpl->assign('Category', $qname ['category']);

            $eu = ($start - 0);
            $nume = Utility::numUserScore($id);
            ////////////////////////////////////////
            $listQuiz = [];
            global $xoopsModuleConfig;
            $dateformat = $xoopsModuleConfig ['dateformat'];
            $q = 1;
            $query = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('xquiz_score') . ' WHERE id = ' . $id . ' ORDER BY score DESC LIMIT ' . $eu . ' , ' . $limit);
            while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
                $listQuiz [$q] ['id'] = $myrow ['id'];
                $listQuiz [$q] ['userid'] = $myrow ['userid'];

                $thisUser = $memberHandler->getUser($myrow ['userid']);

                $listQuiz [$q] ['uname'] = $thisUser->getVar('uname');
                $listQuiz [$q] ['name'] = $thisUser->getVar('name');
                $listQuiz [$q] ['score'] = $myrow ['score'];
                $listQuiz [$q] ['date'] = formatTimestamp(strtotime($myrow ['date']), $dateformat);
                $q ++;
            }
            ////////////////////////////////////////
            $xoopsTpl->assign('quizStat', $listQuiz);
            $nav = new XoopsPageNav($nume, $limit, $start, 'start', "act=s&q=$id");
            echo "<div align='center'>" . $nav->renderImageNav() . '</div><br>';
            break;
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        case 'p':
            if (empty($xoopsUser)) {
                throw new Exception(_MD_XQUIZ_USER_PROFILE);
            }
            $user = $xoopsUser->getVar('uid');

            if (isset($pdid)) {
                $list = userQuestLoader($pdid, $user);
                $xoopsTpl->assign('showQuiz', 4);
                $xoopsTpl->assign('userid', $user);
                $xoopsTpl->assign('questProfile', $list);
            } else {
                $list = Utility::userQuizzes($user);
                $xoopsTpl->assign('showQuiz', 3);
                $xoopsTpl->assign('userid', $user);
                $xoopsTpl->assign('quizProfile', $list);
                $xoopsTpl->assign('quizProfileConfig', $xoopsModuleConfig ['seeScoreProfile']);
            }
            break;
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


        default:
            $cid = 0;
            if (isset($_GET ['cid']) && is_numeric($_GET ['cid'])) {
                $cid = $_GET ['cid'];
            }
            if ((! Category::checkExistCategory($cid)) && 0 != $cid) {
                throw new Exception(_MD_XQUIZ_NOT_EXIST);
            }
            $xt = new Category($xoopsDB->prefix('xquiz_categories'), 'cid', 'pid');

            $parentId = - 1;
            if ($cid > 0) {
                $parentId = $xt->categoryPid($cid);
            }
            $xoopsTpl->assign('Parent', $parentId);

            $listCategory = $xt->getPermChildArray($cid, 'weight asc');
            $xoopsTpl->assign('listCategory', $listCategory);
            $categoryNum = count($listCategory);
            $xoopsTpl->assign('categoryNum', $categoryNum);

            $listQuiz = Quiz::quiz_listQuizLoader($start, $limit, $cid);

            $count = 0;
            foreach ($listQuiz as $key) {
                if (1 == $key ['status']) {
                    $count ++;
                }
            }
            $nav = new XoopsPageNav($count, $limit, $start, 'start', "?cid=$cid");
            echo "<div align='center'>" . $nav->renderImageNav() . '</div><br>';
            $xoopsTpl->assign('listQuiz', $listQuiz);
            $xoopsTpl->assign('quizNum', $count);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if (isset($_POST ['submit'])) {

        //if (! $GLOBALS ['xoopsSecurity']->check ())
        //throw new Exception ( _MD_XQUIZ_QUEST_SECURITY_ERROR );

        if (empty($xoopsUser)) {
            throw new Exception(_MD_XQUIZ_REGISTER_QUIZ);
        }

        $myts          = MyTextSanitizer::getInstance();
        $quizId        = $myts->addSlashes($_POST ['quizId']);
        $user          = $xoopsUser->getVar('uid');
        $userQuizScore = Utility::findUserScore($user, $quizId);
        if ($userQuizScore) {
            throw new Exception(_MD_XQUIZ_DUPLICATE_QUIZ);
        }

        $listQuestion = Questions::listQuestLoader($quizId);
        $userScore = 0;

        echo 'Post1<pre>';
        print_r($_POST);
        echo '</pre>//////////////////////////////////';
        
        $blankAns = array_keys($_POST['questType'], 'MC');
        foreach ($blankAns as $bKeys) {
            if (!isset($_POST['questAns'][$bKeys])) {
                $_POST['questAns'][$bKeys] = '';
            }
        }
        $blankAns = array_keys($_POST['questType'], 'CM');
        foreach ($blankAns as $bKeys) {
            if (!isset($_POST['questAns'][$bKeys])) {
                $_POST['questAns'][$bKeys] = '';
            }
        }

        $postAns = array_map(null, $_POST['questId'], $_POST['questType'], $_POST['questAns']);
        echo 'Post2<pre>';
        print_r($_POST);
        echo '</pre>//////////////////////////////////';
            
        echo '<pre>';
        print_r($postAns);
        echo '</pre>';

        $sumScore = 0;
        foreach ($postAns as $key) {
            $id = $key[0];
            $type = $key[1];
            $ans = $key[2];

            $questObj = new Questions();
            $questObj->retrieveQuestion($id);
            if ($type != $questObj->getType()) {
                throw new Exception(_MD_XQUIZ_QUEST_SECURITY_ERROR);
            }

            /*echo "<pre>";
             print_r($questObj->getAnswers());
             echo "</pre>";*/
            switch ($type) {
                /////////////////////Check Fill in the blank answers/////////
                case 'FB':
                    $score = $questObj->getScore();
                    foreach ($questObj->getAnswers() as $Corrects) {
                        if ((is_array($ans)) && ($ans[$Corrects->getAid()] != $Corrects->getAnswer())) {
                            $score = 0;
                            break;
                        }
                    }
                    $sumScore += $score;
                    break;
                    /////////////////////Check Multi choise answers///////////////
                /*case 'MC':
                    $score = 0;
                    foreach ($questObj->getAnswers() as $Corrects)
                    {
                        if ( ($Corrects->getAid() == $ans) && ($Corrects->getIs_correct() == 1))
                        {
                            $score = $questObj->getScore();
                            break;
                        }
                    }
                    $sumScore += $score;
                    break;*/
                    /////////////////////Check Choose one or more answers///////////////
                /*case 'CM':
                    $score = $questObj->getScore();
                    //$corr = $questObj->getAnswers() ;
                    /* echo "<pre>";
                     print_r($corr);
                     echo "</pre>";

                     foreach ($ans as $sendAns)
                     {

                     }
                     */
                    /*
                    $cAns = array();
                    $j = 0;
                    foreach ($questObj->getAnswers() as $Corrects)
                    {
                        if ( $Corrects->getIs_correct() == 1 )
                        {
                            $cAns[$j] = $Corrects->getAid();
                            $j++;
                        }
                    }
                    if (is_array($ans))
                    {
                        $res = array_diff($ans,$cAns);
                    }
                echo count($ans) ." And ".count($cAns)."|<br>";
                    echo "Ans Is <pre>";
                    print_r($ans);
                echo "</pre><br>";
                    echo "cAns is:<pre>";
                    print_r($cAns);
                    echo "</pre>";
                    if((count($ans)== count($cAns)) && (empty($res)))
                    $sumScore += $score;
                    break;*/
            }
            echo "<br>Sum of Score :$sumScore ";
            /*$date = date ( DATE_ATOM );
             $query = "INSERT INTO " . $xoopsDB->prefix ( 'xquiz_score' ) . "
             (id ,userid ,score ,date) VALUES('$quizId','$user','$sumScore','$date')";
             $res = $xoopsDB->query ( $query );
             if (! $res)
             throw new Exception ( _MD_XQUIZ_DATABASE );
             if ($xoopsModuleConfig ['mailScore'])
             sendEmail ( $user, $sumScore, $quizId );
             $quizScore = '';
             if ($xoopsModuleConfig ['seeScore'])
             $quizScore = "<br>" . _MD_XQUIZ_FINAL_SCORE . " = " . $sumScore;
             throw new Exception ( _MD_XQUIZ_ADD_SCORE . $quizScore );*/
        }

        /*if (! $GLOBALS ['xoopsSecurity']->check ())
            throw new Exception ( _MD_XQUIZ_QUEST_SECURITY_ERROR );

            if (empty ( $xoopsUser ))
            throw new Exception ( _MD_XQUIZ_REGISTER_QUIZ );

            $myts = myTextSanitizer::getInstance ();
            $quizId = $myts->addslashes ( $_POST ['quizId'] );
            $user = $xoopsUser->getVar ( "uid" );
            $userQuizScore = findUserScore ( $user, $quizId );
            if ($userQuizScore)
            throw new Exception ( _MD_XQUIZ_DUPLICATE_QUIZ );

            $listQuestion = Question::listQuestLoader ( $quizId );
            $userScore = 0;
            $query = "INSERT INTO " . $xoopsDB->prefix ( 'xquiz_useranswers' ) . "
            (questId ,quizId ,userId ,userAns) VALUES ";
            $delim = '';
            foreach ( $listQuestion as $key ) {
            $query .= $delim;
            if (isset ( $_POST [$key ['qnumber']] )) {
            if ($myts->addslashes ( $_POST [$key ['qnumber']] ) == $key ['answer'])
            $userScore += $key ['score'];
            }
            $id = $key ['id'];
            $ans = $myts->addslashes ( $_POST [$key ['qnumber']] );
            $query .= "('$id','$quizId','$user','$ans')";
            $delim = ',';
            }
            $res = $xoopsDB->query ( $query );
            if (! $res)
            throw new Exception ( _MD_XQUIZ_DATABASE );

            $date = date ( DATE_ATOM );
            $query = "INSERT INTO " . $xoopsDB->prefix ( 'xquiz_score' ) . "
            (id ,userid ,score ,date) VALUES('$quizId','$user','$userScore','$date')";
            $res = $xoopsDB->query ( $query );
            if (! $res)
            throw new Exception ( _MD_XQUIZ_DATABASE );
            if ($xoopsModuleConfig ['mailScore'])
            sendEmail ( $user, $userScore, $quizId );
            $quizScore = '';
            if ($xoopsModuleConfig ['seeScore'])
            $quizScore = "<br>" . _MD_XQUIZ_FINAL_SCORE . " = " . $userScore;
            throw new Exception ( _MD_XQUIZ_ADD_SCORE . $quizScore );
            */
    }
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} catch (Exception $e) {
    redirect_header(XOOPS_URL . '/modules/xquiz/index.php', 3, $e->getMessage());
}

require XOOPS_ROOT_PATH . '/include/comment_view.php';
require XOOPS_ROOT_PATH . '/footer.php';
