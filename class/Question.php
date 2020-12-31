<?php

namespace XoopsModules\Xquiz;

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

require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

/**
 * Class Question
 * @package XoopsModules\Xquiz
 */
class Question
{
    private $id;
    private $qid;
    private $question;
    private $qnumber;
    private $score;
    private $ans1;
    private $ans2;
    private $ans3;
    private $ans4;
    private $answer;

    public function __construct()
    {
        $this->myts = \MyTextSanitizer::getInstance();
    }

    // set and get $id

    /**
     * @param $id
     * @throws \Exception
     */
    public function set_id($id)
    {
        if (!is_numeric($id)) {
            throw new \Exception('id ' . _AM_XQUIZ_QUEST_NUMBER_ERROR);
        }
        $this->id = $id;
    }

    public function get_id()
    {
        if (!isset($this->id)) {
            throw new \Exception('id ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->id;
    }
    
    // set and get $qid
    /**
     * @param $id
     * @throws \Exception
     */
    public function set_qid($id)
    {
        if (!is_numeric($id)) {
            throw new \Exception('qid ' . _am_XQUIZ_QUEST_NUMBER_ERROR);
        }
        $this->qid = $id;
    }

    public function get_qid()
    {
        if (!isset($this->qid)) {
            throw new \Exception('qid ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->qid;
    }
    
    // set and get $question
    /**
     * @param $question
     */
    public function set_question($question)
    {
        $this->question = $this->myts->addSlashes($question);
    }

    public function get_question()
    {
        if (!isset($this->question)) {
            throw new \Exception('question ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->question;
    }
    
    // set and get $qnumber
    /**
     * @param $qnumber
     * @throws \Exception
     */
    public function set_qnumber($qnumber)
    {
        if (!is_numeric($qnumber)) {
            throw new \Exception(_AM_XQUIZ_QUEST_NUMBER_ERROR);
        }
        $this->qnumber = $qnumber;
    }

    public function get_qnumber()
    {
        if (!isset($this->qnumber)) {
            throw new \Exception('qnumber ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->qnumber;
    }
    
    // set and get $ans1
    /**
     * @param $ans1
     */
    public function set_ans1($ans1)
    {
        $this->ans1 = $this->myts->addSlashes($ans1);
    }

    public function get_ans1()
    {
        if (!isset($this->ans1)) {
            throw new \Exception('answer1 ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->ans1;
    }
    
    // set and get $ans2
    /**
     * @param $ans2
     */
    public function set_ans2($ans2)
    {
        $this->ans2 = $this->myts->addSlashes($ans2);
    }

    public function get_ans2()
    {
        if (!isset($this->ans2)) {
            throw new \Exception('answer2 ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->ans2;
    }
    
    // set and get $ans3
    /**
     * @param $ans3
     */
    public function set_ans3($ans3)
    {
        $this->ans3 = $this->myts->addSlashes($ans3);
    }

    public function get_ans3()
    {
        if (!isset($this->ans3)) {
            throw new \Exception('answer3 ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->ans3;
    }
    
    // set and get $ans4
    /**
     * @param $ans4
     */
    public function set_ans4($ans4)
    {
        $this->ans4 = $this->myts->addSlashes($ans4);
    }

    public function get_ans4()
    {
        if (!isset($this->ans4)) {
            throw new \Exception('answer4 ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->ans4;
    }
    
    // set and get $answer
    /**
     * @param $answer
     */
    public function set_answer($answer)
    {
        $this->answer = $this->myts->addSlashes($answer);
    }

    public function get_answer()
    {
        if (!isset($this->answer)) {
            throw new \Exception('answer ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->answer;
    }
    
    // set and get $score
    /**
     * @param $score
     * @throws \Exception
     */
    public function set_score($score)
    {
        if (!is_numeric($score)) {
            throw new \Exception(_AM_XQUIZ_QUEST_NUMBER_ERROR);
        }
        $this->score = $score;
    }

    public function get_score()
    {
        if (!isset($this->score)) {
            throw new \Exception('score ' . _AM_XQUIZ_QUEST_SET_ERROR);
        }
        return $this->score;
    }
    

    // load number of question from database
    /**
     * @param $qId
     * @return int
     */
    public static function question_numQuestionLoader($qId)
    {
        global $xoopsDB;
        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_quizquestion') . " WHERE qid = $qId");
        return $xoopsDB->getRowsNum($result);
    }
    

    // load questions from database
    /**
     * @param $eu
     * @param $limit
     * @param $qid
     * @return array
     */
    public static function question_listQuestionLoader($eu, $limit, $qid)
    {
        global $xoopsDB;
        $listQuiz = [];
        $q        = 1;
        $query    = $xoopsDB->query(
            ' SELECT * FROM ' . $xoopsDB->prefix('xquiz_quizquestion') . ' WHERE qid = ' . $qid . ' LIMIT ' . $eu . ' , ' . $limit
        );
        while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
            $listQuiz[$q]['id']       = $myrow['id'];
            $listQuiz[$q]['qid']      = $myrow['qid'];
            $listQuiz[$q]['question'] = $myrow['question'];
            $listQuiz[$q]['qnumber']  = $myrow['qnumber'];
            $listQuiz[$q]['score']    = $myrow['score'];
            $listQuiz[$q]['ans1']     = $myrow['ans1'];
            $listQuiz[$q]['ans2']     = $myrow['ans2'];
            $listQuiz[$q]['ans3']     = $myrow['ans3'];
            $listQuiz[$q]['ans4']     = $myrow['ans4'];
            $listQuiz[$q]['answer']   = $myrow['answer'];
            $q++;
        }
        return $listQuiz;
    }
    
    // retrieve question from database
    /**
     * @param $eId
     * @return array|false
     */
    public static function retrieveQuestion($eId)
    {
        global $xoopsDB;
        $query = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_quizquestion') . " WHERE id = '$eId'");
        $myrow = $xoopsDB->fetchArray($query);
        return $myrow;
    }
    

    // List question and show in breaking page
    /**
     * @param $start
     * @param $limit
     * @param $qid
     */
    public static function showQuestions($start, $limit, $qid)
    {
        $nume = self::question_numQuestionLoader($qid);

        $listQuestion = self::question_listQuestionLoader($start, $limit, $qid);
        Utility::collapsableBar('newsub', 'topnewsubicon');
        $temp = "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewsubicon' name='topnewsubicon' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 </a>&nbsp;" . _AM_XQUIZ_QUESTIONS . "</h4><br>
					<div id='newsub' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
					<tr class='bg3'>
					    <th>
							" . _AM_XQUIZ_QUEST_NUM . '
						</th>
						<th>
							' . _AM_XQUIZ_QUEST_NAME . '
						</th>
						<th>
							' . _AM_XQUIZ_QUEST_CORRECT . '
						</th>
						<th>
							' . _AM_XQUIZ_QUEST_SCORE . '
						</th>
						<th>
							' . _AM_XQUIZ_ACTION . '
						</th>
					</tr>';

        $class = 'even';

        $delImage  = '<img src= "' . XOOPS_URL . '/modules/xquiz/assets/images/delete.png " title=' . _AM_XQUIZ_DEL . " alt='' >";
        $editImage = '<img src= "' . XOOPS_URL . '/modules/xquiz/assets/images/edit.png " title=' . _AM_XQUIZ_EDIT . " alt='' >";
        $ts        = \MyTextSanitizer::getInstance();
        foreach ($listQuestion as $key) {
            $class = ('even' == $class) ? 'odd' : 'even';

            $temp .= "
			<tr class='" . $class . "'>
			    <td>
					" . $key['qnumber'] . '
				</td>
				<td>
					' . $ts->previewTarea($key['question'], 1, 1, 1, 1, 1) . '
				</td>
				<td>
				' . $key['answer'] . '
				</td>
				<td>
				' . $key['score'] . '
				</td>
				<td>
				<a href="' . XOOPS_URL . '/modules/xquiz/admin/main.php?op=Quest&act=del&Id=' . $key['id'] . '&qId=' . $key['qid'] . '">
				' . $delImage . '
				</a>
				<a href="' . XOOPS_URL . '/modules/xquiz/admin/main.php?op=Quest&act=edit&Id=' . $key['id'] . '&qId=' . $key['qid'] . '">
				' . $editImage . '
				</a>
				</td>
				</tr>';
        }

        $temp .= '</table></div>';
        echo $temp;
        $nav = new \XoopsPageNav($nume, $limit, $start, 'start', "op=Quest&Id=$qid");
        echo "<div align='center'>" . $nav->renderImageNav() . '</div><br>';
    }
    
    // show select quiz form
    public static function showQuizSelectForm()
    {
        $list = Quiz::allQuizs();

        echo "<div id='newsel' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<form method='get' action='main.php' onchange=\"MM_jumpMenu('parent',this,0)\">
								<input type='hidden' name='op' value='Quest'>
								<label>" . _AM_XQUIZ_QUIZS_SELECT . "
									<select name='Id'>";
        foreach ($list as $key) {
            echo "<option value='" . $key['id'] . "'>" . $key['name'] . '</option>';
        }

        echo "						</select>
								</lable>
								<input type='submit' value='" . _AM_XQUIZ_QUESTION_GO . "'>
							</form>
							</td>
							<td>
							<form method='get' action='main.php'>
							<input type='hidden' name='op' value='Quest'>
							<input type='hidden' name='act' value='add'>
							<label>" . _AM_XQUIZ_QUIZS_SELECT . "
									<select name='Id'>";
        foreach ($list as $key) {
            echo "<option value='" . $key['id'] . "'>" . $key['name'] . '</option>';
        }

        echo "						</select>
							</lable>
							<input type='submit' value='" . _AM_XQUIZ_NEW_QUEST . "'>
							</form>
							</td>							
						</tr>
					</table>
				</div>";
    }
    
    // show question add & edit form
    /**
     * @param        $qId
     * @param string $op
     * @param int    $eId
     */
    public static function QuestForm($qId, $op = 'add', $eId = 0)
    {
        $addQuest_form = new \XoopsThemeForm(

            _AM_QUEST_FORM,

            'addquestfrom', XOOPS_URL . '/modules/xquiz/admin/backend.php',

            'post',

            true

        );

        if ('edit' == $op) {
            $question            = self::retrieveQuestion($eId);
            $question_id_v       = $question['id'];
            $question_qid_v      = $question['qid'];
            $question_question_v = $question['question'];
            $question_qnumber_v  = $question['qnumber'];
            $question_score_v    = $question['score'];
            $question_ans1_v     = $question['ans1'];
            $question_ans2_v     = $question['ans2'];
            $question_ans3_v     = $question['ans3'];
            $question_ans4_v     = $question['ans4'];
            $question_answer_v   = $question['answer'];

            $question_id = new \XoopsFormHidden('questionId', $question_id_v);
            $addQuest_form->addElement($question_id);
            $question_number = new \XoopsFormText(_AM_XQUIZ_QUEST_TOTAL, 'questionNumber', 5, 3, $question_qnumber_v);
            $addQuest_form->addElement($question_number);

            $submit_button = new \XoopsFormButton('', 'editQuestSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        } elseif ('add' == $op) {
            $question_id_v       = '';
            $question_qid_v      = $qId;
            $question_question_v = '';
            $question_qnumber_v  = '';
            $question_score_v    = '';
            $question_ans1_v     = '';
            $question_ans2_v     = '';
            $question_ans3_v     = '';
            $question_ans4_v     = '';
            $question_answer_v   = '';

            $submit_button = new \XoopsFormButton('', 'addQuestSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        }
        $quest_list_array_v = Quiz::quiz_listQuizArray();

        $quiz_name = new \XoopsFormSelect(_AM_XQUIZ_NAME, 'quizId', $question_qid_v);
        $quiz_name->addOptionArray($quest_list_array_v);//$option = array(id=>'name');

        $question_score = new \XoopsFormText(_AM_XQUIZ_QUEST_SCORE, 'questionScore', 15, 5, $question_score_v);
        //$question_description = new \XoopsFormDhtmlTextArea(_MD_XQUIZ_QUEST_DESC, "questionDesc", $question_question_v);

        global $xoopsModuleConfig;
        $options_tray = new \XoopsFormElementTray(_AM_XQUIZ_QUEST_DESC, '<br>');
        if (class_exists('XoopsFormEditor')) {
            $options['name']   = 'questionDesc';
            $options['value']  = $question_question_v;
            $options['rows']   = 25;
            $options['cols']   = '100%';
            $options['width']  = '100%';
            $options['height'] = '600px';
            $contents_contents = new \XoopsFormEditor('', $xoopsModuleConfig['editorUser'], $options, $nohtml = false, $onfailure = 'textarea');
            $options_tray->addElement($contents_contents);
        } else {
            $contents_contents = new \XoopsFormDhtmlTextArea(_AM_XQUIZ_QUEST_DESC, 'questionDesc', $question_question_v);
            $options_tray->addElement($contents_contents);
        }

        $question_ans1 = new \XoopsFormText(_AM_XQUIZ_QUEST_ANS1, 'questionAns1', 50, 100, $question_ans1_v);
        $question_ans2 = new \XoopsFormText(_AM_XQUIZ_QUEST_ANS2, 'questionAns2', 50, 100, $question_ans2_v);
        $question_ans3 = new \XoopsFormText(_AM_XQUIZ_QUEST_ANS3, 'questionAns3', 50, 100, $question_ans3_v);
        $question_ans4 = new \XoopsFormText(_AM_XQUIZ_QUEST_ANS4, 'questionAns4', 50, 100, $question_ans4_v);

        $question_answer = new \XoopsFormRadio(_AM_XQUIZ_QUEST_ANSWER, 'questionAnswer', $question_answer_v, ' | ');
        $temp            = [1 => _AM_XQUIZ_QUEST_ANS1, 2 => _AM_XQUIZ_QUEST_ANS2, 3 => _AM_XQUIZ_QUEST_ANS3, 4 => _AM_XQUIZ_QUEST_ANS4];
        $question_answer->addOptionArray($temp);//$temp = array(value=>'name');
        //$question_token = new \XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS['xoopsSecurity']->createToken());

        $addQuest_form->addElement($quiz_name, true);
        $addQuest_form->addElement($options_tray);
        $addQuest_form->addElement($question_ans1, true);
        $addQuest_form->addElement($question_ans2, true);
        $addQuest_form->addElement($question_ans3, true);
        $addQuest_form->addElement($question_ans4, true);
        $addQuest_form->addElement($question_answer, true);
        $addQuest_form->addElement($question_score, true);
        //$addQuest_form->addElement($question_token, true);
        $addQuest_form->addElement($submit_button, true);

        Utility::collapsableBar('newquiz', 'topnewquiz');
        echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 	</a>&nbsp;" . _AM_XQUIZ_QUEST_NEW . "</h4><br>
						<div id='newquiz' style='text-align: center;'>";
        $addQuest_form->display();
        echo '</div>';
    }
    
    // check exist question in database
    /**
     * @return bool
     */
    public function checkExistQuestion()
    {
        global $xoopsDB;
        $query = $xoopsDB->query(
            'SELECT * FROM ' . $xoopsDB->prefix('xquiz_quizquestion') . "
		 WHERE qid = '$this->qid' AND question LIKE '$this->question'"
        );
        $res   = $xoopsDB->getRowsNum($query);
        if ($res > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    // add new question into database
    public function addQuestion()
    {
        if ($this->checkExistQuestion()) {
            throw new \Exception(_AM_XQUIZ_QUEST_EXIST);
        }

        global $xoopsDB;
        $query = 'Insert into ' . $xoopsDB->prefix('xquiz_quizquestion') . "
				(id,qid,question,qnumber,score,ans1,ans2,ans3,ans4,answer)
				VALUES (NULL , '$this->qid', '$this->question','$this->qnumber',
				'$this->score', '$this->ans1', '$this->ans2', '$this->ans3',
				'$this->ans4','$this->answer');";

        $res = $xoopsDB->query($query);

        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
    }

    
    // delete question from database
    public function deleteQuestion()
    {
        global $xoopsDB;
        $query = 'DELETE FROM ' . $xoopsDB->prefix('xquiz_quizquestion') . " WHERE  
					  id = '$this->id' ";
        $res   = $xoopsDB->query($query);

        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
    }
    
    // edit question
    public function editQuestion()
    {
        global $xoopsDB;
        $query = 'UPDATE ' . $xoopsDB->prefix('xquiz_quizquestion') . " SET 
					  qid = '$this->qid'
					 ,question = '$this->question'
					 ,qnumber = '$this->qnumber'
					 ,score = '$this->score'
					 ,ans1 = '$this->ans1'
					 ,ans2 = '$this->ans2'
					 ,ans3 = '$this->ans3'
					 ,ans4 = '$this->ans4'
					 ,answer = '$this->answer'
					 WHERE id = '$this->id' ";
        $res   = $xoopsDB->query($query);

        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
    }
    
    // number of question
    /**
     * @param $quizId
     * @return mixed
     */
    public static function questionNumber($quizId)
    {
        global $xoopsDB;
        $query = $xoopsDB->query('SELECT COUNT(qid) AS CID FROM ' . $xoopsDB->prefix('xquiz_quizquestion') . " WHERE qid = '$quizId'");
        $myrow = $xoopsDB->fetchArray($query);
        return $myrow['CID'];
    }
    
    // create confirm form for delete question
    /**
     * @param $id
     */
    public static function confirmForm($id)
    {
        $delQuest_form = new \XoopsThemeForm(
            _AM_XQUIZ_DELQUESTFORM, 'delquestfrom', XOOPS_URL . '/modules/xquiz/admin/backend.php', 'post', true
        );
        $quest_id      = new \XoopsFormHidden('questId', $id);
        $quiz_id       = new \XoopsFormHidden('quizId', $qid);
        $quest_confirm = new \XoopsFormRadioYN(_AM_XQUIZ_DELETE_CAPTION, 'delConfirm', 0);
        $submit_button = new \XoopsFormButton('', 'delQuestSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        //$quest_token = new \XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS['xoopsSecurity']->createToken());

        $delQuest_form->addElement($quest_id);
        //$delQuest_form->addElement($quest_token, true);
        $delQuest_form->addElement($quest_confirm, true);
        $delQuest_form->addElement($submit_button);

        Utility::collapsableBar('newquiz', 'topnewquiz');
        echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 	</a>&nbsp;" . _AM_XQUIZ_DELETE . "</h4><br>
						<div id='newquiz' style='text-align: center;'>";
        $delQuest_form->display();
        echo '</div>';
    }

    #end region

    /**
     * @param $qId
     * @return array
     */
    public static function listQuestLoader($qId)
    {
        global $xoopsDB;
        $listQuest = [];
        $q         = 1;
        $query     = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('xquiz_quizquestion') . " WHERE qid = '$qId' ORDER BY 'qnumber' ASC");
        while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
            $listQuest[$q]['id']       = $myrow['id'];
            $listQuest[$q]['qid']      = $myrow['qid'];
            $listQuest[$q]['question'] = $myrow['question'];
            $listQuest[$q]['qnumber']  = $myrow['qnumber'];
            $listQuest[$q]['score']    = $myrow['score'];
            $listQuest[$q]['ans1']     = $myrow['ans1'];
            $listQuest[$q]['ans2']     = $myrow['ans2'];
            $listQuest[$q]['ans3']     = $myrow['ans3'];
            $listQuest[$q]['ans4']     = $myrow['ans4'];
            $listQuest[$q]['answer']   = $myrow['answer'];
            $q++;
        }
        return $listQuest;
    }
}
