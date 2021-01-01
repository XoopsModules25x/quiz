<?php

namespace XoopsModules\Xquiz;

require_once XOOPS_ROOT_PATH . '/class/pagenav.php';

/**
 * Class Questions
 * @package XoopsModules\Xquiz
 */
class Questions
{
    /**
     *
     */

    private       $id;
    private       $qid;
    private       $qnumber;
    private       $type;
    private       $question;
    private       $score;
    private       $answers;
    public static $qTypes = ['MC' => _AM_XQUIZ_ANSWER_TYPE_MC, 'CM' => _AM_XQUIZ_ANSWER_TYPE_CM, 'FB' => _AM_XQUIZ_ANSWER_TYPE_FB];

    /**
     * @return array
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getQid()
    {
        return $this->qid;
    }

    /**
     * @return int
     */
    public function getQnumber()
    {
        return $this->qnumber;
    }

    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @return int
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     */
    public function setAnswers()
    {
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = (int)$id;
    }

    /**
     * @param int $qid
     */
    public function setQid($qid)
    {
        $this->qid = (int)$qid;
    }

    /**
     * @param int $qnumber
     */
    public function setQnumber($qnumber)
    {
        $this->qnumber = (int)$qnumber;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        //$this->question = $xoopsDB->escape($question);
        $this->question = $question;
    }

    /**
     * @param int $score
     */
    public function setScore($score)
    {
        $this->score = (int)$score;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        //$this->type = $xoopsDB->escape($type);
        $this->type = $type;
    }

    public function __construct()
    {
        //TODO - Insert your code here
        $this->answers = [];
    }

    /**
     *
     */
    public function __destruct()
    {
        //TODO - Insert your code here
    }

    /*
     * List question from database
     * @param int $eu
     * @param int $qid
     * @param int $limit
     * @return array
     * @TODO List questions from database for specific quiz
     */
    /**
     * @param $eu
     * @param $limit
     * @param $qid
     * @return array
     */
    public static function questions_list($eu, $limit, $qid)
    {
        global $xoopsDB;
        $listQuiz = [];
        $q        = 1;
        $query    = $xoopsDB->query(' SELECT * FROM ' . $xoopsDB->prefix('xquiz_questions') . ' WHERE quiz_id = ' . $qid . ' LIMIT ' . $eu . ' , ' . $limit);
        while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
            $listQuiz [$q] ['id']       = $myrow ['question_id'];
            $listQuiz [$q] ['qid']      = $myrow ['quiz_id'];
            $listQuiz [$q] ['question'] = $myrow ['question'];
            $listQuiz [$q] ['qnumber']  = $myrow ['qnumber'];
            $listQuiz [$q] ['score']    = $myrow ['score'];
            $listQuiz [$q] ['type']     = $myrow ['question_type'];
            $q++;
        }
        return $listQuiz;
    }

    /*
     * Number of all question
     * @param int $qid
     * @return int
     * @TODO Number of questions in database
     */
    /**
     * @param $qId
     * @return int
     */
    public static function questions_numOfQuestions($qId)
    {
        global $xoopsDB;
        $result = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_questions') . " WHERE quiz_id = $qId");
        return $xoopsDB->getRowsNum($result);
    }

    /*
     * show questions list
     * @param int $start
     * @param int $qid
     * @param int $limit
     * @return array
     * @TODO show questions list
     */
    /**
     * @param $start
     * @param $limit
     * @param $qid
     */
    public static function showQuestions($start, $limit, $qid)
    {
        $nume         = self::questions_numOfQuestions($qid);
        $listQuestion = [];
        $listQuestion = self::questions_list($start, $limit, $qid);

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
							' . _AM_XQUIZ_QUEST_SCORE . '
						</th>					
						<th>
							' . _AM_XQUIZ_ANSWER_TYPE . '
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
					" . $key ['qnumber'] . '
				</td>
				<td>
					' . $ts->previewTarea($key['question'], 1, 1, 1, 1, 1) . '
				</td>
				<td>
				' . $key ['score'] . '
				</td>
				
				<td>
				' . self::$qTypes [$key ['type']] . '
				</td>
				<td>
				<a href="' . XOOPS_URL . '/modules/xquiz/admin/main.php?op=Question&act=del&Id=' . $key ['id'] . '&qId=' . $key ['qid'] . '">
				' . $delImage . '
				</a>
				<a href="' . XOOPS_URL . '/modules/xquiz/admin/main.php?op=Question&act=edit&Id=' . $key ['id'] . '&qId=' . $key ['qid'] . '">
				' . $editImage . '
				</a>
				</td>
				</tr>';
        }

        $temp .= '</table></div>';
        echo $temp;
        $nav = new \XoopsPageNav($nume, $limit, $start, 'start', "op=Question&Id=$qid");
        echo "<div align='center'>" . $nav->renderImageNav() . '</div><br>';
    }

    /*
     * @TODO add question form
     * @para Integer $quizId
     * @para String $type
     * @return string
     */
    /**
     * @param        $qId
     * @param string $type
     */
    public static function QuestAddForm($qId, $type = 'MC')
    {
        $addQuest_form = new \XoopsThemeForm(_AM_QUEST_FORM, 'addquestfrom', XOOPS_URL . '/modules/xquiz/admin/backend.php', 'post', true);

        $question_qid_v      = $qId;
        $question_question_v = '';
        $question_number_v   = self::questionNumber($qId) + 1;

        $submit_button      = new \XoopsFormButton('', 'addQstSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        $quest_list_array_v = Quiz::quiz_listQuizArray();
        $quiz_name          = new \XoopsFormSelect(_AM_XQUIZ_NAME, 'quizId', $question_qid_v);
        $quiz_name->addOptionArray($quest_list_array_v);
        $question_number = new \XoopsFormText(_AM_XQUIZ_QUEST_TOTAL, 'questionNumber', 15, 5, $question_number_v);
        $question_score  = new \XoopsFormText(_AM_XQUIZ_QUEST_SCORE, 'questionScore', 15, 5);
        global $xoopsModuleConfig;
        $options_tray = new \XoopsFormElementTray(_AM_XQUIZ_QUEST_DESC, '<br>');
        if (class_exists('XoopsFormEditor')) {
            $options ['name']   = 'questionDesc';
            $options ['value']  = $question_question_v;
            $options ['rows']   = 15;
            $options ['cols']   = '100%';
            $options ['width']  = '100%';
            $options ['height'] = '400px';
            $contents_contents  = new \XoopsFormEditor('', $xoopsModuleConfig ['editorUser'], $options);
            $options_tray->addElement($contents_contents);
        } else {
            $contents_contents = new \XoopsFormDhtmlTextArea(_MD_XQUIZ_QUEST_DESC, 'questionDesc', $question_question_v);
            $options_tray->addElement($contents_contents);
        }
        switch ($type) {
            case 'CM':
                $cor_val = 'checkbox';
                $thead   = '<th>' . _AM_XQUIZ_QUEST_ANSWER . '</th>';
                break;
            case 'FB':
                $cor_val = 'blank';
                break;
            default:
                $cor_val = 'radio';
                $thead   = '<th>' . _AM_XQUIZ_QUEST_ANSWER . '</th>';
        }
        ob_start();
        $addImage = '<img src= "' . XOOPS_URL . '/modules/xquiz/assets/images/Add_Ans.png " title=' . _AM_XQUIZ_ADD_ANSWER . '>';
        echo "<script type='text/javascript' src='" . XOOPS_URL . "/modules/xquiz/assets/js/table.js'></script>
			<table width='100%' cellspacing='1' cellpadding='3' border='0' id='tblQuiz' >
				<thead>
					<tr>
						<th colspan='5'>
						$addImage
						<input type='button' value='" . _AM_XQUIZ_ADD_ANSWER . "' onclick='xquiz_addRowToTable(null,\"$cor_val\");'>
						</th>
					</tr>
					<tr>
						<th>#</th>
						$thead
						<th>" . _AM_XQUIZ_ANSWER_TEXT . '</th>
						<th>' . _AM_XQUIZ_DELET_ANS . '</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>';

        $ansFormTable = new \XoopsFormLabel(_AM_XQUIZ_ANSWERS_LABEL, ob_get_clean());

        $question_type = new \XoopsFormHidden('type', $type);
        //$question_token = new \XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken());

        $addQuest_form->addElement($quiz_name, true);
        $addQuest_form->addElement($question_number, true);

        $addQuest_form->addElement($options_tray);
        $addQuest_form->addElement($ansFormTable);
        //$addQuest_form->addElement($question_token, true);
        $addQuest_form->addElement($question_type, true);
        $addQuest_form->addElement($question_score, true);
        $addQuest_form->addElement($submit_button, true);

        Utility::collapsableBar('newquiz', 'topnewquiz');
        echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 	</a>&nbsp;" . _AM_XQUIZ_QUEST_NEW . "</h4><br>
						<div id='newquiz' style='text-align: center;'>";
        $addQuest_form->display();
        echo '</div>';
    }

    /*
     * @TODO edit question form
     * @para Integer $questId
     * @return string
     */
    /**
     * @param $questId
     */
    public function QuestEditForm($questId)
    {
        $editQuest_form = new \XoopsThemeForm(_AM_QUEST_FORM, 'editquestfrom', XOOPS_URL . '/modules/xquiz/admin/backend.php', 'post', true);

        $this->retrieveQuestion($questId);
        ////////////////////temp
        $question_id = new \XoopsFormHidden('questionId', $this->getId());
        ////////
        $question_number = new \XoopsFormText(_AM_XQUIZ_QUEST_TOTAL, 'questionNumber', 15, 5, $this->getQnumber());

        $submit_button = new \XoopsFormButton('', 'editQstSubmit', _AM_XQUIZ_SUBMIT, 'submit');

        $quest_list_array_v = Quiz::quiz_listQuizArray();
        $quiz_name          = new \XoopsFormSelect(_AM_XQUIZ_NAME, 'quizId', $this->getQid());
        $quiz_name->addOptionArray($quest_list_array_v);
        $question_score = new \XoopsFormText(_AM_XQUIZ_QUEST_SCORE, 'questionScore', 15, 5, $this->getScore());
        global $xoopsModuleConfig;
        $options_tray = new \XoopsFormElementTray(_AM_XQUIZ_QUEST_DESC, '<br>');
        if (class_exists('XoopsFormEditor')) {
            $options ['name']   = 'questionDesc';
            $options ['value']  = $this->getQuestion();
            $options ['rows']   = 15;
            $options ['cols']   = '100%';
            $options ['width']  = '100%';
            $options ['height'] = '400px';
            $contents_contents  = new \XoopsFormEditor('', $xoopsModuleConfig ['editorUser'], $options);
            $options_tray->addElement($contents_contents);
        } else {
            $contents_contents = new \XoopsFormDhtmlTextArea(_MD_XQUIZ_QUEST_DESC, 'questionDesc', $this->getQuestion());
            $options_tray->addElement($contents_contents);
        }
        $strAdd   = '';
        $addImage = '<img src= "' . XOOPS_URL . '/modules/xquiz/assets/images/Add_Ans.png " title=' . _AM_XQUIZ_ADD_ANSWER . '>';
        $delImage = '<img src= "' . XOOPS_URL . "/modules/xquiz/assets/images/delete.png \" onclick = 'xquiz_deleteCurrentRow(this)' title=" . _AM_XQUIZ_DELET_ANS . '>';
        switch ($this->type) {
            case 'CM':
                $cor_val = 'checkbox';
                $thead   = '<th>' . _AM_XQUIZ_QUEST_ANSWER . '</th>';
                $i       = 1;
                foreach ($this->answers as $answer) {
                    $check = '';
                    if (1 == $answer->getIs_correct()) {
                        $check = ' checked';
                    }
                    $strAdd .= "
					<tr class='classy" . $i % 2 . "'>
						<td>$i</td>
						<td>
							<input type='checkbox' name='corrects[$i]' $check>
						</td>
						<td>
							<input type='text' name='answers[$i]' size='40' value='" . $answer->getAnswer() . "'>
						</td>
						<td>
							" . $delImage . '
						</td>
					</tr>';
                    $i++;
                }

                break;
            case 'FB':
                $cor_val = 'blank';
                $thead   = '';
                $i       = 1;
                foreach ($this->answers as $answer) {
                    $strAdd .= "
					<tr class='classy" . $i % 2 . "'>
						<td>$i</td>
						<td>
							<input type='text' name='answers[$i]' size='40' value='" . $answer->getAnswer() . "'>
						</td>
						<td>
							" . $delImage . '
						</td>
					</tr>';
                    $i++;
                }
                break;
            default:
                $cor_val = 'radio';
                $thead   = '<th>' . _AM_XQUIZ_QUEST_ANSWER . '</th>';
                $i       = 1;
                foreach ($this->answers as $answer) {
                    $check = '';
                    if (1 == $answer->getIs_correct()) {
                        $check = ' checked';
                    }
                    $strAdd .= "
					<tr class='classy" . $i % 2 . "'>
						<td>$i</td>
						<td>
							<input type='radio' name='corrects' value='$i' $check>
						</td>
						<td>
							<input type='text' name='answers[$i]' size='40' value='" . $answer->getAnswer() . "'>
						</td>
						<td>
							" . $delImage . '
						</td>
					</tr>';
                    $i++;
                }
        }
        ob_start();
        echo "<script type='text/javascript' src='" . XOOPS_URL . "/modules/xquiz/assets/js/table.js'></script>
			<table width='100%' cellspacing='1' cellpadding='3' border='0' id='tblQuiz' >
				<thead>
					<tr>
						<th colspan='5'>
						$addImage
						<input type='button' value='" . _AM_XQUIZ_ADD_ANSWER . "' onclick='xquiz_addRowToTable(null,\"$cor_val\");'>
						</th>
					</tr>
					<tr>
						<th>#</th>
						$thead
						<th>" . _AM_XQUIZ_ANSWER_TEXT . '</th>
						<th>' . _AM_XQUIZ_DELET_ANS . "</th>
					</tr>
				</thead>
				<tbody>
				$strAdd
				</tbody>
			</table>";

        $ansFormTable = new \XoopsFormLabel(_AM_XQUIZ_ANSWERS_LABEL, ob_get_clean());

        $question_type = new \XoopsFormHidden('type', $this->getType());
        //$question_token = new \XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken());

        $editQuest_form->addElement($question_id);
        $editQuest_form->addElement($quiz_name, true);
        $editQuest_form->addElement($question_number, true);
        $editQuest_form->addElement($question_score, true);
        $editQuest_form->addElement($options_tray);
        $editQuest_form->addElement($ansFormTable);
        //$editQuest_form->addElement($question_token, true);
        $editQuest_form->addElement($question_type, true);
        $editQuest_form->addElement($submit_button, true);

        Utility::collapsableBar('newquiz', 'topnewquiz');
        echo "<img onclick=\"toggle('toptable'); toggleIcon('toptableicon');\" id='topnewquiz' name='topnewquiz' src='" . XOOPS_URL . "/modules/xquiz/assets/images/close12.gif' alt=''>
				 	</a>&nbsp;" . _AM_XQUIZ_QUEST_NEW . "</h4><br>
						<div id='newquiz' style='text-align: center;'>";
        $editQuest_form->display();
        echo '</div>';
    }

    /*
     * show form for select quiz to show questions
     * @return string
     */
    public static function showQuizSelectForm()
    {
        $list = Quiz::allQuizs();

        echo "<div id='newsel' style='text-align: center;'>
					<table width='100%' cellspacing='1' cellpadding='3' border='0' class='outer'>
						<tr class='odd'>
							<td>
							<form method='get' action='main.php' onchange=\"MM_jumpMenu('parent',this,0)\">
								<input type='hidden' name='op' value='Question'>
								<label>" . _AM_XQUIZ_QUIZS_SELECT . "
									<select name='Id'>";
        foreach ($list as $key) {
            echo "<option value='" . $key ['id'] . "'>" . $key ['name'] . '</option>';
        }

        echo "						</select>
								</lable>
								<input type='submit' value='" . _AM_XQUIZ_QUESTION_GO . "'>
							</form>
							</td>
							<td>
							<form method='get' action='main.php'>
							<input type='hidden' name='op' value='Question'>
							<input type='hidden' name='act' value='add'>
							<label>" . _AM_XQUIZ_QUIZS_SELECT . "
									<select name='Id'>";
        foreach ($list as $key) {
            echo "<option value='" . $key ['id'] . "'>" . $key ['name'] . '</option>';
        }

        echo '						</select>
							</lable>
							<label>' . _AM_XQUIZ_ANSWER_TYPE . "
									<select name='type'>";
        foreach (self::$qTypes as $key => $value) {
            echo "<option value='$key'>$value</option>";
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

    /*
 * TODO add new question to database
 * @param array $answers
 * @param array $corrects
 * @return void
 *
 */
    /**
     * @param $ans
     * @param $is_cor
     * @throws \Exception
     */
    public function addQuestion($ans, $is_cor)
    {
        global $xoopsDB;
        $query = 'Insert into ' . $xoopsDB->prefix('xquiz_questions') . "
				(quiz_id,question_type,question,qnumber,score)
				VALUES ( '$this->qid', '$this->type', '$this->question','$this->qnumber',
				'$this->score');";

        $res      = $xoopsDB->query($query);
        $this->id = $xoopsDB->getInsertId();
        for ($i = 1, $iMax = count($ans); $i <= $iMax; ++$i) {
            $answerObj = new Answer();
            $answerObj->setAnswer($ans [$i]);
            if ((!empty($is_cor [$i])) && ('CM' == $this->type)) {
                $answerObj->setIs_correct(1);
            } elseif (($i == $is_cor) && ('MC' == $this->type)) {
                $answerObj->setIs_correct(1);
            }
            $answerObj->setQuestId($this->id);
            $answerObj->addAnswer();
            $this->answers[] = $answerObj;
        }

        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
    }

    /*
     * @TODO retrieve number of question into database
     * @param integer @quizid
     * @return $integer number of question
     */
    /**
     * @param $quizId
     * @return mixed
     */
    public static function questionNumber($quizId)
    {
        global $xoopsDB;
        $query = $xoopsDB->query('SELECT COUNT(quiz_id) AS CID FROM ' . $xoopsDB->prefix('xquiz_questions') . " WHERE quiz_id = '$quizId'");
        $myrow = $xoopsDB->fetchArray($query);
        return $myrow ['CID'];
    }

    /*
     * @TODO retrieve question from database with question Id and set to object attribute
     * @param int $questionId
     * @return void
     */
    /**
     * @param $questId
     */
    public function retrieveQuestion($questId)
    {
        global $xoopsDB;
        $this->id       = $questId;
        $query          = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_questions') . " WHERE question_id = '$this->id'");
        $myrow          = $xoopsDB->fetchArray($query);
        $this->qid      = $myrow ['quiz_id'];
        $this->qnumber  = $myrow ['qnumber'];
        $this->score    = $myrow ['score'];
        $this->type     = $myrow ['question_type'];
        $this->question = $myrow ['question'];
        $query          = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_answers') . " WHERE question_id = '$this->id'");

        while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
            $answerObj = new Answer();
            $answerObj->setAnswer($myrow ['answer']);
            $answerObj->setAid($myrow ['answer_id']);
            $answerObj->setIs_correct($myrow ['is_correct']);
            $answerObj->setQuestId($myrow ['question_id']);
            $this->answers[] = $answerObj;
        }
    }

    /*
     * @TODO edit Question
     * @param array $answers
     * @param array $corrects
     * @return void
     */
    /**
     * @param $ans
     * @param $is_cor
     * @throws \Exception
     */
    public function editQuestion($ans, $is_cor)
    {
        global $xoopsDB;
        $query = 'UPDATE ' . $xoopsDB->prefix('xquiz_questions') . " SET 
					  quiz_id = '$this->qid'
					 ,question = '$this->question'
					 ,qnumber = '$this->qnumber'
					 ,score = '$this->score'
					 WHERE question_id = '$this->id' ";
        $res   = $xoopsDB->query($query);

        Answer::deleteAnswers($this->getId());
        for ($i = 1, $iMax = count($ans); $i <= $iMax; ++$i) {
            $answerObj = new Answer();
            $answerObj->setAnswer($ans [$i]);
            if ((!empty($is_cor [$i])) && ('CM' == $this->type)) {
                $answerObj->setIs_correct(1);
            } elseif (($i == $is_cor) && ('MC' == $this->type)) {
                $answerObj->setIs_correct(1);
            }
            $answerObj->setQuestId($this->id);
            $answerObj->addAnswer();
            $this->answers[] = $answerObj;
        }
        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
    }

    /*
     * @TODO delete Question and all question's answers from database
     * @return void
     */
    public function deleteQuestion()
    {
        global $xoopsDB;
        $query = 'DELETE FROM ' . $xoopsDB->prefix('xquiz_questions') . " WHERE  
					  question_id = '$this->id' ";
        $res   = $xoopsDB->query($query);
        Answer::deleteAnswers($this->id);
        if (!$res) {
            throw new \Exception(_AM_XQUIZ_QUEST_DATABASE);
        }
    }

    /*
     * @TODO Show delete confirm form
     * @param int $id
     * @return void
     */
    /**
     * @param $id
     */
    public static function confirmForm($id)
    {
        $delQuest_form = new \XoopsThemeForm(_AM_XQUIZ_DELQUESTFORM, 'delqstfrom', XOOPS_URL . '/modules/xquiz/admin/backend.php', 'post', true);
        $quest_id      = new \XoopsFormHidden('questId', $id);
        $quiz_id       = new \XoopsFormHidden('quizId', $qid);
        $quest_confirm = new \XoopsFormRadioYN(_AM_XQUIZ_DELETE_CAPTION, 'delConfirm', 0);
        $submit_button = new \XoopsFormButton('', 'delQstSubmit', _AM_XQUIZ_SUBMIT, 'submit');
        //$quest_token   = new \XoopsFormHidden("XOOPS_TOKEN_REQUEST", $GLOBALS ['xoopsSecurity']->createToken());

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

    /*
     * @TODO List Questions of specefic quiz
     * @param int $quizId
     * @return array $listQuestions
     */
    /**
     * @param $qId
     * @return array
     */
    public static function listQuestLoader($qId)
    {
        global $xoopsDB;
        $listQuest = [];
        $q         = 1;
        $query     = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_questions') . " WHERE quiz_id = $qId");
        while (false !== ($myrow = $xoopsDB->fetchArray($query))) {
            $listQuest[$q]['question_id']   = $myrow['question_id'];
            $listQuest[$q]['question_type'] = $myrow['question_type'];
            $listQuest[$q]['question']      = $myrow['question'];
            $listQuest[$q]['qnumber']       = $myrow['qnumber'];
            $listQuest[$q]['score']         = $myrow['score'];
            $qry                            = $xoopsDB->query('SELECT * FROM ' . $xoopsDB->prefix('xquiz_answers') . ' WHERE question_id = ' . $myrow['question_id']);
            if (0 != $xoopsDB->getRowsNum($qry)) {
                $listQuest[$q]['answer'] = [];
                $t                       = 1;
                while (false !== ($ansRow = $xoopsDB->fetchArray($qry))) {
                    $listQuest[$q]['answer'][$t]['answer_id']  = $ansRow['answer_id'];
                    $listQuest[$q]['answer'][$t]['answer']     = $ansRow['answer'];
                    $listQuest[$q]['answer'][$t]['is_correct'] = $ansRow['is_correct'];
                    $t++;
                }
            }
            $q++;
        }
        return $listQuest;
    }
}
