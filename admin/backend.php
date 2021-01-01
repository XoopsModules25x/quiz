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
    Questions
};

require __DIR__ . '/admin_header.php';
//require_once XOOPS_ROOT_PATH . '/modules/xquiz/class/class.sfiles.php';

if (isset($_POST ['addQuizSubmit'])) {
    $action = 'addQuiz';
} elseif (isset($_POST ['editQuizSubmit'])) {
    $action = 'editQuiz';
} elseif (isset($_POST ['delQuizSubmit'])) {
    $action = 'delQuiz';
} elseif (isset($_POST ['addQuestSubmit'])) {
    $action = 'addQuest';
} elseif (isset($_POST ['addQstSubmit'])) {
    $action = 'addQst';
} elseif (isset($_POST ['editQstSubmit'])) {
    $action = 'editQst';
} elseif (isset($_POST ['delQstSubmit'])) {
    $action = 'delQst';
} elseif (isset($_POST ['editQuestSubmit'])) {
    $action = 'editQuest';
} elseif (isset($_POST ['delQuestSubmit'])) {
    $action = 'delQuest';
} elseif (isset($_POST ['addCateSubmit'])) {
    $action = 'addCategory';
} elseif (isset($_POST ['editCateSubmit'])) {
    $action = 'editCategory';
} elseif (isset($_POST ['delCateSubmit'])) {
    $action = 'delCategory';
}

$myts = \MyTextSanitizer::getInstance();

$maxuploadsize = $xoopsModuleConfig ['maxuploadsize'];

try {
    if (!$GLOBALS ['xoopsSecurity']->check()) {
        throw new \Exception($GLOBALS ['xoopsSecurity']->getErrors() . _AM_XQUIZ_QUEST_SECURITY_ERROR);
    }

    switch ($action) {
        case 'addQuiz':
            $name        = $_POST ['quizName'];
            $description = $_POST ['quizDesc'];
            $bdate       = $_POST ['quizBDate'] ['date'];
            $btime       = $_POST ['quizBDate'] ['time'];
            $edate       = $_POST ['quizEDate'] ['date'];
            $etime       = $_POST ['quizEDate'] ['time'];
            $weight      = $_POST ['quizWeight'];
            $categoryId  = $_POST ['quizCategory'];

            $objQuiz = new Quiz();
            $objQuiz->set_name($name);
            $objQuiz->set_description($description);
            $objQuiz->set_btime($btime);
            $objQuiz->set_etime($etime);
            $objQuiz->set_bdate($bdate);
            $objQuiz->set_edate($edate);
            $objQuiz->set_weight($weight);
            $objQuiz->set_cid($categoryId);

            $objQuiz->addQuiz();
            throw new \Exception(_AM_XQUIZ_ADD . '||?op=Quiz');
            break;

        case 'editQuiz':
            $id          = $_POST ['quizId'];
            $name        = $_POST ['quizName'];
            $description = $_POST ['quizDesc'];
            $bdate       = $_POST ['quizBDate'] ['date'];
            $btime       = $_POST ['quizBDate'] ['time'];
            $edate       = $_POST ['quizEDate'] ['date'];
            $etime       = $_POST ['quizEDate'] ['time'];
            $weight      = $_POST ['quizWeight'];
            $categoryId  = $_POST ['quizCategory'];

            $objQuiz = new Quiz();
            $objQuiz->set_id($id);
            $objQuiz->set_name($name);
            $objQuiz->set_description($description);
            $objQuiz->set_btime($btime);
            $objQuiz->set_etime($etime);
            $objQuiz->set_bdate($bdate);
            $objQuiz->set_edate($edate);
            $objQuiz->set_weight($weight);
            $objQuiz->set_cid($categoryId);

            $objQuiz->editQuiz();
            throw new \Exception(_AM_XQUIZ_EDIT . '||?op=Quiz');
            break;

        case 'delQuiz':
            $id      = $_POST ['quizId'];
            $confirm = $_POST ['delConfirm'];
            if (!$confirm) {
                throw new \Exception(_AM_XQUIZ_RETURN);
            }
            $objQuiz = new Quiz();
            $objQuiz->set_id($id);
            $objQuiz->deleteQuiz();
            throw new \Exception(_AM_XQUIZ_DELETE . '||?op=Quiz');
            break;

        case 'addQuest':
            $qid = $myts->addSlashes($_POST ['quizId']);

            if (!Quiz::quiz_checkExpireQuiz($qid)) {
                throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . '||?op=Quest');
            }
            if (Quiz::quiz_checkActiveQuiz($qid)) {
                throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . '||?op=Quest');
            }
            $question = $_POST ['questionDesc'];
            $score    = $_POST ['questionScore'];
            $ans1     = $_POST ['questionAns1'];
            $ans2     = $_POST ['questionAns2'];
            $ans3     = $_POST ['questionAns3'];
            $ans4     = $_POST ['questionAns4'];
            $answer   = $_POST ['questionAnswer'];
            $qnumber  = Question::questionNumber($qid) + 1;

            $objQuestion = new Question();
            $objQuestion->set_qid($qid);
            $objQuestion->set_question($question);
            $objQuestion->set_score($score);
            $objQuestion->set_qnumber($qnumber);
            $objQuestion->set_ans1($ans1);
            $objQuestion->set_ans2($ans2);
            $objQuestion->set_ans3($ans3);
            $objQuestion->set_ans4($ans4);
            $objQuestion->set_answer($answer);

            $objQuestion->addQuestion();
            throw new \Exception(_AM_XQUIZ_QUEST_ADD . "||?op=Quest&Id=$qid");
            break;

        case 'editQuest':
            if (isset($id)) {
                if (!Quiz::quiz_checkExpireQuiz($id)) {
                    throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . "||?op=Quest&Id=$qid");
                }
                if (Quiz::quiz_checkActiveQuiz($id)) {
                    throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . "||?op=Quest&Id=$qid");
                }
            }
            $id       = $_POST ['questionId'];
            $qid      = $_POST ['quizId'];
            $question = $_POST ['questionDesc'];
            $score    = $_POST ['questionScore'];
            $ans1     = $_POST ['questionAns1'];
            $ans2     = $_POST ['questionAns2'];
            $ans3     = $_POST ['questionAns3'];
            $ans4     = $_POST ['questionAns4'];
            $answer   = $_POST ['questionAnswer'];
            $qnumber  = $_POST ['questionNumber'];

            $objQuestion = new Question();
            $objQuestion->set_id($id);
            $objQuestion->set_qid($qid);
            $objQuestion->set_question($question);
            $objQuestion->set_score($score);
            $objQuestion->set_qnumber($qnumber);
            $objQuestion->set_ans1($ans1);
            $objQuestion->set_ans2($ans2);
            $objQuestion->set_ans3($ans3);
            $objQuestion->set_ans4($ans4);
            $objQuestion->set_answer($answer);

            $objQuestion->editQuestion();
            throw new \Exception(_AM_XQUIZ_QUEST_EDIT . "||?op=Quest&Id=$qid");
            break;

        case 'delQuest':
            $id      = $_POST ['questId'];
            $qid     = $_POST ['quizId'];
            $confirm = $_POST ['delConfirm'];
            if (!$confirm) {
                throw new \Exception(_AM_XQUIZ_RETURN . '||?op=Quest');
            }
            $objQuest = new Question();
            $objQuest->set_qid($qid);
            $objQuest->set_id($id);
            $objQuest->deleteQuestion();
            throw new \Exception(_AM_XQUIZ_QUEST_DELETE . '||?op=Quest');
            break;

        case 'addCategory':
            $title       = '';
            $imgurl      = '';
            $description = '';
            $pid         = 0;
            $weight      = 0;
            if (isset($_POST ['cateTitle'])) {
                $title = ($_POST ['cateTitle']);
            }
            if (isset($_POST ['topic_imgurl']) && '' != $_POST ['topic_imgurl']) {
                $imgurl = ($_POST ['topic_imgurl']);
            }
            if (isset($_POST ['cateDesc'])) {
                $description = $myts->previewTarea($_POST ['cateDesc']);
            }
            if (isset($_POST ['cateParent']) && is_numeric($_POST ['cateParent'])) {
                $pid = $_POST ['cateParent'];
            }
            if (isset($_POST ['cateWeight']) && is_numeric($_POST ['cateWeight'])) {
                $weight = $_POST ['cateWeight'];
            }
            if (isset($_POST ['xoops_upload_file'])) {
                $fldname = $_FILES [$_POST ['xoops_upload_file'] [0]];
                $fldname = (get_magic_quotes_gpc()) ? stripslashes($fldname ['name']) : $fldname ['name'];
                if (xoops_trim('' != $fldname)) {
                    $sfiles         = new Files();
                    $dstpath        = XOOPS_ROOT_PATH . '/uploads/' . $xoopsModule->dirname() . '/category';
                    $destname       = $sfiles->createUploadName($dstpath, $fldname, true);
                    $permittedtypes = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'];
                    $uploader       = new \XoopsMediaUploader($dstpath, $permittedtypes, $maxuploadsize);
                    $uploader->setTargetFileName($destname);
                    if ($uploader->fetchMedia($_POST ['xoops_upload_file'] [0])) {
                        if ($uploader->upload()) {
                            $imgurl = basename($destname);
                        } else {
                            throw new \Exception(_AM_XQUIZ_UPLOAD_ERROR . ' ' . $uploader->getErrors() . '||?op=Category');
                        }
                    } else {
                        throw new \Exception($uploader->getErrors() . '||?op=Category');
                    }
                }
            }
            $newCid = Category::addCategory($title, $pid, $description, $imgurl, $weight);
            // Permissions
            $grouppermHandler = xoops_getHandler('groupperm');
            if (isset($_POST ['groups_quiz_can_view'])) {
                foreach ($_POST ['groups_quiz_can_view'] as $onegroup_id) {
                    $grouppermHandler->addRight('quiz_view', $newCid, $onegroup_id, $xoopsModule->getVar('mid'));
                }
            }
            throw new \Exception(_AM_XQUIZ_ADD_CATEGORY . '||?op=Category');
            break;

        case 'editCategory':
            $title       = '';
            $imgurl      = '';
            $description = '';
            $pid         = 0;
            $weight      = 0;
            $cid         = 0;
            if (isset($_POST ['cateTitle'])) {
                $title = ($_POST ['cateTitle']);
            }
            if (isset($_POST ['topic_imgurl']) && '' != $_POST ['topic_imgurl']) {
                $imgurl = ($_POST ['topic_imgurl']);
            }
            if (isset($_POST ['cateDesc'])) {
                $description = ($_POST ['cateDesc']);
            }
            if (isset($_POST ['cateParent']) && is_numeric($_POST ['cateParent'])) {
                $pid = $_POST ['cateParent'];
            }
            if (isset($_POST ['cateWeight']) && is_numeric($_POST ['cateWeight'])) {
                $weight = $_POST ['cateWeight'];
            }
            if (isset($_POST ['cateId']) && is_numeric($_POST ['cateId'])) {
                $cid = $_POST ['cateId'];
            } else {
                throw new \Exception(_AM_XQUIZ_QUEST_SECURITY_ERROR . '||?op=Category');
            }
            if (isset($_POST ['xoops_upload_file'])) {
                $fldname = $_FILES [$_POST ['xoops_upload_file'] [0]];
                $fldname = (get_magic_quotes_gpc()) ? stripslashes($fldname ['name']) : $fldname ['name'];
                if (xoops_trim('' != $fldname)) {
                    $sfiles         = new Files();
                    $dstpath        = XOOPS_ROOT_PATH . '/uploads/' . $xoopsModule->dirname() . '/category';
                    $destname       = $sfiles->createUploadName($dstpath, $fldname, true);
                    $permittedtypes = ['image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png', 'image/png'];
                    $uploader       = new \XoopsMediaUploader($dstpath, $permittedtypes, $maxuploadsize);
                    $uploader->setTargetFileName($destname);
                    if ($uploader->fetchMedia($_POST ['xoops_upload_file'] [0])) {
                        if ($uploader->upload()) {
                            $imgurl = basename($destname);
                        } else {
                            throw new \Exception(_AM_XQUIZ_UPLOAD_ERROR . ' ' . $uploader->getErrors() . '||?op=Category');
                        }
                    } else {
                        throw new \Exception($uploader->getErrors() . '||?op=Category');
                    }
                }
            }
            Category::editCategory($cid, $title, $pid, $description, $imgurl, $weight);
            // Permissions
            $grouppermHandler = xoops_getHandler('groupperm');
            if (isset($_POST ['groups_quiz_can_view'])) {
                foreach ($_POST ['groups_quiz_can_view'] as $onegroup_id) {
                    $grouppermHandler->addRight('quiz_view', $cid, $onegroup_id, $xoopsModule->getVar('mid'));
                }
            }
            throw new \Exception(_AM_XQUIZ_EDIT_CATEGORY . '||?op=Category');
            break;

        case 'delCategory':
            $confirm = $_POST ['delConfirm'];
            if (!$confirm) {
                throw new \Exception(_AM_XQUIZ_RETURN . '||?op=Category');
            }
            if (isset($_POST ['categoryId']) && is_numeric($_POST ['categoryId'])) {
                $cid = $_POST ['categoryId'];
            }
            Category::deleteCategory($cid);
            throw new \Exception(_AM_XQUIZ_DELETE_CATEGORY . '||?op=Category');
            break;

        case 'addQst':
            $qid = $myts->addSlashes($_POST ['quizId']);

            if (!Quiz::quiz_checkExpireQuiz($qid)) {
                throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . "||?op=Quest&Id=$qid");
            }
            if (Quiz::quiz_checkActiveQuiz($qid)) {
                throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . "||?op=Quest&Id=$qid");
            }
            $question = $_POST ['questionDesc'];
            $score    = $_POST ['questionScore'];
            $type     = $_POST ['type'];
            $qnumber  = $_POST ['questionNumber'];

            $obj = new Questions();
            $obj->setQid($qid);
            $obj->setQnumber($qnumber);
            $obj->setScore($score);
            $obj->setQuestion($question);
            $obj->setType($type);
            $obj->addQuestion($_POST ['answers'], $_POST ['corrects']);

            throw new \Exception(_AM_XQUIZ_QUEST_ADD . "||?op=Question&Id=$qid");
            break;
        case 'editQst':
            if (isset($id)) {
                if (!Quiz::quiz_checkExpireQuiz($id)) {
                    throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . "||?op=Question&Id=$qid");
                }
                if (Quiz::quiz_checkActiveQuiz($id)) {
                    throw new \Exception(_AM_XQUIZ_QUEST_ADD_RULE . "||?op=Question&Id=$qid");
                }
            }
            $id       = $_POST ['questionId'];
            $qid      = $_POST ['quizId'];
            $question = $_POST ['questionDesc'];
            $score    = $_POST ['questionScore'];
            $qnumber  = $_POST ['questionNumber'];
            $qtype    = $_POST ['type'];

            $questionObj = new Questions();
            $questionObj->setId($id);
            $questionObj->setQid($qid);
            $questionObj->setQuestion($question);
            $questionObj->setScore($score);
            $questionObj->setQnumber($qnumber);
            $questionObj->setType($qtype);
            $questionObj->editQuestion($_POST ['answers'], $_POST ['corrects']);

            throw new \Exception(_AM_XQUIZ_QUEST_EDIT . "||?op=Question&Id=$qid");
            break;

        case 'delQst':
            $id      = $_POST ['questId'];
            $qid     = $_POST ['quizId'];
            $confirm = $_POST ['delConfirm'];
            if (!$confirm) {
                throw new \Exception(_AM_XQUIZ_RETURN . '||?op=Question');
            }
            $objQuest = new Questions();
            $objQuest->setQid($qid);
            $objQuest->setId($id);
            $objQuest->deleteQuestion();
            throw new \Exception(_AM_XQUIZ_QUEST_DELETE . '||?op=Question');
            break;

        default:
            echo $action;
    }
} catch (Exception $e) {
    $arr = explode('||', $e->getMessage(), 2);
    redirect_header(XOOPS_URL . '/modules/xquiz/admin/index.php' . $arr [1], 3, $arr [0]);
}
